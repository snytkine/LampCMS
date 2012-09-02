<?php



/**
 * PHP-Class hn_captcha_X1 Version 1.2.1, released 30-Apr-2009
 *
 * is an extension for PHP-Class hn_captcha, Version for PHP 5 !
 *
 * It adds a garbage-collector. (Useful, if you cannot use cronjobs.)
 *
 *
 * Author: Horst Nogajski, coding@nogajski.de
 *
 * $Id: hn_captcha.class.x1.php5,v 1.4.2.2 2009/04/30 14:30:06 horst Exp $
 *
 * Download: http://hn273.users.phpclasses.org/browse/package/1569.html
 *
 * License: GNU LGPL (http://www.opensource.org/licenses/lgpl-license.html)
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *
 * This class generates a picture to use in forms that perform CAPTCHA test
 * (Completely Automated Public Turing to tell Computers from Humans Apart).
 * After the test form is submitted a key entered by the user in a text field
 * is compared by the class to determine whether it matches the text in the picture.
 *
 * The class is a fork of the original released at www.phpclasses.org
 * by Julien Pachet with the name ocr_captcha.
 *
 * The following enhancements were added:
 *
 * - Support to make it work with GD library before version 2
 * - Hacking prevention
 * - Optional use of Web safe colors
 * - Limit the number of users attempts
 * - Display an optional refresh link to generate a new picture with a different key
 *   without counting to the user attempts limit verification
 * - Support the use of multiple random TrueType fonts
 * - Control the output image by only three parameters: number of text characters
 *   and minimum and maximum size preserving the size proportion
 * - Preserve all request parameters passed to the page via the GET method,
 *   so the CAPTCHA test can be added to existing scripts with minimal changes
 * - Added a debug option for testing the current configuration
 */

namespace Lampcms\Captcha;

use \Lampcms\DevException;

/**
 * All the configuration settings are passed to the class in an array when the object instance is initialized.
 *
 * The class only needs two function calls to be used: display_form() and validate_submit().
 *
 *
 * Class that generate a captcha-image with text and a form to fill in this text
 *
 * @author  Horst Nogajski, (mail: horst@nogajski.de)
 * @version 1.3
 *
 */
class Captcha
{

    ////////////////////////////////
    //
    //	PUBLIC PARAMS
    //

    /**
     * Absolute path to a Tempfolder (with trailing slash!).
     *  This must be writeable for PHP and also accessible via HTTP,
     *  because the image will be stored there.
     *
     * @var string
     *
     * @access public
     *
     */
    protected $tempfolder;

    /**
     *  Absolute path to folder with TrueTypeFonts (with trailing slash!).
     *  This must be readable by PHP.
     *
     * @protected string
     *
     **/
    protected $TTF_folder;

    /**
     *  How many chars the generated text should have
     *
     * @type   integer
     * @access public
     *
     **/
    protected $chars = 5;

    /**
     *  The minimum size a Char should have
     *
     * @type   integer
     * @access public
     *
     **/
    protected $minsize = 20;

    /**
     *  The maximum size a Char can have
     *
     * @type   integer
     * @access public
     *
     **/
    protected $maxsize = 30;

    /**
     *  The maximum degrees a Char should be rotated. Set it to 30 means a random rotation between -30 and 30.
     *
     * @type   integer
     * @access public
     *
     **/
    protected $maxrotation = 25;

    /**
     *  Background noise On/Off (if is Off, a grid will be created)
     *
     * @type   boolean
     * @access public
     *
     **/
    protected $noise = true;

    /**
     *  This will only use the 216 websafe color pallette for the image.
     *
     * @type   boolean
     * @access public
     *
     **/
    protected $websafecolors = false;

    /**
     *  Switches language, available are 'en' and 'de'. You can easily add more. Look in CONSTRUCTOR.
     *
     * @type   string
     * @access public
     *
     **/
    protected $lang = "en";

    /**
     *  If a user has reached this number of try's without success, he will moved to the $badguys_url
     *
     * @type   integer
     * @access public
     *
     **/
    protected $maxtry = 3;

