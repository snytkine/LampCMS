/**
 *
 */

var $Y = YAHOO, //
    $D = YAHOO.util.Dom, //
    $C = $D.getElementsByClassName, //
    $CONN = YAHOO.util.Connect, //
    $ = YAHOO.util.Dom.get, //
    $LANG = YAHOO.lang, //
    $COOKIE = YAHOO.util.Cookie, //
    $J = YAHOO.lang.JSON, //
    $W = YAHOO.widget, //
    $L = YAHOO.log, //
    LampcmsException = function (message, exceptionName) {
        this.message = message;
        this.name = exceptionName || "LampcmsException";
    };

oSL = {
    Regform:function () {
    }
};

/**
 * This member handles the success response must determine what the result is
 * for: can be for doc or tpl or can be a text with css we should test the
 * returned text which should always be a JSONobject
 */
oAjaxObject = {
    handleSuccess:function (o) {

        var eLastDiv, json, sDoc, sTpl, errDiv, strMessage = '', //
            eLogin = $("loginHead"), // was nbar
            strContentType = $LANG.trim(o.getResponseHeader["Content-Type"]);
        // alert('ContentType: ' + strContentType);
        switch (strContentType) {
            case 'text/json; charset=UTF-8':
            case 'text/javascript; charset=UTF-8':
                // alert('42 got something that looks like js');
                try {
                    json = $J.parse(o.responseText);
                    // alert(json);
                } catch (e) {
                    alert("Invalid json data in responceText " + $LANG.dump(e)
                        + " strContentType " + strContentType + "<br>oRespnose: "
                        + $LANG.dump(o.responseText));
                }

                switch (true) {

                    case json.hasOwnProperty('exception'):
                        alert(json.exception);
                        break;

                    case json.hasOwnProperty('redirect'):
                        window.location.assign(json.redirect);
                        break;

                    case json.hasOwnProperty('message'):
                        eLogin.innerHTML = json.message;
                        oSL.fColorChange(eLogin, '#00FF00', '#FFFFFF');
                        break;

                    case json.hasOwnProperty('quickreg'):
                        eLastDiv = document.createElement('div');
                        eLastDiv.innerHTML = json.quickreg;
                        document.body.appendChild(eLastDiv);
                        //oSL.modal.hide();
                        oSL.Regform.getInstance().show();
                        break;

                }

        }
    },
    handleFailure:function (o) {
        alert($LANG.dump(o));
    }
}; //
oSL = {
    toString:function () {
        return 'object oSL';
    },
    getQuickRegForm:function () {
        if (oSL.Regform && oSL.Regform.hasDialog()) {
            oSL.Regform.getInstance().show();
        } else {
            /**
             * &ajaxid=1&tplflag=1
             */
            /*if (oSL.modal) {
             oSL.modal.show();
             }*/
            $CONN.asyncRequest("GET", "/index.php?a=getregform", oSL.oCallback);
        }

    },
    hideRegForm:function () {
        if (oSL.Regform) {
            oSL.Regform.getInstance().hide();
            window.location.reload();
        }

        return false;
    },
    /**
     * Get value of specific meta tag This assumes that meta tag name is unique -
     * only appears once in the meta tags If meta tag not found then returns
     * false
     *
     * @param string
     *            sMetaName name of meta tag of which we need the value
     *
     * @param book
     *            bAsElement if passed and is true then return the actual
     *            DOMElement for that meta tag instead of just the value
     */
    getMeta:function (sMetaName, bAsElement) {
        $L('182 looking for meta tag ' + sMetaName);
        var el, i, aMeta = document.getElementsByTagName('meta');
        $L('43 ' + $LANG.dump(aMeta) + ' total metas: ' + aMeta.length);
        if (!aMeta) {
            $L('45 no meta tags in document', 'error');
            return false;
        }

        for (i = 0; i < aMeta.length; i += 1) {
            if (aMeta[i].name && (aMeta[i].name == sMetaName)
                && aMeta[i].content) {
                if (bAsElement) {
                    var el = aMeta[i];
                    $L('213 meta tag element ' + el);

                    return el;
                }

                return aMeta[i].content;
            }
        }

        return false;
    },

    /**
     * Get value of 'mytoken' meta tag which serves as a security token for form
     * validation.
     */
    getToken:function () {
        $L('166 getToken');
        var token = this.getMeta('version_id');
        return token;
    },
    /**
     * Test to determine if page is being viewed by a logged in user a logged in
     * user has the session-tid meta tag set to value of twitter userid
     */
    isLoggedIn:function () {
        $L('64 this is: ' + this); // oTQ

        var ret, uid = this.getMeta('session-uid');
        $L('148 uid: ' + uid);

        ret = (uid && (uid !== '') && (uid !== '0'));

        $L('66 ret: ' + ret);

        return ret;
    },
    /**
     * Get timezone offset based on user clock
     *
     * @return number of secord from UTC time can be negative
     */
    getTZO:function () {
        var tzo, nd = new Date();
        tzo = (0 - (nd.getTimezoneOffset() * 60));

        return tzo;

    },
    /**
     * Get value of timezone offset and set it as tzo cookie This way a value
     * can be read on the server This is useful during the registration as a way
     * to pass the value of timezone offset but without using the POST and
     * without adding it to GET
     *
     * The cookie is set as SESSION cookie with site-wide path (accessible from
     * any page but must be in the same domain)
     */
    setTZOCookie:function () {
        $L('109 this is: ' + this);
        var tzo = this.getTZO();
        $L('117 tzo: ' + tzo);
        $COOKIE.set("tzo", tzo, {
            path:"/"
        });
    },
    oCallback:{
        success:oAjaxObject.handleSuccess,
        failure:oAjaxObject.handleFailure,
        scope:oAjaxObject
    }, //
    fAddIcon:function (s, b) {
        var el = (typeof (s) === 'string') ? $(s) : s;

        if (!this.eLoader) {
            this.eLoader = document.createElement("img");
            this.eLoader.src = '/images/ajax-loader.gif';
            this.eLoader.id = "loadericon";
        }

        if (this.eLoader) {
            if (b && b === true) {
                el.innerHTML = '';
            }

            el.appendChild(this.eLoader);

        }
    }, //
    fRemoveIcon:function () {
        if (this.eLoader && this.eLoader.parentNode) {
            $L('include.js 118 eLoader parent: ' + this.eLoader.parentNode
                + ' id: ' + this.eLoader.parentNode.id);
            this.eLoader.parentNode.removeChild(this.eLoader);
        }
    },
    /**
     * Compares 2 HTML form Dom nodes
     *
     * @param {Object}
        *            oNewForm a new HTML form, usually the one use tries to submit
     * @param {Object}
        *            oOldForm an old HTML form, usually the one with default values
     *            (valued when page first loaded)
     * @return boolean true if at least one of new form's values is different
     *         from the same one in old form or if the new form has a form
     *         element that is not present in the old form.
     */
    fCompareForms:function (oNewForm, oOldForm) {
        $L($CONN.setForm(oNewForm));
        $L($CONN.setForm(oOldForm));

        if ($CONN.setForm(oNewForm) === $CONN.setForm(oOldForm)) {
            return true;
        }

        return false;
    }, //
    /**
     * Use color animation to change background-color of an element slowly from
     * one color to a new color, then back to sFromColor, then set
     * backgroundColor to its original (the one before this function) This can
     * be used to display changes or to attract attention to some message inside
     * a div like to a new error message.
     *
     * @param {Object}
        *            el
     * @param {Object}
        *            sToColor
     */
    fColorChange:function (el, sFromColor, sToColor) {
        $L('starting fColorChange for ' + el);
        var myChange, curBg, myChangeBack, //
            element = (typeof el === 'string') ? $(el) : el, //
            sToColor = (sToColor && typeof sToColor === 'string') ? sToColor
                : '#FF0000', //
            sFromColor = (sFromColor && typeof sFromColor === 'string') ? sFromColor
                : '#FFFFFF';

        $L('element is: ' + element);

        if (element) {

            curBg = $D.getStyle(element, 'background-color');
            $D.setStyle(element, 'background-color', sFromColor);
            myChange = new YAHOO.util.ColorAnim(element, {
                backgroundColor:{
                    to:sToColor
                }
            });

            /**
             * Change the background back to what if was before the animation
             * started
             */
            myChangeBack = function () {
                element.style.backgroundColor = curBg;
            };

            myChange.onComplete.subscribe(myChangeBack);
            myChange.animate();

        }
    }, //
    /**
     * Parse data object, depending of keys and values update elements on the
     * page.
     *
     * @param {Object}
        *            o parsed json data returned from server after processing form
     *            values.
     */
    fParseQf:function (json) {
        $L($LANG.dump(json));

        var strMessage = '', aAvatars, i = 0, el, formField, eMessageDiv = $('qfe');

        switch (true) {

            case json.hasOwnProperty('exception'):
                if (json.hasOwnProperty('errHeader')) {
                    strMessage += '<u>' + json.errHeader + '</u><br>';
                }
                eMessageDiv.innerHTML = '<div id="qfErrors">' + strMessage
                    + json.exception + '</div>';
                break;

            case json.hasOwnProperty('errors'):
                if (json.hasOwnProperty('errHeader')) {
                    strMessage += '<u>' + json.errors.errHeader + '</u><br>';
                }

                eMessageDiv.innerHTML = '<div id="qfErrors">' + strMessage
                    + json.errors.errMessage + '</div>';
                this.aEls = [];
                for (formField in json) {
                    if (json.hasOwnProperty(formField)
                        && json[formField].hasOwnProperty('err')) {
                        el = $('a' + formField);
                        if (el) {
                            el.style.backgroundColor = '#FFFFCC';
                            this.aEls.push(el);
                        }
                    }
                }

                this.fColorChange('qfmessage', '#FF0000', '#FFFFFF'); // eMessageDiv
                break;

        }

        if (oSL.oFrm && oSL.oFrm.elBtnSubmit) {
            oSL.oFrm.elBtnSubmit.disabled = false;
        }
        var elPbar = $('progressBar'), elAvatarField = $('aavatar');
        if (elPbar) {
            elPbar.parentNode.removeChild(elPbar);
        }
        if (elAvatarField) {
            $D.setStyle(elAvatarField, 'display', 'block');
        }

    }
}; //

