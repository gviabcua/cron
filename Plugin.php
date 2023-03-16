<?php namespace Gviabcua\Cron;

use Gviabcua\Cron\Models\Workflow;
use System\Classes\PluginBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
//use System\Classes\SettingsManager;
//use Backend;
use Schema;
use Lang;
use Illuminate\Support\Facades\DB;

class Plugin extends PluginBase {

	/**
	 * @var bool Plugin requires elevated permissions.
	 */
	public $elevated = true;

	public function pluginDetails() {
		return [
			'name' => 'Cron',
			'description' => 'Cron description',
			'author' => 'Gviabcua',
			'icon' => 'icon-magic',
		];
	}

	/**
	 *
	 * Register October CMS schedule
	 *
	 * @param       object  $schedule Our October CMS scheduler
	 * @return      void
	 *
	 */
	public function registerSchedule($schedule) {

		$workflow = new Workflow;

		// For each row in gviabcua_cron_triggers that is NOT of type cronjob....
		$cronjobs = Db::table('gviabcua_cron_workflows')->select(
			'gviabcua_cron_triggers.value as trigger',
			'gviabcua_cron_workflows.id as id'
		)
			->leftJoin('gviabcua_cron_triggers', 'gviabcua_cron_workflows.trigger_id', '=', 'gviabcua_cron_triggers.id')
			->where('gviabcua_cron_workflows.active', 1)
			->where('gviabcua_cron_triggers.type', '=', 'cronjob')
			->get();
		foreach ($cronjobs as $cronjob) {
			$schedule->call(function () use ($workflow, $cronjob) {
				$workflow->triggerWorkflow(null, $cronjob->id);
			})->cron($cronjob->trigger);
		}

		//$workflow = New Workflow;
		//$workflow->triggerWorkflow(null,$schedule,null);
	}

	/**
	 *
	 * Listen for events
	 *
	 * @return      void
	 *
	 */
	public function boot() {
		if (Schema::hasTable('gviabcua_cron_workflows')) {
			$workflow = new Workflow;

			// For each row in gviabcua_cron_triggers that is NOT of type cronjob....
			$events = Db::table('gviabcua_cron_workflows')->select(
				'gviabcua_cron_triggers.value as trigger',
				'gviabcua_cron_workflows.id as id'
			)
				->leftJoin('gviabcua_cron_triggers', 'gviabcua_cron_workflows.trigger_id', '=', 'gviabcua_cron_triggers.id')
				->where('gviabcua_cron_workflows.active', 1)
				->where('gviabcua_cron_triggers.type', '=', 'event')
				->get();
			foreach ($events as $event) {
				Event::listen($event->trigger, function ($param) use ($workflow, $event) {
//function($param)
					$workflow->triggerWorkflow(null, $event->id, $param);
				});
			}
		}
	}
}