<?php 
/**
 * Layout for the admin interface.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	echo html::stylesheet('media/css/admin/all_layer', '', true);
	echo html::stylesheet('media/css/jquery-ui-themeroller', '', true);
	echo "<!--[if lt IE 7]>".
		html::stylesheet('media/css/ie6', '', true)
		."<![endif]-->";
?>
<?php print $content; ?>
