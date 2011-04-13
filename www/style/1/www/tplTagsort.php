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
 * Template for displaying the
 * Options (tags) for sorting the Tags list view
 * Can be sorted by "Popular", "Name", "Recent"
 *
 * Used in wwwViewtags
 */
class tplTagsort extends Lampcms\Template\Template
{
	protected static $vars = array(
	'popular_c' => '', //1
	'name_c' => '', //2
	'recent_c' => '', //3
	'popular' => 'Popular', //4
	'popular_t' => 'Most popular tags', //5
	'name' => 'Name', //6
	'name_t' => 'Sort by name', //7
	'recent' => 'Latest', //8
	'recent_t' => 'Tags with most recent questions' //9
	);

	protected static $tpl = '
	<div id="qtypes" class="cb fl reveal hidden">
	<a href="/tags/popular/" class="ajax sortans ttt2 qtype%1$s" title="%5$s"><span rel="in">%4$s</span></a>
	<a href="/tags/name/" class="ajax sortans ttt2 qtype%2$s" title="%7$s"><span rel="in">%6$s</span></a>
	<a href="/tags/recent/" class="ajax sortans ttt2 qtype%3$s" title="%9$s"><span rel="in">%8$s</span></a>
	</div>';
}