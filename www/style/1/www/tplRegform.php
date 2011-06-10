<?php
/**
 *
 * PHP 5.2 or better is required
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
 * @copyright  2005-2009 (or current year) ExamNotes.net inc.
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */


class tplRegform extends Lampcms\Template\Template
{

	protected static $vars = array(
	'titleBar' => 'Step 2 :: Please provide email address', // 1
	'title' => 'Welcome!', //2
	'header2' => '', //3
	'token' => '', //4
	'externalAccount' => '', //5
	'username' => '', // 6
	'email_l' => 'Email:', // 7
	'email' => '', // 8
	'email_d' => "<strong>Please provide a valid email address<br/>Your password and account activation link will be send to there</strong><br/>Don't worry, your email is never shown anywhere on our site and we never share it.\nWe also never send spam",
	'captcha' => '', //10
	'optinBox' => '', //11
	'button' => '', //12
	'action' => 'join', //13
	'td1width' => '0', //14
	'td2' => '', //15
	'loginBlock' => '', //16
	'email_e' => '', //17
	'username_l' => 'Username', //18
	'username_e' => '', //19
	'username_d' => 'Username will appear alongside your posts', //20
	'formError' => '', // 21
	'divID' => 'regdiv', // 22
	'className' => 'yui-pe-content' // 23
	);

	protected static $tpl = '
	<div id="%22$s" class="%23$s">
	<div class="hd">%1$s</div> 
	<div class="bd"> 
	<!-- <h3>%2$s</h3> -->
	<div class="regheader2">%3$s</div>
	<div id="form_error">%21$s</div>
	<div id="eprog"></div>
	<table class="mainreg">
	<tr>
	<td>
		<form id="regform" method="post" action="/index.php">	
		<input type="hidden" name="a" value="%13$s">
		<input type="hidden" name="tzo" value="">
		<input type="hidden" name="token" value="%4$s">
		<table id="tblreg" align="left" cellpadding="0" cellspacing="0">
		<!-- tr1 optional avatar, twitter/fb username -->
		%5$s
		<!-- username -->
		<tr>
		<td>
			<div class="tr">
				<span class="red"> * </span><span class="label2">%18$s</span><br>
				<input type="text" id="username" maxlength="16" name="username" value="%6$s">
				<br><span class="f_err">%19$s</span>
				<div class="note2">%20$s</div>
			</div>
		</td>
		</tr>
		<!-- email -->
		<tr>
			<td>
				<div class="tr">
					<span class="red"> * </span><span class="label2">%7$s</span><br>
					<input type="text" id="email" name="email" value="%8$s">
					<br><span class="f_err">%17$s</span>
					<div class="note2">%9$s</div>
				</div>
			</td>
	</tr>
	<!-- optional TR for Captcha image and form -->
	<tr>
	  <td>
		%10$s
	  </td>
	</tr>
	<!-- checkbox email offers -->
		%11$s
	<tr>
		<td><span class="red"> * </span><span class="label2">Denotes required fields</span><br></td>
	</tr>
	<!-- submit button -->
	<tr>
		<td>
			%12$s
		</td>
	</tr>
		</table>
		</form>
	</td>
	<td width="%14$s" valign="top">
	%16$s
	%15$s
	</td>
	</tr>
	</table>
	</div>
	</div>';

}

?>