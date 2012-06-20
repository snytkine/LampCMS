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
 * @copyright  2005-2009 (or current year) Dmitri Snytkine
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */

/**
 * This small login form
 * is added to quick registration
 * modal on right side
 * above the 'join with Twitter, FB, etc...'
 *
 * @author Dmitri Snytkine
 *
 */
class tplLoginblock extends Lampcms\Template\Fast
{
    protected static $vars = array('Already a member?<br>Please login');

    protected static $tpl = '
	<div class="loginBlock">
	<form accept-charset="utf-8" action="{_WEB_ROOT_}/" method="post" enctype="application/x-www-form-urlencoded" name="mLogin" id="mLogin">
	<input name="a" type="hidden" value="login">
	<table class="login_block">
	<tr>
	<th colspan="2">%1$s</th>
	</tr>
	<tr>
	<td colspan="2">@@Username@@<br>
	<input type="text" class="inlogin" name="login" id="login" size="15" accesskey="u" tabindex="41">
	</td></tr>
	<tr>
	<td colspan="2">@@Password@@<br>
	<input type="password" name="pwd" class="inpwd" id="pwd" size="10" tabindex="42"><br>
	<a href="{_WEB_ROOT_}/{_remindpwd_}/" class="forgot">@@Forgot password@@?</a>
	</td></tr>
	<tr>
	<td class="chkRemember" align="left" nowrap><label for="chkRemember">
	<input name="chkRemember" type="checkbox" value="3" id="chkRemember">@@Remember me@@?</label></td>
	<td align="left" class="btnGo"><input id="go" value="@@Log in@@" type="submit" tabindex="43"></td>
	</tr>
	</table>
	</form>
	</div>
	';
}

?>
