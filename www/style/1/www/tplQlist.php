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
 * Qlist template
 * designed to display a list of items
 * like list of divs, each one is a question,
 * for example 'all questions' or by tag or 'hot questions'
 * it has 3 parts;
 * title, body and pagination block
 * 
 * The reason that pagination is included
 * in this template is because we can send this parsed
 * 
 * template as ajax response, and it will be complete
 * with pagination.
 * 
 *
 * @author Dmitri Snytkine
 *
 */
class tplQlist extends Lampcms\Template\Template
{
	protected static $vars = array(
	'qtypes' => '', 
	'qlist' => '', 
	'pages' => '',
	'notAjaxPaginatable' => '');

	// <div id="qpages">%3$s</div>
	protected static $tpl = '
	%1$s
	<div class="sortable paginated%4$s qlist">%2$s</div>
	%3$s';
	
}
