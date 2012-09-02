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
 * @copyright  2005-2012 (or current year) Dmitri Snytkine
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */

//error_reporting(E_ALL | E_DEPRECATED);


$Mailer = null;
/**
 * For those
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
                $process[]                       = &$process[$key][stripslashes($k)];
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
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding("UTF-8");
}

if (function_exists('mb_regex_encoding')) {
    mb_regex_encoding("UTF-8");
}


function exception_handler($e)
{
    $code = $e->getCode();
    if (!($e instanceof \OutOfBoundsException)) {
        try {
            $err   = Lampcms\Responder::makeErrorPage('<strong>Error:</strong> ' . Lampcms\Exception::formatException($e));
            $extra = (isset($_SERVER)) ? ' $_SERVER: ' . print_r($_SERVER, 1) : ' no extra';
            if (($code >= 0) && defined('LAMPCMS_DEVELOPER_EMAIL') && strlen(trim(constant('LAMPCMS_DEVELOPER_EMAIL'))) > 7) {
                @mail(LAMPCMS_DEVELOPER_EMAIL, 'ErrorHandle in inc.php', $err . $extra);
            }
            echo nl2br($err);
        } catch ( \Exception $e ) {
            echo 'Error in Exception handler: : ' . $e->getMessage() . ' line ' . $e->getLine() . $e->getTraceAsString();
        }
    } else {
        echo('Got exit signal in error_handler from ' . $e->getTraceAsString());
    }
}

/**
 * If php NOT running as fastcgi
 * then we need to create a dummy function
 *
 */
if (!function_exists('fastcgi_finish_request')) {
    define('NO_FFR', true);
    function fastcgi_finish_request()
    {
    }
}

set_exception_handler('exception_handler');

require 'Lampcms' . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'All.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Exception.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Object.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'String.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Utf8BaseString.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Utf8String.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Responder.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Mail' . DIRECTORY_SEPARATOR . 'Mailer.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Mongo' . DIRECTORY_SEPARATOR . 'Collections.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Ini.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Log.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Request.php';

require 'Lampcms' . DIRECTORY_SEPARATOR . 'Mongo' . DIRECTORY_SEPARATOR . 'DB.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Mongo' . DIRECTORY_SEPARATOR . 'Doc.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Mongo' . DIRECTORY_SEPARATOR . 'Schema' . DIRECTORY_SEPARATOR . 'User.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Event' . DIRECTORY_SEPARATOR . 'Dispatcher.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Event' . DIRECTORY_SEPARATOR . 'Observer.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Locale' . DIRECTORY_SEPARATOR . 'Locale.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'User.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Acl' . DIRECTORY_SEPARATOR . 'Acl.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Acl' . DIRECTORY_SEPARATOR . 'RoleRegistry.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Acl' . DIRECTORY_SEPARATOR . 'Role.php';
//require 'Lampcms' . DIRECTORY_SEPARATOR . 'SplClassLoader.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Registry.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . 'Fast.php';


require 'Lampcms' . DIRECTORY_SEPARATOR . 'Base.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'WebPage.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Forms' . DIRECTORY_SEPARATOR . 'Form.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Cookie.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'LoginForm.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Uri' . DIRECTORY_SEPARATOR . 'UriString.php';
require 'Lampcms' . DIRECTORY_SEPARATOR . 'Uri' . DIRECTORY_SEPARATOR . 'Router.php';


/**
 * Custom error handle
 * the purpose of this is to catch
 * the catchable fatal error, introduced in php 5.2.0
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
 * @param string  $errstr
 * @param string  $errfile
 * @param integer $errline
 *
 * @throws Lampcms\DevException
 * @return true
 */
function LampcmsErrorHandler($errno, $errstr, $errfile, $errline)
{

    $errLevel = error_reporting();

    if ($errno === E_RECOVERABLE_ERROR) {

        d($errfile . ' ' . $errline . ' ' . $errstr);
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
            /**
             * Mongo notices are annoying and totally useless anyway
             * These usually have $errno of 1
             */
            if (($errno & (E_ERROR | E_NOTICE | E_WARNING)) && (strstr($errstr, 'mongo') || strstr($errstr, 'pool'))) {

                return true;
            }

            throw new \Lampcms\DevException($errstr, null, $errno, $errfile, $errline);

        }
    }

    return true;
}

$old_error_handler = set_error_handler("LampcmsErrorHandler");

$Registry = \Lampcms\Registry::getInstance();

