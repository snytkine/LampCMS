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
 * Template for a block on
 * user profile page
 * This is just one block
 * There will be other blocks on
 * user profile page like
 * Block with all user questions, another one
 * with user answers, etc.
 * 
 * @author Dmitri Snytkine
 *
 */
class tplUserInfo extends Lampcms\Template\Template
{
	
	protected static $vars = array(
	'username' => '', // 1
	'avatar' => '', //2
	'reputation' => '', // 3
    'reputationLabel' => 'reputation', // 4
	'name' => '', // 5
	'nameLabel' => 'Name', // 6
	'since' => '', // 7
	'sinceLabel' => 'Member since', // 8
	'lastActivity' => '', // 9
	'lastLabel' => 'Last seen', // 10
	'website' => '',// 11
	'websiteLabel' => 'Website', //12
	'twitter' => '', // 13
	'twitterLabel' => 'Twitter', //14
	'facebook' => '', //15
	'facebookLabel' => 'Facebook', // 16
	'location' => '', // 17
	'locationLabel' => 'Location', //18
	'age' => '', //19
	'ageLabel' => 'Age', //20
	'description' => '' //21
	);
	
	
	protected static $tpl = '
<div class="yui3-g" id="view_profile">
<div class="yui3-u-1-5" id="profileLeft">
	<div class="profile_avatar">%2$s</div>
	<div class="user_score">%3$s<br><span>%4$s</span></div>
</div>
<div class="yui3-u-2-5" id="profileMiddle">
<table class="user_stuff">
	<tr>
		<th colspan="2">%1$s</th>
	</tr>
	<tr>
		<td>%6$s</td>
		<td>%5$s</td>
	</tr>
	<tr>
		<td>%8$s</td>
		<td>%7$s</td>
	</tr>
	<tr>
		<td>%10$s</td>
		<td>%9$s</td>
	</tr>
	<tr>
		<td>%12$s</td>
		<td>%11$s</td>
	</tr>
	<tr>
		<td>%14$s</td>
		<td>%13$s</td>
	</tr>
	<tr>
		<td>%16$s</td>
		<td>%15$s</td>
	</tr>
	<tr>
		<td>%18$s</td>
		<td>%17$s</td>
	</tr>
	<tr>
		<td>%20$s</td>
		<td>%19$s</td>
	</tr>
</table>
</div>
<div class="yui3-u-2-5" id="profileRight">
  <div class="user_description">%21$s</div>
</div>
</div>';
	
	
}
