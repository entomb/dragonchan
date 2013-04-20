/**
 * This is the bookmarklet that should open an iframe on 4chan
 *
 * I don't usualy code JS so help me god.
 *
 */


(function(){

    var s = window.location.toString().split('http://boards.4chan.org/b/res/')
    if(s.length!=2){
        alert("this is not a valid 4chan thread.");
        return;
    }

    if(document.getElementById('dragonraid')){
        return;
    }

    var THREAD_ID = s[1].split('#')[0];

    var div = document.createElement("DIV");
        div.id = "dragonraid"
        div.style.padding = "0px;";
        div.style.margin = "0px;";
        div.style.position = "fixed";
        div.style.top = "0px";
        div.style.left = "0px";
        div.style.width = "100%";
        div.style.height = "100px";
        div.style.zIndex = "1";
        div.style.overflow = "hidden";

        var iframe = document.createElement("IFRAME");
            iframe.src = "http://dragonslayer.eu01.aws.af.cm/"+THREAD_ID+"/status";
            iframe.style.width = "110%";
            iframe.style.height = "200px";
            iframe.style.border = "none;";
        div.appendChild(iframe);

    var style = document.createElement('style'); 
        style.innerHTML = '.fitToScreen{margin-top:100px;}'; 
    document.body.appendChild(style);
    document.body.appendChild(div);
    document.body.style.paddingTop="100px";
    document.getElementById('quickReply').style.zIndex = 1001;

})();

