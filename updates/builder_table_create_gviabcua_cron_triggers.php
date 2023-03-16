<?php namespace Gviabcua\Cron\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateGviabcuaCronTriggers extends Migration {
	public function up() {
		Schema::create('gviabcua_cron_triggers', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			//$table->increments('id')->unsigned(false)->change();
			$table->string('name', 255)->nullable();
			$table->string('type', 255)->nullable();
			$table->string('value', 255)->nullable();
		});
	}

	public function down() {
		Schema::dropIfExists('gviabcua_cron_triggers');
	}
}
