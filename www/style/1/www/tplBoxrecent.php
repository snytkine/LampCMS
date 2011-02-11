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
 * template for one recent tags
 * or unanswered tags box
 * this box holds title of box
 * and the 'tags' element will
 * be a div with recent items
 *
 * @author Dmitri Snytkine
 *
 */

/**
 * This template is used to render
 * the block that holds 'Recent tags'
 * (Or unanswered tags)
 *
 * @todo make html that will result in rendering
 * an HTML for creation of YUI tabbed view
 * with only 1 tab. Other tabs will
 * be added by JS dynamically.
 * JS will dynamically add ONLY tabs and will
 * subscribe them to onClick to dymanically
 * download the content of the tab body.
 *
 * Then this template will not be good for
 * 'unanswered' tabs, then we will have to
 * make separate template for holding unanswered tabs
 * and we can just copy this one or something like that
 *
 * @author Dmitri Snytkine
 *
 */
class tplBoxrecent extends Lampcms\Template\Template
{
	protected static $vars = array(
	'title' => 'Recent Tags', 
	'id' => 'recent-tags', 
	'tags' => '');

	protected static $tpl = '
	<div class="box" id="%2$s">
    	<div class="title">%1$s</div>
    		
    		%3$s
    		
	</div>';
}