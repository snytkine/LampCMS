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

class tplFormask extends Lampcms\Template\Template
{
	/**
	 * Important: names of form fields
	 * must match the keys in this array
	 * for example 'title', 'body', 'tags'
	 * must be names of form fields
	 *
	 * @var array
	 */
	protected static $vars = array(
	'token' => '', //1
	'required' => 'required', //2
	'title' => '', //3
	'title_l' => 'Title', // 4
	'title_d' => 'Please enter a descriptive title at least 10 characters long',
	'title_e' => '', // 6
	'title_c' => 'ask_title', // 7
	'qbody' => '', //8
	'qbody_e' => '', //9
	'tags' => '', //10
	'tags_l' => 'Tags', //11
	'tags_d' => 'At least one tag, max 5 tags separated by spaces', //12
	'tags_e' => '', //13
	'submit' => 'Submit', //14
	'com_hand' => '', // 15
	'readonly' => '', // 16
	'disabled' => '', // 17
	'connectBlock' => '', //18
	'formError' => '', //19
	'tags_required' => '', //20
	'socials' => '' //21
	); 

	protected static $tpl = '
	<div id="ask_form"  class="form_wrap">
	<div class="form_error">%19$s</div>
		<form class="qa_form" name="qaForm" method="POST" action="/index.php" accept-charset="utf-8">
		<input type="hidden" name="a" value="ask">	
		<input type="hidden" name="token" value="%1$s">
		%18$s
		<div class="form_el"> 
                <label for="id_title">%4$s</label> <span class="f_err" id="title_e">%6$s</span><br> 
                <input autocomplete="off" id="id_title" class="title_c%15$s" type="text" name="title" size="80" value="%3$s" %16$s> 
                <div id="title_d" class="caption">%5$s</div> 
       </div>
       <!-- // el title -->
            <div id="similar_questions"></div> 
            <div class="form_el"> 
                <textarea id="id_qbody" rows="6" cols="40" class="com_body%15$s" name="qbody" %16$s>%8$s</textarea>
                <span class="f_err fl cb" id="qbody_e">%9$s</span>
                <div id="body_preview"></div>
                <span class="label">Preview</span>
                <div id="tmp_preview"></div>
            </div>
            <!-- // el body -->
            
            <div class="form_el"> 
            	<label for="id_tags">%11$s</label> %20$s <span class="f_err"  id="tags_e">%13$s</span><br> 
                <input id="id_tags" type="text" name="tags" class="tags_c%15$s" size="80" value="%10$s" %16$s>  
            	<div id="tags_d" class="caption">%12$s</div> 
            </div>
            <!-- // el tags -->
            <div class="fl cb socials">
            %21$s
            </div>
            <div class="form_el">
            	<input id="dostuff" name="submit" type="submit" value="%14$s" %17$s class="btn btn-m"> 
            </div>
            <!-- // el submit -->
		</form>
	</div>';
}
