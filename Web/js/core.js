// Change Style & State & Text of Button
$(function(){
    $.fn.extend({          
        changeButton:function(style, disabled, text) {            
            let style_text = ["", "btn-primary", "btn-success", "btn-warning", "btn-danger"];
            $(this).html(text);
            for (let i=1; i<5; i++) if ($(this).hasClass(style_text[i])) $(this).removeClass(style_text[i]);
            if (style>0) $(this).addClass(style_text[style]);
            if (disabled) $(this).attr("disabled", true); else $(this).removeAttr("disabled");  
        }       
    }); 
});

// Textarea Auto Height
$(function(){
    $.fn.autoHeight = function(){    
        function autoHeight(elem){
            elem.style.height = 'auto';
            elem.scrollTop = 0;
            elem.style.height = (elem.scrollHeight + 5)  + 'px';
        }
        this.each(function(){
            autoHeight(this);
            $(this).on('keyup', function(){
                autoHeight(this);
            });
        });    
    }
});

// Get Preview From Data
function previousData(){
    let xDOM = document.getElementsByName("DATA-FROM");
    let temp = document.createElement("form"); 
    for (let i = 0; i < xDOM.length; i++) {
        if (xDOM[i].id == "page") continue;
        var opt = document.createElement("textarea"); 
        opt.name = xDOM[i].id; 
        opt.value = xDOM[i].value;
        temp.appendChild(opt); 
    }
    return temp;
}

// Redirect to built-in pages
function redirect(URL, PARAMS) {
    var temp = previousData(); 
    temp.action = URL; 
    temp.method = "post"; 
    temp.style.display = "none"; 
    for (var x in PARAMS) { 
        var opt = document.createElement("textarea"); 
        opt.name = x; 
        opt.value = PARAMS[x];
        temp.appendChild(opt); 
    } 
    document.body.appendChild(temp); 
    temp.submit(); return temp; 
}

// Open New Tab for URL
function newdirect(URL, PARAMS){
    var temp = previousData(); 
    temp.action = URL; 
    temp.target = "_blank";
    temp.method = "post"; 
    temp.style.display = "none"; 
    for (var x in PARAMS) { 
        var opt = document.createElement("textarea"); 
        opt.name = x; 
        opt.value = PARAMS[x];
        temp.appendChild(opt); 
    } 
    document.body.appendChild(temp); 
    temp.submit(); return temp; 
}

// Get Documents Root
function getRoot(){
    var webName = "";
    if (webName == "") {
        return window.location.protocol + '//' + window.location.host;
    }
    else {
        return window.location.protocol + '//' + window.location.host + '/' + webName;
    }
}