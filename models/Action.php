<?php namespace Gviabcua\Cron\Models;

use Model;

/**
 * Model
 */
class Action extends Model {
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
		'name' => ['required', 'regex:"^[a-zA-Z]+$"'],
	];

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'gviabcua_cron_actions';

	/**
	 * Scope a query to only include actions of a given type.
	 */
	public function scopeApplyType($query, $type) {
		return $query->where('type', $type);
	}

	/**
	 * Scope a query to only include action type log.
	 */
	public function scopeLog($query) {
		return $query->where('type', 'log');
	}

	/**
	 * Scope a query to only include action type webhook.
	 */
	public function scopeWebhook($query) {
		return $query->where('type', 'webhook');
	}

	/**
	 * Scope a query to only include action type mail.
	 */
	public function scopeMail($query) {
		return $query->where('type', 'mail');
	}

	/**
	 * Scope a query to only include action type query.
	 */
	public function scopeQuery($query) {
		return $query->where('type', 'query');
	}
	
	/**
	 * Scope a query to only include action type query.
	 */
	public function scopeShell($query) {
		return $query->where('type', 'shell');
	}
	
	public function scopeGrusherCommand($query) {
		return $query->where('type', 'GrusherCommand');
	}	

	public function scopeArtisanCommand($query) {
		return $query->where('type', 'ArtisanCommand');
	}
}
