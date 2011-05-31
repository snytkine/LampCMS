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
 * Template for rendering one
 * answer.
 *
 * Need a way to add "Accept" link
 * IF viewer is also question owner
 * We can easily do this with javascript
 * by checking viewer ID in meta
 * and comparing to owner-id
 * of question. But it's not so
 * easy on server side because we loop
 * over mongo cursor, it does not know
 * who is a viewer, so...
 * We can pass callback function but
 * right now we don't have a good way
 * to pass callback to ::loop method
 * and even if we do, we would need to apply
 * the callback to each iteration, not very
 * effecient.
 *
 * @author Dmitri Snytkine
 *
 */
class tplAnswer extends Lampcms\Template\Template
{

	protected static function func(&$a){
		if(array_key_exists('a_edited', $a)){
			$a['edits'] = \tplEditedby::parse(end($a['a_edited']), false);
		}

		if(!empty($a['i_del_ts'])){
			$a['deleted'] = ' deleted';
		}

		if(!empty($a['a_deleted'])){
			$a['deletedby'] = \tplDeletedby::parse($a['a_deleted'], false);
		}

		if(!empty($a['a_comments'])){
			$a['comments_html'] = tplComment::loop($a['a_comments']);
		}
	}

	protected static $vars = array(
	'_id' => '', // 1
	'b' => '', // 2
	'ulink' => '', // 3
	'avtr' => '', // 4
	'hts' => '', // 5
	'i_votes' => '', // 6
	'i_uid' => '0', // 7
	'accepted_text' => '', //8
	'accepted_class' => 'accept_answer', // 9
	'vote_up' => "\xE2\x87\xA7", // 10 \xE2\x87\xA7
	'vote_down' => "\xE2\x87\xA9", //11
	'accept_link' => '&nbsp', // 12,
	'accepted' => '', //13
	'i_flags' => '', // 14
	'edits' => '', // 15
	'deleted' => '', //16
	'deletedby' => '', //17
	'comments_html' => '', //18
	'edit_delete' => '', // 19
	'i_comments' => '0', // 20
	'nocomments' => '', //21
	'i_lm_ts' => '0' // 22
	);


	protected static $tpl = '<table class="ans_table%16$s" id="ans%1$s" lampcms:rid="%1$s" lampcms:i_votes="%6$s" lampcms:i_lm_ts="%22$s" lampcms:i_comments="%20$s" lampcms:i_uid="%7$s">
	<tr>
		<td class="td_votes" width="60px">
		<div class="votebtns cb" id="vote%1$s">
		<a id="upvote-%1$s"
			title="I like this answer (click again to cancel)"
			class="ttt ajax vote thumbup" href="/ansvote/%1$s/up" rel="nofollow">%10$s</a>
		<div id="score%1$s" class="qscore">%6$s</div>

		<a id="downvote-%1$s"
			title="I dont like this answer (click again to cancel)"
			class="ttt ajax vote thumbdown down" href="/ansvote/%1$s/down" rel="nofollow">%11$s</a>
		</div>
		<div class="acceptit anstype">%13$s</div>
		<div class="acceptit">%12$s</div>
		</td>

		<td class="td_answer">
		<div class="ans_body" id="ansbody-%1$s">%2$s</div>

		<div class="answer controls uid-%7$s" id="res_%1$s">
		   	<span class="ico flag ttt" title="Flag this answer as inappropriate">flag</span>%19$s
		</div>
		<!-- // -->
		<table class="foot">
            <tr>
            <td class="edits" valign="top">
            %15$s
            </td>
            <td class="td_poster">
            <div class="usr_info2">
            <div class="qtime">answered <span title="%5$s" class="ts">%5$s</span></div>
            <div class="avtr32">
             <img src="%4$s" height="32" width="32" alt="">
            </div>
            	<div class="usr_details usr usr_%7$s">
            	%3$s<br>
            	<span class="reputation" title="reputation score"></span>
				</div>
			</div>
			%17$s
            </td>
            </tr>
            </table>
		</td>
	</tr>
	<tr>
	<td></td>
	<td>
		<div class="comments%21$s i_comments_%20$s" id="comments-%1$s">
		%18$s
			<div class="add_com cb fl">
				<span class="ico comment fl"> </span><a href="#" class="ajax com_link uid-%7$s" id="comlink_%1$s">add comment</a>
			</div>
		</div>
	</td>
	</tr>
	</table>';
}
