<?php
/**
 *
 * PHP 5.3 or better is required
 *
 * @package    Global functions
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @author     Dmitri Snytkine <cms@lampcms.com>
 * @copyright  2005-2011 (or current year) ExamNotes.net inc.
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */

error_reporting(E_ALL | E_DEPRECATED);

/**
 * If you want to run multi-site installation of Lampcms
 * and want to reuse the single instance of the Lampcms library
 * you must uncomment the line below to define the full
 * path to your 'lib' directory of the lampcms (without trailing slash)
 * The lib directory must contain the Lampcms and Pear folders
 * (same folders that are included in the Lampcms distribution)
 * for example something like this "/var/lampcms/lib" on Linux
 * or something like this 'C:\eclipse\workspace\QA\lib' on Windows
 */
// define('LAMPCMS_LIB_DIR', 'C:\eclipse\workspace\QA\lib');


/**
 * For those unfortunate souls
 * who has magic_quotes enabled on their
 * server despite having php 5.3
 * this code will remove those
 * genocidal quotes added by magic_quotes
 */
if (get_magic_quotes_gpc()) {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
		foreach ($val as $k => $v) {
			unset($process[$key][$k]);
			if (is_array($v)) {
				$process[$key][stripslashes($k)] = $v;
				$process[] = &$process[$key][stripslashes($k)];
			} else {
				$process[$key][stripslashes($k)] = stripslashes($v);
			}
		}
	}
	unset($process);
}


/**
 * Set all the multibyte
 * functions to use UTF-8
 * as internal encoding
 */
if(function_exists('mb_internal_encoding')){
	mb_internal_encoding("UTF-8");
}

function exception_handler($e){
	$code = $e->getCode();
	if(!($e instanceof \OutOfBoundsException)){
		try {
			$err =  Lampcms\Responder::makeErrorPage('<strong>Error:</strong> '.Lampcms\Exception::formatException($e));
			$extra = (isset($_SERVER)) ? ' $_SERVER: '.print_r($_SERVER, 1) : ' no extra';
			if(($code >=0) && defined('LAMPCMS_DEVELOPER_EMAIL') && strlen(trim(constant('LAMPCMS_DEVELOPER_EMAIL'))) > 7){
				@mail(LAMPCMS_DEVELOPER_EMAIL, 'ErrorHandle in inc.php', $err.$extra);
			}
			echo nl2br($err);
		} catch(\Exception $e) {
			echo 'Error in Exception handler: : '.$e->getMessage().' line '.$e->getLine().$e->getTraceAsString();
		}
	} else {
		echo('Got exit signal in error_handler from '.$e->getTraceAsString());
	}
}

/**
 * if php NOT running as fastcgi
 * then we need to create a dummy function
 *
 */
if(!function_exists('fastcgi_finish_request')){
	define('NO_FFR', true);
	function fastcgi_finish_request(){}
}

set_exception_handler('exception_handler');

define('LAMPCMS_PATH', realpath(dirname(__FILE__)));
if(!defined('LAMPCMS_LIB_DIR')){
	define('LAMPCMS_LIB_DIR', LAMPCMS_PATH.DIRECTORY_SEPARATOR.'lib');
}
$libDir = LAMPCMS_LIB_DIR;
$lampcmsClasses = $libDir.DIRECTORY_SEPARATOR.'Lampcms'.DIRECTORY_SEPARATOR;

require $lampcmsClasses.'Interfaces'.DIRECTORY_SEPARATOR.'All.php';
require $lampcmsClasses.'Exception.php';
require $lampcmsClasses.'Object.php';
require $lampcmsClasses.'Responder.php';
require $lampcmsClasses.'Mongo'.DIRECTORY_SEPARATOR.'Collections.php';
require LAMPCMS_PATH.DIRECTORY_SEPARATOR.'Mycollections.php';
require $lampcmsClasses.'Ini.php';
require $lampcmsClasses.'Log.php';
require $lampcmsClasses.'Request.php';
require $lampcmsClasses.DIRECTORY_SEPARATOR.'Mongo'.DIRECTORY_SEPARATOR.'DB.php';
require $lampcmsClasses.DIRECTORY_SEPARATOR.'Mongo'.DIRECTORY_SEPARATOR.'Doc.php'; // User extends it
require $lampcmsClasses.'User.php'; // User is always used
require $lampcmsClasses.'SplClassLoader.php';
require $lampcmsClasses.'Registry.php';
require $lampcmsClasses.'Template'.DIRECTORY_SEPARATOR.'Fast.php';

/**
 * Points.php is in non-standard directory,
 * in fact this file is not even included in distro
 * User must rename Points.php.dist to Points.php
 * That's why we should manually included it
 * because autoloader will not be able to find it.
 * This file only contains a few constants - it's cheap
 * to include it every time, and with APC cache it will
 * be cached.
 */
require LAMPCMS_PATH.DIRECTORY_SEPARATOR.'Points.php';



/**
 * Custom error handle
 * the purpose of this is to catch
 * the catchable fatal error, intoduced in php 5.2.0
 * We use it with type hinting in class constructors
 * if the object passed to class constructor is not of the same type
 * as hinted, it generates a catchable fatal error.
 * The only way to catch it in the normal way is to set custom error handler
 * like this one, then re-throw exception and it will then be caught.
 *
 * This error handler also turns any php error into
 * a ErrorException
 *
 * So almost any error will be displayed in a better way on
 * the page, will be logged and email will be sent to admin.
 *
 *
 * @param integer $errno
 * @param string $errstr
 * @param string $errfile
 * @param integer $errline
 * @return true
 */
