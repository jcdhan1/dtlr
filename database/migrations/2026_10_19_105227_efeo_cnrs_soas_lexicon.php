<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\MySqlConnection;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('efeo_cnrs_soas_lexicon', function (Blueprint $table) {
			$table->id('uid');
			$table->string('ferlus_number', 12)->charset('ascii')->nullable();
			$table->enum('layer', ['I', 'II', 'III', 'IV', 'V'])->nullable();
			$table->string('fr', 255)->nullable();
			$table->string('en_gb', 255)->nullable();
			$table->string('zh_hans', 255)->nullable();
			$table->string('bod', 255)->nullable();
			$table->string('my', 1023)->nullable();
			$table->string('th', 255)->nullable();
			$table->string('nod', 255)->nullable();
			$table->string('lo', 255)->nullable();
			$table->string('vi', 255)->nullable();
			$table->text('comments_vi')->nullable();
			$table->string('okz_latn', 255)->nullable();
			$table->string('km_fonipa', 255)->nullable();
			$table->string('km_fonipa_x_tateyleu', 255)->nullable();
			$table->enum('semantics', [
				'natural environment',
				'directions',
				'plants',
				'animals',
				'kinship',
				'body parts',
				'measures',
				'food and drink',
				'clothing and ornaments',
				'fabric and weaving',
				'house / home',
				'tools, instruments and weapons',
				'fishing',
				'crafts (smithy, woodcraft...)',
				'time',
				'numbers',
				'actions and states',
				'adjectives',
				'various',
				'colours',
				'religion and divination',
				'personal pronouns'

			])->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('efeo_cnrs_soas_lexicon');
	}
};
