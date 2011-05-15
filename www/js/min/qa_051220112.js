var $Y=YAHOO,$D=YAHOO.util.Dom,$C=$D.getElementsByClassName,$CONN=YAHOO.util.Connect,$=YAHOO.util.Dom.get,$LANG=YAHOO.lang,$COOKIE=YAHOO.util.Cookie,$J=YAHOO.lang.JSON,$W=YAHOO.widget,$L=YAHOO.log,LampcmsException=function(message,exceptionName){this.message=message;this.name=exceptionName||"LampcmsException";};oSL={Regform:function(){}};oAjaxObject={handleSuccess:function(o){var eLastDiv,json,sDoc,sTpl,errDiv,strMessage='',eLogin=$("loginHead"),strContentType=$LANG.trim(o.getResponseHeader["Content-Type"]);switch(strContentType){case'text/json; charset=UTF-8':case'text/javascript; charset=UTF-8':try{json=$J.parse(o.responseText);}catch(e){alert("Invalid json data in responceText "+$LANG.dump(e)
+" strContentType "+strContentType+"<br>oRespnose: "
+$LANG.dump(o.responseText));}
switch(true){case json.hasOwnProperty('exception'):alert(json.exception);break;case json.hasOwnProperty('redirect'):window.location.assign(json.redirect);break;case json.hasOwnProperty('message'):eLogin.innerHTML=json.message;oSL.fColorChange(eLogin,'#00FF00','#FFFFFF');break;case json.hasOwnProperty('quickreg'):eLastDiv=document.createElement('div');eLastDiv.innerHTML=json.quickreg;document.body.appendChild(eLastDiv);oSL.Regform.getInstance().show();break;}
break;}},handleFailure:function(o){alert($LANG.dump(o));}};oSL={toString:function(){return'object oSL';},getQuickRegForm:function(){if(oSL.Regform&&oSL.Regform.hasDialog()){oSL.Regform.getInstance().show();}else{$CONN.asyncRequest("GET","/index.php?a=getregform",oSL.oCallback);}},hideRegForm:function(){if(oSL.Regform){oSL.Regform.getInstance().hide();window.location.reload();}
return false;},getMeta:function(sMetaName,bAsElement){$L('182 looking for meta tag '+sMetaName);var el,i,aMeta=document.getElementsByTagName('meta');$L('43 '+$LANG.dump(aMeta)+' total metas: '+aMeta.length);if(!aMeta){$L('45 no meta tags in document','error');return false;}
for(i=0;i<aMeta.length;i+=1){if(aMeta[i].name&&(aMeta[i].name===sMetaName)&&aMeta[i].content){if(bAsElement){el=aMeta[i];$L('213 meta tag element '+el);return el;}
return aMeta[i].content;}}
return false;},getToken:function(){$L('166 getToken');var token=this.getMeta('version_id');return token;},isLoggedIn:function(){$L('64 this is: '+this);var ret,uid=this.getMeta('session-uid');$L('148 uid: '+uid);ret=(uid&&(uid!=='')&&(uid!=='0'));$L('66 ret: '+ret);return ret;},getTZO:function(){var tzo,nd=new Date();tzo=(0-(nd.getTimezoneOffset()*60));return tzo;},setTZOCookie:function(){$L('109 this is: '+this);var tzo=this.getTZO();$L('117 tzo: '+tzo);$COOKIE.set("tzo",tzo,{path:"/"});},oCallback:{success:oAjaxObject.handleSuccess,failure:oAjaxObject.handleFailure,scope:oAjaxObject},fAddIcon:function(s,b){var el=(typeof(s)==='string')?$(s):s;if(!this.eLoader){this.eLoader=document.createElement("img");this.eLoader.src='/images/ajax-loader.gif';this.eLoader.id="loadericon";}
if(this.eLoader){if(b&&b===true){el.innerHTML='';}
el.appendChild(this.eLoader);}},fRemoveIcon:function(){if(this.eLoader&&this.eLoader.parentNode){$L('include.js 118 eLoader parent: '+this.eLoader.parentNode
+' id: '+this.eLoader.parentNode.id);this.eLoader.parentNode.removeChild(this.eLoader);}},fCompareForms:function(oNewForm,oOldForm){$L($CONN.setForm(oNewForm));$L($CONN.setForm(oOldForm));if($CONN.setForm(oNewForm)===$CONN.setForm(oOldForm)){return true;}
return false;},fColorChange:function(el,sFromColor,sToColor){$L('starting fColorChange for '+el);var myChange,curBg,myChangeBack,element=(typeof el==='string')?$(el):el,sToColor=(sToColor&&typeof sToColor==='string')?sToColor:'#FF0000',sFromColor=(sFromColor&&typeof sFromColor==='string')?sFromColor:'#FFFFFF';$L('element is: '+element);if(element){curBg=$D.getStyle(element,'background-color');$D.setStyle(element,'background-color',sFromColor);myChange=new YAHOO.util.ColorAnim(element,{backgroundColor:{to:sToColor}});myChangeBack=function(){element.style.backgroundColor=curBg;};myChange.onComplete.subscribe(myChangeBack);myChange.animate();}},fParseQf:function(json){$L($LANG.dump(json));var strMessage='',aAvatars,i=0,el,formField,eMessageDiv=$('qfe');switch(true){case json.hasOwnProperty('exception'):if(json.hasOwnProperty('errHeader')){strMessage+='<u>'+json.errHeader+'</u><br>';}
eMessageDiv.innerHTML='<div id="qfErrors">'+strMessage
+json.exception+'</div>';break;case json.hasOwnProperty('errors'):if(json.hasOwnProperty('errHeader')){strMessage+='<u>'+json.errors.errHeader+'</u><br>';}
eMessageDiv.innerHTML='<div id="qfErrors">'+strMessage
+json.errors.errMessage+'</div>';this.aEls=[];for(formField in json){if(json.hasOwnProperty(formField)&&json[formField].hasOwnProperty('err')){el=$('a'+formField);if(el){el.style.backgroundColor='#FFFFCC';this.aEls.push(el);}}}
this.fColorChange('qfmessage','#FF0000','#FFFFFF');break;}
if(oSL.oFrm&&oSL.oFrm.elBtnSubmit){oSL.oFrm.elBtnSubmit.disabled=false;}
var elPbar=$('progressBar'),elAvatarField=$('aavatar');if(elPbar){elPbar.parentNode.removeChild(elPbar);}
if(elAvatarField){$D.setStyle(elAvatarField,'display','block');}}};oSL.tweet=(function(){var oDialog;var siteTitle=oSL.getMeta('site_title');var siteUrl=oSL.getMeta('site_url');var token=oSL.getToken();return{getInstance:function(){var eRootDiv,oFrm,siteDescription,sForm;if(!oDialog){if(!$('dialog1')){sForm='<div class="hd">Please enter your information</div>'
+'<div class="bd"><hr/>'
+'<form method="POST" action="/index.php">'
+'<input type="hidden" name="a" value="tweet">'
+'<input type="hidden" name="token" value="'
+token
+'">'
+'<h3 class="tweetdlg">Tweet this:</h3>'
+'<div class="clear"></div>'
+'<textarea cols="44" rows="5" name="tweet">'
+$('twinvite').title
+' '
+siteTitle
+' '
+siteUrl
+'</textarea>'
+'<div class="clear"></div>'+'</form>';eRootDiv=document.createElement('div');eRootDiv.id='dialog1';document.body.appendChild(eRootDiv);eRootDiv.innerHTML=sForm;}
oDialog=new $W.Dialog("dialog1",{width:"30em",fixedcenter:true,visible:false,constraintoviewport:true,buttons:[{text:"Submit",handler:function(){this.submit();},isDefault:true},{text:"Cancel",handler:function(){this.cancel();}}]});oDialog.beforeSubmitEvent.subscribe(function(){$L('before submit tweet');});oDialog.callback={success:function(o){alert('Tweet sent');},failure:function(o){alert('Tweet not sent');}};oDialog.setHeader("Invite Your Friends");oDialog.render(document.body);}
return oDialog;},destroy:function(){if(oDialog){oDialog.destroy();}},hide:function(){if(oDialog){oDialog.hide();}},setTextArea:function(s){},toString:function(){return'object oDialog created with oSL.dialog()';}};})();oSL.Regform=(function(){var errDiv,oDialog,aDialogs={},oPrompt,handleSubmit=function(){this.submit();},handleCancel=function(){$L('41 clicked on Cancel this is: '+this);oSL.Regform.getPrompt().show();},handleContinue=function(){this.hide();},handleExit=function(){var eAvatar=$('regext');$L('handling exit');this.hide();oSL.Regform.getInstance().hide();if(eAvatar){$COOKIE.set("dnd","1",{path:"/"});}},handleSuccess=function(o){var response,i,aButtons,oMyDialog=oSL.Regform.getInstance();oSL.Regform.enableButtons();aButtons=oSL.Regform.getInstance().getButtons();for(i=0;i<aButtons.length;i+=1){$L('button '+i+' is '+aButtons[i]);}
response=o.responseText;try{json=$J.parse(o.responseText);switch(true){case(json.hasOwnProperty('exception')):setError(json);break;case(json.hasOwnProperty('action')&&(json.action==='done')):oMyDialog.setHeader('Welcome!');oMyDialog.setFooter('');oMyDialog.setBody(json.body);break;}}catch(e){alert("Invalid json data in responceText "+$LANG.dump(e)+"Respnose: "+$LANG.dump(o.responseText));}},handleFailure=function(o){oSL.Regform.enableButtons();oSL.Regform.getInstance().setBody('<p>boo hoo, something is wrong</p>');$L('47 fail ','warn');},setError=function(oError){var i,errDiv=$('form_error'),aInputs,message=oError.exception,oRegform=oSL.Regform.getInstance(),myForm=oRegform.form;errDiv.innerHTML=message;oSL.fColorChange(errDiv,'#FFFFFF','#FF0000');if(oError.type&&('LampcmsCaptchaLimitException'===oError.type)){$LANG.later(2000,oRegform,'destroy');}
if(oError.hasOwnProperty('fields')){aInputs=oError.fields;for(i=0;i<aInputs.length;i+=1){if(myForm.hasOwnProperty(aInputs[i])){myForm[aInputs[i]].style.backgroundColor="#CCFFCC";}}}
if(oError.hasOwnProperty('captcha')){if(oError.captcha.public_key&&oError.captcha.hncaptcha&&oError.captcha.img){myForm.public_key.value=oError.captcha.public_key;myForm.private_key.value='';myForm.hncaptcha.value=oError.captcha.hncaptcha;$('imgcaptcha').innerHTML=oError.captcha.img;}}else{if(myForm.private_key&&oError.type){myForm.private_key.disabled=true;}}},aButtonsDone=[{text:"<-- Return to page",handler:function(){alert('this is '+this);},isDefault:true},{text:"Go to Profile editor -->",handler:function(){alert('go to profile');}}],startProgress=function(o){oSL.Regform.disableButtons();};return{getInstance:function(){$L('cp 13','warn');if(!oDialog){$L('cp 15','warn');$D.removeClass("regdiv","yui-pe-content");$L('cp 17','warn');oDialog=new $W.Dialog("regdiv",{width:"50em",fixedcenter:"contained",visible:false,constraintoviewport:false,hideaftersubmit:false,draggable:true,close:false,modal:true,buttons:[{text:"Create Your Account",handler:handleSubmit,isDefault:true},{text:"Cancel",handler:handleCancel}]});oDialog.callback={success:handleSuccess,failure:handleFailure};oDialog.validate=function(){var at,checkEmail,tzo,message,aInputs=[],myForm=this.form,nd=new Date(),data=this.getData();$L('data: '+$LANG.dump(data));tzo=(0-(nd.getTimezoneOffset()*60));if((myForm.tzo)&&(tzo)){myForm.tzo.value=tzo;}
checkEmail=function(str){var at="@",dot=".",lat=str.indexOf(at),lstr=str.length,ldot=str.indexOf(dot);if(str.indexOf(at)===-1||str.indexOf(at)===0||str.indexOf(at)===lstr){return false;}
if(str.indexOf(dot)===-1||str.indexOf(dot)===0||str.indexOf(dot)===lstr){return false;}
if(str.substring(lat-1,lat)===dot||str.substring(lat+1,lat+2)===dot){return false;}
if((str.indexOf(at)===-1)||(str.indexOf(at,(lat+1))!==-1)||(str.indexOf(dot,(lat+2))===-1)||(str.indexOf(" ")!==-1)){return false;}
return true;};switch(true){case(data.email===""):message="Please enter email address";aInputs.push('email');break;case(data.username===""):message="Please enter Username";aInputs.push('username');break;case(data.hasOwnProperty('private_key')&&(""===data.private_key)):message="Please enter the text from image";aInputs.push('private_key');break;case(!checkEmail(data.email)):message="Email address appears to be invalid<br>Please enter a valid Email";aInputs.push('email');break;default:return true;}
setError({exception:message,fields:aInputs});return false;};oDialog.asyncSubmitEvent.subscribe(function(type,args){var connectionObject=args[0];startProgress();});oDialog.render($('lastdiv'));}
return oDialog;},toString:function(){return'object oSL.Regform';},getPrompt:function(){if(!oPrompt){$L('making prompt');oPrompt=new $W.SimpleDialog("simpledialog1",{width:"300px",fixedcenter:true,zindex:99,visible:false,draggable:false,close:true,modal:true,text:"Do you want to continue?",icon:$W.SimpleDialog.ICON_ALARM,constraintoviewport:true,buttons:[{text:"Continue registration",handler:handleContinue,isDefault:true},{text:"Exit registration",handler:handleExit}],effect:[{effect:$W.ContainerEffect.FADE,duration:0.2}]});oPrompt.setHeader("Are you sure?");oPrompt.render(document.body);}
$L('176 oPrompt: '+oPrompt,'warn');return oPrompt;},disableButtons:function(){var i,aBtns;$L('105 this is: '+this,'warn');if(oDialog){aBtns=oDialog.getButtons();for(i=0;i<aBtns.length;i+=1){aBtns[i].set('disabled',true);}}},enableButtons:function(){var i,aBtns;$L('105 this is: '+this,'warn');if(oDialog){aBtns=oDialog.getButtons();for(i=0;i<aBtns.length;i+=1){aBtns[i].set('disabled',false);}}},setButtonsDone:function(){oDialog.cfg.queueProperty("buttons",aButtonsDone);},destroy:function(){if(oDialog){oDialog.destroy();}},hasDialog:function(){if(oDialog&&oDialog.body){return true;}
return false;}};})();YUI({}).use('node','dump','event','escape','gallery-storage-lite','gallery-overlay-extras','dd-plugin','transition','yui2-container','yui2-editor','yui2-resize','yui2-animation','io-form','json','jsonp','imageloader','autocomplete','autocomplete-filters','autocomplete-highlighters','gallery-node-tokeninput','cookie',function(Y,result){var YAHOO=Y.YUI2,TTT2=Y.all('.ttt2'),ttB,ttB2,oMetas={},loader,getMeta,setMeta,getToken,ensureLogin,initTooltip,getEditedText,previewDiv,preview,MysubmitForm,showDeleteForm,showRetagForm,showShredForm,showCommentForm,addAdminControls,checkExtApi,showFlagForm,showCloseForm,codeButtons={},initAutoComplete,getAlerter,isModerator,isEditable,initFBSignup,Twitter,showEditComment,setToken,getReputation,isLoggedIn,getViewerId,oCTabs={},foldGroup,revealComments,dnd=false,res=Y.one('#body_preview'),write=function(str){var d=new Date();str+=' :: '+d.toTimeString();if(res){res.set('innerHTML',str);}},saveToStorage=function(){Y.StorageLite.on('storage-lite:ready',function(){var tags,html=editor.saveHTML();saveTitle();saveTags();Y.StorageLite.setItem(getStorageKey(),html);write('Draft saved..');});},commentTip='<tr><td></td><td colspan="2" class="lighttext">Enter at least 16 characters<br>Allowed mini-Markdown formatting: _italic_ and **bold**</td></tr>',eForm=Y.one('.qa_form'),eAskTA,reputation,viewerId=null,bModerator=1,eInputTitle,eInputTags,eTagsHint,eBodyHint,eTitleHint,aComHand,oVotes={},editor,oAlerter,loadingMasks=[],getStorageKey=function(){var formName;if(!eForm){return null;}
return eForm.get('name');},initTagInput=function(el){var input=(el)?el:Y.one("#id_tags");if(input){Y.one(input).plug(Y.Plugin.TokenInput,{delimiter:' '});}},mmdDecode=function(s){var bold,ret,em=/(\<em>|\<\/em>)/g;bold=/(\<strong>|\<\/strong>)/g;ret=s.replace(em,'_');ret=ret.replace(bold,'**');return ret;},mmdEncode=function(s){var bold,ret,em=/(\<em>|\<\/em>)/g;bold=/(\<strong>|\<\/strong>)/g;ret=s.replace(em,'_');ret=ret.replace('/(\*\*)([^\*]+)(\*\*)/g','<strong>\\2</strong>');return ret;},incrementVoteCounter=function(qid){var ret;if(!oVotes.hasOwnProperty(qid)){oVotes[qid]=1;}else{oVotes[qid]=(oVotes[qid]+1);}
ret=(oVotes[qid]<5);return ret;},getTZO=function(){var tzo,nd=new Date();tzo=(0-(nd.getTimezoneOffset()*60));return tzo;},showLoading=function(node,header){var target,box,label=(header)?header:'Loading...',width,height;if(!loader){loader=new Y.Overlay({centered:true,srcNode:"#loading",width:"100px",headerContent:"Loading...",bodyContent:"<img src='/images/loading-bar.gif'>",zIndex:1000});Y.one("#loading").removeClass('hidden');loader.render();}
loader.set('headerContent',label);if(node&&(node instanceof Y.Node)){loader.set("centered",node);}else{loader.set("centered",true);}
loader.set("constrain",true);loader.show();},hideLoading=function(node){if(loader){loader.hide();}},initGfcSignup=function(){if((typeof google==='undefined')||!google.friendconnect){return;}
google.friendconnect.requestSignIn();return;},storeReadEtag=function(){var sKey,uid,etag=getMeta('etag'),qid;if(etag){qid=getMeta('qid');if(qid){uid=getViewerId();etag=parseInt(etag,10);sKey='q-'+qid+'_'+uid;Y.StorageLite.setItem(sKey,etag);}}},setReadLinks=function(){var uid,eDivs,stored,oStorage=Y.StorageLite,eQlist=Y.one('.qlist');if(!eQlist){return;}
eDivs=eQlist.all('.qs');if(!eDivs||eDivs.size()===0){return;}
uid=getViewerId();eDivs.each(function(){var qid,etag,stored,span;qid=this.get('id');etag=this.getAttribute('lampcms:i_etag');stored=oStorage.getItem(qid+'_'+uid);if(stored){if(stored===etag){this.one('a.ql').addClass('read');span=this.one('span.ru');if(span){span.removeClass('unread');span.addClass('read');span.setAttribute('lampcms:ttt','No Unread Items. Click to toggle status');}}}});},toggleRead=function(el){var curStatus,qid,etag,qsDiv,uid=getViewerId(),link;curStatus=(el.test('.unread'))?'unread':'read';qsDiv=el.ancestor("div.qs");qid=qsDiv.get('id');link=qsDiv.one('a.ql');etag=qsDiv.getAttribute('lampcms:i_etag');etag=parseInt(etag,10);sKey=qid+'_'+uid;if('unread'===curStatus){link.removeClass('unread').addClass('read');el.removeClass('unread').addClass('read').setAttribute('lampcms:ttt','No Unread items. Click to toggle status');Y.StorageLite.setItem(sKey,etag);}else{link.removeClass('read').addClass('unread');el.removeClass('read').addClass('unread').setAttribute('lampcms:ttt','Unread items. Click to toggle status');Y.StorageLite.removeItem(sKey);}},handleVote=function(el){var request,id=el.get('id');switch(true){case el.test('.thumbupon'):el.removeClass('thumbupon');el.addClass('thumbup');break;case el.test('.thumbup'):el.removeClass('thumbup');el.addClass('thumbupon');break;case el.test('.thumbdownon'):el.removeClass('thumbdownon');el.addClass('thumbdown');break;case el.test('.thumbdown'):el.removeClass('thumbdown');el.addClass('thumbdownon');break;}
if(incrementVoteCounter(id)){request=Y.io(el.get('href'));}},handleLikeComment=function(el){var parent,likesdiv,likes,id=el.get('id');if(el.test('.thumbupon')){return;}
el.addClass('thumbupon');id=id.substr(7);parent=el.ancestor("div");likesdiv=parent.next(".c_likes");likes=likesdiv.get("text");likes=(!likes)?0:parseInt(likes,10);likesdiv.set("text",(likes+1));Y.io('/index.php?a=likecomment&commentid='+id);},getQuickRegForm=function(){oSL.getQuickRegForm();},initFbInvite=function(target){var siteTitle,siteUrl,siteDescription,caption;if(typeof FB==='undefined'){return;}
siteTitle=getMeta('site_title');siteUrl=getMeta('site_url');siteDescription=target.get('title');caption=getMeta('site_description');FB.ui({method:'stream.publish',message:'I joined this site with Facebook Connect button. You should check it out too',attachment:{name:siteTitle,caption:caption,description:siteDescription,href:siteUrl},action_links:[{text:siteTitle,href:siteUrl}],user_message_prompt:'Invite your Facebook Friends to join this site'},function(response){});},handleModalForm=function(e){var request,cfg,form=e.currentTarget;e.halt();cfg={method:'POST',form:{id:form,useDisabled:true}};oAlerter.hide();showLoading();request=Y.io('/index.php',cfg);},handleCommentForm=function(e){var body,cfg,request,numChars,form=e.currentTarget;e.halt();e.preventDefault();body=form.one("textarea[name=com_body]");numChars=body.get("value").length;if(body&&(numChars<10)){alert('Comment must be at least 10 characters long');return;}
if(body&&(numChars>600)){alert('Comment must be at under 600 chars long. Please remove '
+(numChars-600)+' characters from your comment');return;}
cfg={method:'POST',form:{id:form,useDisabled:true}};if(oAlerter){oAlerter.hide();}
showLoading(form.ancestor('div'));request=Y.io('/index.php',cfg);},handleAjaxLinks=function(e){var ancestor,id,res,rtype,restype,resID,fbappid,fbcookie,el=e.currentTarget,target=e.target;id=el.get('id');switch(true){case el.test('.qpages'):if('A'===e.target.get('tagName')&&Y.one(".paginated")){e.halt();handlePagination(e.target);}
break;case el.test('.ext_api'):checkExtApi(el);break;case el.test('span.ru'):toggleRead(el);break;case el.test('.vote'):e.halt();if(ensureLogin()){handleVote(el);}
break;case el.test('.c_like'):e.halt();if(ensureLogin()){handleLikeComment(el);}
break;case el.test('.fbsignup'):initFBSignup();break;case el.test('.gfcsignin'):initGfcSignup();break;case el.test('.twsignin'):Twitter.startDance();break;case el.test('.add_tumblr'):Twitter.startDance('/index.php?a=logintumblr',680,540);break;case el.test('.add_blogger'):Twitter.startDance('/index.php?a=connectblogger',680,540);break;case(id==='gfcset'):if((typeof google!=='undefined')&&google.friendconnect){google.friendconnect.requestSettings();}
break;case(id==='gfcinvite'):if((typeof google!=='undefined')&&google.friendconnect){google.friendconnect.requestInvite();}
break;case(id==='fbinvite'):initFbInvite(el);break;case(id==='twinvite'):oTweet=oSL.tweet.getInstance();oTweet.show();break;case(el.test('.change_image')):if(Y.one("#avatar_upload")){Y.one("#avatar_upload").removeClass('pic_upload');}
break;case(id==='logout'):e.preventDefault();e.halt();showLoading(el);fbappid=getMeta('fbappid');if((typeof FB!=='undefined')&&fbappid&&FB.getSession()){FB.logout(function(response){fbcookie="fbs_"+fbappid;Y.Cookie.remove(fbcookie);window.location.assign('/index.php?a=logout');});}else{window.location.assign('/index.php?a=logout');}
break;case el.test('.flag'):ancestor=el.ancestor("div.controls");if(ancestor){restype=(ancestor.test('.question'))?'q':'a';resID=ancestor.get('id');resID=resID.substr(4);}else{ancestor=el.ancestor("div.com_flag");if(ancestor){restype='c';resID=el.get('id');resID=resID.substr(6);}}
if(ancestor){showFlagForm({'rid':resID,'rtype':restype});}
break;case el.test('.retag'):ancestor=el.ancestor("div.controls");if(ancestor){resID=ancestor.get('id');resID=resID.substr(4);showRetagForm(resID);}
break;case el.test('.sortans'):e.halt();getSortedAnswers(el);break;case el.test('.stick'):window.location.assign('/index.php?a=stick&qid='+getMeta('qid'));break;case el.test('.unstick'):window.location.assign('/index.php?a=unstick&qid='+getMeta('qid'));break;case el.test('.close'):ancestor=el.ancestor("div.controls");if(ancestor){resID=ancestor.get('id');resID=resID.substr(4);showCloseForm(resID);}
break;case el.test('.del'):ancestor=el.ancestor("div.controls");if(ancestor){resID=ancestor.get('id');resID=resID.substr(4);if(ancestor.test('.com_tools')){deleteComment(resID);}else{rtype=(ancestor.test('.question'))?'q':'a';showDeleteForm({'rid':resID,'rtype':rtype});}}
break;case el.test('.edit'):ancestor=el.ancestor("div.controls");if(ancestor){e.halt();e.preventDefault();resID=ancestor.get('id');resID=resID.substr(4);if(ancestor.test('.com_tools')){if(!isEditable(ancestor)){alert('You cannot edit comments that are older than '+getMeta('comments_timeout')+' minutes');return;}else{showEditComment(resID);}}else{restype=(ancestor.test('.question'))?'q':'a';window.location.assign('/index.php?a=edit&rid='+resID+'&rtype='+restype);}}
break;case el.test('.com_link'):e.preventDefault();showCommentForm(el);break;case el.test('.btn_shred'):if(ensureLogin()){showShredForm(el.get('id'));}
break;case el.test('.btnfollow'):handleFollow(el);break;}},handlePagination=function(el){var href,qpages;qpages=el.ancestor("div.qpages");if(!el.hasAttribute('href')){return;}
href=el.getAttribute('href');if(qpages){showLoading(qpages);Y.io(href);}},getSortedAnswers=function(el){var href,curTab,curTabId,sortby=el.get('id'),qid,qtype=Y.one("#qtypes"),eTab=el.ancestor("div").next("div.sortable")||Y.one(".sortable");if(el.test(".qtype_current")){return;}
curTab=el.ancestor("div").one(".qtype_current");if(curTab){curTabId=curTab.get("id");if(!oCTabs.hasOwnProperty(curTabId)){oCTabs[curTabId]=eTab.getContent();}}
el.siblings().removeClass('qtype_current');el.addClass('qtype_current');if(oCTabs.hasOwnProperty(sortby)&&oCTabs[sortby].length>0){eTab.setContent(oCTabs[sortby]);foldGroup.fetch();}else{showLoading(eTab);href=el.getAttribute('href');href=('#'===href)?'/index.php?a=getanswers&qid='+getMeta('qid')+'&sort='+sortby:href;Y.io(href,{'arguments':{'sortby':sortby}});}},handleFollow=function(el){if(!ensureLogin()){return;}
el.removeClass('unfollow');var viewerDiv,title,controls,id,resID,ftype='q',follow='on',form,oLabels={'q':'question','u':'user','t':'tag'};resID=el.getAttribute('lampcms:follow');ftype=el.getAttribute('lampcms:ftype');viewerDiv=Y.one("#flwr_"+getViewerId());if(el.test('.following')){controls=Y.one('#res_'+resID);if(controls){if(controls.test('.uid-'+getViewerId())){if(!confirm('Are you sure you want to unfollow your own question?')){el.one('span.icoc').removeClass('del').addClass('check');el.one('span.flabel').set('text','Following');return;}}}
title=(ftype==='u')?'Follow':'Follow this '+oLabels[ftype];el.removeClass('following').addClass('follow');el.set('title',title);el.one('span.icoc').removeClass('check').addClass('cplus');el.one('span.flabel').set('text',title);follow='off';if(viewerDiv){viewerDiv.hide('fadeOut');}}else{title='You are following this '+oLabels[ftype];el.removeClass('follow').addClass('following');el.set('title',title);el.one('span.icoc').removeClass('cplus').removeClass('del').addClass('check');el.one('span.flabel').set('text','Following');follow='on';if(viewerDiv){viewerDiv.show('fadeIn');}}
form='<form name="form_f" action="/index.php">'
+'<input type="hidden" name="a" value="follow">'
+'<input type="hidden" name="ftype" value="'+ftype+'">'
+'<input type="hidden" name="follow" value="'+follow+'">'
+'<input type="hidden" name="f" value="'+resID+'">'
+'<input type="hidden" name="token" value="'+getToken()+'">';form=Y.one('body').appendChild(form);cfg={method:'POST',form:{id:form}};request=Y.io('/index.php',cfg);return;},handleOver=function(e){var sFlw='<span class="icoc del">&nbsp;</span><span> Unfollow</span>',el=e.currentTarget;switch(true){case el.test('.following'):if(!el.hasClass('unfollow')){el.addClass('unfollow');el.one('span.icoc').removeClass('check').addClass('del');el.one('span.flabel').set('text','Unfollow');}
break;}},handleOut=function(e){var sFlw='<span class="icoc check">&nbsp;</span><span> Following</span>',el=e.currentTarget;switch(true){case(el.test('.following')):el.removeClass('unfollow');el.one('span.icoc').removeClass('dev').addClass('check');el.one('span.flabel').set('text','Following');break;}},revealHidden=function(e){var els=(e)?e.all('.reveal'):Y.all('.reveal');if(els){els.each(function(){if(this.test('.owner')){if(this.test('.oid-'+getViewerId())){this.removeClass('hidden');}}else{this.removeClass('hidden');}});}},handleSuccess=function(ioId,o,args){hideLoading();var data,target,paginated,scoreDiv,comDivID,eDiv,eRepliesDiv,sContentType=Y.Lang.trim(o.getResponseHeader("Content-Type"));if('text/json; charset=UTF-8'!==sContentType){alert('Invalid Content-Type header: '+sContentType);return;}
if(undefined===o.responseText){alert('No text in response');return;}
try{data=Y.JSON.parse(o.responseText);}catch(e){alert("Error parsing response object"+e+"<br>o.responseText: "+o.responseText);return;}
if(data.exception){if(data.type&&'Lampcms\\MustLoginException'===data.type){ensureLogin(true);}else{alert(data.exception);}}
if(data.alert){alert(data.alert);}
if(data.success){alert(data.alert);}
if(data.replace&&data.replace.target&&data.replace.content){Y.one("#"+data.replace.target).set('innerHTML',data.replace.content);foldGroup.fetch();initTooltip();revealHidden();}
if(data.reload){if(data.reload>0){Y.later(data.reload,this,function(){window.location.reload(true);});}else{window.location.reload(true);}}
if(data.formError){if(Y.one(".form_error")){Y.one(".form_error").set('innerHTML',data.formError);}else{alert(data.formError);}
return;}
if(data.formElementError){setFormError(data.formElementError);return;}
if(data.setmeta&&data.setmeta.key&&data.setmeta.val){setMeta(data.setmeta.key,data.setmeta.val);}
if(data.paginated){paginated=Y.one(".paginated");if(paginated){paginated.setContent(data.paginated);foldGroup.fetch();initTooltip();return;}}
if(data.comment&&data.comment.res&&data.comment.html){if(data.comment.id&&Y.one('#comment-'+data.comment.id)){Y.one('#comment-'+data.comment.id).replace(data.comment.html);}else{Y.one('#comm_wrap_'+data.comment.res).remove();Y.one('#comments-'+data.comment.res).insert(data.comment.html,Y.one('#comments-'+data.comment.res).one('.add_com'));}
return;}
if(data.vote&&data.vote.hasOwnProperty('v')&&data.vote.rid){scoreDiv=Y.one('#score'+data.vote.rid);if(scoreDiv){scoreDiv.set('innerHTML',data.vote.v);}}else{if(data.redirect||data.answer){Y.StorageLite.removeItem(getStorageKey());removeTitle();removeTags();if(data.redirect){getAlerter('<h3>Success</h3>').set("bodyContent",'Item saved! Redirecting to <br><a href="'+data.redirect+'">'+data.redirect+'</a>').show();Y.later(1000,this,function(){window.location.assign(data.redirect);});}
if(Y.one("#answers")){if(editor){editor.setEditorHTML('<br>');}
Y.one("#answers").append(data.answer).scrollIntoView();if(typeof dp!=='undefined'){dp.SyntaxHighlighter.HighlightAll('code');}}}}},saveTitle=function(){var title=Y.one("#id_title");if(title){Y.StorageLite.setItem('title',title.get('value'));}},saveTags=function(){var tags=Y.one("#id_tags");if(tags){Y.StorageLite.setItem('tags',tags.get('value'));}},removeTitle=function(){var title=Y.one("#id_title");if(title){Y.StorageLite.removeItem('title');}},removeTags=function(){var tags=Y.one("#id_tags");if(tags){Y.StorageLite.removeItem('nuts');}},setFormError=function(o){var field,eErr;for(field in o){if(o.hasOwnProperty(field)){eErr=(Y.one("#"+field+"_e"));if(eErr){eErr.set('text',o[field]);}else{eErr=Y.one(".form_error");if(eErr){eErr.set('text',o[field]);}}
if(eErr){eErr.scrollIntoView();}else{alert(o[field]);}}}},handleFailure=function(ioId,o){hideLoading();alert('Error occured. Server returned status '+o.status+' response: '+o.statusText);};Y.on('io:success',handleSuccess);Y.on('io:failure',handleFailure);MysubmitForm=function(e){var request,cfg,mbody,title,tags,reason,form=e.currentTarget;title=form.one("#id_title");tags=form.one("#id_tags");reason=form.one("#id_reason");if(reason&&(1>reason.get("value").length)){alert('You must include reason for editing');e.halt();return;}
mbody=getEditedText();mbody=mbody.replace(/"codepreview"/g,'"code"');form.one("textarea[name=qbody]").set("value",mbody);cfg={method:'POST',form:{id:form,useDisabled:true}};if(Y.one("#dostuff")&&Y.one("#dostuff").ancestor('div')){showLoading(Y.one("#dostuff").ancestor('div'));}
request=Y.io('/index.php',cfg);e.halt();return false;};var getCodeButton=function(){var ret={type:'separator'};if(typeof dp!=='undefined'){ret={group:'sourcecode',label:'Code style',buttons:[{type:'select',label:'Select',value:'codestyle',disabled:true,menu:[{text:'None',value:'nocode',checked:true},{text:'JavaScript',value:'javascript'},{text:'HTML/XML',value:'xml'},{text:'CSS',value:'css'},{text:'Python',value:'python'},{text:'Ruby',value:'ruby'},{text:'PHP',value:'php'},{text:'C',value:'c'},{text:'C++',value:'cpp'},{text:'C#',value:'csharp'},{text:'Java',value:'java'},{text:'SQL',value:'sql'},{text:'VB',value:'vb'},{text:'Delphi',value:'delphi'}]}]};}
return ret;};var makeEditor=function(){var codeButtons,btnSeparator={type:'separator'};if(Y.one("#id_qbody")&&Y.all('.com_hand').isEmpty()){codeButtons=getCodeButton();editor=new YAHOO.widget.Editor('id_qbody',{dompath:false,width:'660px',height:'140px',autoHeight:true,extracss:'pre { margin-left: 10px; margin-right: 10px; padding: 2px; background-color: #EEE; } ',animate:true,toolbar:{buttons:[{group:'saveclear',label:'Save / New',buttons:[{type:'push',label:'Save Draft',value:'save'},{type:'push',label:'New Document',value:'clear'}]},{group:'textstyle',label:'Font Style',buttons:[{type:'push',label:'Bold CTRL + SHIFT + B',value:'bold'},{type:'push',label:'Italic CTRL + SHIFT + I',value:'italic'},{type:'push',label:'Underline CTRL + SHIFT + U',value:'underline'},{type:'push',label:'Strike Through',value:'strikethrough'}]},btnSeparator,{group:'blockquote',label:'Quote',buttons:[{type:'push',label:'Indent',value:'indent',disabled:true},{type:'push',label:'Outdent',value:'outdent',disabled:true}]},btnSeparator,{group:'indentlist',label:'Lists',buttons:[{type:'push',label:'Create an Unordered List',value:'insertunorderedlist'},{type:'push',label:'Create an Ordered List',value:'insertorderedlist'}]},btnSeparator,codeButtons,btnSeparator,{group:'insertitem',label:'Link / Image',buttons:[{type:'push',label:'HTML Link CTRL + SHIFT + L',value:'createlink',disabled:true},{type:'push',label:'Insert Image',value:'insertimage',disabled:false}]},btnSeparator,{group:'undoredo',label:'Undo/Redo',buttons:[{type:'push',label:'Undo',value:'undo',disabled:true},{type:'push',label:'Redo',value:'redo',disabled:true}]}]}});editor.on('toolbarLoaded',function(){this.on('afterNodeChange',function(o){var btn=this.toolbar.getButtonByValue('codestyle');if(btn){if(this._hasSelection()){this.toolbar.enableButton(btn);}else{this.toolbar.disableButton(btn);}}
preview();},this,true);this.on('editorKeyUp',function(){preview();});editor.toolbar.on('codestyleClick',function(ev){var escaped,html,sel=this._getSelection(),newEl,el=editor._getSelectedElement(),codetype=ev.button.value.toLowerCase();escaped=Y.Escape.html(sel.toString());switch(true){case('nocode'===codetype&&editor._isElement(el,'pre')):editor._swapEl(el,'code');html=editor.getEditorHTML();html=html.replace(/<code([^>]*)>/gi,'');html=html.replace(/<\/code>/gi,'');editor.setEditorHTML(html);break;case(editor._isElement(el,'pre')):el.className=codetype;break;default:editor.execCommand('inserthtml','<pre alt="codepreview" class="'+codetype+'">'+escaped+'</pre>');}
return false;},this,true);editor.toolbar.on('clearClick',function(){if(confirm('Are you sure you want to reset the Editor?')){editor.setEditorHTML('<br>');write('Editor content cleared..');}});editor.toolbar.on('saveClick',saveToStorage);});if(!Y.one('#iedit')){Y.later(5000,editor,function(){if(editor.editorDirty){editor.editorDirty=null;saveToStorage();}},{},true);}
Y.StorageLite.on('storage-lite:ready',function(){var title,tags,editorValue,body=Y.one('#id_qbody');editorValue=Y.StorageLite.getItem(getStorageKey());if(body&&!Y.one('#iedit')&&null!==editorValue&&''!==editorValue){body.set('value',editorValue);if(Y.one("#id_title")){title=Y.StorageLite.getItem('title');tags=Y.StorageLite.getItem('tags');if(title){Y.one("#id_title").set('value',title);}
if(title){Y.one("#id_tags").set('value',tags);}}
write('Loaded content draft from Local Storage');}else{write('Editor ready');}
editor.render();});getEditedText=function(){var i,pre,holder,html=editor.getEditorHTML();html=editor.cleanHTML(html);if(typeof dp!=='undefined'){html=html.replace(/alt="codepreview"/g,'rel="codepreview"');holder=document.createElement('div');holder.innerHTML=html;pre=holder.getElementsByTagName('pre');for(i=0;i<pre.length;i++){pre[i].innerHTML="\n"+pre[i].innerHTML.replace(/<br>/g,"\n")+"\n";pre[i].innerHTML="\n"+pre[i].innerHTML.replace(/&nbsp;/g," ")+"\n";}
html=holder.innerHTML;}
return html;};previewDiv=Y.one('#tmp_preview');preview=function(){previewDiv=(previewDiv)?previewDiv:null;if(previewDiv){previewDiv.set('innerHTML',getEditedText());}
if((typeof dp!=='undefined')&&dp.SyntaxHighlighter){dp.SyntaxHighlighter.HighlightAll('codepreview');}};}};showFlagForm=function(o){var oAlert,form,faction='flagger';if(ensureLogin()){if(o.rtype&&'c'===o.rtype){faction='flagcomment';}
form='<div id="div_flag" style="text-align: left">'
+'<form name="form_flag" action="/index.php">'
+'<input type="hidden" name="a" value="'+faction+'">'
+'<input type="hidden" name="rid" value="{rid}">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<input type="hidden" name="qid" value="'+getMeta('qid')+'">'
+'<input type="hidden" name="rtype" value="{rtype}">'
+'<input type="radio" name="reason" value="spam"><label> Spam</label><br>'
+'<input type="radio" name="reason" value="inappropriate"><label> Inappropriate</label><br>'
+'<hr>'
+'<label for="id_note">Comments?</label>'
+'<textarea name="note" cols="40" rows="2" style="display: block;"></textarea>'
+'<input type="submit" class="btn" value="Report">'
+'</form>'
+'</div>';form=Y.Lang.sub(form,o);oAlert=getAlerter('<h3>Report to moderator</h3>');oAlert.set("bodyContent",form);oAlert.show();}};showCloseForm=function(qid){var oAlert,form;if(ensureLogin()){form='<div style="text-align: left">'
+'<form name="form_close" id="id_close" action="/index.php">'
+'<input type="hidden" name="a" value="close">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<input type="hidden" name="qid" value="'+qid+'">'
+'<input type="radio" name="reason" value="Not a question" checked><label>Not a real question</label><br>'
+'<input type="radio" name="reason" value="Off topic"><label>Way off Topic</label><br>'
+'<input type="radio" name="reason" value="Unproductive debate"><label>Turned into unproductive debate</label><br>'
+'<input type="radio" name="reason" value="Duplicate"><label>Duplicate question</label><br>'
+'<hr>'
+'<label for="id_note">Comments?</label>'
+'<textarea name="note" cols="40" rows="2" style="display: block;"></textarea>'
+'<input type="submit" class="btn" value="Close this question">'
+'</form>'
+'</div>';oAlert=getAlerter('<h3>Close this question</h3>');oAlert.set("bodyContent",form);oAlert.show();}};showRetagForm=function(){var oAlert,form,oTags,sTags='';if(ensureLogin()){oTags=Y.all('td.td_question > div.tgs a');oTags.each(function(){sTags+=this.get('text')+' ';});sTags=Y.Lang.trimRight(sTags);form='<div id="div_flag" style="text-align: left">'
+'<form name="form_flag" id="id_flag" action="/index.php">'
+'<input type="hidden" name="a" value="retag">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<input type="hidden" name="qid" value="'+getMeta('qid')+'">'
+'<hr>'
+'<label for="id_note">At least one tag, max 5 tags separated by spaces</label>'
+'<input type="text" class="ta1" id="id_retag" size="40" name="tags" value="'+sTags+'"></input>'
+'<br>'
+'<input type="submit" class="btn" value="Save">'
+'</form>'
+'</div>';oAlert=getAlerter('<h3>Edit Tags</h3>');oAlert.set("bodyContent",form);initTagInput(Y.one("#id_retag"));oAlert.show();}};var deleteComment=function(resID){var comment,f,myform,cfg,request;if(confirm('Really delete this comment?')){comment=Y.one("#comment-"+resID);if(comment){myform='<form name="form_del" action="/index.php">'
+'<input type="hidden" name="a" value="deletecomment">'
+'<input type="hidden" name="rid" value="'+resID+'">'
+'<input type="hidden" name="token" value="'+getToken()+'">';f=comment.appendChild(myform);cfg={method:'POST',form:{id:f,useDisabled:true}};request=Y.io('/index.php',cfg);comment.hide('fadeOut');Y.later(1000,comment,function(){comment.remove();});}}};showDeleteForm=function(o){var oAlert,form,banCheckbox='',a='delete';if(ensureLogin()){if(o.rtype&&'c'===o.rtype){a='deletecomment';}
if(isModerator()){banCheckbox='<br><input type="checkbox" name="ban"><label> Ban poster</label><br>';}
form='<div id="div_del" style="text-align: left">'
+'<form name="form_del" action="/index.php">'
+'<input type="hidden" name="a" value="'+a+'">'
+'<input type="hidden" name="rid" value="{rid}">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<input type="hidden" name="qid" value="'+getMeta('qid')+'">'
+'<input type="hidden" name="rtype" value="{rtype}">'
+'<hr>'
+'<label for="id_note">Reason for delete (optional)</label>'
+'<textarea name="note" cols="40" rows="2" style="display: block;"></textarea>'
+banCheckbox
+'<br><input type="submit" class="btn" value="Delete">'
+'</form>'
+'</div>';form=Y.Lang.sub(form,o);oAlert=getAlerter('<h3>Delete item</h3>');oAlert.set("bodyContent",form);oAlert.show();}};showCommentForm=function(el){var minrep,vid,form,rep,resID;rep=getReputation();vid=getViewerId();minrep=getMeta('min_com_rep');if(ensureLogin()){if(('1'===getMeta('comment'))||(getMeta('asker_id')===vid)||(rep>minrep)||el.test('.uid-'+vid)){resID=el.get('id');resID=resID.substr(8);form=Y.one('#add-comment-'+resID);if(!form){form='<div id="comm_wrap_'+resID+'" class="fl cb">'
+'<form action="/index.php" id="add-comment-'+resID+'" class="comform" method="post">'
+'<input type="hidden" name="a" value="addcomment">'
+'<input type="hidden" name="rid" value="'+resID+'">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<table class="cb fr tbl_comment">'
+'<tr><td width="60px" class="com_icons" valign="top"></td>'
+'<td class="com_main">'
+'<textarea name="com_body" cols="60" rows="3" class="com_bo" style="display: block; padding: 2px;"></textarea>'
+'</td>'
+'<td class="com_button" valign="top">'
+'<input type="submit" name="doit" class="btn_comment" value="comment">'
+'</td>'
+'</tr>'
+commentTip
+'</table>'
+'</form></div>';el.insert(form,'after');}else{if(form._isHidden()){form.show('fadeIn');}else{form.hide('fadeOut');}}}else{alert('You must have a reputation of at least <b>'+minrep+'</b><br>'
+'to be able to add comments<br>'
+'Your current reputation is: <b>'+rep+'</b>');return;}}};showEditComment=function(resID){var form,wrapDiv,body,content;wrapDiv=Y.one("#comment-"+resID);if(wrapDiv){body=wrapDiv.one('.com_b');content=body.get('innerHTML');content=mmdDecode(content);form='<div id="comm_wrap_'+resID+'" class="fl cb">'
+'<form action="/index.php" id="edit-comment-'+resID+'" class="comform" method="post">'
+'<input type="hidden" name="a" value="editcomment">'
+'<input type="hidden" name="commentid" value="'+resID+'">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<table class="cb fr tbl_comment">'
+'<tr><td width="60px" class="com_icons" valign="top"></td>'
+'<td class="com_main">'
+'<textarea name="com_body" cols="60" rows="4" class="com_bo" style="display: block; padding: 2px;">'+content+'</textarea>'
+'</td>'
+'<td class="com_button" valign="top">'
+'<input type="submit" name="doit" class="btn_comment" value="save">'
+'</td>'
+'</tr>'
+commentTip
+'</table>'
+'</form></div>';wrapDiv.insert(form,'replace');}};showShredForm=function(uid){var id=uid.substr(5);form='<div id="div_del" style="text-align: left">'
+'<form name="form_shred" id="id_shred" action="/index.php">'
+'<input type="hidden" name="a" value="shred">'
+'<input type="hidden" name="uid" value="'+id+'">'
+'<input type="hidden" name="token" value="'+getToken()+'">'
+'<p>Shredding user will completely delete all posts made by the user<br>'
+'as well as all user tags'
+'<br>It will also change user status to *deleted*'
+'<br>and ban all IP addresses ever used by that user</p>'
+'<p>Proceed only if you absolutely sure you want to do this'
+'<hr>'
+'<input type="submit" class="btn_shred" value="Shred">'
+'</form>'
+'</div>';oAlert=getAlerter('<h3>Shred User</h3>');oAlert.set("bodyContent",form);oAlert.show();};setMeta=function(metaName,value){var node=getMeta(metaName,true);if(node&&value){node.set('content',value);}};ensureLogin=function(bForceAlert){var message;if(bForceAlert||!isLoggedIn()){message='<div class="larger"><p>You must login to perform this action</p>'
+'<p>Please login or <a class="close" href="#" onClick=oSL.getQuickRegForm(); return false;>Click here to register</a></div>';getAlerter('Please Login').set("bodyContent",message).show();return false;}
return true;};getToken=function(){return getMeta('version_id');};setToken=function(val){setMeta('version_id',val);};getViewerId=function(){var uid;if(null===viewerId){uid=getMeta('session_uid');viewerId=(!uid)?0:parseInt(uid,10);}
return viewerId;};isLoggedIn=function(){var ret,uid=getViewerId();ret=(uid&&(uid!=='')&&(uid!=='0'));return ret;};isModerator=function(){var role;if(bModerator<2){role=getMeta('role');if(role&&(('administrator'===role)||('moderator'===role))){bModerator=3;}else{bModerator=2;}}
return(3===bModerator);};getReputation=function(){var score;if(!reputation){score=getMeta('rep');reputation=(!score)?1:parseInt(score,10);}
return reputation;};addAdminControls=function(){var controls=Y.all('div.controls');if(controls){controls.each(function(){if(this.test('.question')){if(isModerator()||this.test('.uid-'+getViewerId())||(500<getReputation())){this.append(' <span class="ico retag ajax" title="Retag this item">retag</span>');}
if(!Y.one('#closed')&&(isModerator()||this.test('.uid-'+getViewerId()))){this.append(' <span class="ico close ajax"  title="Close this question">close</span>');}
if('administrator'===getMeta('role')){if(!this.test('.sticky')){this.append(' <span class="ico stick ajax"  title="Make sticky">stick</span>');}else{this.append(' <span title="Unstick" class="ico unstick ajax">unstick</span>');}}}
if(isModerator()||this.test('.uid-'+getViewerId())||2000<getReputation()){if(isModerator()||this.test('.uid-'+getViewerId())){this.append(' <span title="Delete "class="ico del ajax">delete</span>');}
if(!this.test('.com_tools')||isEditable(this)){this.append(' <span  title="Edit" class="ico edit ajax">edit</span>');}}});}};isEditable=function(controls){var timeOfComment,timeDiff,maxDiff;if(isModerator()){return true;}
maxDiff=getMeta('comments_timeout');if(!maxDiff){return true;}
maxDiff=maxDiff*60000;timeOfComment=controls.one('div.com_ts').get('title');if(!timeOfComment){return true;}
timeOfComment=new Date(timeOfComment);timeDiff=((new Date()).getTime()-timeOfComment.getTime());if(timeDiff>maxDiff){return false;}
return true;};initFBSignup=function(){var callback,fbPerms;if(typeof FB!=='undefined'){fbPerms=getMeta('fbperms');if(!fbPerms){fbPerms='';}
if(isLoggedIn()){callback=function(response){if(response.session){if(response.perms){showLoading(null,'Connecting<br>Facebook account');Y.io('/index.php?a=connectfb');}else{}}};}else{callback=function(response){if(response.session){if(response.perms){window.top.location.reload(true);}}else{}};}
FB.login(callback,{perms:fbPerms});}
return;};getAlerter=function(header){if(!oAlerter){oAlerter=new Y.Overlay({srcNode:'#fbOverlay',width:'500px',height:'300px',zIndex:100,centered:true,constrain:true,render:true,visible:false,plugins:[{fn:Y.Plugin.OverlayModal},{fn:Y.Plugin.OverlayKeepaligned}]});Y.one('#hide-fbOverlay').on('click',function(){oAlerter.hide();});}
if(!header){header='Alert';}
oAlerter.set("headerContent",'<h3>'+header+'</h3>');return oAlerter;};getMeta=function(metaName,asNode){var ret,node;if(!oMetas[metaName]){node=Y.one('meta[name='+metaName+']');oMetas[metaName]=node;}
if(!oMetas[metaName]){return false;}
if(asNode){return oMetas[metaName];}
ret=oMetas[metaName].get('content');return ret;};checkExtApi=function(el){if((el.get('tagName')==='INPUT')&&el.get('checked')){saveToStorage();switch(true){case((el.get('id')==='api_tweet')&&(!getMeta('tw'))):Twitter.startDance();break;case((el.get('id')==='api_facebook')&&('1'!==getMeta('fb'))):initFBSignup();break;case((el.get('id')==='api_tumblr')&&('1'!==getMeta('tm'))):Twitter.startDance('/index.php?a=logintumblr',800,540);break;case((el.get('id')==='api_blogger')&&('1'!==getMeta('blgr'))):Twitter.startDance('/index.php?a=connectblogger',680,540);break;}}};revealComments=function(){var comments,limit=getMeta('max_comments');if(limit&&0<parseInt(limit,10)){comments=Y.all('div.nocomments');if(comments){comments.removeClass('nocomments');}}};Twitter={popupWindow:null,oInterval:null,startDance:function(url,w,h){showLoading();var u,mydomain,popupParams,height,width;width=(w)?w:800;height=(h)?h:800;popupParams='location=0,status=0,width='+width+',height='+height+',alwaysRaised=yes,modal=yes';u=(!url)?'http://'+window.location.hostname+'/index.php?a=logintwitter&ajaxid=1':url;if(this.popupWindow&&!this.popupWindow.closed){this.popupWindow.location.href=u;this.popupWindow.focus();hideLoading();return;}
this.popupWindow=window.open(u,'twitterWindow',popupParams);hideLoading();if(!this.popupWindow){alert('Unable to open login window. Please make sure to disable popup blockers in your browser');return;}
if(this.oInterval){window.clearInterval(this.oInterval);this.oInterval=null;}
this.oInterval=window.setInterval(this.checkLogin,500);},checkLogin:function(){if(!Twitter.popupWindow||Twitter.popupWindow.closed){Twitter.cancelIntervals();window.location.reload(true);}},cancelIntervals:function(){if(this.oInterval){window.clearInterval(this.oInterval);this.oInterval=null;}},toString:function(){return'object Twitter';}};initTooltip=function(){var TTT=Y.all('.ttt');if(TTT&&TTT.size()>0){if(ttB){ttB.destroy();}
ttB=new YAHOO.widget.Tooltip("ttB",{context:TTT._nodes,autodismissdelay:5500,hidedelay:350,xyoffset:[-10,-45],effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.20}});}};if(TTT2&&TTT2.size()>0){ttB2=new YAHOO.widget.Tooltip("ttB2",{context:TTT2._nodes,autodismissdelay:5500,hidedelay:350,xyoffset:[-10,-45],effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.20}});}
initAutoComplete=function(){var isearch,id_title;if("1"===getMeta('noac')){return;}
isearch=Y.one('#id_q');id_title=Y.one('#id_title');if(isearch){isearch.plug(Y.Plugin.AutoComplete,{minQueryLength:3,resultHighlighter:'wordMatch',resultListLocator:'ac',resultTextLocator:'title',source:'/index.php?a=titlehint&q={query}&ajaxid=1&callback={callback}'});}
if(id_title){id_title.plug(Y.Plugin.AutoComplete,{minQueryLength:3,resultHighlighter:'wordMatch',resultListLocator:'ac',resultTextLocator:'title',source:'/index.php?a=titlehint&q={query}&ajaxid=1&callback={callback}',resultFormatter:function(query,results){return Y.Array.map(results,function(result){var tpl='<a href="/q{_id}/{url}">{t}</a><br>{intro}<br><div class="c6">Asked {hts} (<span class="c_{status}">{i_ans} answer{ans_s})</span></div>';var raw=result.raw;return Y.Lang.sub(tpl,{_id:raw._id,url:raw.url,intro:raw.intro,t:result.highlighted,hts:raw.hts,i_ans:raw.i_ans,ans_s:raw.ans_s,status:raw.status});});}});id_title.ac.on('select',function(e){var qlink,result=e.result;if(result.raw&&result.raw._id&&result.raw.url){e.preventDefault();qlink='/q'+result.raw._id+'/'+result.raw.url;window.location.assign(qlink);}});}};initTooltip();makeEditor();if(editor){}
revealComments();revealHidden();setReadLinks();storeReadEtag();aComHand=Y.all('.com_hand');if(aComHand&&!aComHand.isEmpty()){aComHand.on('focus',getQuickRegForm);}
Y.on('submit',MysubmitForm,'.qa_form');Y.delegate("click",handleAjaxLinks,"body",'.ajax');Y.one('body').delegate("hover",handleOver,handleOut,'.following');Y.delegate("submit",handleModalForm,"#fbOverlay",'form');Y.delegate("submit",handleCommentForm,"#qview-body",'.comform');Y.delegate("click",function(){getAlerter().hide();},"#fbOverlay",'a.close');window.alert=function(text){var oAlert=getAlerter();oAlert.set("bodyContent",text);oAlert.show();};if(Y.one('#regdiv')){dnd=Y.Cookie.get("dnd");if(!dnd){oSL.Regform.getInstance().show();}}
foldGroup=new Y.ImgLoadGroup({foldDistance:2});foldGroup.set('className','imgloader');initAutoComplete();initTagInput();addAdminControls();if(typeof dp!=='undefined'){dp.SyntaxHighlighter.HighlightAll('code');}});