<?php namespace Gviabcua\Cron\Models;

use Model;

/**
 * Model
 */
class Trigger extends Model {
	use \October\Rain\Database\Traits\Validation;

	/*
		     * Disable timestamps by default.
		     * Remove this line if timestamps are defined in the database table.
	*/
	public $timestamps = false;

	/**
	 * @var array Validation rules
	 */
	public $rules = [
		'name' => 'required',
	];

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'gviabcua_cron_triggers';
}
