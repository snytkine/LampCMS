var dp = {sh:{Toolbar:{}, Utils:{}, RegexLib:{}, Brushes:{}, Strings:{AboutDialog:'<html><head><title>About...</title></head><body class="dp-about"><table cellspacing="0"><tr><td class="copy"><p class="title">dp.SyntaxHighlighter</div><div class="para">Version: {V}</p><p><a href="http://www.dreamprojections.com/syntaxhighlighter/?ref=about" target="_blank">http://www.dreamprojections.com/syntaxhighlighter</a></p>&copy;2004-2007 Alex Gorbatchev.</td></tr><tr><td class="footer"><input type="button" class="close" value="OK" onClick="window.close()"/></td></tr></table></body></html>'}, ClipboardSwf:null, Version:'1.5.1'}};
dp.SyntaxHighlighter = dp.sh;
dp.sh.Toolbar.Commands = {ExpandSource:{label:'+ expand source', check:function (highlighter) {
    return highlighter.collapse;
}, func:function (sender, highlighter) {
    sender.parentNode.removeChild(sender);
    highlighter.div.className = highlighter.div.className.replace('collapsed', '');
}}, ViewSource:{label:'view plain', func:function (sender, highlighter) {
    var wnd, code = dp.sh.Utils.FixForBlogger(highlighter.originalCode).replace(/</g, '&lt;');
    wnd = window.open('', '_blank', 'width=750, height=400, location=0, resizable=1, menubar=0, scrollbars=0');
    wnd.document.write('<textarea style="width:99%;height:99%">' + code
        + '</textarea>');
    wnd.document.close();
}}, CopyToClipboard:{label:'copy to clipboard', check:function () {
    return false;
}, func:function (sender, highlighter) {
    var code = dp.sh.Utils.FixForBlogger(highlighter.originalCode).replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&amp;/g, '&');
    if (window.clipboardData) {
        window.clipboardData.setData('text', code);
    } else if (dp.sh.ClipboardSwf !== null) {
        var flashcopier = highlighter.flashCopier;
        if (flashcopier === null) {
            flashcopier = document.createElement('div');
            highlighter.flashCopier = flashcopier;
            highlighter.div.appendChild(flashcopier);
        }
        flashcopier.innerHTML = '<embed src="'
            + dp.sh.ClipboardSwf
            + '" FlashVars="clipboard='
            + encodeURIComponent(code)
            + '" width="0" height="0" type="application/x-shockwave-flash"></embed>';
    }
}}, PrintSource:{label:'print', func:function (sender, highlighter) {
    var doc = null, iframe = document.createElement('IFRAME');
    iframe.style.cssText = 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;';
    document.body.appendChild(iframe);
    doc = iframe.contentWindow.document;
    dp.sh.Utils.CopyStyles(doc, window.document);
    doc.write('<div class="'
        + highlighter.div.className.replace('collapsed', '')
        + ' printing">' + highlighter.div.innerHTML + '</div>');
    doc.close();
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
    document.body.removeChild(iframe);
}}, About:{label:'?', func:function (highlighter) {
    var doc, wnd = window.open('', '_blank', 'dialog,width=300,height=150,scrollbars=0');
    doc = wnd.document;
    dp.sh.Utils.CopyStyles(doc, window.document);
    doc.write(dp.sh.Strings.AboutDialog.replace('{V}', dp.sh.Version));
    doc.close();
    wnd.focus();
}}};
dp.sh.Toolbar.Create = function (highlighter) {
    var name, cmd, div = document.createElement('DIV');
    div.className = 'tools';
    for (name in dp.sh.Toolbar.Commands) {
        cmd = dp.sh.Toolbar.Commands[name];
        if (cmd && cmd.check && cmd.check !== null && !cmd.check(highlighter)) {
            continue;
        }
        div.innerHTML += '<a href="#" onclick="dp.sh.Toolbar.Command(\'' + name
            + '\',this);return false;">' + cmd.label + '</a>';
    }
    return div;
};
dp.sh.Toolbar.Command = function (name, sender) {
    var n = sender;
    while (n !== null && n.className.indexOf('dp-highlighter') === -1) {
        n = n.parentNode;
    }
    if (n !== null) {
        dp.sh.Toolbar.Commands[name].func(sender, n.highlighter);
    }
};
dp.sh.Utils.CopyStyles = function (destDoc, sourceDoc) {
    var i, links = sourceDoc.getElementsByTagName('link');
    for (i = 0; i < links.length; i++) {
        if (links[i].rel.toLowerCase() === 'stylesheet') {
            destDoc.write('<link type="text/css" rel="stylesheet" href="'
                + links[i].href + '"></link>');
        }
    }
};
dp.sh.Utils.FixForBlogger = function (str) {
    return(dp.sh.isBloggerMode === true) ? str.replace(/<br\s*\/?>|&lt;br\s*\/?&gt;/gi, '\n') : str;
};
dp.sh.RegexLib = {MultiLineCComments:new RegExp('/\\*[\\s\\S]*?\\*/', 'gm'), SingleLineCComments:new RegExp('//.*$', 'gm'), SingleLinePerlComments:new RegExp('#.*$', 'gm'), DoubleQuotedString:new RegExp('"(?:\\.|(\\\\\\")|[^\\""\\n])*"', 'g'), SingleQuotedString:new RegExp("'(?:\\.|(\\\\\\')|[^\\''\\n])*'", 'g')};
dp.sh.Match = function (value, index, css) {
    this.value = value;
    this.index = index;
    this.length = value.length;
    this.css = css;
};
dp.sh.Highlighter = function () {
    this.noGutter = false;
    this.addControls = true;
    this.collapse = false;
    this.tabsToSpaces = true;
    this.wrapColumn = 80;
    this.showColumns = true;
};
dp.sh.Highlighter.SortCallback = function (m1, m2) {
    if (m1.index < m2.index) {
        return-1;
    } else if (m1.index > m2.index) {
        return 1;
    } else {
        if (m1.length < m2.length) {
            return-1;
        } else if (m1.length > m2.length) {
            return 1;
        }
    }
    return 0;
};
dp.sh.Highlighter.prototype.CreateElement = function (name) {
    var result = document.createElement(name);
    result.highlighter = this;
    return result;
};
dp.sh.Highlighter.prototype.GetMatches = function (regex, css) {
    var index = 0, match = null;
    while ((match = regex.exec(this.code)) !== null) {
        this.matches[this.matches.length] = new dp.sh.Match(match[0], match.index, css);
    }
};
dp.sh.Highlighter.prototype.AddBit = function (str, css) {
    var i, span, lines;
    if (str === null || str.length === 0) {
        return;
    }
    span = this.CreateElement('SPAN');
    str = str.replace(/ /g, '&nbsp;');
    str = str.replace(/</g, '&lt;');
    str = str.replace(/\n/gm, '&nbsp;<br>');
    if (css !== null) {
        if ((/br/gi).test(str)) {
            lines = str.split('&nbsp;<br>');
            for (i = 0; i < lines.length; i++) {
                span = this.CreateElement('SPAN');
                span.className = css;
                span.innerHTML = lines[i];
                this.div.appendChild(span);
                if (i + 1 < lines.length) {
                    this.div.appendChild(this.CreateElement('BR'));
                }
            }
        } else {
            span.className = css;
            span.innerHTML = str;
            this.div.appendChild(span);
        }
    } else {
        span.innerHTML = str;
        this.div.appendChild(span);
    }
};
dp.sh.Highlighter.prototype.IsInside = function (match) {
    var c, i;
    if (match === null || match.length === 0) {
        return false;
    }
    for (i = 0; i < this.matches.length; i++) {
        c = this.matches[i];
        if (c !== null) {
            if ((match.index > c.index) && (match.index < c.index + c.length)) {
                return true;
            }
        }
    }
    return false;
};
dp.sh.Highlighter.prototype.ProcessRegexList = function () {
    var i;
    for (i = 0; i < this.regexList.length; i++) {
        this.GetMatches(this.regexList[i].regex, this.regexList[i].css);
    }
};
dp.sh.Highlighter.prototype.ProcessSmartTabs = function (code) {
    var i, lines = code.split('\n'), result = '', tabSize = 4, tab = '\t', InsertSpaces = function (line, pos, count) {
        var left, right, spaces = '', i;
        left = line.substr(0, pos);
        right = line.substr(pos + 1, line.length);
        for (i = 0; i < count; i++) {
            spaces += ' ';
        }
        return left + spaces + right;
    }, ProcessLine = function (line, tabSize) {
        var pos = 0, spaces;
        if (line.indexOf(tab) === -1) {
            return line;
        }
        while ((pos = line.indexOf(tab)) !== -1) {
            spaces = tabSize - pos % tabSize;
            line = InsertSpaces(line, pos, spaces);
        }
        return line;
    };
    for (i = 0; i < lines.length; i++) {
        result += ProcessLine(lines[i], tabSize) + '\n';
    }
    return result;
};
dp.sh.Highlighter.prototype.SwitchToList = function () {
    var html = this.div.innerHTML.replace(/<(br)\/?>/gi, '\n'), lines = html.split('\n'), div, columns, showEvery, i = 1, j, li, span;
    if (this.addControls === true) {
        this.bar.appendChild(dp.sh.Toolbar.Create(this));
    }
    if (this.showColumns) {
        div = this.CreateElement('div');
        columns = this.CreateElement('div');
        showEvery = 10;
        while (i <= 150) {
            if (i % showEvery === 0) {
                div.innerHTML += i;
                i += (i + '').length;
            } else {
                div.innerHTML += '&middot;';
                i++;
            }
        }
        columns.className = 'columns';
        columns.appendChild(div);
        this.bar.appendChild(columns);
    }
    for (j = 0, lineIndex = this.firstLine; j < lines.length - 1; j++, lineIndex++) {
        li = this.CreateElement('LI');
        span = this.CreateElement('SPAN');
        if (j % 2 === 0) {
            li.className = 'alt';
        }
        span.innerHTML = lines[j] + '&nbsp;';
        li.appendChild(span);
        this.ol.appendChild(li);
    }
    this.div.innerHTML = '';
};
dp.sh.Highlighter.prototype.Highlight = function (code) {
    var i, j, match, Trim = function (str) {
        return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
    }, Chop = function (str) {
        return str.replace(/\n*$/, '').replace(/^\n*/, '');
    }, Unindent = function (str) {
        var i, j, lines = dp.sh.Utils.FixForBlogger(str).split('\n'), indents = [], regex = new RegExp('^\\s*', 'g'), min = 1000, matches;
        for (i = 0; i < lines.length && min > 0; i++) {
            if (Trim(lines[i]).length !== 0) {
                matches = regex.exec(lines[i]);
                if (matches !== null && matches.length > 0) {
                    min = Math.min(matches[0].length, min);
                }
            }
        }
        if (min > 0) {
            for (j = 0; j < lines.length; j++) {
                lines[j] = lines[j].substr(min);
            }
        }
        return lines.join('\n');
    }, Copy = function (string, pos1, pos2) {
        return string.substr(pos1, pos2 - pos1);
    }, pos = 0;
    code = code || '';
    this.originalCode = code;
    this.code = Chop(Unindent(code));
    this.div = this.CreateElement('DIV');
    this.bar = this.CreateElement('DIV');
    this.ol = this.CreateElement('OL');
    this.matches = [];
    this.div.className = 'dp-highlighter';
    this.div.highlighter = this;
    this.bar.className = 'bar';
    this.ol.start = 1;
    if (this.CssClass !== null) {
        this.ol.className = this.CssClass;
    }
    if (this.collapse) {
        this.div.className += ' collapsed';
    }
    if (this.noGutter) {
        this.div.className += ' nogutter';
    }
    if (this.tabsToSpaces === true) {
        this.code = this.ProcessSmartTabs(this.code);
    }
    this.ProcessRegexList();
    if (this.matches.length === 0) {
        this.AddBit(this.code, null);
        this.SwitchToList();
        this.div.appendChild(this.bar);
        this.div.appendChild(this.ol);
        return;
    }
    this.matches = this.matches.sort(dp.sh.Highlighter.SortCallback);
    for (i = 0; i < this.matches.length; i++) {
        if (this.IsInside(this.matches[i])) {
            this.matches[i] = null;
        }
    }
    for (j = 0; j < this.matches.length; j++) {
        match = this.matches[j];
        if ((match !== null) && (match.length !== 0)) {
            this.AddBit(Copy(this.code, pos, match.index), null);
            this.AddBit(match.value, match.css);
            pos = match.index + match.length;
        }
    }
    this.AddBit(this.code.substr(pos), null);
    this.SwitchToList();
    this.div.appendChild(this.bar);
    this.div.appendChild(this.ol);
};
dp.sh.Highlighter.prototype.GetKeywords = function (str) {
    return'\\b' + str.replace(/ /g, '\\b|\\b') + '\\b';
};
dp.sh.BloggerMode = function () {
    dp.sh.isBloggerMode = true;
};
dp.sh.HighlightAll = function (name, showGutter, showControls, collapseAll, firstLine, showColumns) {
    var i, j, brush, elements = [], options, element, aliases, headNode, styleNode, textNode, language = '', highlighter = null, registered = {}, propertyName = 'innerHTML', FindValue = function () {
        var i, a = arguments;
        for (i = 0; i < a.length; i++) {
            if (a[i] !== null) {
                if (typeof(a[i]) === 'string' && a[i] !== '') {
                    return a[i] + '';
                }
                if (typeof(a[i]) === 'object' && a[i].value !== '') {
                    return a[i].value + '';
                }
            }
        }
        return null;
    }, IsOptionSet = function (value, list) {
        var i;
        for (i = 0; i < list.length; i++) {
            if (list[i] === value) {
                return true;
            }
        }
        return false;
    }, GetOptionValue = function (name, list, defaultValue) {
        var i, matches = null, regex = new RegExp('^' + name + '\\[(\\w+)\\]$', 'gi');
        for (i = 0; i < list.length; i++) {
            if ((matches = regex.exec(list[i])) !== null) {
                return matches[1];
            }
        }
        return defaultValue;
    }, FindTagsByName = function (list, name, tagName) {
        var i, tags = document.getElementsByTagName(tagName);
        for (i = 0; i < tags.length; i++) {
            if (tags[i].getAttribute('rel') === name) {
                list.push(tags[i]);
            }
        }
    };
    FindTagsByName(elements, name, 'pre');
    FindTagsByName(elements, name, 'code');
    if (elements.length === 0) {
        return;
    }
    for (brush in dp.sh.Brushes) {
        aliases = dp.sh.Brushes[brush].Aliases;
        if (aliases !== null) {
            for (i = 0; i < aliases.length; i++) {
                registered[aliases[i]] = brush;
            }
        }
    }
    for (j = 0; j < elements.length; j++) {
        element = elements[j];
        options = FindValue(element.attributes['class'], element.className, element.attributes['language'], element.language);
        options = options || 'java';
        options = options.split(':');
        language = options[0].toLowerCase();
        if (registered[language] !== null) {
            highlighter = new dp.sh.Brushes[registered[language]]();
            highlighter.noGutter = (showGutter == null) ? IsOptionSet('nogutter', options) : !showGutter;
            highlighter.addControls = (showControls == null) ? !IsOptionSet('nocontrols', options) : showControls;
            highlighter.collapse = (collapseAll == null) ? IsOptionSet('collapse', options) : collapseAll;
            highlighter.showColumns = (showColumns == null) ? IsOptionSet('showcolumns', options) : showColumns;
            headNode = document.getElementsByTagName('head')[0];
            if (highlighter.Style && headNode) {
                styleNode = document.createElement('style');
                styleNode.setAttribute('type', 'text/css');
                if (styleNode.styleSheet) {
                    styleNode.styleSheet.cssText = highlighter.Style;
                } else {
                    textNode = document.createTextNode(highlighter.Style);
                    styleNode.appendChild(textNode);
                }
                headNode.appendChild(styleNode);
            }
            highlighter.firstLine = (firstLine === null) ? parseInt(GetOptionValue('firstline', options, 1)) : firstLine;
            highlighter.Highlight(element[propertyName]);
            highlighter.source = element;
            element.parentNode.replaceChild(highlighter.div, element);
        }
    }
};