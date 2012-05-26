/**
 *
 */
YUI.add('cateditor', function (Y) {

    Y.namespace('categoryEditor');

    Y.categoryEditor.Editor = function () {

        var listItems, focus, toggleActive, removeItem, setupEditedDiv, clearEditables, toggleCatOnly, handleEdited, disableButtons, resetForm, enableButtons, setFormError, prependCategory, loadEditorForm, Editcat, dblClick;
        if (jQuery === undefined) {
            Y.log('jQuery, jQuery UI and jQuery nestedSortable must be included');
            return;
        }

        Y.log('jQuery is ' + jQuery + 'jQuery(\'ol.sortable\')' + jQuery('div'));
        listItems = Y.all("ol.sortable > li");
        Y.log('listItems: ' + listItems + ' ' + listItems.size());
        if (0 !== listItems.size()) {
            Y.all(".hide").removeClass('hide');
        }

        if (jQuery('ol.sortable').length > 0) {


            jQuery('ol.sortable').nestedSortable({
                /*disableNesting: 'no-nest',*/
                forcePlaceholderSize:true,
                handle:'div',
                helper:'clone',
                items:'li',
                maxLevels:10,
                opacity:.6,
                placeholder:'placeholder',
                revert:250,
                tabSize:25,
                tolerance:'pointer',
                toleranceElement:'> div'
            });
        }

        resetEditor = function (e, skipPrompt) {
            Y.log('resetting editor form');
            var catId = Y.one('#id_edit_category').one('input[name=category_id]').get('value');

            if ('' === catId || skipPrompt || (confirm('Are you sure?\nResetting form will switch from "Edit mode" to "Add new category" mode') )) {
                // reset hidden input
                Y.one('#id_edit_category').one('input[name=category_id]').set('value', '');
                // reset description
                Y.log('Reseting id_catdesc: ' + Y.one("textarea[name=catdesc]").get('text'));
                Y.one('textarea[name=catdesc]').set('value', '');
                Y.one('textarea[name=catdesc]').set('text', '');
                // set submit button text to Add New Category
                Y.one('#cat_submit').set('value', 'Add New Category');
                // Remove errors
                Y.all("span.f_err").set('text', '');
                // Uncheck category only
                Y.one('#id_catonly').set('checked', false);
                // Check active
                Y.one('#id_active').set('checked', true);
                // reset title
                Y.one('#id_cattitle').set('value', '');
                // reset slug
                Y.one('#id_catslug').set('value', '');
            }
        };

        /**
         * Add 'edited' class and scroll into view
         * the newly added or edited 'li' element
         */
        focus = function (e) {
            e.addClass('edited');
            e.scrollIntoView();
        };

        /**
         * Remove 'editable' class from all elements
         * the 'editable' class is assigned to li currently
         * being loaded into the editor form
         */
        clearEditables = function () {
            Y.all('.editable').removeClass('editable');
        };
        /**
         * Toggles active/active1 class
         * of the sortable div
         * active1 means category is active
         * active means not active (strange, I know)
         */
        toggleActive = function (div, isActive) {
            if (isActive) {
                div.removeClass('active').addClass('active1');
            } else {
                div.removeClass('active1').addClass('active');
            }
        };
        /**
         * Assign 'sci1' class to 'category only' type
         * of 'li' and 'sci' to 'not category only'
         */
        toggleCatOnly = function (div, isCatonly) {
            if (isCatonly) {
                div.removeClass('sci').addClass('sci1');
            } else {
                div.removeClass('sci1').addClass('sci');
            }
        };
        /**
         * Setup properties of div
         * of the category that has just been returned
         * from the server in ajax response.
         */
        setupEditedDiv = function (div, oCat, li) {
            var span, listItems;
            Y.all('div.edited').removeClass('edited');
            div.set('text', oCat['title']);
            span = Y.Node.create('<span class="icoc del fr" title="Delete">&nbsp;</span>');
            div.append(span);
            div.setAttribute('lampcms:active', oCat['b_active']);
            div.setAttribute('lampcms:catonly', oCat['b_catonly']);
            div.setAttribute('lampcms:desc', oCat['desc']);
            div.setAttribute('lampcms:slug', oCat['slug']);
            div.addClass('new_cat');
            toggleActive(div, oCat['b_active']);
            toggleCatOnly(div, oCat['b_catonly']);
            if (li) {
                li.show(true);
            }

            /**
             * Remive the "hide"
             * class from "save order" button
             * and possibly from other buttons
             * This is necessary to do in the case when the very
             * first category was just added, otherwise
             * the "Save order" button will still remain hidden
             */
            listItems = Y.all("ol.sortable > li");
            if (listItems.size() > 1) {
                Y.one("#save_nested").removeClass('hide');
            }

        };

        /**
         * Callback for success of io request
         * @param int id io transaction id
         * @para string resp io response object
         */
        handleEdited = function (id, resp) {
            var li, div, span, data, oCat;
            Y.log('Got success ');
            enableButtons();
            clearEditables();

            data = Y.JSON.parse(resp.responseText);

            resetEditor(null, true);

            if (data.hasOwnProperty('alert')) {
                alert(data['alert']);
                return;
            }
            Y.log('got responseText');
            oCat = data['category'];
            Y.log('Got category object' + oCat);
            li = Y.one('#cat_' + oCat['id']);
            // li can be null if not found
            Y.log('li: ' + li);
            if (li) {
                div = li.one('div');
                setupEditedDiv(div, oCat);
            } else {
                /**
                 * This is a newly added category.
                 * Must create
                 *
                 */
                li = Y.Node.create('<li id="cat_' + oCat['id'] + '" style="opacity: 0; display: none;"></li>');
                div = Y.Node.create('<div class="booy">' + oCat['title'] + '</div>');
                div.append(span);
                li.append(div);
                Y.one('ol.sortable').prepend(li);
                setupEditedDiv(div, oCat, li);

            }

            focus(div);
            jQuery('ol.sortable').nestedSortable('refresh');

        };

        var handleFailed = function (id, o) {
            Y.log('Failed request to Editor');
        }

        setFormError = function (o) {
            var field, eErr;
            for (field in o) {
                if (o.hasOwnProperty(field)) {
                    eErr = (Y.one("#" + field + "_e"));
                    if (eErr) {

                        eErr.set('text', o[field]);
                    } else {

                        eErr = Y.one(".form_error");
                        if (eErr) {

                            eErr.set('text', o[field]);
                        }
                    }

                    if (eErr) {
                        eErr.scrollIntoView();
                    } else {
                        alert(o[field]);
                    }
                }
            }
        }, //

            disableButtons = function () {
                Y.one('.btn_comment').set('disabled', 'disabled');
            };

        enableButtons = function () {
            Y.one('.btn_comment').removeAttribute('disabled');
        };
        /**
         * Remove the li item from
         * the <ol> first applying the
         * fading out effect
         *
         * @todo if li has child ol element
         * then refuse to remove this category
         * and show message that cannot remove
         * a category that has sub-categories.
         * First must move subcategories out or
         * remove them.
         */
        removeItem = function (e) {
            var cfg, id, li, subs, el, span = e.currentTarget;
            el = span.ancestor('div');
            li = el.ancestor('li');
            subs = li.one('ol');
            Y.log('subs: ' + subs);
            if (subs) {
                alert("Cannot remove category that has one or more sub-categories.\n<br>" +
                    "You must remove all sub-categories before you can delete this category ");
                return;
            }
            if (!confirm("Are you sure? If this category have any posts, it may result in broken links. It is safer to just make category inactive")) {
                return;
            }
            id = li.get('id').substr(4)
            cfg = {
                on:{
                    success:function () {
                        li.scrollIntoView();
                        el.setStyle('backgroundColor', 'red')
                            .setStyle('borderWidth', '2px')
                            .setStyle('borderColor', 'red')
                            .setStyle('overflow', 'hidden');

                        el.transition({
                            duration:0.75,
                            easing:'ease-out',
                            height:0,
                            width:{
                                delay:0.75,
                                easing:'ease-in',
                                value:0
                            },

                            opacity:{
                                delay:1.5,
                                duration:1.25,
                                value:0
                            }
                        }, function () {
                            li.remove();
                            jQuery('ol.sortable').nestedSortable('refresh');
                        })
                    },
                    failure:function () {
                        alert('Failed to delete category. Look in server php log for details of error')
                    }
                }

            };

            request = Y.io('/index.php?a=editcategory&del=' + id, cfg);
        };

        /**
         * Function to load the data
         * from the <li> element into
         * the editor form.
         * This function is fired on doubleclick
         * on the <li> element
         */
        loadEditorForm = function (e) {
            var isCategory, description, isActive, id, el = e.currentTarget;

            Y.log('title in el: ' + el.get('text'));

            clearEditables();
            el.addClass('editable');
            Y.all("span.f_err").set('text', '');
            Y.all("div.edited").removeClass('edited');
            Y.log('el: ' + el + ' slug: ' + el.getAttribute('lampcms:slug'));
            id = Y.one(el).ancestor('li').get('id').substr(4);
            Y.log('295 value of id: ' + id);
            isCategory = el.getAttribute('lampcms:catonly');
            isCategory = (isCategory && "false" !== isCategory);
            isActive = el.getAttribute('lampcms:active');
            isActive = (isActive && "false" !== isActive);
            Y.log('isActive: ' + isActive);

            Y.one('#id_cattitle').set('value', Y.Lang.trim(el.get('text')));
            Y.one('#id_catslug').set('value', Y.Lang.trim(el.getAttribute('lampcms:slug')));
            description = el.getAttribute('lampcms:desc');
            Y.log('description: ' + description);

            Y.one('textarea[name=catdesc]').set('text', description);
            Y.one('textarea[name=catdesc]').set('value', description);

            Y.one('#id_edit_category').one('input[name=category_id]').set('value', id);
            Y.one('#cat_submit').set('value', 'Edit Category');

            if (isCategory) {
                Y.one('#id_catonly').set('checked', true);
            } else {
                Y.one('#id_catonly').set('checked', false);
            }

            if (isActive) {
                Y.one('#id_active').set('checked', true);
            } else {
                Y.one('#id_active').set('checked', false);
            }

            Y.one("#add_category").scrollIntoView();
        }

        /**
         * Function handles the "Submit" action
         * of add/edit category form
         */
        Editcat = function (e) {
            Y.log('starting Editcat');
            var request, cfg, title, desc, slug, form = e.currentTarget;
            e.halt();
            e.preventDefault();
            errors = false;
            title = form.one("#id_cattitle");
            slug = form.one("#id_catslug");
            sTitle = Y.Lang.trim(title.get('value'));
            sSlug = Y.Lang.trim(slug.get('value'));
            //alert('title: ' + title.get('value'));
            if (!sTitle.length) {
                setFormError({'cattitle':'required'});
                errors = true;
            }

            if (!sSlug.length) {
                setFormError({'catslug':'required'});
                errors = true;
            }

            if (!errors) {
                Y.log("Before post");
                cfg = {
                    method:'POST',
                    form:{
                        id:form
                        /*upload: true,*/
                    },
                    on:{
                        start:function () {
                            Y.log('started request')
                        },
                        success:handleEdited,
                        failure:handleFailed
                    }

                };

                disableButtons();
                //showLoading(Y.one("#cat_submit").ancestor('div'));
                request = Y.io('/index.php', cfg);
                return false;
            }

        };
        //


        Y.on('click', function () {
            var serialized = jQuery('ol.sortable').nestedSortable('serialize');
            jQuery('#serializeOutput').text(serialized + '\n\n');
        }, '#serialize');

        Y.one("#reset_cat").on('click', resetEditor);

        Y.delegate("dblclick", loadEditorForm, "ol.sortable", 'div');
        Y.delegate("click", removeItem, "ol.sortable", "span.del");
        Y.delegate("mousedown", function (e) {
            var d = e.currentTarget;
            d.removeClass('edited');
        }, "ol.sortable", 'div.edited');


        Y.one("#save_nested").on('click', function () {
            var d, cfg, ser = jQuery('ol.sortable').nestedSortable('serialize'); //toHierarchy
            Y.log('her: ' + Y.dump(ser));
            da = 'a=editcategory&sort=1&' + ser;
            cfg = {
                method:'POST',
                data:da,
                on:{
                    success:handleEdited,
                    failure:function () {
                        alert('Failed')
                    }
                }

            };
            request = Y.io('/index.php', cfg);
        })


        Y.on('submit', Editcat, '#id_edit_category');

    };


}, '0.1.1' /* module version */, {
    requires:['node', 'dump', 'event', 'base', 'io', 'io-base', 'io-form', 'io-upload-iframe', 'json', 'transition']
});