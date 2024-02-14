<?php namespace Gviabcua\Cron\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;
use Illuminate\Support\Facades\DB;

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
		DB::statement("INSERT INTO `gviabcua_cron_triggers` (`id`, `name`, `type`, `value`) VALUES
		(1,	'Every 1 min',	'cronjob',	'* * * * *'),
		(2,	'Every 1 hour',	'cronjob',	'0 * * * *'),
		(3,	'Every 2 hour on 00 min',	'cronjob',	'0 */2 * * *'),
		(4,	'Every 6 hour',	'cronjob',	'0 */6 * * *'),
		(5,	'Every 6 hour on 15 min',	'cronjob',	'15 */6 * * *'),
		(6,	'Every 3 hour',	'cronjob',	'0 */3 * * *'),
		(7,	'Every 5 min',	'cronjob',	'*/5 * * * *'),
		(8,	'Every 10 min',	'cronjob',	'*/10 * * * *'),
		(9,	'On 4 am',	'cronjob',	'0 4 * * *'),
		(10,	'On 8 am',	'cronjob',	'0 8 * * *'),
		(11,	'Every hour on 15 min',	'cronjob',	'15 * * * *'),
		(12,	'Every12 hour on 20 min',	'cronjob',	'20 */12 * * *'),
		(13,	'On 13:00',	'cronjob',	'0 13 * * *'),
		(14,	'Every hour on 20 min',	'cronjob',	'20 * * * *'),
		(15,	'Every 12 hour',	'cronjob',	'0 */12 * * *'),
		(16,	'On 2 am',	'cronjob',	'0 2 * * *'),
		(17,	'Every 20 min',	'cronjob',	'*/20 * * * *'),
		(18,	'On 23 pm',	'cronjob',	'0 23 * * *'),
		(19,	'Every hour on 50 min',	'cronjob',	'50 */1 * * *'),
		(20,	'Every 3 hour on 15 min',	'cronjob',	'15 */3 * * *'),
		(21,	'Every 2 min',	'cronjob',	'*/2 * * * *'),
		(24,	'Every 15 min',	'cronjob',	'*/15 * * * *'),
		(27,	'Every 25 min',	'cronjob',	'*/25 * * * *'),
		(30,	'Every 30 min',	'cronjob',	'*/30 * * * *'),
		(33,	'Every 35 min',	'cronjob',	'*/35 * * * *'),
		(36,	'Every 40 min',	'cronjob',	'*/40 * * * *'),
		(39,	'Every 45 min',	'cronjob',	'*/45 * * * *'),
		(42,	'Every 55 min',	'cronjob',	'*/55 * * * *'),
		(45,	'Every 50 min',	'cronjob',	'*/50 * * * *'),
		(48,	'Every 3 min',	'cronjob',	'*/3 * * * *'),
		(51,	'Every 4 min',	'cronjob',	'*/4 * * * *'),
		(53,	'On 3:00',	'cronjob',	'0 3 * * *'),
		(59,	'At 9:15',	'cronjob',	'15 9 * * *'),
		(62,	'At 10:50',	'cronjob',	'50 10 * * *'),
		(65,	'Every 11 min',	'cronjob',	'*/11 * * * *'),
		(66,	'Every 12 hour on 30 min',	'cronjob',	'30 */12 * * *'),
		(67,	'Every 9 min',	'cronjob',	'*/9 * * * *'),
		(68,	'Every 2 hour on 30 min',	'cronjob',	'30 */2 * * *'),
		(69,	'At 9:02',	'cronjob',	'02 9 * * *'),
		(70,	'On 1 am',	'cronjob',	'0 1 * * *'),
		(71,	'On 01:10 am',	'cronjob',	'10 1 * * *'),
		(72,	'At 10:20',	'cronjob',	'20 10 * * *'),
		(73,	'At 10:30',	'cronjob',	'30 10 * * *'),
		(74,	'On 6 am',	'cronjob',	'0 6 * * *'),
		(75,	'On 5 am',	'cronjob',	'0 5 * * *');");
	}

	public function down() {
		Schema::dropIfExists('gviabcua_cron_triggers');
	}
}
