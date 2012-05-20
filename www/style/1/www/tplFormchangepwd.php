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

class tplFormchangepwd extends \Lampcms\Template\Fast
{

	protected static $vars = array(
	'token' => '', //1
	'required' => 'required', //2
	'current' => '', //3
	'current_l' => 'Current Password', // 4
	'current_d' => 'Enter your current password',
	'current_e' => '', // 6
	'pwd1' => '', //7
	'pwd1_e' => '', //8
	'pwd1_l' => 'Enter new password', //9
	'pwd2' => '', //10
	'pwd2_l' => 'Confirm new password', //11
	'pwd2_e' => '', //12
	'submit' => 'Save', //13
	'formTitle' => '', // 14
    'formError' => '', //15
	'forgot' => 'Forgot password?' //16
	); 
	
	
	protected static $tpl = '
	<form name="pwdForm" method="POST" action="/index.php" accept-charset="utf-8">
	<div id="tools" class="frm">
	<div class="frmtitle">%14$s</div>
	<div class="form_error">%15$s</div>
		<input type="hidden" name="a" value="changepwd">	
		<input type="hidden" name="token" value="%1$s">
		<div class="form_el1"> 
                <label for="id_current">%4$s</label>: <span class="f_err">%6$s</span><br> 
                <input autocomplete="off" id="id_current" class="current_c" type="text" name="current" size="20" value="%3$s"> 
       		  	<div id="current_d" class="caption">%5$s<br><a href="/remindpwd/">%16$s</a></div><hr>
        </div>
       <!-- // el current -->
            
            <div class="form_el1"> 
                <label for="id_pwd1">%9$s</label>: <span class="f_err">%8$s</span><br> 
                <input autocomplete="off" id="id_pwd1" class="pwd1_c" type="text" name="pwd1" size="20" value="%7$s"> 
            </div>
            <!-- // pwd1 -->
            
            <div class="form_el1"> 
            	<label for="id_pwd2">%11$s</label>: <span class="f_err">%12$s</span><br> 
                <input autocomplete="off" id="id_pwd2" class="pwd2_c" type="text" name="pwd2" size="20" value="%10$s">            
            </div>
            <!-- // pwd2 -->
            
            <div class="form_el1">
            	<input id="frmsub1" name="submit" type="submit" value="%13$s" class="btn btn-m"> 
            </div>
            <!-- // el submit -->
		
	</div>
	</form>';

}
