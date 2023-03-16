<?php namespace Gviabcua\Cron\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateGviabcuaCronWorkflows extends Migration {
	public function up() {
		Schema::create('gviabcua_cron_workflows', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->text('items');
			$table->integer('trigger_id')->nullable();
			$table->smallInteger('active')->nullable()->default(0);
			$table->string('description', 255)->nullable();
		});
	}

	public function down() {
		Schema::table('gviabcua_cron_workflows', function ($table) {
			Schema::dropIfExists('gviabcua_cron_workflows');
		});
	}
}