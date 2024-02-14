<?php namespace Gviabcua\Cron\Updates;
use Schema;
use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\DB;


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
		DB::statement("INSERT INTO `gviabcua_cron_actions` (`id`, `name`, `type`, `value`, `description`) VALUES
					(2,	'ServicesRecheck',	'webhook',	'%API%cat=service&action=services_recheck',	'Перевірка роботи сервісів/перезапуск'),
					(3,	'RunDeviceDiscovery',	'grushercommand',	'device_discovery',	'Пошук обладнання'),
					(4,	'RunOnuDiscovery',	'grushercommand',	'get_onus',	'Пошук ОНУ на ОЛТ'),
					(5,	'RunFdbDiscovery',	'grushercommand',	'get_fdb',	'Пошук МАКів на обладнанні'),
					(6,	'RunOnusSignalDiscovery',	'grushercommand',	'onu_signals',	'Зняття сигналів ОНУ з усіх ОЛТ'),
					(7,	'UpdateUsersFromThirdparty',	'grushercommand',	'update_users_from_thirdparty',	'оновити список абонентів'),
					(8,	'GetOnuListOltWithNoScriptReg',	'grushercommand',	'get_onus_autoreg',	'Опитування ОЛТ, де ОНУ реєструються автоматично на ОЛТ'),
					(9,	'DoBackups',	'grushercommand',	'do_backups',	'Створення резервних копій пристроїв'),
					(10,	'SendReport',	'grushercommand',	'reports_main_report',	'Відправка звітів'),
					(12,	'RunSfpPowerDiscovery',	'grushercommand',	'get_sfp_power',	'Отримання сигналів SFP модулів (де можливо)'),
					(14,	'DeleteExpirationDays',	'webhook',	'%API%cat=system&action=delete_expiration_days',	'Видалення старих даних'),
					(15,	'RunCommandForAllDeviceGETSYS',	'webhook',	'%API%cat=run&action=run_command_for_all_device&param=get_device_sys_info',	'Отримання SYS пристроїв'),
					(17,	'GetIferrors',	'grushercommand',	'get_iferror',	'Отримання помилок'),
					(18,	'GetVlanListOnDevice',	'grushercommand',	'get_vlans_list_to_db',	'Отримання списку VLAN на пристроях'),
					(19,	'DeviceMonitoring',	'grushercommand',	'device_monitoring',	'Моніторинг доступності пристрою / оновлення інформації'),
					(20,	'UpdateUsersideVolsNodeList',	'grushercommand',	'get_us_vols_nodes_list_from_us',	'Оновити перілік ВОЛЗ/Вузлів зв\'язку з Userside'),
					(21,	'RunOnusSignalDiscoveryCritical',	'grushercommand',	'onu_signals_critical',	'Зняття сигналів з важливих ОНУ'),
					(22,	'RunGetAllDevicePortsStates',	'grushercommand',	'get_all_device_ports_states',	'Отримання історій портів комутаторів'),
					(23,	'OnuMonitoring',	'grushercommand',	'onu_monitoring',	'Моніторинг доступності вибраних ONU'),
					(26,	'TestNotification',	'shell',	'/usr/bin/php /var/www/html/custom/cron_scripts/test_script.php',	'Тестове сповіщення'),
					(50,	'PortMonitoring',	'grushercommand',	'ports_monitoring',	'Моніторинг доступності порту пристрою'),
					(55,	'OnuMonitoringAll',	'grushercommand',	'onu_monitoring_all',	'Моніторинг доступності всіх ONU'),
					(56,	'DiscoveringDevicesMetrics',	'grushercommand',	'get_metrics',	'');");
	}

	public function down() {
		Schema::dropIfExists('gviabcua_cron_actions');
	}
}
