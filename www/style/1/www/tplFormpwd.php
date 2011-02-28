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

class tplFormpwd extends Lampcms\Template\Template
{

	protected static $vars = array(
	'token' => '', //1
	'required' => 'Required field', //2
	'title' => 'Forgotten password', //3
	'login_l' => 'Username OR email address', // 4
	'login_d' => 'If you have forgotten your
		username or password, you can request to have your username emailed to
		you and to reset your password. When you fill in your registered email
		address, you will be sent instructions on how to reset your password.',
	'login_e' => '', // 6
	'login_c' => 'login_title', // 7
	'formError' => '', // 8
	'submit' => 'Submit', //9
	'reset' => 'Reset', // 10
	'login' => '' // 11
	);


	protected static $tpl = '<div id="userForm" class="frm1">
<div class="frmtitle">%3$s</div>
<form id="frm1" name="frm1" method="post" action="/index.php"
	enctype="application/x-www-form-urlencoded" accept-charset="utf-8">
<input name="token" type="hidden" value="%1$s"> <input name="a"
	type="hidden" value="remindpwd">
<table class="qform">
	<tr>
		<th colspan="2">
		<div id="eprog">%5$s</div>
		</th>
	</tr>
	<tr>
		<td colspan="2" id="qfmessage">
		<div id="qfe">%8$s</div>
		</td>
	</tr>
	<tr valign="top">
		<td align="right" class="labl">
		<span style="color: #FF0000;">* </span>%4$s
		</td>
		<td><input size="20" maxlength="255" id="id_login" name="login"
			type="text" value="%11$s">
			<br>
			<div style="color: #FF0000;">%6$s</div></td>
	</tr>
	<tr>
		<td></td>
		<td align="left" valign="top">
		<table class="subres">
			<tr>
				<td width="50%%"><input class="btn btn-m" type="submit"
					name="dostuff" value="%9$s"></td>
				<td><input class="btn btn-m" type="reset"
					name="reset" value="%10$s"></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td></td>
		<td align="left" valign="top"><span style="color: #FF0000;">
		* </span><span style="font-size: larger;">%2$s</span><br>
		<div id="rtediv"></div>
		</td>
	</tr>
</table>
</form>
</div>';

}
