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
 * @copyright  2005-2012 (or current year) Dmitri Snytkine
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */


class tplUanswers extends \Lampcms\Template\Fast
{

    protected static $vars = array(
        '_id' => '0', //1
        'i_qid' => '', //2
        'title' => '', //3
        'accepted' => '', //4
        'hts' => '', //5
        'i_ts' => '', //6
        'i_votes' => '0', //7
        'v_s' => '', //8
        'ans_s' => '', //9
        'answered' => 'answered' // 10
    );

    protected static $tpl = '
	<div class="qrow" id="q-%2$s">  
	    <div class="qstats2">        
	       <div class="sqr1 ansvotes%4$s">
	          %7$s
	          <br>
	          vote%8$s
	       </div>
	    </div>
    <!-- //statsdiv -->
    <div class="smmry2">
        <a href="/q%2$s/#ans%1$s" class="ql" title="%3$s">%3$s</a><br>
        <div class="asked2"><span rel="in">%10$s </span><span title="%6$s" class="ts" rel="time">%5$s</span></div>           
    </div>
    <!-- //smmry -->
	</div>
	<!-- //qs -->';
}
