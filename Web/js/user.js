function user_profile(id, func){
    $.get(
        "/libs/user.php", 
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
        $.cookie('User_Token', null); 
        redirect("/", {});
    });

    // Logout Function
    $("#user-inbox").click(function(){ 
        redirect("/", {"page": "Inbox"}); 
    });
});
