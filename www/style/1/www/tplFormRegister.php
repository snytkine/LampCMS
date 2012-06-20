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

/**
 * Template for the registration form
 *
 * @author Dmitri Snytkine
 *
 */
class tplFormRegister extends \Lampcms\Template\Fast
{
    protected static $vars = array();


    protected static $tpl = '<form id="regform" method="post" action="{_WEB_ROOT_}/">
		<input type="hidden" name="a" value="%13$s"/>
		<input type="hidden" name="tzo" value=""/>
		<input type="hidden" name="token" value="%4$s"/>
		<table id="tblreg" align="left" cellpadding="0" cellspacing="0">
		<!-- tr1 optional avatar, twitter/fb username -->
		%5$s
		<!-- username -->
		%6$s
		<!-- email -->
		<tr>
		<td>
		<div class="tr">
		<span class="red"> * </span><span class="label2">%7$s</span><br/>
		<input type="text" id="email" name="email" value="%8$s"/>
		<div class="note2">%9$s</div>
		</div>
		</td>
		</tr>
		<!-- optional TR for Captcha image and form -->
		%10$s
		<!-- checkbox email offers -->
		%11$s
		<tr>
		<td><span class="red"> * </span><span class="label2">Denotes required fields</span><br/></td>
		</tr>
		<!-- submit button -->
		%12$s
		</table>
		</form>';
}
