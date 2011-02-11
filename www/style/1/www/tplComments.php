<?php
/**
 *
 * PHP 5.2 or better is required
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
 * @copyright  2005-2009 (or current year) ExamNotes.net inc.
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */

/**
 * Template for one comment block
 * @author admin
 *
 */
class tplComments extends Lampcms\Template\Template
{
	protected static $vars = array(
	'_id' => 0,
	'av' => '',
	'usr' => '',
	'ts' => '',
	'dt' => '',
	'b' => '',
	'replies' => '',
	'reply' => 'Reply',
	'replyLink' => '' // id of parent if this is a reply set only for replies
	);

	/**
	 * <a href="/index.php?a=reply&amp;comid=%1$s&amp;parentid=%9$s"><span class="reply">%8$s</span></a>
	 * @var unknown_type
	 */
	protected static $tpl = '
	<div class="comment" id="com_%1$s">
		<div class="comdiv">
			<div class="poster">
				<span class="avatar">
						<img src="%2$s" width="48" height="48" class="uavatar" alt="%4$s" />
				</span>
				<span class="username">%3$s</span>
			</div>
			<div class="com_time" title="%5$s" ts="%4$s">%5$s</div>
			<div class="c_b">%6$s</div>
			<div class="com_ft">
				%9$s
			</div>
		</div>
		%7$s
	</div>';
}


?>