    /**
     *  Gives the user the possibility to generate a new captcha-image.
     *
     * @type   boolean
     * @access public
     *
     **/
    protected $refreshlink = true;

    /**
     *  If a user has reached his maximum try's, he will located to this url.
     *
     * @type   boolean
     * @access public
     *
     **/
    protected $badguys_url = "/";

    /**
     * Number between 1 and 32
     *
     *  Defines the position of 'current try number' in (32-char-length)-string generated by function get_try()
     *
     * @type   integer
     * @access public
     *
     **/
    protected $secretposition = 15;

    /**
     *  The string is used to generate the md5-key.
     *
     * @type   string
     * @access public
     *
     **/
    protected $secretstring = "A very interesting string like 8 char password!";

    /**
     *  Outputs configuration values for testing
     *
     * @type   boolean
     * @access public
     *
     **/
    protected $debug = false;

    /** @access public **/
    public $msg1;

    /** @access public **/
    public $msg2;

    ////////////////////////////////
    //
    //	PRIVATE PARAMS
    //

    /** @private **/
    private $lx; // width of picture
    /** @private **/
    private $ly; // height of picture
    /** @private **/
    private $jpegquality = 80; // image quality
    /** @private **/
    private $noisefactor = 9; // this will multiplyed with number of chars
    /** @private **/
    private $nb_noise; // number of background-noise-characters
    /** @private **/
    private $TTF_file = 'font.ttf'; // holds the current selected TrueTypeFont
    /** @private **/
    private $buttontext;

    /** @private **/
    private $refreshbuttontext;

    /** @private **/
    private $public_K;

    /** @private **/
    private $private_K;

    /** @private **/
    private $key; // md5-key
    /** @private **/
    private $public_key; // public key
    /** @private **/
    private $filename; // filename of captcha picture
    /** @private **/
    private $gd_version; // holds the Version Number of GD-Library
    /** @private **/
    // private $QUERY_STRING;		// keeps the ($_GET) Querystring of the original Request
    /** @private **/
    private $current_try = 0;

    /** @private **/
    private $r;

    /** @private **/
    private $g;

    /** @private **/
    private $b;


    /**
     * Factory method
     * Will return Dummy object
     * in case user does not have required
     * GD and imagettftext function
     *
     * Otherwise will return object of this class
     *
     * @param \Lampcms\Config\Ini object
     *
     * @return \Lampcms\Captcha\Captcha|\Lampcms\Captcha\CaptchaStub
     */
    public static function factory(\Lampcms\Config\Ini $Ini)
    {
        d('cp captcha factory');
        $aConfig = $Ini->getSection('CAPTCHA');

        if (!empty($aConfig['disabled'])) {
            d('Captcha disabled by administrator. Using Captcha Stub instead');

            return new CaptchaStub();
        }

        try {
            self::checkGD();
            return new self($Ini, $aConfig);
        } catch ( DevException $e ) {
            e('Unable to use Captcha because of this error: ' . $e->getMessage());

            return new Stub();
        }
    }


