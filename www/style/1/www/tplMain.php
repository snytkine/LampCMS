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

class tplMain extends Lampcms\Template\Template
{

	/* css1: <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?3.3.0/build/cssreset/reset-min.css&3.3.0/build/cssfonts/fonts-min.css&3.3.0/build/cssgrids/grids-min.css">
	 * <script type="text/javascript" src="http://yui.yahooapis.com/combo?2.8.0r4/build/utilities/utilities.js&2.8.0r4/build/container/container-min.js&2.8.0r4/build/menu/menu-min.js&2.8.0r4/build/button/button-min.js&2.8.0r4/build/datasource/datasource-min.js&2.8.0r4/build/editor/editor-min.js&2.8.0r4/build/json/json-min.js&2.8.0r4/build/resize/resize-min.js&2.8.0r4/build/tabview/tabview-min.js&2.8.0r4/build/cookie/cookie-min.js&2.8.1/build/imageloader/imageloader-min.js"></script>', //12
	 '
	 <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css&2.8.0r4/build/base/base-min.css&2.8.0r4/build/assets/skins/sam/skin.css">
	 gfc_js' => '', //13
	 */
	protected static $vars = array(
	'title' => 'title', //1
	'site_url' => '', //2
	'site_title' => '', // 3
	'site_description' => '', //4
	'version_id' => '', //5
	'session_uid' => '', //6
	'description' => '', //7
	'extra_metas' => '', //8
	'css1' => '', // 9
	'main_css' => '/css/main.css', //10
	'extra_css' => '', //11
	'js' => '<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.8.0r4/build/utilities/utilities.js&2.8.0r4/build/container/container-min.js&2.8.0r4/build/button/button-min.js&2.8.0r4/build/json/json-min.js&2.8.0r4/build/cookie/cookie-min.js"></script>', //12
	'gfc_js' => '', //13
	'fb_js' => '', //14
	'template_id' => 'yui-t6', //15
	'header' => '', //16
	'body' => '', //17
	'side' => '', //18
	'footer' => '', //19
	'extra_html' => '', //20
	'last_js' => '', //21
	'ads_js' => '', //22
	'analytics_js' => '', // 23
	'topTabs' => '', //24
	'topRight' => '', //25
	'right2' => '', // 26
	'right3' => '', // 27
	'right4' => '', // 28
	'right5' => '', // 29
	'qheader' => '', // 30
	'tags' => '', // 31
	'layoutID' => '1', // 32
	'role' => 'guest', // 33
	'rep' => '1', // 34
	'JS_PREFIX' => '' //35
	);

	//<link rel="shortcut icon" href="/favicon.ico">
	protected static $tpl = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>%1$s</title>
<meta name="site_url" content="%2$s">
<meta name="site_title" content="%3$s">
<meta name="site_description" content="%4$s">
<meta name="version_id" content="%5$s">
<meta name="session_uid" content="%6$s">
<meta name="description" content="%7$s">
<meta name="role" content="%33$s">
<meta name="rep" content="%34$s">
%8$s
%9$s
<link href="%10$s" rel="stylesheet" type="text/css">
<script src="http://yui.yahooapis.com/3.3.0/build/yui/yui-min.js"></script>
<!-- 11, 12, 13 -->
%11$s
%12$s
<link rel="shortcut icon" href="/favicon.ico">
</head>
<body class="yui-skin-sam">
%14$s
<div id="hd" class="dheader">
	 <div id="loginHead" class="doc3">
	 	<div class="fl w40">
	 	<div class="icn home"></div>
	 		<a href="/">Home</a>
	 	</div>
	 	%16$s
	 </div>
</div>
<div id="doc3" class="gbox %15$s">
	%24$s
	<div class="yui3-g" id="layout%32$s">
<div class="yui3-u-3-4" id="qview-main">			
 	<div class="qheader">%30$s</div>
    <div id="qview-body">%17$s</div>
</div>
<div class="yui3-u-1-4" id="nav">
<!-- right side -->
  <div id="qview-side">
	%25$s
 	%18$s
 	%26$s
 	%27$s
 	%28$s
 	%29$s
 	%31$s
   </div>
</div>
    </div>
	<div id="ft" class="footer">%19$s
	<div id="ccwiki-copyright">Powered by <a href="http://www.lampcms.com">LampCMS</a> Questions and Answers are licensed under <a href="http://creativecommons.org/licenses/by-sa/2.5/" rel="nofollow" target="_blank">cc-wiki</a> license.</div>
	<div class="timer">{timer}</div>
	</div> 
</div>

<div id="fbOverlay">
<div class="yui3-widget-hd"><h3>Alert</h3></div>
<div class="yui3-widget-bd"></div>
<div class="yui3-widget-ft">
<div><button id="hide-fbOverlay" class="btn">close</button></div>
</div>

</div>
%20$s
<div id="lastdiv" class="delegate"></div>
%13$s
<script type="text/javascript" src="%35$s/js/include.js"></script>
<script type="text/javascript" src="%35$s/js/qa.js"></script>
<!-- GFC JS -->
%21$s
%22$s
</body>
</html>';

}
