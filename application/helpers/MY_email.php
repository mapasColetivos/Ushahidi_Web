<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Email helper class.
 * Extends built-in email helper class
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi
 * @category   Helpers
 * @link       https://github.com/mapasColetivos/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class email extends email_Core {
	
	/**
	 * Emails the link for resetting a forgotten password
	 *
	 * @param  Model_User user      Name of the recipient
	 */
	public static function send_reset_password_email($user)
	{
		$from = Kohana::lang('ui_admin.password_reset_from');
		$subject = Kohana::lang('ui_admin.password_reset_subject');
		$password_reset_url = url::site('users/reset_password/'.$user->id.'?token='.urlencode($user->get_reset_password_token()));

		$message = Kohana::lang('ui_admin.password_reset_message_line_1').' '.$user->name.",\n";
		$message .= Kohana::lang('ui_admin.password_reset_message_line_2').' '.$user->name.". ";
		$message .= Kohana::lang('ui_admin.password_reset_message_line_3')."\n\n";
		$message .= $password_reset_url."\n\n";
		
		return self::send($user->email, $from, $subject, $message, FALSE) == 1;
		
	}
}