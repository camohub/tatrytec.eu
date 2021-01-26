<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comments extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedBigInteger('article_id');
			$table->unsignedBigInteger('user_id');
			$table->string('user_name', 50);
			$table->string('email', 50);
			$table->text('content', 255);
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
		//Schema::drop('comments');
	}
}
