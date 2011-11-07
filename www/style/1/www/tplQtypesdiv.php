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
 * Template for making the top div in the
 * questions list view
 *
 * In order to set the currently viewed types of questions
 * as 'current', just pass 'current' as a value
 * for the corresponding questions view type
 * for example 'Unanswere' => '1'
 *
 * @author Dmitri Snytkine
 *
 */
class tplQtypesdiv extends \Lampcms\Template\Fast
{
	protected static $vars = array(
	'newest_c' => '', //1
	'voted_c' => '', //2
	'active_c' => '', //3
	'newest' => 'Newest', //4
	'newest_t' => 'Most recent questions', //5
	'voted' => 'Most Voted', //6
	'voted_t' => 'Questions with most votes', //7
	'active' => 'Most Active', //8
	'active_t' => 'Questions with most activity' //9
	);

	protected static $tpl = '
	<div id="qtypes">
	<a href="/questions/" rel="nofollow" class="ttt2 qtype%1$s" title="%5$s"><span rel="in">%4$s</span></a>
	<a href="/voted/" rel="nofollow" class="ttt2 qtype%2$s" title="%7$s"><span rel="in">%6$s</span></a>
	<a href="/active/" rel="nofollow" class="ttt2 qtype%3$s" title="%9$s"><span rel="in">%8$s</span></a>
	</div>';
	
}
