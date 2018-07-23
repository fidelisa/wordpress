var urlParams = window.location.search;

if (urlParams.includes("fdmob")) {
    sessionStorage.setItem("fdmob", "true")
}

if (urlParams.includes("delfdmob")) {
    sessionStorage.removeItem("fdmob");
}

var hideHeader = sessionStorage.getItem("fdmob");

if (hideHeader == "true") {

    var classesHide = '.site-header, .site-footer';

    if (opts_fdls && opts_fdls.hideclass) {
        classesHide = opts_fdls.hideclass
    }

    var 
        css = classesHide + ' { display: none !important; }',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');

    style.type = 'text/css';
    if (style.styleSheet) {
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
}


window.parent.postMessage("href:"+window.location.href, '*');

window.addEventListener("message", function(e) {
    if (e.data === "go:back") {
    	window.history.back();
    }
});