    /**
     * Extracts the config array and generate needed params.
     *
     * @param \Lampcms\Config\Ini $Ini
     * @param array               $config
     * @param bool                $secure
     * @param bool                $debug
     *
     * @throws \Lampcms\Exception
     * @throws \Lampcms\DevException
     */
    public function __construct(\Lampcms\Config\Ini $Ini, array $config = array(), $secure = true, $debug = false)
    {

        $this->Ini = $Ini;

        $aConfig = (!empty($config)) ? $config : $Ini->getSection('CAPTCHA');
        d('Captcha config: ' . \json_encode($aConfig));


        d("Captcha-Debug: The available GD-Library has major version " . $this->gd_version);

        $this->tempfolder = LAMPCMS_DATA_DIR . 'img' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
        $this->TTF_file = LAMPCMS_CONFIG_DIR. DIRECTORY_SEPARATOR .'fonts' . DIRECTORY_SEPARATOR . 'font.ttf';

        d('$this->tempfolder: ' . $this->tempfolder . ' $this->TTF_folder: ' . $this->TTF_folder);

        // Hack prevention
        if (
            (isset($_GET['maxtry']) || isset($_POST['maxtry']) || isset($_COOKIE['maxtry']))
            ||
            (isset($_GET['debug']) || isset($_POST['debug']) || isset($_COOKIE['debug']))
            ||
            (isset($_GET['captcharefresh']) || isset($_COOKIE['captcharefresh']))
            ||
            (isset($_POST['captcharefresh']) && isset($_POST['private_key']))
        ) {
            d("Captcha-Debug: bad guy detected!");
            if (isset($this->badguys_url) && !headers_sent()) {
                header('Location: ' . $this->badguys_url);
            } else {
                throw new \Lampcms\Exception('Sorry but something is not right with this captcha image');
            }
        }

        // extracts config array
        if (!empty($aConfig)) {
            d("Captcha-Debug: Extracts Config-Array in secure-mode!");
            $valid = get_object_vars($this);
            // d('valid vars: '.print_r($valid, 1));
            foreach ($aConfig as $k => $v) {
                if (array_key_exists($k, $valid)) {
                    $this->$k = $v; // key/val from $config become instance variables here
                }
            }
        }

        // check vars for maxtry, secretposition and min-max-size
        $this->maxtry         = ($this->maxtry > 9 || $this->maxtry < 1) ? 3 : $this->maxtry;
        $this->secretposition = ($this->secretposition > 32 || $this->secretposition < 1) ? $this->maxtry : $this->secretposition;
        if ($this->minsize > $this->maxsize) {
            $temp          = $this->minsize;
            $this->minsize = $this->maxsize;
            $this->maxsize = $temp;
            e("What do you think I mean with min and max? Switch minsize with maxsize.");
        }

        d("Set current TrueType-File: (" . $this->TTF_file . ")");
        // get number of noise-chars for background if is enabled
        $this->nb_noise = $this->noise ? ($this->chars * $this->noisefactor) : 0;
        d("Set number of noise characters to: (" . $this->nb_noise . ")");


        // set dimension of image
        $this->lx = ($this->chars + 1) * (int)(($this->maxsize + $this->minsize) / 1.5);
        $this->ly = (int)(2.4 * $this->maxsize);
        d("Set image dimension to: (" . $this->lx . " x " . $this->ly . ")");
        d("Set messages to language: (" . $this->lang . ")");


        // check Postvars
        if (isset($_POST['public_key'])) {
            $this->public_K = substr(strip_tags($_POST['public_key']), 0, $this->chars);
        }

        /**
         * Replace Z with 0 for submitted captcha text
         * because we replace 0 with Z when generated image
         * So now we must make sure to replace it back to 0
         * str_replace('Z', '0',
         */
        if (isset($_POST['private_key'])) {
            $this->private_K = substr(strip_tags($_POST['private_key']), 0, $this->chars);
        }
        $this->current_try = isset($_POST['hncaptcha']) ? $this->get_try() : 0;
        if (!isset($_POST['captcharefresh'])) {
            $this->current_try++;
        }

        d("Check POST-vars, current try is: (" . $this->current_try . ")");


        // generate Keys
        $this->key        = md5($this->secretstring);
        $this->public_key = substr(md5(uniqid(rand(), true)), 0, $this->chars);

        d('public key is: ' . $this->public_key);

    } // end constructor


    /**
     * validates POST-vars and return result
     *
     * @return int 0 = first call | 1 = valid submit | 2 = not valid | 3 = not valid and has reached maximum tries
     */
    public function validate_submit()
    {

        $chk = $this->check_captcha($this->public_K, $this->private_K);

        if ($chk) {
            d("Captcha-Debug: Captcha is valid, validating submitted form returns: (1)");
            return 1;
        } else {
            if ($this->current_try > $this->maxtry) {
                d("Captcha-Debug:  Validating submitted form returns: (3)");
                return 3;
            } elseif ($this->current_try > 0) {
                d("Captcha-Debug:  Validating submitted form returns: (2)");
                return 2;
            } else {
                d("Captcha-Debug:  Validating submitted form returns: (0)");
                return 0;
            }
        }
    }


