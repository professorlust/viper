<?php namespace Viper\Model;

class User_Token extends Eloquent {
	
	protected $table = 'users_tokens';
	
	protected $fillable = array(
		'user_id', 'token'
	);
	/**
	 * Like with all other models, make sure we don't ever return the id
	 * or user_id.
	 *
	 * @var array
	 */
	protected $hidden = array(
		'id', 'user_id', 'user'
	);
	/**
	 * Definition of the parent user relationship
	 * 
	 * @return \Viper\Model\User
	 */
	public function user() {
		return $this->belongsTo('User');
	}
	/**
	 * Generates a code and then hashes it, giving us the token.
	 */
	public function generate() {
		if(empty($this->attributes['token'])) {
			do {
				$token = md5($this->attributes['id'] . Str::random(16));
			} while(DB::table($this->table)->where('token', $token)->count() == 0);
			
			$this->attributes['token'] = $token;
		}
	}
	
}