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

//namespace Lampcms\Template;

//use Lampcms\Template\Fast;

/**
 * Qview is the main template to
 * view just about any page
 * in questions module
 * 
 * In default view it has 2 columns,
 * in mobile view it will have just one
 * column.
 * 
 * Header has something like breadcrumb,
 * body has the parsed view of oneQuestion 
 * or List view template
 * 
 * and the right column (or somewhere at the bottom
 * or not all all in mobile view) is the block with
 * tags like 'recent tags' or 'unanswered tags' or
 * 'related tags' or could be 'similar questions' when
 * viewing a single question.
 *
 * @author Dmitri Snytkine
 *
 */
class tplQview extends Lampcms\Template\Fast{

	protected static $vars = array(
	'header' => '', //1
	'body' => '', //2
	'footer' => '', //3
	'tags' => '', // 4
	'toptabs' => '', // 5
	'topright' => '', // 6
	'right2' => '', // 7
	'right3' => '', // 8
	'right4' => '', // 9
	'right5' => '' // 10
	);


	protected static $tpl = '
	<div id="qview">
	<div class="yui-ge">
         <div class="yui-u first">
         	<div id="qview-main">
         	%5$s
         		<div class="qheader">%1$s</div>
         		<div id="qview-body">%2$s</div>
         	</div>	
         	<div id="qview-footer">%3$s
         	<div id="ccwiki-copyright">Questions and Answers are licensed under <a href="http://creativecommons.org/licenses/by-sa/2.5/" rel="nofollow" target="_blank">cc-wiki</a> license.</div>
         	</div>
         </div>
    	<div class="yui-u">
         <!-- right side -->
         	<div id="qview-side">
         	%6$s
         	%7$s
         	%8$s
         	%9$s
         	%10$s
         	%4$s
         	</div>
         </div>
      </div>
      </div>';
}