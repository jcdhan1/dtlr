<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('languages', function (Blueprint $table) {
			$table->id();
			$table->text('autonym');
			$table->jsonb('metadata')->nullable();
			$table->boolean('site')->default(false);
			$table->boolean('nmt')->default(false);
			$table->timestamps();

			// IETF BCP 47 language tag components
			$table->string('iso_639_3', 3)->charset('ascii')->default('zxx');
			$table->string('iso_15924', 4)->charset('ascii')->nullable();
			$table->string('iso_3166_alpha_2', 2)->charset('ascii')->nullable();
			$table->string('variant', 8)->charset('ascii')->nullable();

			// External codes
			$table->string('glottocode', 8)->charset('ascii')->nullable();
			$table->string('wals', 3)->charset('ascii')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('languages');
	}
};