    public function display_captcha()
    {
        $this->make_captcha();
        $is = getimagesize($this->get_filename());

        return "\n" . '<img class="captchapict" src="' . $this->get_filename_url() . '" ' . $is[3] . ' alt="@@This is a captcha-picture. It is used to prevent mass-access by robots. see www.captcha.net@@" title="">' . "\n";

    }


    /**
     *  must be public to work on our project
     */
    public function make_captcha()
    {
        $private_key = $this->generate_private();
        d("Captcha-Debug: Generate private key: ($private_key)");

        // create Image and set the appropriate function depending on GD-Version & websafecolor-value
        if ($this->gd_version >= 2 && !$this->websafecolors) {
            $func1 = '\\imagecreatetruecolor';
            $func2 = '\\imagecolorallocate';
        } else {
            $func1 = '\\imagecreate';
            $func2 = '\\imagecolorclosest';
        }
        $image = $func1($this->lx, $this->ly);
        d("Generate ImageStream with: ($func1)");
        d("For colordefinitions we use: ($func2)");
        d('$image is: ' . gettype($image));


        // Set Backgroundcolor
        $this->random_color(224, 255);
        $back = @\imagecolorallocate($image, $this->r, $this->g, $this->b);
        \imagefilledrectangle($image, 0, 0, $this->lx, $this->ly, $back);
        d("Captcha-Debug: We allocate one color for Background: (" . $this->r . "-" . $this->g . "-" . $this->b . ")");

        // allocates the 216 websafe color palette to the image
        if ($this->gd_version < 2 || $this->websafecolors) {
            $this->makeWebsafeColors($image);
        }


        // fill with noise or grid
        if ($this->nb_noise > 0) {
            // random characters in background with random position, angle, color
            d("Captcha-Debug: Fill background with noise: (" . $this->nb_noise . ")");
            for ($i = 0; $i < $this->nb_noise; $i++) {
                //d('Captcha-Debug');

                $size  = (int)(\mt_rand((int)($this->minsize / 2.3), (int)($this->maxsize / 1.7)));
                $angle = (int)(\mt_rand(0, 360));
                $x     = (int)(\mt_rand(0, $this->lx));
                $y     = (int)(\mt_rand(0, (int)($this->ly - ($size / 5))));
                $this->random_color(160, 224);
                $color = $func2($image, $this->r, $this->g, $this->b);
                $text  = chr((int)(\mt_rand(45, 250)));
                if (false === \imagettftext($image, $size, $angle, $x, $y, $color, $this->TTF_file, $text)) {

                    throw new DevException('Your php does not support imagettftext operation OR your fonts file did not upload correctly (hint: did you upload them in text mode instead of binary?). You should disable captcha support in !config.ini');
                }

                //d('Captcha-Debug');
            }
        } else {
            // generate grid
            d("Captcha-Debug: Fill background with x-gridlines: (" . (int)($this->lx / (int)($this->minsize / 1.5)) . ")");
            for ($i = 0; $i < $this->lx; $i += (int)($this->minsize / 1.5)) {
                $this->random_color(160, 224);
                $color = $func2($image, $this->r, $this->g, $this->b);
                @imageline($image, $i, 0, $i, $this->ly, $color);
            }
            d("Captcha-Debug: Fill background with y-gridlines: (" . (int)($this->ly / (int)(($this->minsize / 1.8))) . ")");
            for ($i = 0; $i < $this->ly; $i += (int)($this->minsize / 1.8)) {
                $this->random_color(160, 224);
                $color = $func2($image, $this->r, $this->g, $this->b);
                @imageline($image, 0, $i, $this->lx, $i, $color);
            }
        }

        // generate Text
        d("Captcha-Debug: Fill foreground with chars and shadows: (" . $this->chars . ")");
        for ($i = 0, $x = (int)(\mt_rand($this->minsize, $this->maxsize)); $i < $this->chars; $i++) {
            //d('Captcha-Debug');
            $text = \strtoupper(\substr($private_key, $i, 1));
            //d('Captcha-Debug: $text:  '.$text);
            $angle = (int)(\mt_rand(($this->maxrotation * -1), $this->maxrotation));
            $size = (int)(\mt_rand($this->minsize, $this->maxsize));
            $y = (int)(\mt_rand((int)($size * 1.5), (int)($this->ly - ($size / 7))));
            $this->random_color(0, 127);
            //d('Captcha-Debug');
            $color = $func2($image, $this->r, $this->g, $this->b);
            //d('Captcha-Debug');
            $this->random_color(0, 127);
            $shadow = $func2($image, $this->r + 127, $this->g + 127, $this->b + 127);
            //d('Captcha-Debug');
            @\imagettftext($image, $size, $angle, $x + (int)($size / 15), $y, $shadow, $this->TTF_file, $text);
            @\imagettftext($image, $size, $angle, $x, $y - (int)($size / 15), $color, $this->TTF_file, $text);
            $x += (int)($size + ($this->minsize / 5));
            //d('Captcha-Debug');
        }

        d('$image: ' . \gettype($image) . ' image file: ' . $this->get_filename() . ' $this->jpegquality: ' . $this->jpegquality);
        if (true !== \imagejpeg($image, $this->get_filename(), $this->jpegquality)) {
            e('error writing captcha image. Make sure your www/w directory and ALL subdirectory have writable permission');
            throw new DevException('Unable to save captcha-image to ' . $this->get_filename().' Make sure your www/w directory and ALL subdirectory have writable permission');
        }

        if (!file_exists($this->get_filename())) {
            e('Unable to save captcha file to ' . $this->get_filename().' Make sure your www/w directory and ALL subdirectory have writable permission');
            throw new DevException('Unable to save captcha-image to ' . $this->get_filename().' Make sure your www/w directory and ALL subdirectory have writable permission');
        }

        //d('Captcha-Debug');
        if (true !== \imagedestroy($image)) {
            e("Captcha-Debug: Destroy GD Image Resource failed.");
        }
        //d('Captcha-Debug');
    }


