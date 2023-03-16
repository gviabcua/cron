<?php namespace Gviabcua\Cron\Updates;
use Schema;
use October\Rain\Database\Updates\Migration;


class BuilderTableCreateGviabcuaCronActions extends Migration {
	public function up() {
		Schema::create('gviabcua_cron_actions', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->increments('id')->unsigned(false)->change();
			$table->string('name', 255)->nullable();
			$table->string('type', 255)->nullable();
			$table->string('value', 255)->nullable();
			$table->string('description', 255)->nullable();
		});
	}

	public function down() {
		Schema::dropIfExists('gviabcua_cron_actions');
	}
}
