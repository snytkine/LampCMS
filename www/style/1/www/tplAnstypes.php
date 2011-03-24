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

class tplAnstypes extends Lampcms\Template\Template
{
	protected static $vars = array(
	'i_lm_c' => '', // 1
	'i_score_c' => '', //2
	
	'i_lm' => 'Active', //3 
	'i_lm_t' => 'Most recenty active', //4
	
	'i_score' => 'Most Voted', //5
	'i_score_t' => 'Answers with highest votes', //6

	'i_ts_c' => '', //7
	'i_ts' => 'Oldest', // 8
	'i_ts_t' => 'Oldest to recent' // 9
	
	);

	protected static $tpl = '
	<div id="qtypes" class="cb fl">
		<a id="i_lm_ts" rel="nofollow" href="#" class="ajax qtype%1$s ttt" title="%4$s"><span rel="in">%3$s</span></a>
		<a id="i_ts" rel="nofollow" href="#" class="ajax qtype%7$s ttt" title="%9$s"><span rel="in">%8$s</span></a>
		<a id="i_votes" rel="nofollow" href="#" class="ajax qtype%2$s ttt" title="%5$s"><span rel="in">%5$s</span></a>
	</div>';
}