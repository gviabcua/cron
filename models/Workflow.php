<?php namespace Gviabcua\Cron\Models;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Gviabcua\NetControl\Models\Logs as GrusherLog;
use Illuminate\Support\Facades\Mail;
use Model;
use Gviabcua\NetControl\Models\Option;
use Gviabcua\NetControl\Models\Devicebase;

/**
 * Model
 */
class Workflow extends Model {
	use \October\Rain\Database\Traits\Validation;

	/*
		     * Disable timestamps by default.
		     * Remove this line if timestamps are defined in the database table.
	*/
	public $timestamps = false;

	/**
	 * @var string The one to one relation needed for form relation and record finder (added manually).
	 */
	public $belongsTo = [
		'trigger' => [
			'Gviabcua\Cron\Models\Trigger', 'order'      => 'name asc',
		],
		'action_id' => [
			'Gviabcua\Cron\Models\Action', 'order'      => 'name asc',
		],
	];

	/**
	 * @var array Validation rules
	 */
	public $rules = [
		'name' => ['required', 'regex:"^[A-Za-z]+$"'],
	];

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'gviabcua_cron_workflows';

	protected $jsonable = ['items'];

	/**
	 *
	 * Trigger workflow rule
	 *
	 * @param       string  $name The name of our rule
	 * @param       object  $schedule Our October CMS scheduler
	 * @return      void
	 *
	 */
	public function triggerWorkflow($name = null, $id = null, $param = null) {
		$workflows = false;

		// Manual trigger
		if (!is_null($name)) {
			// For each row in gviabcua_cron_triggers that HAS name....
			$workflows = Db::table('gviabcua_cron_workflows')->select(
				'gviabcua_cron_triggers.value as trigger',
				'gviabcua_cron_workflows.items as items',
				'gviabcua_cron_workflows.name as name'
			)
				->leftJoin('gviabcua_cron_triggers', 'gviabcua_cron_workflows.trigger_id', '=', 'gviabcua_cron_triggers.id')
				->where('gviabcua_cron_workflows.active', 1)
				->where('gviabcua_cron_workflows.name', '=', $name)
				->get();
		}
		// Event or Schedule trigger
		elseif (!is_null($id)) {
			// For each row in gviabcua_cron_triggers that IS of type cronjob....
			$workflows = Db::table('gviabcua_cron_workflows')->select(
				'gviabcua_cron_triggers.value as trigger',
				'gviabcua_cron_workflows.items as items',
				'gviabcua_cron_workflows.name as name'
			)
				->leftJoin('gviabcua_cron_triggers', 'gviabcua_cron_workflows.trigger_id', '=', 'gviabcua_cron_triggers.id')
				->where('gviabcua_cron_workflows.active', 1)
				->where('gviabcua_cron_workflows.id', '=', $id)
				->get();
		}

		if ($workflows) {

			foreach ($workflows as $workflow) {
				// get actions as an array of objects with property action_id
				$actions = json_decode($workflow->items);

				// Loop actions
				foreach ($actions as $action) {
					$newrule = Db::table('gviabcua_cron_actions')->select('*')
						->where('gviabcua_cron_actions.id', $action->action_id)
						->first();

					//if($workflow->trigger){Log::info(json_encode($workflow->trigger));}
					if (isset($newrule->type)){
						switch ($newrule->type) {
						case "mail":
							$this->workflowMail($newrule, $param);
							break;
						case "shell":
							$this->workflowShell($newrule, $param);
							GrusherLog::logging($newrule->value, 80);
							break;
						case "artisancommand":
							$this->workflowArtisanCommand($newrule, $param);
							break;
						case "grushercommand":
							$this->workflowGrusherCommand($newrule, $param);
							GrusherLog::logging($newrule->value, 81);
							break;
						case "webhook":
							$this->workflowWebhook($newrule, $param);
							GrusherLog::logging($newrule->value, 82);
							break;
						case "log":
							Log::info(json_encode($newrule));
							break;
						case "query":
							$this->workflowQuery($newrule, $param);
							break;
						}
					}
				}
			}

		}
	}

	/**
	 *
	 * Sending mails as part of a workflow
	 *
	 * @param       object  $rule Our variables
	 * @param       array  $param Our variables
	 * @return      void
	 *
	 */
	protected function workflowShell($rule, $param = null) {
		$command = $rule->value; // e.g. https;//briddle.nl?first_name
		Log::info("Command: '" . $command. "'");
		shell_exec($command);
	}
	protected function workflowArtisanCommand($rule, $param = null) {
		//$command = $rule->value; // e.g. https;//briddle.nl?first_name
		//$script_command = Option::get_system_commands('PHP') . " " . base_path() . "/artisan $command > /dev/null 2>&1 &";
		//Log::info("Command: '" . $command. "'");
		//shell_exec($command);
		//Notify::send_to_telegram($command);
	}
	protected function workflowGrusherCommand($rule, $param = null) {
		$command = $rule->value;
		Log::info("Grusher command start: '" . $command. "' '".$param."'");
		Devicebase::RUN_COMMAND($command, $param); 
		Log::info("Grusher command end: '" . $command. "' '".$param."'");
		//shell_exec($command);
		//Notify::send_to_telegram($command);
	}
	/**
	 *
	 * Sending mails as part of a workflow
	 *
	 * @param       object  $rule Our variables
	 * @param       array  $param Our variables
	 * @return      void
	 *
	 */
	protected function workflowMail($rule, $param = null) {
		$results = Db::select($rule->value);
		if (is_array($results)) {
			for ($i = 0; $i < count($results); $i++) {
				if (isset($results[$i]->email) && isset($results[$i]->name)) {
					$vars = (array) $results[$i];
					$email = $results[$i]->email;
					$name = $results[$i]->name;
					Mail::send($rule->name, $vars, function ($message) use ($email, $name) {
						$message->to($email, $name);
					});
				} else {
					Log::info('Missing email and/or name field in: ' . $rule->name);
				}
			}
		} else {
			Log::info('Action value is no array (' . json_encode($results) . ') in: ' . $rule->name);
		}
	}

	/**
	 *
	 * Pinging URL's as part of a workflow
	 *
	 * @param       object  $rule Our variables
	 * @param       array  $param Our variables
	 * @return      void
	 *
	 */
	protected function workflowWebhook($rule, $param = null) {
		$url = $rule->value; // e.g. https;//briddle.nl?first_name

		//Get URL segments (if any)
		/*	$querystring = explode('?',$url);
	    	if(is_array($querystring)){
	        	$segments = explode('&',$querystring[1]);
	        }
	        if(is_object($param) && is_array($segments)) {
	        	foreach($segments as $segment){
	            	if($param->$segment){
	                	$url = str_replace($segment, $segment . '=' . urlencode($param->$segment), $url);
	                }
	            }
	        	Log::info(json_encode($url));
	        }
*/
		$url = str_replace("%API%", Config::get('app.url') . 'api?', $url);
		//Log::info($url);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if (200 == $retcode) {
			Log::info('Webhook for ' . $url . ' responded in: ' . $rule->name);
		} else {
			Log::info('Webhook for ' . $url . ' did not respond in: ' . $rule->name);
		}
	}

	/**
	 *
	 * Run a query as part of a workflow
	 *
	 * @param       object  $rule Our variables
	 * @param       array  $param Our variables
	 * @return      void
	 *
	 */
	protected function workflowQuery($rule, $param = null) {
		$results = Db::raw($rule->value);
		if (is_array($results)) {

		} else {
			Log::info('Action value is no array (' . json_encode($results) . ') in: ' . $rule->name);
		}
	}

}