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

/**
 * Template for the answer form
 *
 * @author Dmitri Snytkine
 *
 */
class tplFormanswer extends Lampcms\Template\Template
{

	protected static $vars = array(
	'token' => '', //1
	'required' => 'required', //2
	'qbody' => '', //3
	'qbody_e' => '', //4
	'submit' => 'Submit answer', //5
	'com_hand' => '', // 6
	'readonly' => '', // 7
	'disabled' => '', // 8
	'connectBlock' => '', // 9
 	'formError' => '', // 10
	'title' => 'Your answer', //11
	'qid' => '', //12
	'socials' => '' //13
	);

	protected static $tpl = '
	<div id="answer_form" class="form_wrap">
	<h4 class="form_title">%11$s</h4>
	<div class="form_error">%10$s</div>
		<form class="qa_form" name="ansForm" method="POST" action="/index.php" accept-charset="utf-8">
		<input type="hidden" name="a" value="answer">
		<input type="hidden" name="qid" value="%12$s">	
		<input type="hidden" name="token" value="%1$s">
		%9$s
            <div class="form_el"> 
                <textarea id="id_qbody" rows="10" cols="40" class="com_body%6$s" name="qbody" %7$s>%3$s</textarea><br>
                <span class="f_err">%4$s</span>
                <div id="body_preview"></div>
                <span class="label">Preview</span>
                <div id="tmp_preview"></div>
            </div>
            <!-- // el body -->
            <div class="fl cb socials">
            %13$s
            </div>
            <div class="form_el">
            	<input id="dostuff" name="submit" type="submit" value="%5$s" %8$s class="btn btn-m"> 
            </div>
            <!-- // el submit -->
		</form>
	</div>';
}