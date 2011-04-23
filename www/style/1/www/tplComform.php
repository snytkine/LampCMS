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


class tplComform extends Lampcms\Template\Template
{

	protected static $vars = array(
	'token' => '1',
	'rid' => '',
	'qs' => '',
	'pageID' => '0',
	'label' => '', //5
	'avatar' => '',
	'text' => '',
	'btn' => 'Post comment',
	'header' => '',
	'connectBlock' => '', //10
	'readonly' => 'no', //11
	'hand' => '', //12
	'disabled' => '' //13
	);


	protected static $tpl = '<div id="comformdiv">
	%9$s
	<a name="com_label"></a>
	<span class="com_label rounded">%5$s</span>
	%10$s
	<form class="comment_form" accept-charset="utf-8" action="/index.php" enctype="application/x-www-form-urlencoded" method="post" name="uForm">
<input name="a" type="hidden" value="rcomment">
<input name="token" type="hidden" value="%1$s">
<input name="rid" type="hidden" value="%2$s">
<input name="com_id" type="hidden" value="0">
<input name="qs" type="hidden" value="%3$s">
<input name="pageID" type="hidden" value="%4$s">
<table class="cform">
<tr> 
<td width="64px" valign="top" align="right" class="avt">
%6$s
</td> 
<td> <!--  width="90%%" -->
<TEXTAREA cols="40" rows="6" name="mbody" class="com_text%12$s" %11$s>%7$s</TEXTAREA>

</td> 
</tr> 
<tr> 
<td></td> 
<td align="right">
<input class="btn btn-m" type="submit" name="dostuff" %13$s value="%8$s">
</td> 
</tr> 
</table> 
</form></div>';
	
}

