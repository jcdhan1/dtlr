#!/bin/bash

source .env.deployment

# --- CONFIRMATION FUNCTION (y/n) ---
confirm() {
    while true; do
        read -r -p "$1 (y/n): " response
        case "$response" in
            [yY]* ) return 0;;
            [nN]* ) return 1;;
            * ) echo "Please answer y or n.";;
        esac
    done
}

echo "Starting deployment pipeline..."
echo "-------------------------------"

TRIGGER_WEBHOOK=false

# --- STAGE 1: CORE APPLICATION CODE ---
if confirm "Stage 1: Push application code via git-ftp?"; then
    echo "Pushing application updates..."
    git ftp push
else
    echo "Skipped Stage 1."
fi
echo "-------------------------------"

# --- STAGE 2: FRONTEND ASSETS (Vite) ---
if confirm "Stage 2: Build and upload frontend assets (Vite)?"; then
    echo "Building frontend assets..."
    npm run build
    echo "Zipping public/build directory..."
    zip -r build.zip public/build/ -q
    echo "Uploading build.zip..."
    curl -T build.zip "ftp://$FTP_HOST/htdocs/build.zip" --user "$FTP_USER:$FTP_PASS"
    TRIGGER_WEBHOOK=true
else
    echo "Skipped Stage 2."
fi
echo "-------------------------------"

# --- STAGE 3: BACKEND ASSETS (Composer) ---
DO_STAGE_3=false
FORCE_COMPOSER=false

if [ "$1" == "-f" ] || [ "$1" == "--force" ]; then
    echo "Stage 3: Force option passed via CLI argument."
    DO_STAGE_3=true
    FORCE_COMPOSER=true
else
    while true; do
        read -r -p "Stage 3: Upload backend assets? (y=check diff, n=skip, f=force) [y/n/f]: " response
        case "$response" in
            [yY]* ) DO_STAGE_3=true; FORCE_COMPOSER=false; break;;
            [fF]* ) DO_STAGE_3=true; FORCE_COMPOSER=true; break;;
            [nN]* ) DO_STAGE_3=false; break;;
            * ) echo "Please answer y, n, or f.";;
        esac
    done
fi

if [ "$DO_STAGE_3" = true ]; then
    LAST_HASH=$(cat .vendor_deploy_hash 2>/dev/null || echo "HEAD~1")
    SHOULD_BUILD=false
    
    if [ "$FORCE_COMPOSER" = true ]; then
        echo "Force flag used. Bypassing Git diff check..."
        SHOULD_BUILD=true
    elif git diff --name-only "$LAST_HASH" HEAD | grep -qE '^composer\.(json|lock)$'; then
        echo "Composer changes detected in Git diff..."
        SHOULD_BUILD=true
    else
        echo "No Composer changes detected. Skipping vendor zip."
    fi

    if [ "$SHOULD_BUILD" = true ]; then
        echo "Preparing vendor package..."
        composer install --optimize-autoloader --no-dev
        zip -r vendor.zip vendor/ -q
        echo "Uploading vendor.zip (this may take a minute)..."
        curl -T vendor.zip "ftp://$FTP_HOST/htdocs/vendor.zip" --user "$FTP_USER:$FTP_PASS"
        git rev-parse HEAD > .vendor_deploy_hash
        TRIGGER_WEBHOOK=true
    fi
else
    echo "Skipped Stage 3."
fi
echo "-------------------------------"

# --- STAGE 4: REMOTE EXTRACTION ---
if [ "$TRIGGER_WEBHOOK" = true ]; then
    if confirm "Stage 4: Generate remote extraction link?"; then
        # Generate a secure 32-character random hex token
        DEPLOY_TOKEN=$(openssl rand -hex 16)
        
        echo "Injecting secure token into unzipper.php..."
        sed -i "s/PLACEHOLDER_TOKEN/$DEPLOY_TOKEN/" unzipper.php
        
        echo "Uploading unzipper webhook..."
        curl -T unzipper.php "ftp://$FTP_HOST/htdocs/unzipper.php" --user "$FTP_USER:$FTP_PASS"
        
        echo "Reverting local unzipper.php to placeholder..."
        sed -i "s/$DEPLOY_TOKEN/PLACEHOLDER_TOKEN/" unzipper.php
        
        echo ""
        echo "============================================================"
        echo " ACTION REQUIRED: Ctrl+Click the link below in your terminal"
        echo " to open it in your browser and extract the files:"
        echo ""
        echo " $DOMAIN/unzipper.php?token=$DEPLOY_TOKEN"
        echo "============================================================"
        echo ""
        read -r -p "Press Enter here ONLY AFTER you see 'Success' in your browser..."
    else
        echo "Skipped Stage 4. Zips are on the server but have not been extracted."
    fi
else
    echo "Stage 4 Skipped: No zips were uploaded to extract."
fi
echo "-------------------------------"

# --- STAGE 5: CLEANUP ---
if confirm "Stage 5: Clean up local workspace and restore dev dependencies?"; then
    NEEDS_RESTORE=false
    if [ -f "vendor.zip" ]; then
        NEEDS_RESTORE=true
    fi

    echo "Cleaning up local zips..."
    rm -f build.zip vendor.zip
    
    if [ "$NEEDS_RESTORE" = true ]; then
        echo "Restoring local development dependencies..."
        composer install
    fi
    echo "Cleanup complete."
else
    echo "Skipped Stage 5."
fi

echo "-------------------------------"
echo "Deployment pipeline finished."
