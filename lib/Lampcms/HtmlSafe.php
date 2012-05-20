<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * HTML_Safe Parser
 *
 * PHP version 5
 *
 * @category  HTML
 * @package   HTML_Safe
 * @author    Roman Ivanov <thingol@mail.ru>
 * @author    Miguel Vazquez Gocobachi <demrit@mx.gnu.org>
 * @copyright 2004-2009 Roman Ivanov, Miguel Vazquez Gocobachi
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/HTML_Safe
 */

/**
 * This package requires HTMLSax3 package
 */
//require_once 'XML/HTMLSax3.php';

/**
 * HTML_Safe Parser
 *
 * This parser strips down all potentially dangerous content within HTML:
 * <ul>
 * <li>opening tag without its closing tag</li>
 * <li>closing tag without its opening tag</li>
 * <li>any of these tags: "base", "basefont", "head", "html", "body", "applet",
 * "object", "iframe", "frame", "frameset", "script", "layer", "ilayer", "embed",
 * "bgsound", "link", "meta", "style", "title", "blink", "xml" etc.</li>
 * <li>any of these attributes: on*, data*, dynsrc</li>
 * <li>javascript:/vbscript:/about: etc. protocols</li>
 * <li>expression/behavior etc. in styles</li>
 * <li>any other active content</li>
 * </ul>
 * It also tries to convert code to XHTML valid, but htmltidy is far better
 * solution for this task.
 *
 * <b>Example:</b>
 * <pre>
 * $parser = new HTML_Safe();
 * $result = $parser->parse($doc);
 * </pre>
 *
 * @category  HTML
 * @package   HTML_Safe
 * @author    Roman Ivanov <thingol@mail.ru>
 * @author    Miguel Vazquez Gocobachi <demrit@mx.gnu.org>
 * @copyright 2004-2009 Roman Ivanov, Miguel Vazquez Gocobachi
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/HTML_Safe
 */
/**
 * @todo
 * this requires pear/XML, pear/XML/HTMLSax3
 *
 * @author admin
 *
 */
namespace Lampcms;

class HtmlSafe
{
	/**
	 * Storage for resulting HTML output
	 *
	 * @var string
	 */
	protected $xhtml = '';

	/**
	 * Array of counters for each tag
	 *
	 * @var array
	 */
	protected $counter = array();

	/**
	 * Stack of unclosed tags
	 *
	 * @var array
	 */
	protected $stack = array();

	/**
	 * Array of counters for tags that must be deleted with all content
	 *
	 * @var array
	 */
	protected $dcCounter = array();

	/**
	 * Stack of unclosed tags that must be deleted with all content
	 *
	 * @var array
	 */
	protected $dcStack = array();

	/**
	 * Stores level of list (ol/ul) nesting
	 *
	 * @var int
	 */
	protected $listScope = 0;

	/**
	 * Stack of unclosed list tags
	 *
	 * @var array
	 */
	protected $liStack = array();

	/**
	 * Array of prepared regular expressions for protocols (schemas) matching
	 *
	 * @var array
	 */
	protected $protoRegexps = array();

	/**
	 * Array of prepared regular expressions for CSS matching
	 *
	 * @var array
	 */
	protected $cssRegexps = array();

	/**
	 * Allowed tags
	 *
	 * @var array
	 */
	protected $allowTags = array();


	/**
	 * List of single tags ("<tag />")
	 *
	 * @var array
	 */
	protected $singleTags = array('area', 'br', 'img', 'input', 'hr', 'wbr', );

	/**
	 * List of dangerous tags (such tags will be deleted)
	 *
	 * @var array
	 */
	protected $deleteTags = array(
        'applet', 'base',   'basefont', 'bgsound', 'blink',  'body',
        'embed',  'frame',  'frameset', 'head',    'html',   'ilayer',
        'iframe', 'layer',  'link',     'meta',    'object', 'style',
        'title',  'script', 'input'
        );

        /**
         * List of dangerous tags (such tags will be deleted, and all content
         * inside this tags will be also removed)
         *
         * @var array
         */
        protected $deleteTagsContent = array('script', 'style', 'title', 'xml', 'form');

        /**
         * Type of protocols filtering ('white' or 'black')
         *
         * @var string
         */
        protected $protocolFiltering = 'white';

        /**
         * List of "dangerous" protocols (used for blacklist-filtering)
         *
         * @var array
         */
        protected $blackProtocols = array(
        'about',   'chrome',     'data',       'disk',     'hcp',
        'help',    'javascript', 'livescript', 'lynxcgi',  'lynxexec',
        'ms-help', 'ms-its',     'mhtml',      'mocha',    'opera',
        'res',     'resource',   'shell',      'vbscript', 'view-source',
        'vnd.ms.radio',   'wysiwyg'
        );

