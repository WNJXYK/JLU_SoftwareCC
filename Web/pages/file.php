<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Files</h1>
    </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr><th>ID</th><th>Name</th><th>Size(KB)</th><th>URL</th></tr>
                        </thead>
                        <tbody id="file-content">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <form role="form" action="./libs/file.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="File">File Upload</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="file" /> 
                                    <label class="custom-file-label" for="File">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text" id="upload">Upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

        
    </section>
</div>

<script type="text/javascript">
    function update(){
        $.get(
            "./libs/file.php",
            {},
            function(json, status){
                let list = json.data;
                $("#file-content").html("");
                for (let i = 0; i < list.length; ++i){
                    $("#file-content").append($('<tr><td>' + list[i].id + '</td><td>' + list[i].name + '</td><td>' + list[i].size + '</td><td>' + list[i].path + '</td><td><a href="#" onclick="deleteFile(' + list[i].id + ')">Delete</a></td></tr>'));
                }
            }
        );
    }
    $(function(){
        update();
    });

    function deleteFile(x){
        $.post(
            "./libs/file.php",
            {"id": x},
            function(json, status){
                if (json.status == 0){
                    update();
                    toastr.success("Deleted");
                }else toastr.error(json.msg);
            }
        );
    }

    $('form').submit(function (event) {
        event.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                json = JSON.parse(data);
                if (json.status == 0){
                    update();
                    toastr.success("Uploaded");
                }else toastr.error(json.msg);
            }
        });
    });

</script>