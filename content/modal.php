<div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h6 class="modal-title" id="myModalLabel">
                    Medium Modal
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <form action="" id="foo"> -->
                <!-- <div id="custommessage"></div> -->
                <div class="modal-body col-12" id="modal-body"></div>
            <!-- </form> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="bs-image-viwer-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-image-viwer-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h6 class="modal-title" id="myModalLabel">
                    Image Viewer
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <form action="" id="foo"> -->
                <!-- <div id="custommessage"></div> -->
                <div class="modal-body col-12"><img src="" style="object-fit: contain; width: 100%" id="imageviewer" alt="loading..."></div>
            <!-- </form> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    function modalcontent(id) {
        var value = document.getElementById(id);
        document.getElementById("modal-body").innerHTML = "Getting data...";
        title = value.dataset.title;
        link = value.dataset.url;
        title += ' | <span class="btn btn-tool fs-3 text-primary" id="' + id + '" data-url="' + link + '" data-id="' + id + '" data-title="' + title + '" onclick="modalcontent(\'' + id + '\')"> <li class="nav-icon fas fa-sync"></li> Reload</span>';
        id = value.dataset.id;
        modaltitle = document.getElementById('myModalLabel').innerHTML = title;
        $.ajax({
            type: 'GET',
            url: link,
            data: {},
            success: function(response) {
                // confirm(response);
                document.getElementById("modal-body").innerHTML = response;
            }
        });
        // document.getElementById("modal-body").innerHTML='<object type="text/html" data="'+link+'" style="width: 100%!important; overflow: auto!important; height: 60vh;"></object>';

    }
</script>