        /**
         * List of "safe" protocols (used for whitelist-filtering)
         *
         * @var array
         */
        protected $whiteProtocols = array(
        'ftp',  'http',  'https',
        'mailto', 'news', 'nntp', 'webcal',
        'xmpp',   'callto'
        );

        protected $whiteProtocols_ = array(
        'ed2k',   'file', 'ftp',  'gopher', 'http',  'https',
        'irc',    'mailto', 'news', 'nntp', 'telnet', 'webcal',
        'xmpp',   'callto',
        );

        /**
         * List of attributes that can contain protocols
         *
         * @var array
         */
        protected $protocolAttributes = array(
        'action', 'background', 'codebase', 'dynsrc', 'href', 'lowsrc', 'src',
        );

        /**
         * List of dangerous CSS keywords
         *
         * Whole style="" attribute will be removed, if parser will find one of
         * these keywords
         *
         * @var array
         */
        protected $cssKeywords = array(
        'absolute', 'behavior',       'behaviour',   'content', 'expression',
        'fixed',    'include-source', 'moz-binding',
        );

        /**
         * List of tags that can have no "closing tag"
         *
         * @var array
         * @deprecated XHTML does not allow such tags
         */
        protected $noClose = array();

        /**
         * List of block-level tags that terminates paragraph
         *
         * Paragraph will be closed when this tags opened
         *
         * @var array
         */
        protected $closeParagraph = array(
        'address', 'blockquote', 'center', 'dd',      'dir',       'div',
        'dl',      'dt',         'h1',     'h2',      'h3',        'h4',
        'h5',      'h6',         'hr',     'isindex', 'listing',   'marquee',
        'menu',    'multicol',   'ol',     'p',       'plaintext', 'pre',
        'table',   'ul',         'xmp',
        );

        /**
         * List of table tags, all table tags outside a table will be removed
         *
         * @var array
         */
        protected $tableTags = array(
        'caption', 'col', 'colgroup', 'tbody', 'td', 'tfoot', 'th',
        'thead',   'tr',
        );

        /**
         * List of list tags
         *
         * @var array
         */
        protected $listTags = array('dir', 'menu', 'ol', 'ul', 'dl', );

        /**
         * List of dangerous attributes
         *
         * @var array
         */
        protected $attributes = array('dynsrc', 'id', 'name', );

        /**
         * List of allowed "namespaced" attributes
         *
         * @var array
         */
        protected $attributesNS = array('xml:lang', );

        /**
         * Constructs class
         *
         * @access public
         */
        public function __construct()
        {
        	//making regular expressions based on Proto & CSS arrays
        	foreach ($this->blackProtocols as $proto) {
        		$preg = "/[\s\x01-\x1F]*";
        		for ($i=0; $i<strlen($proto); $i++) {
        			$preg .= $proto{$i} . "[\s\x01-\x1F]*";
        		}
        		$preg .= ":/i";
        		$this->protoRegexps[] = $preg;
        	}

        	foreach ($this->cssKeywords as $css) {
        		$this->cssRegexps[] = '/' . $css . '/i';
        	}
        	return true;
        }

        /**
         * Handles the writing of attributes - called from $this->openHandler()
         *
         * @param array $attrs array of attributes $name => $value
         *
         * @return boolean
         */
        protected function writeAttrs($attrs)
        {
        	if (is_array($attrs)) {
        		foreach ($attrs as $name => $value) {
        			$name = strtolower($name);

        			if (strpos($name, 'on') === 0) {
        				continue;
        			}

        			if (strpos($name, 'data') === 0) {
        				continue;
        			}

        			if (in_array($name, $this->attributes)) {
        				continue;
        			}

        			if (!preg_match('/^[a-z0-9]+$/i', $name)) {
        				if (!in_array($name, $this->attributesNS)) {
        					continue;
        				}
        			}

        			if (($value === true) || (is_null($value))) {
        				$value = $name;
        			}

        			if ($name == 'style') {
        				// removes insignificant backslahes
        				$value = str_replace("\\", '', $value);

        				// removes CSS comments
        				while (1) {
        					$_value = preg_replace('!/\*.*?\*/!s', '', $value);

        					if ($_value == $value) {
        						break;
        					}

        					$value = $_value;
        				}

        				// replace all & to &amp;
        				$value = str_replace('&amp;', '&', $value);
        				$value = str_replace('&', '&amp;', $value);

        				foreach ($this->cssRegexps as $css) {
        					if (preg_match($css, $value)) {
        						continue 2;
        					}
        				}

        				foreach ($this->protoRegexps as $proto) {
        					if (preg_match($proto, $value)) {
        						continue 2;
        					}
        				}
        			}

        			$tempval = preg_replace('/&#(\d+);?/me', "chr('\\1')", $value); //"'
        			$tempval = preg_replace(
                    '/&#x([0-9a-f]+);?/mei',
                    "chr(hexdec('\\1'))",
        			$tempval
        			);

        			if ((in_array($name, $this->protocolAttributes))
        			&& (strpos($tempval, ':') !== false)
        			) {
        				if ($this->protocolFiltering == 'black') {
        					foreach ($this->protoRegexps as $proto) {
        						if (preg_match($proto, $tempval)) {
        							continue 2;
        						}
        					}
        				} else {
        					$_tempval = explode(':', $tempval);
        					$proto    = $_tempval[0];

        					if (!in_array($proto, $this->whiteProtocols)) {
        						continue;
        					}
        				}
        			}

        			/**
        			 * @todo why not use htmlspecialchars (with 4th arg) which will also
        			 * take care of replacing & with &amp;
        			 *
        			 * @var unknown_type
        			 */
        			$value        = str_replace("\"", '&quot;', $value);
        			$this->xhtml .= ' ' . $name . '="' . $value . '"';
        		}
        	}

        	return true;
        }

