<?php namespace Gviabcua\Cron\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;
use Illuminate\Support\Facades\DB;

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
		DB::statement("INSERT INTO `gviabcua_cron_workflows` (`id`, `name`, `items`, `trigger_id`, `active`, `description`) VALUES
		(3,	'DiscoveringDevices',	'[{\"action_id\":\"3\",\"_group\":\"grushercommand\"}]',	6,	1,	'Пошук нового обладнання'),
		(4,	'DiscoveringOnus',	'[{\"action_id\":\"4\",\"_group\":\"grushercommand\"}]',	4,	1,	'Оновлення інформації на OLT по ONU'),
		(5,	'DiscoveringFDB',	'[{\"action_id\":\"5\",\"_group\":\"grushercommand\"}]',	68,	1,	'Пошук MAC-адрес на обладнанні'),
		(6,	'DiscoveringOnusSignal',	'[{\"action_id\":\"6\",\"_group\":\"grushercommand\"}]',	20,	1,	'Отримання сигналів ONU з усіх OLT'),
		(7,	'UpdateUsersFromThirdparty',	'[{\"action_id\":\"7\",\"_group\":\"webhook\"}]',	6,	1,	'Оновлення списку абонетів з білінга'),
		(8,	'GetOnuListOltWithNoScriptReg',	'[{\"action_id\":\"8\",\"_group\":\"grushercommand\"}]',	65,	1,	'Оновлення інформації на OLT по ONU (з автореєстрацією ONU)'),
		(9,	'GetBackups',	'[{\"action_id\":\"9\",\"_group\":\"grushercommand\"}]',	75,	1,	'Створення резервних копій обладнання'),
		(10,	'SendReport',	'[{\"action_id\":\"10\",\"_group\":\"webhook\"},{\"action_id\":\"13\",\"_group\":\"webhook\"}]',	10,	1,	'Розсилання звітів'),
		(12,	'DiscoveringSFPPower',	'[{\"action_id\":\"12\",\"_group\":\"grushercommand\"}]',	6,	1,	'Отримання сигналів SFP модулів (де можливо)'),
		(15,	'DiscoveringDevicesPortsStates',	'[{\"action_id\":\"22\",\"_group\":\"grushercommand\"}]',	6,	1,	'Оновлення інформації по портам пристроїв'),
		(16,	'GetIfErrors',	'[{\"action_id\":\"17\",\"_group\":\"grushercommand\"}]',	9,	1,	'Отримання помилок на портах пристроїв'),
		(17,	'DiscoveringVlansList',	'[{\"action_id\":\"18\",\"_group\":\"grushercommand\"}]',	9,	1,	'Отримання VLAN на пристроях'),
		(18,	'MonitoringDevices',	'[{\"action_id\":\"19\",\"_group\":\"grushercommand\"}]',	21,	1,	'Моніторинг доступності пристрою / оновлення інформації'),
		(19,	'UpdateUsersideVolsNodeList',	'[{\"action_id\":\"20\",\"_group\":\"webhook\"}]',	18,	1,	'Оновлення переліку ВОЛЗ/Вузлів зв\'язку з Userside'),
		(20,	'DiscoveringOnusSignalCritical',	'[{\"action_id\":\"21\",\"_group\":\"grushercommand\"}]',	19,	1,	'Отримання сигналів з важливих ONU'),
		(21,	'MonitoringOnus',	'[{\"action_id\":\"23\",\"_group\":\"grushercommand\"}]',	21,	1,	'Моніторинг доступності вибраних ONU'),
		(39,	'tetsnotify',	'[{\"action_id\":\"26\",\"_group\":\"shell\"}]',	2,	0,	'Тест'),
		(41,	'MonitoringPorts',	'[{\"action_id\":\"50\",\"_group\":\"grushercommand\"}]',	7,	1,	'Моніторинг доступності порту пристрою'),
		(46,	'MonitoringOnusAll',	'[{\"action_id\":\"55\",\"_group\":\"grushercommand\"}]',	24,	1,	'Моніторинг доступності всіх ONU'),
		(47,	'DiscoveringDevicesMetrics',	'[{\"action_id\":\"56\",\"_group\":\"grushercommand\"}]',	24,	1,	'Оновлення метрик пристроїв');");
	}

	public function down() {
		Schema::table('gviabcua_cron_workflows', function ($table) {
			Schema::dropIfExists('gviabcua_cron_workflows');
		});
	}
}