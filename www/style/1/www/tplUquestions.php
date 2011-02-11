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

class tplUquestions extends \Lampcms\Template\Template
{

	protected static $vars = array(
	'_id' => '0', //1
	'i_votes' => '0', //2
	'i_ans' => '0', //3
	'i_views' => '0', //4
	'url' => '', //5
	'intro' => '', //6
	'title' => '', //7
	'tags_c' => '', //8
	'tags_html' => '', //9
	'status' => 'un', //10
	'username' => '', //11
	'avtr' => '',//12
	'hts' => '',//13
	'i_ts' => '',//14
	'vw_s' => 's',//15
	'v_s' => '',//16
	'ans_s' => ''//17
	);

	protected static $tpl = '
	<div class="qrow" id="q-%1$s">  
	    <div class="qstats2">        
	       <div class="sqr1 vc2">
	          %2$s
	          <br>
	          vote%16$s
	       </div>
	       <div class="sqr1 %10$s">
	       <span class="middle">
	       		%3$s
	       		<br>answer%17$s
	       		</span>
	       </div>
	       <div class="sqr1 vws2">
	         	%4$s
	         	<br>
	         	view%15$s
	       </div>
	    </div>
    <!-- //statsdiv -->
    <div class="smmry2">
        <a href="/q%1$s/%5$s" class="ql" title="%6$s">%7$s</a><br>
        <div class="tgs2 %8$s">%9$s</div>
        <div class="asked2"><span rel="in">asked </span><span title="%13$s" class="ts" rel="time">%13$s</span></div>
            
    </div>
    <!-- //smmry -->
	</div>
	<!-- //qs -->';
}
