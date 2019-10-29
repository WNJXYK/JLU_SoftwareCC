function user_profile(id, func){
    $.get(
        getRoot() + "/libs/user.php", 
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}


$(function(){
    // Replace Text
    $(".ctext-username").html($.cookie("User_Nick"));
    $(".ctext-usertype").html($.cookie("User_Type"));
    
    // Logout Function
    $("#user-logout").click(function(){ 
        $.removeCookie('User_Token', {"path" : getPath() + "/"}); 
        redirect(getRoot() + "/", {});
    });

    // Logout Function
    $("#user-inbox").click(function(){ 
        redirect(getRoot() + "/", {"page": "Inbox"}); 
    });

    // Logout Function
    $("#user-file").click(function(){ 
        newdirect(getRoot() + "/", {"page": "File"}); 
    });
});
