<?php namespace Gviabcua\Cron\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Actions extends Controller {
	public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];

	public $listConfig = 'config_list.yaml';
	public $formConfig = 'config_form.yaml';

	public $requiredPermissions = [
		'cron',
	];

	public function __construct() {
		parent::__construct();
		BackendMenu::setContext('Gviabcua.Cron', 'cron', 'actions'); /* added manually */
		$this->bodyClass = 'compact-container'; /* added manually */
	}
}
