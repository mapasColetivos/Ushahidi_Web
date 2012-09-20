<?php defined('SYSPATH') OR die('No direct script access');

/**
 * Model for the auth_tokens table
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class Auth_Tokens_Model extends ORM {

	/**
	 * Database table name
	 * @var string
	 */	
	protected $table_name = 'auth_tokens';

	/**
	 * Creates a new token entry
	 *
	 * @param string $type
	 * @param string $data
	 * @return  User_Tokens_Model on success, FALSE otherwise
	 */
	public static function create_token($type, $data)
	{
		$token_orm = ORM::factory('auth_tokens');
		$token_orm->type = $type;
		$token_orm->token = hash_hmac('sha1', $data, text::random('alnum', 24));
		$token_orm->data = json_encode($data);
		$token_orm->created_date = date("Y-m-d H:i:s", time());
		// Set the token to expire in 24 hours
		$token_orm->expire_date = date("Y-m-d H:i:s", time()+86400);
		$token_orm->save();

		return $token_orm;
	}


	/**
	 * Gets an entry with the specified token type and value. The expiry
	 * date of the record must be earlier than the current date & time
	 *
	 * @param  string $type Type of the token to be retrieved
	 * @param  sring  $token Token value
	 * @return Auth_Model_Token if a record is found, FALSE otherwise
	 */
	public static function get_token($type, $token)
	{
		$sysdate = date('Y-m-d H:i:s', time());
		$token_orm = ORM::factory('auth_tokens')
		    ->where('type', $type)
		    ->where('token', $token)
		    ->where('expire_date >=', $sysdate)
		    ->find();

		if ($token_orm->loaded)
			return $token_orm;

		return FALSE;
	}
}