        /**
         * Opening tag handler - called from HTMLSax
         *
         * @param object &$parser HTML Parser
         * @param string $name    tag name
         * @param array  $attrs   tag attributes
         *
         * @return boolean
         */
        public function openHandler(\XML_HTMLSax3 $parser, $name, $attrs)
        {

        	$name = strtolower($name);

        	if (in_array($name, $this->deleteTagsContent)) {
        		array_push($this->dcStack, $name);
        		$this->dcCounter[$name] = isset($this->dcCounter[$name])
        		? $this->dcCounter[$name]+1 : 1;
        	}
        	if (count($this->dcStack) != 0) {
        		return true;
        	}

        	if (in_array($name, $this->deleteTags)
        	&& !in_array($name, $this->allowTags)
        	) {
        		return true;
        	}

        	if (!preg_match("/^[a-z0-9]+$/i", $name)) {
        		if (preg_match("!(?:\@|://)!i", $name)) {
        			$this->xhtml .= '&lt;' . $name . '&gt;';
        		}
        		return true;
        	}

        	if (in_array($name, $this->singleTags)) {
        		$this->xhtml .= '<' . $name;
        		$this->writeAttrs($attrs);
        		$this->xhtml .= ' />';
        		return true;
        	}

        	// TABLES: cannot open table elements when we are not inside table
        	if ((isset($this->counter['table']))
        	&& ($this->counter['table'] <= 0)
        	&& (in_array($name, $this->tableTags))
        	) {
        		return true;
        	}

        	// PARAGRAPHS: close paragraph when closeParagraph tags opening
        	if ((in_array($name, $this->closeParagraph)) && (in_array('p', $this->stack))) {
        		$this->closeHandler($parser, 'p');
        	}

        	// LISTS: we should close <li> if <li> of the same level opening
        	if (($name == 'li')
        	&& count($this->liStack)
        	&& ($this->listScope == $this->liStack[count($this->liStack)-1])
        	) {
        		$this->closeHandler($parser, 'li');
        	}

        	// LISTS: we want to know on what nesting level of lists we are
        	if (in_array($name, $this->listTags)) {
        		$this->listScope++;
        	}
        	if ($name == 'li') {
        		array_push($this->liStack, $this->listScope);
        	}

        	$this->xhtml .= '<' . $name;
        	$this->writeAttrs($attrs);
        	$this->xhtml .= '>';
        	array_push($this->stack, $name);
        	$this->counter[$name] = isset($this->counter[$name]) ? $this->counter[$name]+1 : 1;
        	return true;
        }

        /**
         * Closing tag handler - called from HTMLSax
         *
         * @param object &$parser HTML parser
         * @param string $name    tag name
         *
         * @return boolean
         */
        public function closeHandler(\XML_HTMLSax3 $parser, $name)
        {
        	$name = strtolower($name);

        	if (isset($this->dcCounter[$name])
        	&& ($this->dcCounter[$name] > 0)
        	&& (in_array($name, $this->deleteTagsContent))
        	) {
        		while ($name != ($tag = array_pop($this->dcStack))) {
        			$this->dcCounter[$tag]--;
        		}

        		$this->dcCounter[$name]--;
        	}

        	if (count($this->dcStack) != 0) {
        		return true;
        	}

        	if ((isset($this->counter[$name])) && ($this->counter[$name] > 0)) {
        		while ($name != ($tag = array_pop($this->stack))) {
        			$this->closeTag($tag);
        		}

        		$this->closeTag($name);
        	}
        	return true;
        }

        /**
         * Closes tag
         *
         * @param string $tag tag name
         *
         * @return boolean
         */
        protected function closeTag($tag)
        {
        	if (!in_array($tag, $this->noClose)) {
        		$this->xhtml .= '</' . $tag . '>';
        	}

        	$this->counter[$tag]--;

        	if (in_array($tag, $this->listTags)) {
        		$this->listScope--;
        	}

        	if ($tag == 'li') {
        		array_pop($this->liStack);
        	}
        	return true;
        }

