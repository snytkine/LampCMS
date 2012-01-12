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

class tplFormask extends Lampcms\Template\Simple
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
	'token' => '', 
	'required' => 'required', 
	'title' => '', 
	'title_l' => 'Title', 
	'title_d' => 'Enter a descriptive title',
	'title_e' => '', 
	'title_c' => 'ask_title', 
	'qbody' => '', 
	'qbody_e' => '',
	'tags' => '', 
	'tags_l' => 'Tags', 
	'tags_d' => 'At least one tag, max 5 tags separated by spaces',
	'tags_e' => '',
	'category' => '', 
	'category_class' => 'category',
	'category_l' => 'Category', 
	'category_e' => '',
	'category_menu' => '',
	'submit' => 'Submit',
	'com_hand' => '',
	'readonly' => '', 
	'disabled' => '', 
	'connectBlock' => '',
	'formError' => '',
	'tags_required' => '', 
	'socials' => '', 
	'Preview' => 'Preview' 
	); 

	protected static $tpl = '
	<div id="ask_form"  class="form_wrap">
	<div class="form_error">{formError}</div>
		<form class="qa_form" name="qaForm" method="POST" action="/index.php" accept-charset="utf-8">
		<input type="hidden" name="a" value="ask">	
		<input type="hidden" name="token" value="{token}">
		{connectBlock}
		<div class="form_el"> 
                <label for="id_title">{title_l}</label> <span class="f_err" id="title_e">{title_e}</span><br> 
                <input autocomplete="off" id="id_title" class="title_c{com_hand}" type="text" name="title" size="80" value="{title}" {readonly}> 
                <div id="title_d" class="caption">{title_d}</div> 
       </div>
       <!-- // el title -->
            <div id="similar_questions"></div> 
            <div class="form_el"> 
                <textarea id="id_qbody" rows="6" cols="40" class="com_body{com_hand}" name="qbody" {readonly}>{qbody}</textarea>
                <span class="f_err fl cb" id="qbody_e">{qbody_e}</span>
                <div id="body_preview"></div>
                <span class="label">{Preview}</span>
                <div id="tmp_preview"></div>
            </div>
            <!-- // el body -->
            
            <!-- CATEGORY {category_class} -->
            <div class="form_el {category_class}"> 
            	<label for="id_category">{category_l}</label> <span class="f_err"  id="category_e">{category_e}</span><br> 
                {category_menu}
            	<div id="category_d" class="caption"></div> 
            </div>
            <!-- //CATEGORY -->
            
            <div class="form_el"> 
            	<label for="id_tags">{tags_l}</label> {tags_required} <span class="f_err"  id="tags_e">{tags_e}</span><br> 
                <input id="id_tags" type="text" name="tags" class="tags_c{com_hand}" size="80" value="{tags}" {readonly}>  
            	<div id="tags_d" class="caption">{tags_d}</div> 
            </div>
            <!-- // el tags -->
            <div class="fl cb socials">
            {socials}
            </div>
            <div class="form_el">
            	<input id="dostuff" name="submit" type="submit" value="{submit}" {disabled} class="btn btn-m"> 
            </div>
            <!-- // el submit -->
		</form>
	</div>';
}
