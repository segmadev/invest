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
            <div class="p-9 border-bottom chat-meta-user d-flex align-items-center justify-content-between">
                <div class="hstack gap-3 current-chat-user-name">
                    <div class="position-relative">
                        <!-- <p>my name</p> -->
                        <button id="show_chat_list" class='fs-6 btn badge rounded-pill bg-primary d-md-none d-sm-block'><i class='ti ti-arrow-narrow-left'></i></button>
                        <img src="<?= $u->get_profile_icon_link($uID, $what); ?>" alt="user1" width="48" height="48" class="rounded-circle" />
                        <!-- <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                            <span class="visually-hidden">New alerts</span>
                        </span> -->
                    </div>
                    <div class="">
                        <h6 class="mb-1 name fw-semibold"><?= $u->get_name($uID, $what) ?></h6>
                        <p class="mb-0" id="last_seen"><i class='fs-3'>loading...</i></p>
                    </div>
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
                    <a class="chat-menu text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                    </li>
                </ul>
            </div>
            <div class="position-relative overflow-hidden d-flex">
                <div class="position-relative d-flex flex-grow-1 flex-column">
                    <div class="chat-box p-9" data-simplebar>
                        <div class="chat-list chat active-chat" data-user-id="1">
                        <input type="hidden" id="chatID" value="<?= $chatID ?>">  
                        <div id="chatold"></div>
                            <div id="chatnew">
                                <?php
                                if (isset($messages) && $messages->rowCount()  > 0) {
                                    foreach ($messages as $row) {
                                        $ch->display_message($row, $userID);
                                    }
                                } else {
                                    echo $c->empty_page("No chat here yet", icon: "<i class='ti ti-messages text-primary fs-10'></i>");
                                }
                                ?>
                            </div>

                        </div>
                        <!-- 2 -->

                    </div>
                    <div class="px-9 py-6 border-top chat-send-message-footer">
                        <form action="" id="foo">
                            <div id="image-preview-upload"></div>
                            <div id="custommessage"></div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 w-85">
                                    <a class="position-relative nav-icon-hover z-index-5" href="javascript:void(0)"> <i class="ti ti-mood-smile text-dark bg-hover-primary fs-7"></i></a>
                                    <input onchange="showPreview(event, 'image-preview-upload')" name="upload" value="" id="upload" type="file" class="form-control upload d-none" placeholder="Enter Upload">
                                    <?php
                                    unset($message_form['message']);
                                    unset($message_form['upload']);

                                    echo  $c->create_form($message_form);
                                    ?>
                                    <input type="hidden" name="send_message" value="">
                                    <input type="hidden" name="page" value="chat">
                                    <input name="message" type="text" class="form-control message-type-box text-muted border-0 p-0 ms-2" placeholder="Type a Message" id="message-input-box" />

                                </div>
                                <ul class="list-unstyledn mb-0 d-flex align-items-center">
                                    <li><label for="upload" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)"><i class="ti ti-photo-plus"></i></label>
                                    </li>
                                    <!-- <li><a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 " href="javascript:void(0)"><i class="ti ti-paperclip"></i></a></li> -->
                                    <li><button type="submit" class="btn border-0 text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 active" href="javascript:void(0)"><i class="ti ti-send"></i></button></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="app-chat-offcanvas border-start app-chat-right chat-media-list" data-simplebar="">
                    <!-- <div class="p-3 d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold mb-0">Media <span class="text-muted">(<?php // media here  ?>)</span></h6>
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
                        <?php if($chat['is_group'] == "yes"){ ?>
                        <div class="files-chat">
                            <h6 class="fw-semibold mb-3">Users <span class="text-muted">(<?= $ch->no_users_in_group($uID) ?>)</span></h6>
                            <div id="grouplist"></div>
                           
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
            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Contact">
            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
        </form>
        <div class="dropdown">
            <a class="text-muted fw-semibold d-flex align-items-center" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Recent Chats<i class="ti ti-chevron-down ms-1 fs-5"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="javascript:void(0)">Sort by time</a></li>
                <li><a class="dropdown-item border-bottom" href="javascript:void(0)">Sort by Unread</a></li>
                <li><a class="dropdown-item" href="javascript:void(0)">Hide favourites</a></li>
            </ul>
        </div>
    </div>
    <div class="app-chat">
        <ul class="chat-users" style="height: calc(100vh - 200px)" data-simplebar>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user bg-light" id="chat_user_1" data-user-id="1">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-1.jpg" alt="user1" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Michell Flintoff</h6>
                            <span class="fs-3 text-truncate text-body-color d-block">You: Yesterdy was great...</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">15 mins</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_2" data-user-id="2">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-2.jpg" alt="user-2" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-danger">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Bianca Anderson</h6>
                            <span class="fs-3 text-truncate text-dark fw-semibold d-block">Nice looking dress
                                you...</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">30 mins</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_3" data-user-id="3">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-8.jpg" alt="user-8" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-warning">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Andrew Johnson</h6>
                            <span class="fs-3 text-truncate text-body-color d-block">Sent a photo</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">2 hrs</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_4" data-user-id="4">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-4.jpg" alt="user-4" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Mark Strokes</h6>
                            <span class="fs-3 text-truncate text-body-color d-block">Lorem ispusm text sud...</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">5 days</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_5" data-user-id="5">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-1.jpg" alt="user1" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Mark, Stoinus &
                                Rishvi..</h6>
                            <span class="fs-3 text-truncate text-dark fw-semibold d-block">Lorem ispusm text ...</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">5 days</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_2" data-user-id="2">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-2.jpg" alt="user-2" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-danger">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Bianca Anderson</h6>
                            <span class="fs-3 text-truncate text-dark fw-semibold d-block">Nice looking dress
                                you...</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">30 mins</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_3" data-user-id="3">
                    <div class="d-flex align-items-center">
                        <span class="position-relative">
                            <img src="dist/images/profile/user-8.jpg" alt="user-8" width="48" height="48" class="rounded-circle" />
                            <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-warning">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">Andrew Johnson</h6>
                            <span class="fs-3 text-truncate text-body-color d-block">Sent a photo</span>
                        </div>
                    </div>
                    <p class="fs-2 mb-0 text-muted">2 hrs</p>
                </a>
            </li>
        </ul>
    </div>
</div>