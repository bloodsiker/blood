/*
 * jQuery Spellchecker - v0.2.4 - 2012-12-19
 * https://github.com/badsyntax/jquery-spellchecker
 * Copyright (c) 2012 Richard Willis; Licensed MIT
 */
(function(e,t){var n={lang:"en",webservice:{path:"spellchecker.php",driver:"PSpell"},local:{requestError:"There was an error processing the request.",ignoreWord:"Ignore word",ignoreAll:"Ignore all",ignoreForever:"Add to dictionary",loading:"Loading...",noSuggestions:"(No suggestions)"},suggestBox:{numWords:5,position:"above",offset:2,appendTo:null},incorrectWords:{container:"body",position:null}},r="spellchecker";Function.prototype.bind||(Function.prototype.bind=function(e){return t.proxy(this,e)});var i=function(e,t){function n(){}n.prototype=t.prototype,e.prototype=new n,e.prototype.constructor=e},s=function(e){return t("<div />").html(e).html()};RegExp.escape=function(e){return e.replace(/[\-\[\]{}()*+?.,\^$|#\s]/g,"\\$&")};var o="\\u0021-\\u0023\\u0025-\\u002A\\u002C-\\u002F\\u003A\\u003B\\u003F\\u0040\\u005B-\\u005D\\u005F\\u007B\\u007D\\u00A1\\u00A7\\u00AB\\u00B6\\u00B7\\u00BB\\u00BF\\u037E\\u0387\\u055A-\\u055F\\u0589\\u058A\\u05BE\\u05C0\\u05C3\\u05C6\\u05F3\\u05F4\\u0609\\u060A\\u060C\\u060D\\u061B\\u061E\\u061F\\u066A-\\u066D\\u06D4\\u0700-\\u070D\\u07F7-\\u07F9\\u0830-\\u083E\\u085E\\u0964\\u0965\\u0970\\u0AF0\\u0DF4\\u0E4F\\u0E5A\\u0E5B\\u0F04-\\u0F12\\u0F14\\u0F3A-\\u0F3D\\u0F85\\u0FD0-\\u0FD4\\u0FD9\\u0FDA\\u104A-\\u104F\\u10FB\\u1360-\\u1368\\u1400\\u166D\\u166E\\u169B\\u169C\\u16EB-\\u16ED\\u1735\\u1736\\u17D4-\\u17D6\\u17D8-\\u17DA\\u1800-\\u180A\\u1944\\u1945\\u1A1E\\u1A1F\\u1AA0-\\u1AA6\\u1AA8-\\u1AAD\\u1B5A-\\u1B60\\u1BFC-\\u1BFF\\u1C3B-\\u1C3F\\u1C7E\\u1C7F\\u1CC0-\\u1CC7\\u1CD3\\u2010-\\u2027\\u2030-\\u2043\\u2045-\\u2051\\u2053-\\u205E\\u207D\\u207E\\u208D\\u208E\\u2329\\u232A\\u2768-\\u2775\\u27C5\\u27C6\\u27E6-\\u27EF\\u2983-\\u2998\\u29D8-\\u29DB\\u29FC\\u29FD\\u2CF9-\\u2CFC\\u2CFE\\u2CFF\\u2D70\\u2E00-\\u2E2E\\u2E30-\\u2E3B\\u3001-\\u3003\\u3008-\\u3011\\u3014-\\u301F\\u3030\\u303D\\u30A0\\u30FB\\uA4FE\\uA4FF\\uA60D-\\uA60F\\uA673\\uA67E\\uA6F2-\\uA6F7\\uA874-\\uA877\\uA8CE\\uA8CF\\uA8F8-\\uA8FA\\uA92E\\uA92F\\uA95F\\uA9C1-\\uA9CD\\uA9DE\\uA9DF\\uAA5C-\\uAA5F\\uAADE\\uAADF\\uAAF0\\uAAF1\\uABEB\\uFD3E\\uFD3F\\uFE10-\\uFE19\\uFE30-\\uFE52\\uFE54-\\uFE61\\uFE63\\uFE68\\uFE6A\\uFE6B\\uFF01-\\uFF03\\uFF05-\\uFF0A\\uFF0C-\\uFF0F\\uFF1A\\uFF1B\\uFF1F\\uFF20\\uFF3B-\\uFF3D\\uFF3F\\uFF5B\\uFF5D\\uFF5F-\\uFF65",u="\\u0041-\\u005A\\u0061-\\u007A\\u00AA\\u00B5\\u00BA\\u00C0-\\u00D6\\u00D8-\\u00F6\\u00F8-\\u02C1\\u02C6-\\u02D1\\u02E0-\\u02E4\\u02EC\\u02EE\\u0370-\\u0374\\u0376\\u0377\\u037A-\\u037D\\u0386\\u0388-\\u038A\\u038C\\u038E-\\u03A1\\u03A3-\\u03F5\\u03F7-\\u0481\\u048A-\\u0527\\u0531-\\u0556\\u0559\\u0561-\\u0587\\u05D0-\\u05EA\\u05F0-\\u05F2\\u0620-\\u064A\\u066E\\u066F\\u0671-\\u06D3\\u06D5\\u06E5\\u06E6\\u06EE\\u06EF\\u06FA-\\u06FC\\u06FF\\u0710\\u0712-\\u072F\\u074D-\\u07A5\\u07B1\\u07CA-\\u07EA\\u07F4\\u07F5\\u07FA\\u0800-\\u0815\\u081A\\u0824\\u0828\\u0840-\\u0858\\u08A0\\u08A2-\\u08AC\\u0904-\\u0939\\u093D\\u0950\\u0958-\\u0961\\u0971-\\u0977\\u0979-\\u097F\\u0985-\\u098C\\u098F\\u0990\\u0993-\\u09A8\\u09AA-\\u09B0\\u09B2\\u09B6-\\u09B9\\u09BD\\u09CE\\u09DC\\u09DD\\u09DF-\\u09E1\\u09F0\\u09F1\\u0A05-\\u0A0A\\u0A0F\\u0A10\\u0A13-\\u0A28\\u0A2A-\\u0A30\\u0A32\\u0A33\\u0A35\\u0A36\\u0A38\\u0A39\\u0A59-\\u0A5C\\u0A5E\\u0A72-\\u0A74\\u0A85-\\u0A8D\\u0A8F-\\u0A91\\u0A93-\\u0AA8\\u0AAA-\\u0AB0\\u0AB2\\u0AB3\\u0AB5-\\u0AB9\\u0ABD\\u0AD0\\u0AE0\\u0AE1\\u0B05-\\u0B0C\\u0B0F\\u0B10\\u0B13-\\u0B28\\u0B2A-\\u0B30\\u0B32\\u0B33\\u0B35-\\u0B39\\u0B3D\\u0B5C\\u0B5D\\u0B5F-\\u0B61\\u0B71\\u0B83\\u0B85-\\u0B8A\\u0B8E-\\u0B90\\u0B92-\\u0B95\\u0B99\\u0B9A\\u0B9C\\u0B9E\\u0B9F\\u0BA3\\u0BA4\\u0BA8-\\u0BAA\\u0BAE-\\u0BB9\\u0BD0\\u0C05-\\u0C0C\\u0C0E-\\u0C10\\u0C12-\\u0C28\\u0C2A-\\u0C33\\u0C35-\\u0C39\\u0C3D\\u0C58\\u0C59\\u0C60\\u0C61\\u0C85-\\u0C8C\\u0C8E-\\u0C90\\u0C92-\\u0CA8\\u0CAA-\\u0CB3\\u0CB5-\\u0CB9\\u0CBD\\u0CDE\\u0CE0\\u0CE1\\u0CF1\\u0CF2\\u0D05-\\u0D0C\\u0D0E-\\u0D10\\u0D12-\\u0D3A\\u0D3D\\u0D4E\\u0D60\\u0D61\\u0D7A-\\u0D7F\\u0D85-\\u0D96\\u0D9A-\\u0DB1\\u0DB3-\\u0DBB\\u0DBD\\u0DC0-\\u0DC6\\u0E01-\\u0E30\\u0E32\\u0E33\\u0E40-\\u0E46\\u0E81\\u0E82\\u0E84\\u0E87\\u0E88\\u0E8A\\u0E8D\\u0E94-\\u0E97\\u0E99-\\u0E9F\\u0EA1-\\u0EA3\\u0EA5\\u0EA7\\u0EAA\\u0EAB\\u0EAD-\\u0EB0\\u0EB2\\u0EB3\\u0EBD\\u0EC0-\\u0EC4\\u0EC6\\u0EDC-\\u0EDF\\u0F00\\u0F40-\\u0F47\\u0F49-\\u0F6C\\u0F88-\\u0F8C\\u1000-\\u102A\\u103F\\u1050-\\u1055\\u105A-\\u105D\\u1061\\u1065\\u1066\\u106E-\\u1070\\u1075-\\u1081\\u108E\\u10A0-\\u10C5\\u10C7\\u10CD\\u10D0-\\u10FA\\u10FC-\\u1248\\u124A-\\u124D\\u1250-\\u1256\\u1258\\u125A-\\u125D\\u1260-\\u1288\\u128A-\\u128D\\u1290-\\u12B0\\u12B2-\\u12B5\\u12B8-\\u12BE\\u12C0\\u12C2-\\u12C5\\u12C8-\\u12D6\\u12D8-\\u1310\\u1312-\\u1315\\u1318-\\u135A\\u1380-\\u138F\\u13A0-\\u13F4\\u1401-\\u166C\\u166F-\\u167F\\u1681-\\u169A\\u16A0-\\u16EA\\u1700-\\u170C\\u170E-\\u1711\\u1720-\\u1731\\u1740-\\u1751\\u1760-\\u176C\\u176E-\\u1770\\u1780-\\u17B3\\u17D7\\u17DC\\u1820-\\u1877\\u1880-\\u18A8\\u18AA\\u18B0-\\u18F5\\u1900-\\u191C\\u1950-\\u196D\\u1970-\\u1974\\u1980-\\u19AB\\u19C1-\\u19C7\\u1A00-\\u1A16\\u1A20-\\u1A54\\u1AA7\\u1B05-\\u1B33\\u1B45-\\u1B4B\\u1B83-\\u1BA0\\u1BAE\\u1BAF\\u1BBA-\\u1BE5\\u1C00-\\u1C23\\u1C4D-\\u1C4F\\u1C5A-\\u1C7D\\u1CE9-\\u1CEC\\u1CEE-\\u1CF1\\u1CF5\\u1CF6\\u1D00-\\u1DBF\\u1E00-\\u1F15\\u1F18-\\u1F1D\\u1F20-\\u1F45\\u1F48-\\u1F4D\\u1F50-\\u1F57\\u1F59\\u1F5B\\u1F5D\\u1F5F-\\u1F7D\\u1F80-\\u1FB4\\u1FB6-\\u1FBC\\u1FBE\\u1FC2-\\u1FC4\\u1FC6-\\u1FCC\\u1FD0-\\u1FD3\\u1FD6-\\u1FDB\\u1FE0-\\u1FEC\\u1FF2-\\u1FF4\\u1FF6-\\u1FFC\\u2071\\u207F\\u2090-\\u209C\\u2102\\u2107\\u210A-\\u2113\\u2115\\u2119-\\u211D\\u2124\\u2126\\u2128\\u212A-\\u212D\\u212F-\\u2139\\u213C-\\u213F\\u2145-\\u2149\\u214E\\u2183\\u2184\\u2C00-\\u2C2E\\u2C30-\\u2C5E\\u2C60-\\u2CE4\\u2CEB-\\u2CEE\\u2CF2\\u2CF3\\u2D00-\\u2D25\\u2D27\\u2D2D\\u2D30-\\u2D67\\u2D6F\\u2D80-\\u2D96\\u2DA0-\\u2DA6\\u2DA8-\\u2DAE\\u2DB0-\\u2DB6\\u2DB8-\\u2DBE\\u2DC0-\\u2DC6\\u2DC8-\\u2DCE\\u2DD0-\\u2DD6\\u2DD8-\\u2DDE\\u2E2F\\u3005\\u3006\\u3031-\\u3035\\u303B\\u303C\\u3041-\\u3096\\u309D-\\u309F\\u30A1-\\u30FA\\u30FC-\\u30FF\\u3105-\\u312D\\u3131-\\u318E\\u31A0-\\u31BA\\u31F0-\\u31FF\\u3400-\\u4DB5\\u4E00-\\u9FCC\\uA000-\\uA48C\\uA4D0-\\uA4FD\\uA500-\\uA60C\\uA610-\\uA61F\\uA62A\\uA62B\\uA640-\\uA66E\\uA67F-\\uA697\\uA6A0-\\uA6E5\\uA717-\\uA71F\\uA722-\\uA788\\uA78B-\\uA78E\\uA790-\\uA793\\uA7A0-\\uA7AA\\uA7F8-\\uA801\\uA803-\\uA805\\uA807-\\uA80A\\uA80C-\\uA822\\uA840-\\uA873\\uA882-\\uA8B3\\uA8F2-\\uA8F7\\uA8FB\\uA90A-\\uA925\\uA930-\\uA946\\uA960-\\uA97C\\uA984-\\uA9B2\\uA9CF\\uAA00-\\uAA28\\uAA40-\\uAA42\\uAA44-\\uAA4B\\uAA60-\\uAA76\\uAA7A\\uAA80-\\uAAAF\\uAAB1\\uAAB5\\uAAB6\\uAAB9-\\uAABD\\uAAC0\\uAAC2\\uAADB-\\uAADD\\uAAE0-\\uAAEA\\uAAF2-\\uAAF4\\uAB01-\\uAB06\\uAB09-\\uAB0E\\uAB11-\\uAB16\\uAB20-\\uAB26\\uAB28-\\uAB2E\\uABC0-\\uABE2\\uAC00-\\uD7A3\\uD7B0-\\uD7C6\\uD7CB-\\uD7FB\\uF900-\\uFA6D\\uFA70-\\uFAD9\\uFB00-\\uFB06\\uFB13-\\uFB17\\uFB1D\\uFB1F-\\uFB28\\uFB2A-\\uFB36\\uFB38-\\uFB3C\\uFB3E\\uFB40\\uFB41\\uFB43\\uFB44\\uFB46-\\uFBB1\\uFBD3-\\uFD3D\\uFD50-\\uFD8F\\uFD92-\\uFDC7\\uFDF0-\\uFDFB\\uFE70-\\uFE74\\uFE76-\\uFEFC\\uFF21-\\uFF3A\\uFF41-\\uFF5A\\uFF66-\\uFFBE\\uFFC2-\\uFFC7\\uFFCA-\\uFFCF\\uFFD2-\\uFFD7\\uFFDA-\\uFFDC",a=function(){this._handlers={}};a.prototype={on:function(e,n){this._handlers[e]||(this._handlers[e]=t.Callbacks()),this._handlers[e].add(n)},trigger:function(e){var n=Array.prototype.slice.call(arguments,1);if(t.isFunction(e))return e.apply(this,n);this._handlers[e]&&this._handlers[e].fireWith(this,n)},handler:function(e){return function(t){this.trigger(e,t)}.bind(this)}};var f=function(e){return function(n){n.preventDefault(),n.stopPropagation();var r=t(n.currentTarget),i=t.trim(r.data("word")||r.text());this.trigger(e,n,i,r,this)}.bind(this)},l=function(e,t){this.instances=[];for(var n=0;n<e.length;n++)this.instances.push(t(e[n]));this.methods(["on","destroy","trigger"])};l.prototype.methods=function(e){t.each(e,function(e,t){this[t]=function(){this.execute(t,arguments)}.bind(this)}.bind(this))},l.prototype.execute=function(e,n){t.each(this.instances,function(t,r){r[e].apply(r,n)})},l.prototype.get=function(e){return this.instances[e]};var c=function(e,n,r){a.call(this),this.config=e,this.parser=n,this.spellCheckerElement=t(r),this.createBox(),this.bindEvents()};i(c,a);var h=function(e,t,n){c.apply(this,arguments)};i(h,c),h.prototype.bindEvents=function(){this.container.on("click","a",f.call(this,"select.word")),this.on("addWords",this.addWords.bind(this))},h.prototype.createBox=function(){this.container=t(['<div class="'+r+'-incorrectwords">',"</div>"].join("")).hide(),t.isFunction(this.config.incorrectWords.position)?this.config.incorrectWords.position.call(this.spellCheckerElement,this.container):this.container.appendTo(this.config.incorrectWords.container)},h.prototype.addWords=function(e){e=t.grep(e,function(n,r){return r===t.inArray(n,e)});var n=t.map(e,function(e){return'<a href="#">'+e+"</a>"}).join("");this.container.html(n).show()},h.prototype.removeWord=function(e){e&&e.remove(),this.container.children().length===0&&this.container.hide()},h.prototype.destroy=function(){this.container.empty().remove()};var p=function(e,n,r){a.call(this),this.config=e,this.parser=n,this.spellCheckerElement=this.element=t(r),this.bindEvents()};i(p,a),p.prototype.bindEvents=function(){this.element.on("click."+r,"."+r+"-word-highlight",f.call(this,"select.word"))},p.prototype.addWords=function(e){var t=this.parser.highlightWords(e,this.element);this.element.html(t)},p.prototype.removeWord=function(e){},p.prototype.destroy=function(){this.element.off("."+r);try{e.findAndReplaceDOMText.revert()}catch(t){}};var d=function(e,n){this.element=n,e.suggestBox.appendTo?this.body=t(e.suggestBox.appendTo):this.body=this.element.length&&this.element[0].nodeName==="BODY"?this.element:"body",this.position=t.isFunction(e.suggestBox.position)?e.suggestBox.position:this.position,c.apply(this,arguments)};i(d,c),d.prototype.bindEvents=function(){var e="click."+r;this.container.on(e,this.onContainerClick.bind(this)),this.container.on(e,".ignore-word",f.call(this,"ignore.word")),this.container.on(e,".ignore-all",this.handler("ignore.all")),this.container.on(e,".ignore-forever",this.handler("ignore.forever")),this.container.on(e,".words a",f.call(this,"select.word")),t("html").on(e,this.onWindowClick.bind(this)),this.element[0].nodeName==="BODY"&&this.element.parent().on(e,this.onWindowClick.bind(this))},d.prototype.createBox=function(){var e=this.config.local;this.container=t(['<div class="'+r+'-suggestbox">',' <div class="footer">','   <a href="#" class="ignore-word">'+e.ignoreWord+"</a>",'   <a href="#" class="ignore-all">'+e.ignoreAll+"</a>",'   <a href="#" class="ignore-forever">'+e.ignoreForever+"</a>"," </div>","</div>"].join("")).appendTo(this.body),this.words=t(['<div class="words">',"</div>"].join("")).prependTo(this.container),this.loadingMsg=t(['<div class="loading">',this.config.local.loading,"</div>"].join("")),this.footer=this.container.find(".footer").hide()},d.prototype.addWords=function(e){var n;e.length?n=t.map(e,function(e){return'<a href="#">'+e+"</a>"}).slice(0,this.config.suggestBox.numWords).join(""):n="<em>"+this.config.local.noSuggestions+"</em>",this.words.html(n)},d.prototype.showSuggestedWords=function(e,n,r){this.wordElement=t(r),e(n,this.onGetWords.bind(this))},d.prototype.loading=function(e){this.footer.hide(),this.words.html(e?this.loadingMsg.clone():""),this.position(),this.open()},d.prototype.position=function(){var n=t(e),r=this.wordElement.data("firstElement")||this.wordElement,i=r.offset(),s=this.config.suggestBox.offset,o=this.container.outerHeight(),u=i.top-o-s,a=i.top+r.outerHeight()+s,f=i.left,l;this.config.suggestBox.position==="below"?(l=a,n.height()+n.scrollTop()<a+o&&(l=u)):l=u,this.container.css({top:l,left:f})},d.prototype.open=function(){this.position(),this.container.fadeIn(180)},d.prototype.close=function(){this.container.fadeOut(100,function(){this.footer.hide()}.bind(this))},d.prototype.detach=function(){this.container=this.container.detach()},d.prototype.reattach=function(){this.container.appendTo(this.body)},d.prototype.onContainerClick=function(e){e.stopPropagation()},d.prototype.onWindowClick=function(e){this.close()},d.prototype.onGetWords=function(e){this.addWords(e),this.footer.show(),this.position(),this.open()},d.prototype.destroy=function(){this.container.empty().remove()};var v=function(e){this.config=e,this.defaultConfig={url:e.webservice.path,type:"POST",dataType:"json",cache:!1,data:{lang:e.lang,driver:e.webservice.driver},error:function(){alert(e.local.requestError)}.bind(this)}};v.prototype.makeRequest=function(e){var n=t.extend(!0,{},this.defaultConfig);return t.ajax(t.extend(!0,n,e))},v.prototype.checkWords=function(e,t){return this.makeRequest({data:{action:"get_incorrect_words",text:e},success:t})},v.prototype.getSuggestions=function(e,t){return this.makeRequest({data:{action:"get_suggestions",word:e},success:t})};var m=function(e){this.elements=e};m.prototype.clean=function(e){e=""+e,e=s(e),e=e.replace(/\xA0|\s+|(&nbsp;)/mg," "),e=e.replace(new RegExp("<[^>]+>","g"),"");var n=["(^|\\s+)["+o+"]+","["+o+"]+\\s+["+o+"]+","["+o+"]+(\\s+|$)"].join("|");return e=e.replace(new RegExp(n,"g")," "),e=t.trim(e.replace(/\s{2,}/g," ")),e=t.map(e.split(" "),function(e){return/^\d+$/.test(e)?null:e}).join(" "),e};var g=function(){m.apply(this,arguments)};i(g,m),g.prototype.getText=function(e,n){return t.map(this.elements,function(e){return this.clean(n?n(e):t(e).val())}.bind(this))},g.prototype.replaceWordInText=function(e,t,n){var r=new RegExp("(^|[^"+u+"])("+RegExp.escape(e)+")(?=[^"+u+"]|$)","g");return(n+"").replace(r,"$1"+t)},g.prototype.replaceWord=function(e,n,r){r=t(r);var i=this.replaceWordInText(e,n,r.val());r.val(i)};var y=function(){m.apply(this,arguments)};i(y,m),y.prototype.getText=function(e,n){return e&&(e=t(e)).length?this.clean(e.text()):t.map(this.elements,function(r){return n?e=n(r):e=t(r).clone().find('[class^="spellchecker-"]').remove().end().text(),this.clean(e)}.bind(this))},y.prototype.replaceText=function(t,n,r,i){e.findAndReplaceDOMText(t,n,r,i)},y.prototype.replaceWord=function(n,r,i){try{e.findAndReplaceDOMText.revert()}catch(s){}var o=new RegExp("(^|[^"+u+"])("+RegExp.escape(n)+")(?=[^"+u+"]|$)","g");this.replaceText(o,i[0],this.replaceTextHandler(n,r),2),this.incorrectWords=t.map(this.incorrectWords||[],function(e){return e===n?null:e}),this.highlightWords(this.incorrectWords,i)},y.prototype.replaceTextHandler=function(e,t){var n=t,r,i,s;return function(o,u){return u!==s&&(s=u,t=n,r=""),i=t.substring(0,o.length),t=t.substr(o.length),r+=o,r===e&&(i+=t),document.createTextNode(i)}},y.prototype.highlightWords=function(e,n){if(!e.length)return;this.incorrectWords=e,e=t.map(e,function(e){return RegExp.escape(e)});var r="";r+="([^"+u+"])",r+="("+e.join("|")+")",r+="(?=[^"+u+"])",this.replaceText(new RegExp(r,"g"),n[0],this.highlightWordsHandler(e),2)},y.prototype.highlightWordsHandler=function(e){var n,i;return function(e,s,o){var u=t("<span />",{"class":r+"-word-highlight"});return s!==n&&(n=s,i=u),u.text(e).data({firstElement:i,word:o}),u[0]}},y.prototype.ignoreWord=function(e,t){this.replaceWord(e,t)};var b=function(e,r){a.call(this),this.elements=t(e).attr("spellcheck","false"),this.config=t.extend(!0,n,r),this.setupWebService(),this.setupParser(),this.elements.length&&(this.setupSuggestBox(),this.setupIncorrectWords(),this.bindEvents())};i(b,a),b.prototype.setupWebService=function(){this.webservice=new v(this.config)},b.prototype.setupSuggestBox=function(){this.suggestBox=new d(this.config,this.elements),this.on("replace.word.before",function(){this.suggestBox.close(),this.suggestBox.detach()}.bind(this)),this.on("replace.word",function(){this.suggestBox.reattach()}.bind(this)),this.on("destroy",function(){this.suggestBox.destroy()}.bind(this))},b.prototype.setupIncorrectWords=function(){this.incorrectWords=new l(this.elements,function(e){return this.config.parser==="html"?new p(this.config,this.parser,e):new h(this.config,this.parser,e)}.bind(this)),this.on("replace.word",function(e){this.incorrectWords.get(e).removeWord(this.incorrectWordElement)}.bind(this)),this.on("destroy",function(){this.incorrectWords.destroy()},this)},b.prototype.setupParser=function(){this.parser=this.config.parser==="html"?new y(this.elements):new g(this.elements)},b.prototype.bindEvents=function(){this.on("check.fail",this.onCheckFail.bind(this)),this.suggestBox.on("ignore.word",this.onIgnoreWord.bind(this)),this.suggestBox.on("select.word",this.onSelectWord.bind(this)),this.incorrectWords.on("select.word",this.onIncorrectWordSelect.bind(this))},b.prototype.check=function(e,t){this.trigger("check.start"),e=typeof e=="string"?this.parser.clean(e):this.parser.getText(e||"",this.config.getText),this.webservice.checkWords(e,this.onCheckWords(t))},b.prototype.getSuggestions=function(e,t){this.suggestBox&&this.suggestBox.loading(!0),this.webservice.getSuggestions(e,t)},b.prototype.replaceWord=function(e,t,n){if(typeof n=="string")return this.parser.replaceWordInText(e,t,n);var r=n||this.spellCheckerElement,i=this.elements.index(r);this.trigger("replace.word.before"),this.parser.replaceWord(e,t,r),this.trigger("replace.word",i)},b.prototype.destroy=function(){this.trigger("destroy")},b.prototype.onCheckWords=function(e){return function(n){var r=n.data,i="success";t.each(r,function(e,t){if(t.length)return i="fail",!1}),this.trigger("check.complete"),this.trigger("check."+i,r),this.trigger(e,r)}.bind(this)},b.prototype.onCheckFail=function(e){this.suggestBox.detach(),t.each(e,function(e,n){n.length&&(n=t.grep(n,function(e,r){return r===t.inArray(e,n)}),this.incorrectWords.get(e).addWords(n))}.bind(this)),this.suggestBox.reattach()},b.prototype.onSelectWord=function(e,t,n){e.preventDefault(),this.replaceWord(this.incorrectWord,t)},b.prototype.onIgnoreWord=function(e,t,n){e.preventDefault(),this.replaceWord(this.incorrectWord,this.incorrectWord)},b.prototype.onIncorrectWordSelect=function(e,t,n,r){e.preventDefault(),this.incorrectWord=t,this.incorrectWordElement=n,this.spellCheckerElement=r.spellCheckerElement,this.spellCheckerIndex=this.elements.index(this.spellCheckerElement),this.suggestBox.showSuggestedWords(this.getSuggestions.bind(this),t,n),this.trigger("select.word",e)},t.SpellChecker=b})(this,jQuery),window.findAndReplaceDOMText=function(){function e(e,i,o,u){var a,f=[],l=n(i),c=s(o);if(!l)return;if(e.global)while(!!(a=e.exec(l)))f.push(t(a,u));else a=l.match(e),f.push(t(a,u));f.length&&r(i,f,c)}function t(e,t){t=t||0;if(!e[0])throw"findAndReplaceDOMText cannot handle zero-length matches";var n=e.index;if(t>0){var r=e[t];if(!r)throw"Invalid capture group";n+=e[0].indexOf(r),e[0]=r}return[n,n+e[0].length,[e[0]]]}function n(e){if(e.nodeType===3)return e.data;var t="";if(!!(e=e.firstChild))do t+=n(e);while(!!(e=e.nextSibling));return t}function r(e,t,n){var r,i,s,o,u,a,f=[],l=0,c=e,h=t.shift(),p=0;e:for(;;){c.nodeType===3&&(!o&&c.length+l>=h[1]?(o=c,a=h[1]-l):s&&f.push(c),!s&&c.length+l>h[0]&&(s=c,u=h[0]-l),l+=c.length);if(s&&o){c=n({startNode:s,startNodeIndex:u,endNode:o,endNodeIndex:a,innerNodes:f,match:h[2],matchIndex:p}),l-=o.length-a,s=null,o=null,f=[],h=t.shift(),p++;if(!h)break}else if(c.firstChild||c.nextSibling){c=c.firstChild||c.nextSibling;continue}for(;;){if(c.nextSibling){c=c.nextSibling;break}if(c.parentNode===e)break e;c=c.parentNode}}}function s(e){i=[];var t;if(typeof e!="function"){var n=e.nodeType?e:document.createElement(e);t=function(e){var t=document.createElement("div"),r;return t.innerHTML=n.outerHTML||(new window.XMLSerializer).serializeToString(n),r=t.firstChild,e&&r.appendChild(document.createTextNode(e)),r}}else t=e;return function(n){var r=n.startNode,s=n.endNode,o=n.matchIndex,u,a;if(r===s){var f=r;n.startNodeIndex>0&&(u=document.createTextNode(f.data.substring(0,n.startNodeIndex)),f.parentNode.insertBefore(u,f));var l=t(n.match[0],o,n.match[0]);return f.parentNode.insertBefore(l,f),n.endNodeIndex<f.length&&(a=document.createTextNode(f.data.substring(n.endNodeIndex)),f.parentNode.insertBefore(a,f)),f.parentNode.removeChild(f),i.push(function(){var e=l.parentNode;e.insertBefore(l.firstChild,l),e.removeChild(l),e.normalize()}),l}u=document.createTextNode(r.data.substring(0,n.startNodeIndex)),a=document.createTextNode(s.data.substring(n.endNodeIndex));var c=t(r.data.substring(n.startNodeIndex),o,n.match[0]),h=[];for(var p=0,d=n.innerNodes.length;p<d;++p){var v=n.innerNodes[p],m=t(v.data,o,n.match[0]);v.parentNode.replaceChild(m,v),h.push(m)}var g=t(s.data.substring(0,n.endNodeIndex),o,n.match[0]);return r.parentNode.insertBefore(u,r),r.parentNode.insertBefore(c,r),r.parentNode.removeChild(r),s.parentNode.insertBefore(g,s),s.parentNode.insertBefore(a,s),s.parentNode.removeChild(s),i.push(function(){h.unshift(c),h.push(g);for(var e=0,t=h.length;e<t;++e){var n=h[e],r=n.parentNode;r.insertBefore(n.firstChild,n),r.removeChild(n),r.normalize()}}),g}}var i;return e.revert=function(){for(var t=0,n=i.length;t<n;++t)i[t]();i=[]},e}();

(function () {
    'use strict';

    CKEDITOR.plugins.add('jquerySpellChecker', {
        lang: ['en', 'ru', 'uk'],
        config: {
            lang: ADMIN_LANG,
            parser: 'html',
            webservice: {
                path: '/admin/spellchecker',
                driver: 'PSpell'
            },
            suggestBox: {
                position: 'below',
                appendTo: 'body'
            }
        },

        init: function( editor ) {
            editor.addContentsCss(this.path + 'styles/jquery.spellchecker.min.css');

            this.config.local = {
                loading: editor.lang.jquerySpellChecker.loading,
                ignoreWord: editor.lang.jquerySpellChecker.ignoreWord,
                noSuggestions: editor.lang.jquerySpellChecker.noSuggestions
            };

            var t = this;
            var pluginName = 'jquerySpellChecker';
            this.config.suggestBox.position = this.positionSuggestBox();

            editor.addCommand(pluginName, {
                canUndo: false,
                readOnly: 1,
                exec: function() {
                    t.toggle(editor);
                }
            });

            editor.ui.addButton('JquerySpellChecker', {
                label: editor.lang.jquerySpellChecker.label,
                icon: 'spellchecker',
                command: pluginName,
                toolbar: 'spellchecker,10'
            });



            editor.on('saveSnapshot', function() {
                t.destroy();
            });
        },

        create: function() {

            this.editor.setReadOnly(true);
            this.editor.commands.jquerySpellChecker.toggleState();
            this.editorWindow = this.editor.document.getWindow().$;

            this.createSpellchecker();
            this.spellchecker.check();

            $(this.editorWindow)
                .on('scroll.spellchecker', $.proxy(function scroll(){
                    if (this.spellchecker.suggestBox) {
                        this.spellchecker.suggestBox.close();
                    }
                }, this));
        },

        destroy: function() {
            if (!this.spellchecker)
                return;
            this.spellchecker.destroy();
            this.spellchecker = null;
            this.editor.setReadOnly(false);
            this.editor.commands.jquerySpellChecker.toggleState();
            $(this.editorWindow).off('.spellchecker');
        },

        toggle: function(editor) {
            this.editor = editor;
            if (!this.spellchecker) {
                this.create();
            } else {
                this.destroy();
            }
        },

        createSpellchecker: function() {
            var t = this;

            t.config.getText = function() {
                return $('<div />').append(t.editor.getData()).text();
            };
            t.spellchecker = new $.SpellChecker(t.editor.document.$.body, this.config);

            t.spellchecker.on('check.success', function() {
                alert(t.editor.lang.jquerySpellChecker.success);
                t.destroy();
            });
            t.spellchecker.on('replace.word', function() {
                if (t.spellchecker.parser.incorrectWords.length === 0) {
                    t.destroy();
                }
            });
        },

        positionSuggestBox: function() {

            var t = this;

            return function() {

                var ed = t.editor;
                var word = (this.wordElement.data('firstElement') || this.wordElement)[0];

                var p1 = $(ed.container.$).find('iframe').offset();
                var p2 = $(ed.container.$).offset();
                var p3 = $(word).offset();

                var left = p3.left + p2.left;
                var top = p3.top + p2.top + (p1.top - p2.top) + word.offsetHeight;

                top -= $(t.editorWindow).scrollTop();

                this.container.css({
                    top: top,
                    left: left
                });
            };
        }
    });

}());