function LampcmsErrorHandler($errno, $errstr, $errfile, $errline)
{

	$errLevel = error_reporting();

	if ($errno === E_RECOVERABLE_ERROR) {

		d($errfile.' '.$errline.' '.$errstr);
		$e = 'Caught catchable fatal error in file: %1$s<br>
		on line: %2$s
		<br><br>
		Error message: <br>
		%3$s<br>';

		$err = vsprintf($e, array($errfile, $errline, $errstr));

		throw new Lampcms\DevException($err);

	} else {

		if ($errLevel === 0) {

			return;
		}
		/**
		 * If error level falls within our
		 * error reporting mask, then throw an ErrorException
		 */
		if ($errLevel & $errno) {

			throw new \Lampcms\DevException($errstr, NULL, $errno, $errfile, $errline);
		}
	}

	return true;
}

$old_error_handler = set_error_handler("LampcmsErrorHandler");
// autoloader here
require 'autoload.php';

$Registry = \Lampcms\Registry::getInstance();

try{

	$oINI = $Registry->Ini;
	$dataDir = $oINI->LAMPCMS_DATA_DIR;
	$dataDir = rtrim($dataDir, '/');

	define('LAMPCMS_WWW_DIR', LAMPCMS_PATH.DIRECTORY_SEPARATOR.\Lampcms\WWW_DIR.DIRECTORY_SEPARATOR);
	define('LAMPCMS_DEVELOPER_EMAIL', $oINI->EMAIL_DEVELOPER);
	define('LAMPCMS_SALT', $oINI->SALT);
	define('LAMPCMS_COOKIE_SALT', $oINI->COOKIE_SALT);
	define('LAMPCMS_DEFAULT_LANG', $oINI->DEFAULT_LANG);
	define('LAMPCMS_DEFAULT_LOCALE', $oINI->DEFAULT_LOCALE);
	define('LAMPCMS_TR_DIR', $oINI->TRANSLATIONS_DIR);
	define('LAMPCMS_COOKIE_DOMAIN', $oINI->COOKIE_DOMAIN );
	define('LAMPCMS_IMAGE_SITE', $oINI->IMAGE_SITE);
	define('LAMPCMS_AVATAR_IMG_SITE', $oINI->AVATAR_IMG_SITE);

	if (!empty($dataDir)) {
		define('LAMPCMS_DATA_DIR', $dataDir.DIRECTORY_SEPARATOR);
	} else {
		define('LAMPCMS_DATA_DIR', LAMPCMS_WWW_DIR.'w'.DIRECTORY_SEPARATOR);
	}

} catch(Lampcms\IniException $e){
	throw new \OutOfBoundsException($e->getMessage());
}


/**
 * First thing is to set our timezone
 */
if (false === date_default_timezone_set($oINI->SERVER_TIMEZONE)) {
	throw new \Lampcms\DevException('Invalid name of  "SERVER_TIMEZONE" in !config.ini constant. The list of valid timezone names can be found here: http://us.php.net/manual/en/timezones.php');
}

/**
 * The DEBUG is automatically enabled for
 * users whose ip addresses are added to
 * MY_IP section of config.inc
 * or if script is run from console
 */
$myIP = \Lampcms\Request::getIP();

$aMyIPs = $oINI->offsetGet('MY_IP');
$debug = $oINI->DEBUG;

if ($debug || isset($aMyIPs[$myIP]) || defined('SPECIAL_LOG_FILE')) {
	define('LAMPCMS_DEBUG', true);
	error_reporting(E_ALL | E_DEPRECATED);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	ini_set('warn_plus_overloading', 1);
	/**
	 * Turn on session garbage collection
	 * to be run at every session start
	 * to give us consistant behaviour
	 * in debug mode
	 * Session expiration is 5 minutes
	 * which means when logged in without
	 * using "remember me" option,
	 * you supposed to be logged out after 5 minutes
	 * of inactivity. The only way to test it
	 * is to login, then after 6-7 minutes access site
	 * with a different browser. Then go to the browser with logged
	 * in user and try to use any other link. User should not
	 * be logged in anymore at this time.
	 */
	ini_set("session.gc_maxlifetime", "300");
	ini_set('session.gc_probability', "1");
	ini_set('session.gc_divisor', "1");
} else {
	define('LAMPCMS_DEBUG', false);
	error_reporting(E_ALL ^ E_WARNING);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	ini_set('warn_plus_overloading', 0);
}

define('LOG_FILE_PATH', $oINI->LOG_FILE_PATH);

/**
 * Empty the log file if
 * necessary
 */
/**
 * LOG_PER_SCRIPT
 * will return string '1' for true
 * or empty string for false
 */
if((true === LAMPCMS_DEBUG) && ('' !== LOG_FILE_PATH) && (true === (bool)$oINI->LOG_PER_SCRIPT) && !\Lampcms\Request::isAjax()){

	file_put_contents(LOG_FILE_PATH, PHP_SAPI.' '.print_r($_SERVER, 1), LOCK_EX);
}

/**
 * Shortcuts to log debug and log error
 * MUST BE CALLED after DEBUG MODE and LOG_FILE_PATH
 * has been defined
 */
function d($message){
	if(defined('LAMPCMS_DEBUG') && true === LAMPCMS_DEBUG){
		\Lampcms\Log::d($message, 2);
	}
}

function e($message){
	\Lampcms\Log::e($message, 2);
}


/**
 * Must be called here AFTER autoloaders have
 * been registered because it relies on autoloaders
 * to find observer classes
 */
$Registry->registerObservers();