        /**
         * Character data handler - called from HTMLSax
         *
         * @param object &$parser HTML parser
         * @param string $data    textual data
         *
         * @return boolean
         */
        public function dataHandler(\XML_HTMLSax3 $parser, $data)
        {
        	if (count($this->dcStack) == 0) {
        		$this->xhtml .= $data;
        	}

        	return true;
        }

        /**
         * Escape handler - called from HTMLSax
         *
         * @param object &$parser HTML parser
         * @param string $data    comments or other type of data
         *
         * @return boolean
         */
        public function escapeHandler(\XML_HTMLSax3 $parser, $data)
        {
        	return true;
        }

        /**
         * Allow tags
         *
         * Example:
         * <pre>
         * $safe = new HTML_Safe;
         * $safe->setAllowTags(array('body'));
         * </pre>
         *
         * @param array $tags Tags to allow
         *
         * @return void
         */
        public function setAllowTags($tags = array())
        {
        	if (is_array($tags)) {
        		$this->allowTags = $tags;
        	}
        }

        /**
         * Returns the XHTML document
         *
         * @return string Processed (X)HTML document
         */
        public function getXHTML()
        {
        	while ($tag = array_pop($this->stack)) {
        		$this->closeTag($tag);
        	}

        	return $this->xhtml;
        }

        /**
         * Clears current document data
         *
         * @return boolean
         */
        public function clear()
        {
        	$this->xhtml = '';
        	return true;
        }

        /**
         * Main parsing fuction
         *
         * @param string $doc HTML document for processing
         *
         * @return string Processed (X)HTML document
         */
        public function parse($doc)
        {
        	require_once(LAMPCMS_LIB_DIR.DIRECTORY_SEPARATOR.'Pear'.DIRECTORY_SEPARATOR.'XML'.DIRECTORY_SEPARATOR.'HTMLSax3.php');
        	require_once(LAMPCMS_LIB_DIR.DIRECTORY_SEPARATOR.'Pear'.DIRECTORY_SEPARATOR.'XML'.DIRECTORY_SEPARATOR.'HTMLSax3'.DIRECTORY_SEPARATOR.'States.php');
        	require_once(LAMPCMS_LIB_DIR.DIRECTORY_SEPARATOR.'Pear'.DIRECTORY_SEPARATOR.'XML'.DIRECTORY_SEPARATOR.'HTMLSax3'.DIRECTORY_SEPARATOR.'Decorators.php');
        	// Save all '<' symbols
        	/**
        	 * @todo this will replace
        	 * < p> with &lt p
        	 * May not be what we want
        	 */
        	$doc = preg_replace("/<(?=[^a-zA-Z\/\!\?\%])/", '&lt;', $doc);

        	// Web documents shouldn't contains \x00 symbol
        	$doc = str_replace("\x00", '', $doc);

        	// Opera6 bug workaround
        	$doc = str_replace("\xC0\xBC", '&lt;', $doc);

        	// UTF-7 encoding ASCII decode
        	$doc = $this->repackUTF7($doc);

        	// Instantiate the parser
        	$parser= new \XML_HTMLSax3();

        	// Set up the parser
        	$parser->set_object($this);

        	$parser->set_element_handler('openHandler', 'closeHandler');
        	$parser->set_data_handler('dataHandler');
        	$parser->set_escape_handler('escapeHandler');

        	$parser->parse($doc);

        	return $this->getXHTML();
        }


        /**
         * UTF-7 decoding function
         *
         * @param string $str HTML document for recode ASCII part of UTF-7 back to ASCII
         *
         * @return string Decoded document
         */
        public function repackUTF7($str)
        {
        	return preg_replace_callback(
            '!\+([0-9a-zA-Z/]+)\-!',
        	array($this, 'repackUTF7Callback'), $str);
        }

        /**
         * Additional UTF-7 decoding fuction
         *
         * @param string $str String for recode ASCII part of UTF-7 back to ASCII
         *
         * @return string Recoded string
         */
        public function repackUTF7Callback($str)
        {
        	$str = base64_decode($str[1]);
        	$str = preg_replace_callback(
            '/^((?:\x00.)*)((?:[^\x00].)+)/',
        	array($this, 'repackUTF7Back'),$str);

        	return preg_replace('/\x00(.)/', '$1', $str);
        }

        /**
         * Additional UTF-7 encoding fuction
         *
         * @param string $str String for recode ASCII part of UTF-7 back to ASCII
         *
         * @return string Recoded string
         */
        public function repackUTF7Back($str)
        {
        	return $str[1] . '+' . rtrim(base64_encode($str[2]), '=') . '-';
        }
}

?>