try {

    $Ini     = $Registry->Ini;
    $dataDir = $Ini->LAMPCMS_DATA_DIR;
    $dataDir = rtrim($dataDir, '/');

    define('LAMPCMS_DEVELOPER_EMAIL', $Ini->EMAIL_DEVELOPER);
    define('LAMPCMS_SALT', $Ini->SALT);
    define('LAMPCMS_COOKIE_SALT', $Ini->COOKIE_SALT);
    define('LAMPCMS_DEFAULT_LANG', $Ini->DEFAULT_LANG);
    define('LAMPCMS_DEFAULT_LOCALE', $Ini->DEFAULT_LOCALE);
    define('LAMPCMS_TR_DIR', $Ini->TRANSLATIONS_DIR);
    define('LAMPCMS_COOKIE_DOMAIN', $Ini->COOKIE_DOMAIN);
    define('LAMPCMS_CATEGORIES', (int)$Ini->CATEGORIES);
    define('LAMPCMS_SHOW_RENDER_TIME', (bool)$Ini->SHOW_TIMER);
    define('LAMPCMS_UTF8_INPUT', (int)$Ini->UTF8_INPUT);

    if (!empty($dataDir)) {
        define('LAMPCMS_DATA_DIR', $dataDir . DIRECTORY_SEPARATOR);
    } else {
        define('LAMPCMS_DATA_DIR', LAMPCMS_WWW_DIR . 'w' . DIRECTORY_SEPARATOR);
    }

} catch ( Lampcms\IniException $e ) {
    throw new \OutOfBoundsException($e->getMessage());
}


$Mailer = $Registry->Mailer;
/**
 * No longer setting timezone here
 * it is recommended to set default timezone in php.ini
 * The actual value of timezone will be set per-user
 * based on timezone selected in settings or in case
 * of non-logged in user by value of cookie 'tzn' OR
 * as a last resort a value of SERVER_TIMEZONE setting
 */
/*if (false === date_default_timezone_set($Ini->SERVER_TIMEZONE)) {
    throw new \Lampcms\DevException('Invalid name of  "SERVER_TIMEZONE" in !config.ini constant. The list of valid timezone names can be found here: http://us.php.net/manual/en/timezones.php');
}*/

/**
 * The DEBUG is automatically enabled for
 * users whose ip addresses are added to
 * MY_IP section of config.inc
 * or if script is run from console
 */
$myIP = \Lampcms\Request::getIP();

$aMyIPs = $Ini->offsetGet('MY_IP');
$debug  = $Ini->DEBUG; // string '1' in case of true, empty string of false


if ($debug || isset($aMyIPs[$myIP]) || defined('SPECIAL_LOG_FILE')) {
    define('LAMPCMS_DEBUG', true);
    error_reporting(E_ALL | E_DEPRECATED); // E_ALL | E_DEPRECATED
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('warn_plus_overloading', 1);
    /**
     * Turn on session garbage collection
     * to be run at every session start
     * to give us consistant behaviour
     * in debug mode
     * Session expiration is 10 minutes
     * which means when logged in without
     * using "remember me" option,
     * you supposed to be logged out after 5 minutes
     * of inactivity. The only way to test it
     * is to login, then after 11-12 minutes access site
     * with a different browser. Then go to the browser with logged
     * in user and try to use any other link. User should not
     * be logged in anymore at this time.
     */
    ini_set("session.gc_maxlifetime", "600");
    ini_set('session.gc_probability', "1");
    ini_set('session.gc_divisor', "1");
} else {
    define('LAMPCMS_DEBUG', false);
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('warn_plus_overloading', 0);
}

define('LOG_FILE_PATH', $Ini->LOG_FILE_PATH);

/**
 * Empty the log file if
 * necessary
 */
/**
 * LOG_PER_SCRIPT
 * will return string '1' for true
 * or empty string for false
 */
if ((true === LAMPCMS_DEBUG) && ('' !== LOG_FILE_PATH) && (true === (bool)$Ini->LOG_PER_SCRIPT) && !\Lampcms\Request::isAjax()) {

    file_put_contents(LOG_FILE_PATH, PHP_SAPI . ' ' . print_r($_SERVER, 1), LOCK_EX);
}

/**
 * Shortcuts to log debug and log error
 * MUST BE CALLED after DEBUG MODE and LOG_FILE_PATH
 * has been defined
 *
 * @param string $message
 */
function d($message)
{
    if (defined('LAMPCMS_DEBUG') && true === LAMPCMS_DEBUG) {
        \Lampcms\Log::d($message, 2);
    }
}

/**
 * Log error message
 *
 * @param string $message
 */
function e($message)
{
    \Lampcms\Log::e($message, 2);
}


/**
 * Must be called here AFTER autoloaders have
 * been registered because it relies on autoloaders
 * to find observer classes
 */
$Registry->registerObservers();

