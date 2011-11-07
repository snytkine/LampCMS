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

class tplSimtabs extends Lampcms\Template\Fast
{
	/**
	 * $aData will be submitted in format:
	 *
	 *  $aData = array(
	 *	array('Similar Threads', 'div contents'),
	 *	array('Similar Questions', 'div contents'));
	 *
	 * Data array will be prepared and ready
	 * to be used in this template
	 * 
	 * Don NOT Change this if you don't understand
	 * it!
	 * 
	 * @param array $a
	 */
	protected static function func(&$a){
		$aTmp = $a;
		$lis = '';
		$divs = '';
		for($i = 0; $i < count($aTmp); $i += 1){
			$class = (0 === $i) ? 'selected' : 'atab';
			$lis .= sprintf('<li class="%s"><a href="#simtab%d"><span class="i18n">%s</span></a></li>', $class, ($i+1), $aTmp[$i][0]);
			$divs .= sprintf('<div id="simtab%d">%s</div>', ($i+1), $aTmp[$i][1]);
		}

		$a['lis'] = $lis;
		$a['divs'] = $divs;
	}




	protected static $vars = array(
	'lis' => '',
	'divs' => ''
	);

	protected static $tpl = '
	<div id="sims">
    	<ul class="yui-nav">%1$s</ul>
    	<div class="yui-content">%2$s</div>
	</div>';
}