/**
 * Dialog used for Tweeting from our site Should display modal window with a
 * short form to send tweet.
 */
oSL.tweet = (function () {

    var oDialog;
    var siteTitle = oSL.getMeta('site_title');
    var siteUrl = oSL.getMeta('site_url');
    var token = oSL.getToken();

    return {

        getInstance:function () {
            var eRootDiv, oFrm, siteDescription, sForm;
            if (!oDialog) {
                if (!$('dialog1')) {

                    sForm = '<div class="hd">Please enter your information</div>'
                        + '<div class="bd"><hr/>'
                        + '<form method="POST" action="/index.php">'
                        + '<input type="hidden" name="a" value="tweet">'
                        + '<input type="hidden" name="token" value="'
                        + token
                        + '">'
                        + '<h3 class="tweetdlg">Tweet this:</h3>'
                        + '<div class="clear"></div>'
                        + '<textarea cols="44" rows="5" name="tweet">'
                        + $('twinvite').title
                        + ' '
                        + siteTitle
                        + ' '
                        + siteUrl
                        + '</textarea>'
                        + '<div class="clear"></div>' + '</form>';

                    eRootDiv = document.createElement('div');
                    eRootDiv.id = 'dialog1';
                    document.body.appendChild(eRootDiv);
                    eRootDiv.innerHTML = sForm;
                }
                oDialog = new $W.Dialog("dialog1", {
                    width:"30em",
                    fixedcenter:true,
                    visible:false,
                    constraintoviewport:true,
                    /*
                     * x : 200, y : 200,
                     */
                    buttons:[
                        {
                            text:"Submit",
                            handler:function () {
                                this.submit();
                            },
                            isDefault:true
                        },
                        {
                            text:"Cancel",
                            handler:function () {
                                this.cancel();
                            }
                        }
                    ]
                });
                oDialog.beforeSubmitEvent.subscribe(function () {
                    $L('before submit tweet');
                    //oSL.modal.show();
                });
                oDialog.callback = {
                    success:function (o) {
                        alert('Tweet sent');
                        //oSL.modal.hide();
                    },
                    failure:function (o) {
                        alert('Tweet not sent');
                        //oSL.modal.hide();
                    }
                };
                oDialog.setHeader("Invite Your Friends");
                oDialog.render(document.body);
            }

            return oDialog;
        },
        /**
         * Useful if we need to call destructor
         */
        destroy:function () {
            if (oDialog) {
                oDialog.destroy();
            }
        },
        /**
         * If panel exists call the hide() method
         */
        hide:function () {
            if (oDialog) {
                oDialog.hide();
            }
        },

        setTextArea:function (s) {

        },
        toString:function () {
            return 'object oDialog created with oSL.dialog()';
        }
    };

})();

