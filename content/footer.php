</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <?php require_once "pages/notifications/list.php"; ?>
</div>
<!--  Customizer -->
<!-- <button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn" type="button" >
  <i class="ti ti-settings fs-7" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Settings"></i>
</button> -->
<div class="offcanvas offcanvas-end customizer offcanvas-size-xxl" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" data-simplebar="">
  <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
    <h6 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">Users in group</h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-4">
    <form class="position-relative mb-4">
      <input type="search" class="form-control py-2 ps-5" oninput="search_div(this.value, 'grouplist')" id="text-srh-user" placeholder="Search User">
      <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
    </form>
    <div id="grouplist"></div>
  </div>
</div>

<script>
  function search_div(keyword, id) {
    // const div = document.getElementById(id);
    // const children = div.querySelectorAll('*');
    
    for (const a of document.getElementById(id).querySelectorAll('a')) {
      const h6 = a.querySelector('h6');
      if (h6.innerHTML.toLowerCase().includes(keyword.toLowerCase()) || keyword == "") {
        // console.log(h6.innerHTML);
        a.style.setProperty("display", "block", "important");
      }else{
        a.style.setProperty("display", "none", "important");
      }
    }
  }
</script>
<?php require_once "content/foot.php"; ?>
<script>
  function getBrowserTheme() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }
</script>
<br><br><br>
<?php if ($page != "chat") { ?>
  <footer class="d-flex justify-content-center bottom-nav" style="margin-top: 50px">
    <div class="col-11 shadow d-flex justify-content-around p-2 rounded botton-navs bg-light">
      <a href="index" class="btn <?php if ($page == "dashboard") {
                                    echo "btn-primary";
                                  } ?>"><i class='ti ti-home'></i></a>
      <a href="index?p=investment" class="btn <?php if ($page == "investment") {
                                                echo "btn-primary";
                                              } ?>"><i class='ti ti-align-box-bottom-center'></i></a>
      <a href="index?p=stocks" class="btn <?php if ($page == "stocks") {
                                            echo "btn-primary";
                                          } ?>"><i class='ti ti-box-multiple-0'></i></a>
      <a href="index?p=deposit" class="btn <?php if ($page == "deposit") {
                                              echo "btn-primary";
                                            } ?>"><i class='ti ti-plus'></i></a>
      <a href="index?p=chat" class="btn <?php if ($page == "chat") {
                                          echo "btn-primary";
                                        } ?>"><i class='ti ti-messages'></i><span class="fs-2 text-danger" id="message-no"></span></a>

      <!-- <a href="index?p=profile" class="btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Settings"><img src="<?= $u->get_profile_icon_link($userID) ?>" alt="" width="40" height="40"></a> -->
    </div>
  </footer>
<?php } ?>
<?= htmlspecialchars_decode($d->get_settings("live_chat_widget")) ?>
</body>
<!--  footercdd nav -->

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 14 Aug 2023 16:01:44 GMT -->

</html>