    /**
     *
     * Enter description here ...
     *
     * @param unknown_type $image
     */
    protected function makeWebsafeColors(&$image)
    {
        //$a = array();
        for ($r = 0; $r <= 255; $r += 51) {
            for ($g = 0; $g <= 255; $g += 51) {
                for ($b = 0; $b <= 255; $b += 51) {
                    $color = imagecolorallocate($image, $r, $g, $b);
                }
            }
        }

        d("Captcha-Debug: Allocate 216 websafe colors to image: (" . imagecolorstotal($image) . ")");
        //return $a;
    }


    /**
     *
     * Enter description here ...
     *
     * @param int $min
     * @param int $max
     */
    protected function random_color($min, $max)
    {
        $this->r = (int)(mt_rand($min, $max));
        $this->g = (int)(mt_rand($min, $max));
        $this->b = (int)(mt_rand($min, $max));
    }


    /**
     * Check captcha
     *
     * @param string $public  public key
     * @param string $private private key
     *
     * @return bool
     */
    protected function check_captcha($public, $private)
    {
        $res = false;
        /**
         * when check, destroy picture on disk
         */
        if (file_exists($this->get_filename($public))) {
            $ret = @unlink($this->get_filename($public)) ? true : false;
            if ($this->debug) {
                d("Captcha-Debug: Delete image (" . $this->get_filename($public) . ") returns: ($ret)");
            }

            $res = (strtolower($private) == strtolower($this->generate_private($public)));

            d("Captcha-Debug: Comparing public with private key returns: ($res)");
            d('PRIV: ' . strtolower($private) . " ? Generated-PRIVATE (from public=$public) : " . strtolower($this->generate_private($public)));

        } else {

            e('Captcha-Debug: file does not exist ' . $this->get_filename($public));
        }

        return $res;
    }


    /**
     * must be public for Lampcms project
     *
     * @param string $public
     *
     * @return string
     */
    public function get_filename($public = "")
    {
        if ($public == "") {
            $public = $this->public_key;
        }

        return $this->tempfolder . $public . ".jpg";
    }


    /**
     *
     *
     * @param string $public
     *
     * @return string
     */
    public function get_filename_url($public = "")
    {
        if ($public == "") {
            $public = $this->public_key;
        }

        return '{_DIR_}/w/img/tmp/' . $public . ".jpg";
    }