/**
 * Javascript for creating modal window with registration form, handling
 * registration form submit via ajax, handling various responses, errors
 */
oSL.Regform = (function () {

    var errDiv;

    /**
     * Object of type Dialog which is a form inside of modal window
     */
    var oDialog;

    /**
     * Associative array of dialog objects
     */
    var aDialogs = {};

    /**
     * SimpleDialog prompt that will handle the "Cancel" button
     */
    var oPrompt;

    /**
     * Handle click on submit button "this" is object of oDialog Must disable
     * the submit button, start validation and actually submit the form and add
     * 'loading' icon or start email validation progress bar.
     */
    var handleSubmit = function () {
        // alert('12 this is: ' + this);
        // oSL.Regform.setButtonsDone();
        this.submit();
    };

    /**
     * User clicked on Cancel button We must show prompt "Are you sure?" Yes/No
     * if Yes, then must set cookie 'skipReg' so that next time during the same
     * sessin we don't show this prompt again
     */
    var handleCancel = function () {
        $L('41 clicked on Cancel this is: ' + this);
        oSL.Regform.getPrompt().show();

    };
    /**
     * Handles when user clicked on "Continue registration" button in the "Are
     * you sure?" Prompt
     */
    var handleContinue = function () {
        this.hide();
    };

    /**
     * Handle click on Exit registration button in the oPrompt prompt This will
     * close the prompt and will close the registration Dialog
     */
    var handleExit = function () {
        var eAvatar = $('regext');
        $L('handling exit');
        this.hide();
        oSL.Regform.getInstance().hide();
        /**
         * don't set dnd cookie if this is not part of "Join" form
         */
        if (eAvatar) {
            $COOKIE.set("dnd", "1", {
                path:"/"
            });
        }
    };
    /**
     * Success only means that json data was received but it may still contain
     * error messages, This function will set error messages if there are any,
     * or in case of success it will replace the body of this panel with the
     * success text and maybe 2 buttons "Close" and "Go to profile page" Also
     * it's possible that if we want to show the newsletter selection page we
     * will then probably have to destroy this panel and create a brand new one
     * for the newsletter selections
     */
    var handleSuccess = function (o) {
        // $L('39 success ' + this, 'warn');
        var oMyDialog = oSL.Regform.getInstance();
        //oSL.modal.hide();
        oSL.Regform.enableButtons();
        // oSL.Regform.getInstance().setBody('');
        // oSL.Regform.getInstance().setFooter('<p>stuff and stuff</p>');
        var aButtons = oSL.Regform.getInstance().getButtons();
        for (var i = 0; i < aButtons.length; i += 1) {
            $L('button ' + i + ' is ' + aButtons[i]);
        }

        var response = o.responseText;
        try {
            json = $J.parse(o.responseText);
            // alert($LANG.dump(json));
            switch (true) {
                case (json.hasOwnProperty('exception')):
                    setError(json);
                    break;

                case (json.hasOwnProperty('action') && (json.action == 'done')):
                    oMyDialog.setHeader('Welcome!');
                    oMyDialog.setFooter('');
                    oMyDialog.setBody(json.body);
                    break;
            }

        } catch (e) {
            //oSL.modal.hide();
            alert("Invalid json data in responceText " + $LANG.dump(e) + "Respnose: " + $LANG.dump(o.responseText));
        }

    };

    var handleFailure = function (o) {
        //oSL.modal.hide();
        oSL.Regform.enableButtons();
        oSL.Regform.getInstance().setBody('<p>boo hoo, something is wrong</p>');
        // setError('failed');
        $L('47 fail ', 'warn');
    };

    var setError = function (oError) {

        var errDiv = $('form_error');
        // alert('errDiv: ' + errDiv);
        var aInputs, message = oError.exception, //
            oRegform = oSL.Regform.getInstance(); //
        var myForm = oRegform.form;
        // alert('setting error: ' + message);
        // alert('cp 1825');
        errDiv.innerHTML = message;
        // alert('cp 1828');
        oSL.fColorChange(errDiv, '#FFFFFF', '#FF0000');
        // alert('cp 1830');
        if (oError.type && ('LampcmsCaptchaLimitException' === oError.type)) {
            $LANG.later(2000, oRegform, 'destroy');
        }
        // alert('cp 1832');
        if (oError.hasOwnProperty('fields')) {
            // alert('cp 1834');
            aInputs = oError.fields;
            for (var i = 0; i < aInputs.length; i += 1) {
                if (myForm.hasOwnProperty(aInputs[i])) {
                    myForm[aInputs[i]].style.backgroundColor = "#CCFFCC";
                }
            }
        }

        if (oError.hasOwnProperty('captcha')) {
            if (oError.captcha.public_key && oError.captcha.hncaptcha
                && oError.captcha.img) {
                myForm.public_key.value = oError.captcha.public_key;
                myForm.private_key.value = '';
                myForm.hncaptcha.value = oError.captcha.hncaptcha;
                $('imgcaptcha').innerHTML = oError.captcha.img;
            }
        } else {
            /**
             * If error is not a captcha error this means that captcha has been
             * verified since we do captcha verification first In this case we
             * should set the form field to disabled oError.type means exception
             * came from server side validation and not just from validate() js
             * based pre-validation
             */
            if (myForm.private_key && oError.type) {
                myForm.private_key.disabled = true;
            }
        }

        // alert('cp 1864');
    };
    /**
     * Buttons to be used on the "Registration complete" panel These buttons
     * will replace the other buttons that were created initially on the Dialog
     */
    var aButtonsDone = [
        {
            text:"<-- Return to page",
            handler:function () {
                alert('this is ' + this);
            },
            isDefault:true
        },
        {
            text:"Go to Profile editor -->",
            handler:function () {
                alert('go to profile');
            }
        }
    ];

    /**
     * Start the progress bar or progress icon
     */
    var startProgress = function (o) {
        oSL.Regform.disableButtons();
        //oSL.modal.show('Please wait...');
    };

    return {
        getInstance:function () {
            $L('cp 13', 'warn');
            if (!oDialog) {
                $L('cp 15', 'warn');
                $D.removeClass("regdiv", "yui-pe-content");
                $L('cp 17', 'warn');
                oDialog = new $W.Dialog("regdiv", {
                    width:"50em",
                    fixedcenter:"contained",
                    visible:false,
                    constraintoviewport:false,
                    hideaftersubmit:false,
                    draggable:true,
                    close:false,
                    modal:true,
                    /*
                     * x: 150, y: 10,
                     */
                    buttons:[
                        {
                            text:"Create Your Account",
                            handler:handleSubmit,
                            isDefault:true
                        },
                        {
                            text:"Cancel",
                            handler:handleCancel
                        }
                    ]
                });

                oDialog.callback = {
                    success:handleSuccess,
                    failure:handleFailure
                };

                oDialog.validate = function () {
                    // alert('validating');
                    var message, //
                        aInputs = [], //
                        myForm = this.form, //
                        nd = new Date(), //
                        data = this.getData();
                    $L('data: ' + $LANG.dump(data));
                    var tzo = (0 - (nd.getTimezoneOffset() * 60)); // now its
                    // number of
                    // seconds
                    if ((myForm.tzo) && (tzo)) {
                        myForm.tzo.value = tzo;
                    }

                    var checkEmail = function (str) {
                        var at = "@", dot = ".", lat = str.indexOf(at), lstr = str.length, ldot = str
                            .indexOf(dot);

                        if (str.indexOf(at) == -1 || str.indexOf(at) == 0
                            || str.indexOf(at) == lstr) {

                            return false;
                        }

                        if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0
                            || str.indexOf(dot) == lstr) {

                            return false;
                        }

                        if (str.substring(lat - 1, lat) == dot
                            || str.substring(lat + 1, lat + 2) == dot) {

                            return false;
                        }

                        if ((str.indexOf(at) == -1)
                            || (str.indexOf(at, (lat + 1)) != -1)
                            || (str.indexOf(dot, (lat + 2)) == -1)
                            || (str.indexOf(" ") != -1)) {

                            return false;
                        }

                        return true;
                    };

                    switch (true) {
                        case (data.email == ""):
                            message = "Please enter email address";
                            aInputs.push('email');
                            break;

                        case (data.username == ""):
                            message = "Please enter Username";
                            aInputs.push('username');
                            break;

                        case (data.hasOwnProperty('private_key') && ("" == data.private_key)):
                            message = "Please enter the text from image";
                            aInputs.push('private_key');
                            break;

                        case (!checkEmail(data.email)):
                            message = "Email address appears to be invalid<br>Please enter a valid Email";
                            aInputs.push('email');
                            break;

                        default:

                            return true;
                    }

                    setError({
                        exception:message,
                        fields:aInputs
                    });
                    return false;

                };
                oDialog.asyncSubmitEvent.subscribe(function (type, args) {

                    var connectionObject = args[0];
                    startProgress();

                });

                oDialog.render($('lastdiv'));

            }

            return oDialog;
        },

        toString:function () {
            return 'object oSL.Regform';
        },
        getPrompt:function () {
            if (!oPrompt) {
                $L('making prompt');
                oPrompt = new $W.SimpleDialog("simpledialog1", {
                    width:"300px",
                    fixedcenter:true,
                    zindex:99,
                    visible:false,
                    draggable:false,
                    close:true,
                    modal:true,
                    text:"Do you want to continue?",
                    icon:$W.SimpleDialog.ICON_ALARM,
                    /* icon : $W.SimpleDialog.ICON_HELP, */
                    constraintoviewport:true,
                    buttons:[
                        {
                            text:"Continue registration",
                            handler:handleContinue,
                            isDefault:true
                        },
                        {
                            text:"Exit registration",
                            handler:handleExit
                        }
                    ],
                    effect:[
                        {
                            effect:$W.ContainerEffect.FADE,
                            duration:0.2
                        }
                    ]
                });

                oPrompt.setHeader("Are you sure?");
                oPrompt.render(document.body);
            }

            $L('176 oPrompt: ' + oPrompt, 'warn');

            return oPrompt;
        },
        disableButtons:function () {
            var aBtns;
            $L('105 this is: ' + this, 'warn');
            if (oDialog) {
                aBtns = oDialog.getButtons();
                for (var i = 0; i < aBtns.length; i += 1) {
                    aBtns[i].set('disabled', true);
                }

            }
        },
        enableButtons:function () {
            var aBtns;
            $L('105 this is: ' + this, 'warn');
            if (oDialog) {
                aBtns = oDialog.getButtons();
                for (var i = 0; i < aBtns.length; i += 1) {
                    aBtns[i].set('disabled', false);
                }

            }
        },
        setButtonsDone:function () {
            oDialog.cfg.queueProperty("buttons", aButtonsDone);
        },
        destroy:function () {
            if (oDialog) {
                oDialog.destroy();
            }
        },
        hasDialog:function () {
            if (oDialog && oDialog.body) {
                return true;
            }

            return false;
        }

    };
})();
