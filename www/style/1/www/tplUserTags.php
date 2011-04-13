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
 * This template renders block
 * with "User tags" on user profile page
 * and "User following these tags" block
 * on the profile page
 * 
 * @author Dmitri Snytkine
 *
 */
class tplUserTags extends Lampcms\Template\Template
{
	protected static function func(&$a){
		if($a['count'] != 1){
			$a['s'] = 's';
		}
	}
	
	protected static $vars = array(
	'count' => '', //1
	'label' => '', //2
	'tags' => '', //3
	's' => ''
	);
	
	// %2$s%4$s
	protected static $tpl = '
	<div class="user_tags cb fl">
	<h3><span class="counter">%1$s</span></h3>
		<div id="utags2">
			%3$s
		</div> 
	</div> 
	<!-- // user_tags  -->
	';
}
