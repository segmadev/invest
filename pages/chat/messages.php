<style>
    @media only screen and (max-width: 600px) {
        header {
            display: none !important;
        }

        .container-fluid,
        .chat-background {
            padding: 0 !important;
            /* padding-left: 30px;  */
        }

        .chat-background {
            padding: 20px !important;
        }

        .chat-background {
            height: calc(100vh - 220px) !important;
        }

        .chat-container {
            margin-left: 10px !important;
        }
    }
</style>
<script>
    document.getElementById("main-wrapper").setAttribute("data-sidebar-position", "");
</script>
<?php $script[] = "modal"; ?>
<div class="w-100 w-xs-100 chat-container">
    <div class="chat-box-inner-part h-100">
        <div class="chat-not-selected h-100 d-none">
            <div class="d-flex align-items-center justify-content-center h-100 p-5">
                <div class="text-center">
                    <span class="text-primary">
                        <i class="ti ti-message-dots fs-10"></i>
                    </span>
                    <h6 class="mt-2">Open chat from the list</h6>
                </div>
            </div>
        </div>
        <div class="chatting-box d-block">
            <div class="p-3 border-bottom chat-meta-user d-flex align-items-center justify-content-between">
                <div class="hstack gap-3 current-chat-user-name">
                    <div class="position-relative">
                        <!-- <p>my name</p> -->

                        <!-- <button onclick="loadnotification()" class="btn mb-1 btn-light-info text-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
              <div class="icon bg-primary rounded-circle"></div>
              <i class="ti ti-bell-ringing"></i> <span class="text-danger fw-semibold"><b id="note-no">12</b></span>
            </a>
          </button> -->


                        <a type="button" class='text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative sidebartoggler d-xl-none' type="button"><i class='ti ti-menu-2'></i></a>
                        <a id="show_chat_list" type="button" class='text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative d-xl-none' type="button" data-bs-toggle="offcanvas" data-bs-target="#example2" aria-controls="example2"><i class='ti ti-messages'></i> <span id="message-no" class="text-danger" style="font-size: 10px"></span></a>
                        <img id="imag-profile-icon" data-url="" data-title="Image Viewer" data-bs-toggle="modal" data-bs-target="#bs-image-viwer-modal-md" onclick="imageviwer('<?= $u->get_profile_icon_link($uID, $what); ?>')" src="<?= $u->get_profile_icon_link($uID, $what); ?>" alt="user1" width="30" height="30" class="rounded-circle" />
                        <!-- <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                            <span class="visually-hidden">New alerts</span>
                        </span> -->
                    </div>
                    <a class="" <?php if ($chat['is_group'] ==  "yes") { ?> href='#' <?php } else { ?> href='#' id="profile-name-image" data-url="" data-title="Image Viewer" data-bs-toggle="modal" data-bs-target="#bs-image-viwer-modal-md" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" onclick="imageviwer('<?= $u->get_profile_icon_link($uID, $what); ?>')" <?php } ?>>
                        <h6 class="mb-1 name fw-semibold fs-3"><?= $d->short_text($u->get_name($uID, $what), 15) ?></h6>
                        <p class="mb-0" id="last_seen" style="font-size: 10px!important"><i>loading...</i></p>
                    </a>
                </div>
                <ul class="list-unstyled mb-0 d-flex align-items-center">
                    <!-- <li><a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 "
                            href="javascript:void(0)"><i class="ti ti-phone"></i></a></li>
                    <li><a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 "
                            href="javascript:void(0)"><i class="ti ti-video"></i></a></li>
                    <li> -->
                    <!-- <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)" type="button" data-bs-toggle="offcanvas" data-bs-target="#app-chat-offcanvas" aria-controls="offcanvasScrolling">
                            <i class="ti ti-menu-2"></i>
                        </a> -->
                    <?php if ($chat['is_group'] ==  "yes") { ?>
                        <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                            <i class="ti ti-users"></i>
                        </a>
                    <?php } ?>
                    </li>
                </ul>
            </div>
            <div class="position-relative overflow-hidden d-flex">
                <div class="position-relative d-flex flex-grow-1 flex-column">
                    <div class="chat-box p-9 chat-background" data-simplebar>
                        <div class="chat-list chat active-chat" data-user-id="1">
                            <input type="hidden" id="chatID" value="<?= $chatID ?>">
                            <div id="chatold"></div>
                            <div id="loadining" style="display: none">
                                <center><button class='btn btn-sm btn-primary opacity-0.5'>Loading</button>
                                    <center />
                            </div>
                            <div id="chatnew">
                                <?php
                                if (isset($messages) && $messages->rowCount()  > 0) {
                                    foreach ($messages as $row) {
                                        echo $ch->display_message($row, $userID);
                                    }
                                } else {
                                    echo "<div data-chat-id='0'>" . $c->empty_page("No chat here yet", icon: "<i class='ti ti-messages text-primary fs-10'></i>") . "</div>";
                                }
                                ?>
                            </div>

                        </div>
                        <!-- 2 -->

                    </div>
                    <div class="chat-send-message-footer p-0 p-2">
                        <form action="chat-passer" id="chatForm" onsubmit="return void(0);">
                            <div id="image-preview-upload"></div>
                            <div class="d-flex bg-light" id="reply_div" style="display: none!important">
                                <div class="p-2 d-inline-block text-dark fs-3 col-11" id="reply_message"></div>
                                <div class="w-100 justify-content-center align-items-center d-flex"><button class='btn' type='button' onclick='cancel_reply()'><i class="ti ti-x fs-5 text-danger"></i></button></div>
                            </div>
                            <div id="custommessage"></div>
                            <?php
                            unset($message_form['video']);
                            unset($message_form['message']);
                            unset($message_form['upload']);
                            echo  $c->create_form($message_form);
                            ?>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 w-85">
                                    <!-- <a class="position-relative nav-icon-hover z-index-5" href="javascript:void(0)"> <i class="ti ti-mood-smile text-dark bg-hover-primary fs-7"></i></a> -->
                                    <input onchange="showPreview(event, 'image-preview-upload')" name="upload" value="" id="upload" type="file" class="form-control upload d-none" placeholder="Enter Upload">

                                    <input type="hidden" name="send_message" value="">
                                    <input type="hidden" name="page" value="chat">
                                    <input name="message" type="text" class="form-control message-type-box text-muted border-0 p-0 ms-2" placeholder="Type a Message" id="message-input-box" required/>

                                </div>
                                <ul class="list-unstyledn mb-0 d-flex align-items-center">
                                    <div class="btn-group dropup">
                                        <li type="button" class="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)"><i class="ti ti-paperclip"></i></a>
                                        </li>
                                        <div class="dropdown-menu">
                                            <!-- Dropdown menu links -->
                                            <!-- <li></li> -->
                                            <!-- <li><label for="" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relativ"><i class="ti ti-video"></i> Video</label></li> -->

                                            <a class="dropdown-item fs-3" href="#"><label for="upload" class=""><i class="ti ti-photo-plus"></i> Image</label></a>
                                            <button type="button" class="dropdown-item fs-3" id="pick" href="#"><i class="ti ti-video"></i> Video</button>
                                            <!-- <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a> -->
                                        </div>
                                    </div>

                                    <!-- <li id="sharemenu"><a data-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="loading..." class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)"><i class="ti ti-photo-plus"></i></a></li> -->
                                    <!-- <li><label for="upload" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)"><i class="ti ti-photo-plus"></i></label></li> -->
                                    <li><button type="submit" id="sendmessage" class="btn border-0 text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 active" href="javascript:void(0)"><i class="ti ti-send"></i></button></li>
                                    <?php if ($d->validate_admin()) { ?>
                                        <li><a id="moremessage" data-url="modal?p=chat&action=new&id=<?= htmlspecialchars($_GET['id']); ?>" data-title="More message options" onclick="modalcontent(this.id)" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)"><i class="ti ti-dots"></i></a></li>
                                    <?php } ?>

                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="app-chat-offcanvas border-start app-chat-right chat-media-list" data-simplebar="" id="app-chat-right">
                    <!-- <div class="p-3 d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold mb-0">Media <span class="text-muted">(<?php // media here  
                                                                                        ?>)</span></h6>
                        <a class="chat-menu d-lg-none d-block text-dark fs-6 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                            <i class="ti ti-x"></i>
                        </a>
                    </div> -->


                    <div class="offcanvas-body p-9">
                        <!-- <div class="media-chat mb-7">
                            <div class="row">
                                <div class="col-4 px-1">
                                    <div class="rounded-1 overflow-hidden mb-2"><img src="dist/images/products/product-1.jpg" alt="" class="w-100"></div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="rounded-1 overflow-hidden mb-2"><img src="dist/images/products/product-2.jpg" alt="" class="w-100"></div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="rounded-1 overflow-hidden mb-2"><img src="dist/images/products/product-3.jpg" alt="" class="w-100"></div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="rounded-1 overflow-hidden mb-2"><img src="dist/images/products/product-4.jpg" alt="" class="w-100"></div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="rounded-1 overflow-hidden mb-2"><img src="dist/images/products/product-1.jpg" alt="" class="w-100"></div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="rounded-1 overflow-hidden mb-2"><img src="dist/images/products/product-2.jpg" alt="" class="w-100"></div>
                                </div>
                            </div>
                        </div> -->
                        <?php if ($chat['is_group'] == "yes") { ?>
                            <div class="files-chat">
                                <h6 class="fw-semibold mb-3">Users
                                    <!-- <span class="text-muted">(<?= $ch->no_users_in_group($uID) ?>)</span> -->
                                </h6>


                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-start user-chat-box chat-offcanvas" tabindex="-1" id="chat-sidebar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel"> Chats </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="px-4 pt-9 pb-6">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center">
                <div class="position-relative">
                    <img src="dist/images/profile/user-1.jpg" alt="user1" width="54" height="54" class="rounded-circle">
                    <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </div>
                <div class="ms-3">
                    <h6 class="fw-semibold mb-2">Mathew Anderson</h6>
                    <p class="mb-0 fs-2">Marketing Director</p>
                </div>
            </div>
            <div class="dropdown">
                <a class="text-dark fs-6 nav-icon-hover " href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti ti-dots-vertical"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item d-flex align-items-center gap-2 border-bottom" href="javascript:void(0)"><span><i class="ti ti-settings fs-4"></i></span>Setting</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)"><span><i class="ti ti-help fs-4"></i></span>Help and feadback</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)"><span><i class="ti ti-layout-board-split fs-4"></i></span>Enable split View mode</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 border-bottom" href="javascript:void(0)"><span><i class="ti ti-table-shortcut fs-4"></i></span>Keyboard
                            shortcut</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)"><span><i class="ti ti-login fs-4"></i></span>Sign Out</a></li>
                </ul>
            </div>
        </div>
        <form class="position-relative mb-4">
            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search User">
            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
        </form>
        <!-- <div class="dropdown">
            <a class="text-muted fw-semibold d-flex align-items-center" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Recent Chats<i class="ti ti-chevron-down ms-1 fs-5"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="javascript:void(0)">Sort by time</a></li>
                <li><a class="dropdown-item border-bottom" href="javascript:void(0)">Sort by Unread</a></li>
                <li><a class="dropdown-item" href="javascript:void(0)">Hide favourites</a></li>
            </ul>
        </div> -->
    </div>
    <div class="app-chat">

        <ul class="chat-users" style="height: calc(100vh - 200px)" data-simplebar>
        </ul>
    </div>
</div>

<div id="chat-users-holder" style="display: none"></div>

<div id="share-menu-holder" class="d-none">
    <li><label for="upload" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative"><i class="ti ti-photo-plus"></i> Image</label></li>
    <li><label for="" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relativ"><i class="ti ti-video"></i> Video</label></li>
</div>

<script>
    var sharemenu = document.getElementById("sharemenu");
    var shareMenuHolder = document.getElementById("share-menu-holder");
    sharemenu.addEventListener("click", function(e) {
        var popBody = document.getElementsByClassName("popover-body");
        if (popBody) {
            console.log(popBody);
            // popBody.innerHTML = shareMenuHolder.innerHTML;
        }
    });
</script>