<!DOCTYPE html>
<html lang="zh-CN">
    <?php include("./libs/config.php")?>
    <?php include("./pages/header.php")?>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo"><b>Canvas</b></div>
            <div class="card">
                <div class="card-body login-card-body">
                <p class="login-box-msg" id="msg">Welcome to canvas~</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="ID" id="id">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" id="pwd">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                       
                    </div>
                    <div class="col-4"><button type="submit" class="btn btn-primary btn-block btn-flat" id="login">Sign In</button></div>
                </div>
            </div>
        </div>
        <script src="./js/MD5.js"></script>
        <script type="text/javascript">
            $("#login").click(function(){
                $("#login").changeButton(3, true, "Waiting~");
                $.post(
                    "./libs/login.php", 
                    {
                        "id": $("#id").val(), 
                        "pwd": hex_md5($("#pwd").val()), 
                        "rem": $("#rem").val() 
                    }, 
                    function(json, status){
                        if (json.status == 0){
                            $("#login").changeButton(2, true, "Success");
                            redirect(getRoot() + "/",  {"page": "Dashboard"});
                        }else{
                            $("#msg").html(json.msg);
                            $("#login").changeButton(1, false, "Login");
                        }
                    }
                );
            });
        </script>
    </body>
</html>