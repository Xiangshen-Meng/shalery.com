<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	public function up()
	{
		Schema::create('events', function($table)
		{
			$table->bigIncrements('shalery_id');
			$table->bigInteger('event_id');
			$table->integer('provider_id');		//connpass 1, doorkeeper 2

			$table->string('title', 500);
			$table->string('address', 500)->nullable();
			$table->string('url', 500);


			$table->string('lat')->nullable();
			$table->string('lon')->nullable();

			$table->integer('user_limit')->unsigned()->nullable();
			$table->integer('user_ticket')->unsigned()->nullable();
			$table->integer('user_wait')->unsigned()->nullable();

			$table->timestamp('start_time')->nullable();
			$table->timestamp('end_time')->nullable();
			$table->timestamp('update_time');

			$table->mediumText('description')->nullable();

			$table->timestamps();

			$table->index('event_id');
			$table->index('start_time');
			$table->index('update_time');
		});
	}

	public function down()
	{
		Schema::drop('events');
	}

}
