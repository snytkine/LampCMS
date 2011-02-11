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

class tplLoginform extends Lampcms\Template\Template
{
	protected static $vars = array();

	protected static $tpl = '<form action="/index.php" method="post" name="frmLogin" id="frmLogin">
<input name="_qf__frmLogin" type="hidden" value="">
<input name="a" type="hidden" value="login">
<input name="r" type="hidden" value="%1$s">
<table border="0">
<tr>
<td>%2$s</td>
<td>
<input type="text" class="inlogin" name="login" id="login" size="15" accesskey="u" tabindex="1"></td>
<td class="chkRemember" colspan="2" align="left" nowrap="nowrap"><label for="chkRemember">
<input name="chkRemember" type="checkbox" value="3" id="chkRemember">%4$s</label></td>
</tr>
<tr>
<td><label for="pwd">%3$s</label></td>
<td><input type="password" name="pwd" class="inpwd" id="pwd" size="10" tabindex="4"></td>
<td align="left" class="btnGo"><input id="go" value="%9$s" type="submit"></td>
<td><a href="%5$s" class="forgot">%6$s</a></td>
</tr>
<tr>
<td></td>
<td colspan="3" align="left" class="signup"><a href="%7$s" class="signup">%8$s</a></td>
</tr>
<tr>
<td colspan="4" align="left" class="loginErr">
<div class="titleWarning" id="titleWarning">%13$s</div>
</td>
</tr>
<tr>
<td></td>
<td colspan="3" align="left">
<div class="extauth">%11$s</div>	
<div class="extauth">%12$s</div>	
</td>
</tr>
%10$s
</table>
</form>';
	
}