    /**
     *
     * @return array with 3 elements: src = the web path (relative),
     * 'w' = width, 'h' = height
     */
    public function getCaptchaImage()
    {
        $this->make_captcha();
        $is = getimagesize($this->tempfolder . $this->public_key . '.jpg');

        return array('src' => '{_DIR_}/w/img/tmp/' . $this->public_key . '.jpg',
                     'w'   => $is[0],
                     'h'   => $is[1]);
    }


    /**
     * Must be public to work on Lampcms project
     *
     * @param bool $in
     *
     * @return int|string
     */
    public function get_try($in = true)
    {
        $s = array();
        for ($i = 1; $i <= $this->maxtry; $i++) {
            $s[$i] = $i;
        }

        if ($in) {
            return (int)substr(\strip_tags($_POST['hncaptcha']), ($this->secretposition - 1), 1);
        } else {
            $a = "";
            $b = "";
            for ($i = 1; $i < $this->secretposition; $i++) {
                $a .= $s[(int)(\mt_rand(1, $this->maxtry))];
            }
            for ($i = 0; $i < (32 - $this->secretposition); $i++) {
                $b .= $s[(int)(\mt_rand(1, $this->maxtry))];
            }

            return $a . $this->current_try . $b;
        }
    }


    /**
     * Get version of php GD extension
     *
     * @return version of GD
     *
     * @throws \Lampcms\DevException if GD not available
     * or not compiled with imatettftext support
     * or does not have JPEG support
     */
    public static function checkGD()
    {
        if (!extension_loaded('gd')) {
            throw new DevException('GD module not loaded. Cannot use Captcha class without GD library. Check your php info');
        }

        if (!function_exists('imagettftext')) {
            throw new DevException('Your php installation does not have the "imagettftext" function. Captcha cannot be used without this function. ');
        }

        $gd_info = gd_info();

        if (empty($gd_info['JPG Support']) && empty($gd_info['JPEG Support'])) {
            throw new DevException('Your php GD version does not have support for JPG image. Captcha cannot be used without JPG support in GD');
        }

        if (empty($gd_info['GD Version'])) {
            throw new DevException('Unknown version of GD. Unable to use Captcha');
        }

        $gdv = $gd_info['GD Version'];
        d('$gdv: ' . $gdv);
        $Version = \preg_replace('/[[:alpha:][:space:]()]+/', '', $gdv);
        d('Version: ' . $Version);

        if (version_compare($Version, 2.0) < 0) {
            throw new DevException('GD version must be newer than 2.0. Your installed version is: ' . $Version . ' Captcha will not be used');
        }

        return $Version;
    }


    /**
     *
     * The private key will be used
     * for the actual image of captcha
     *
     * @param string $public
     *
     * @return mixed|string
     */
    protected function generate_private($public = "")
    {
        if ($public == "") {
            $public = $this->public_key;
        }

        d("public key WHICH USED for generate private key $public");

        $key = \substr(md5($this->key . $public), 16 - $this->chars / 2, $this->chars);
        /**
         * 0 will be replaced with Z
         * because 0 renders badly in our font
         *
         */
        $key = \str_replace('0', 'Z', $key);

        return $key;
    }


    /**
     * getter method to get public_key
     * which is a private var
     *
     * @return string value of public_key
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }


    /**
     * Returns array of values that we need for
     * the Captcha form.
     *
     * @return array with 'img' => complete html of img tag,
     * 'public_key' value of public key,
     * 'hncaptcha' value of hncaptcha
     */
    public function getCaptchaArray()
    {
        $aRet = array(
            'img'        => $this->display_captcha(),
            'public_key' => $this->getPublicKey(),
            'hncaptcha'  => $this->get_try(false));

        return $aRet;
    }


    /**
     *
     * Create block with Label, Image and
     * input for captcha entry
     *
     * This block can just be dropped into an html template
     * of any form
     *
     * @return string html block with Captcha
     */
    public function getCaptchaBlock()
    {
        $aVals = $this->getCaptchaArray();
        d('got captcha vals: ' . \json_encode($aVals));

        $s = \tplCaptcha::parse($aVals, false);

        return $s;
    }

}
