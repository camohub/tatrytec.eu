<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pages extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->collation = 'utf8mb4_slovak_ci';
			$table->id();
			$table->string('title', 255);
			$table->string('slug', 255);
			$table->longText('content');
			$table->boolean('visible')->default(FALSE);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('pages');
	}
}
