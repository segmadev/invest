$(function () {
  var chatarea = $("#chat");

  $("#chat .message-center a").on("click", function () {
    var name = $(this).find(".mail-contnet h5").text();
    var img = $(this).find(".user-img img").attr("src");
    var id = $(this).attr("data-user-id");
    var status = $(this).find(".profile-status").attr("data-status");

    if ($(this).hasClass("active")) {
      $(this).toggleClass("active");
      $(".chat-windows #user-chat" + id).hide();
    } else {
      $(this).toggleClass("active");
      if ($(".chat-windows #user-chat" + id).length) {
        $(".chat-windows #user-chat" + id)
          .removeClass("mini-chat")
          .show();
      } else {
        var msg = msg_receive(
          "I watched the storm, so beautiful yet terrific."
        );
        msg += msg_sent("That is very deep indeed!");
        var html =
          "<div class='user-chat' id='user-chat" +
          id +
          "' data-user-id='" +
          id +
          "'>";
        html +=
          "<div class='chat-head'><img src='" +
          img +
          "' data-user-id='" +
          id +
          "'><span class='status " +
          status +
          "'></span><span class='name'>" +
          name +
          "</span><span class='opts'><i class='material-icons closeit' data-user-id='" +
          id +
          "'>clear</i><i class='material-icons mini-chat' data-user-id='" +
          id +
          "'>remove</i></span></div>";
        html +=
          "<div class='chat-body'><ul class='chat-list'>" + msg + "</ul></div>";
        html +=
          "<div class='chat-footer'><input type='text' data-user-id='" +
          id +
          "' placeholder='Type & Enter' class='form-control'></div>";
        html += "</div>";
        $(".chat-windows").append(html);
      }
    }
  });
});

// *******************************************************************
// Chat Application
// *******************************************************************

$(".search-chat").on("keyup", function () {
  var value = $(this).val().toLowerCase();
  $(".chat-users li").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
});

$(".app-chat .chat-user ").on("click", function (event) {
  if ($(this).hasClass(".active")) {
    return false;
  } else {
    var findChat = $(this).attr("data-user-id");
    var personName = $(this).find(".chat-title").text();
    var personImage = $(this).find("img").attr("src");
    var hideTheNonSelectedContent = $(this)
      .parents(".chat-application")
      .find(".chat-not-selected")
      .hide()
      .siblings(".chatting-box")
      .show();
    var showChatInnerContent = $(this)
      .parents(".chat-application")
      .find(".chat-container .chat-box-inner-part")
      .show();

    if (window.innerWidth <= 767) {
      $(".chat-container .current-chat-user-name .name").html(
        personName.split(" ")[0]
      );
    } else if (window.innerWidth > 767) {
      $(".chat-container .current-chat-user-name .name").html(personName);
    }
    $(".chat-container .current-chat-user-name img").attr("src", personImage);
    $(".chat").removeClass("active-chat");
    $(".user-chat-box .chat-user").removeClass("bg-light");
    //$('.chat-container .chat-box-inner-part').css('height', '100%');
    $(this).addClass("bg-light");
    $(".chat[data-user-id = " + findChat + "]").addClass("active-chat");
  }
  if ($(this).parents(".user-chat-box").hasClass("user-list-box-show")) {
    $(this).parents(".user-chat-box").removeClass("user-list-box-show");
  }
  $(".chat-meta-user").addClass("chat-active");
  //$('.chat-container').css('height', 'calc(100vh - 158px)');
  $(".chat-send-message-footer").addClass("chat-active");
});

// Send Messages
$(".message-type-box").on("keydown", function (event) {
  if (event.key === "Enter") {
    // Start getting time
    var now = new Date();
    var hh = now.getHours();
    var min = now.getMinutes();

    var ampm = hh >= 12 ? "pm" : "am";
    hh = hh % 12;
    hh = hh ? hh : 12;
    hh = hh < 10 ? "0" + hh : hh;
    min = min < 10 ? "0" + min : min;

    var time = hh + ":" + min + " " + ampm;
    // End

    var chatInput = $(this);
    var chatMessageValue = chatInput.val();
    if (chatMessageValue === "") {
      return;
    }
    $messageHtml =
      '<div class="text-end mb-3"> <div class="p-2 bg-light-info text-dark rounded-1 d-inline-block fs-3">' +
      chatMessageValue +
      '</div> <div class="d-block fs-2">' +
      time +
      "</div>  </div>";
    var appendMessage = $(this)
      .parents(".chat-application")
      .find(".active-chat")
      .append($messageHtml);
    // var clearChatInput = chatInput.val("");
  }
});

// *******************************************************************
// Email Application
// *******************************************************************

$(document).ready(function () {
  $(".back-btn").click(function () {
    $(".app-email-chatting-box").hide();
  });
  $(".chat-user").click(function () {
    $(".app-email-chatting-box").show();
  });
});

// *******************************************************************
// chat Offcanvas
// *******************************************************************

$("body").on("click", ".chat-menu", function () {
  $(".app-chat-offcanvas").toggleClass("app-chat-right");
  $(this).toggleClass("app-chat-active");
});

get_group_users();
setInterval(function () {
  if (document.getElementById("chat-users").innerHTML != null) {
    try {
      if (
        document.getElementById("mobile-chat-list").innerHTML !=
        document.getElementById("chat-users").innerHTML
      ) {
        document.getElementById("mobile-chat-list").innerHTML =
          document.getElementById("chat-users").innerHTML;
      }
    } catch (error) {}
  }
  if(document.getElementById("chatnew")) {
    // get all messages
    get_message();
      // check user status
    user_status();
  }

  get_user_chat_list();
}, 2000); // 3000 milliseconds = 3 seconds

function get_group_users(start = 0) {
  // console.log("Statat " + start);
  if (
    document.querySelector("#receiverID") &&
    document.querySelector("#grouplist")
  ) {
    var groupID = document.querySelector("#receiverID").value;
    var limit = 30;

    $.ajax({
      type: "post",
      url: "passer",
      data: {
        get_group_users: groupID,
        start: start,
        limit: limit,
        page: "chat",
      },
      success: function (response) {
        if (response != "null" && response != null && response != "") {
          // console.log(response);
          document.getElementById("grouplist").innerHTML += response;
          get_group_users(start + limit);
        }
      },
    });
  }
}

function get_message() {
  const div = document.querySelector("#chatnew");
  const lastElement = div.lastElementChild;
  var lastchat = lastElement.getAttribute("data-chat-id");
  if (lastchat != null) {
    // console.log(lastchat);
    var chatID = document.querySelector("#chatID").value;
    $.ajax({
      type: "post",
      url: "passer?chat=",
      data: {
        lastchat: lastchat,
        chatID: chatID,
        page: "chat",
        get_chat: 50,
      },
      success: function (response) {
        // console.log(response);
        var Resholder = response.trim();
        
        if (Resholder == "null" || Resholder == "" || Resholder == null) {
          return false;
        }
        console.log(Resholder);
        console.log(lastchat);
        if (lastchat == 0 || lastchat == "0") {
          document.getElementById("chatnew").innerHTML = response;
        } else {
          document.getElementById("chatnew").innerHTML += response;
        }
      },
    });
  }
}
get_old_message();
function get_old_message() {
  if(!document.querySelector("#chatnew")) {
    return null;
  }
  const div = document.querySelector("#chatnew");
  const firstElement = div.firstElementChild;
  var firstchat = firstElement.getAttribute("data-chat-id");
  if (firstchat != null) {
    // console.log(firstchat);
    var chatID = document.querySelector("#chatID").value;
    $.ajax({
      type: "post",
      url: "passer?chat=old",
      data: {
        firstchat: firstchat,
        chatID: chatID,
        page: "chat",
        get_chat: 2000,
      },
      success: function (response) {
        // console.log(response);
        if (response != "null" && response != "" && response != null) {
          document
            .getElementById("chatnew")
            .insertAdjacentHTML("beforebegin", response);
        }
      },
    });
  }
}

function reply_to(id, message) {
  if (
    document.getElementById("reply_div") &&
    document.getElementById("reply_message") &&
    document.getElementById("reply_to")
  ) {
    document.getElementById("reply_to").value = id;
    document.getElementById("reply_message").innerHTML = message;
    document.getElementById("reply_div").style.display = "block";
  }
}

setTimeout(function () {
  // get all messages

  var chatbox = document.querySelector(".chat-box");
  var chatdiv = chatbox.querySelector(".simplebar-content-wrapper");
  console.log(chatdiv.scrollHeight);
  chatdiv.scrollTop = chatdiv.scrollHeight;
}, 1000);

// get and display user status
function user_status() {
  if (document.querySelector("#receiverID")) {
    const receiverID = document.querySelector("#receiverID").value;
    $.ajax({
      type: "post",
      url: "passer",
      data: {
        get_last_seen: receiverID,
        page: "chat",
      },
      success: function (response) {
        // console.log(response);
        if (response != "null" && document.querySelector("#last_seen")) {
          // console.log(response);
          document.getElementById("last_seen").innerHTML = response;
        }
      },
    });
  }
}

function get_user_chat_list() {
  if (document.querySelector("#chat-users")) {

    if(!document.getElementById("lastChatTime")) {
      const input = document.createElement('input');
      input.setAttribute('type', 'hidden');
      input.setAttribute('value', '0');
      input.setAttribute('id', 'lastChatTime');
      document.body.appendChild(input);
    }
    var lastChatTime = document.getElementById("lastChatTime");
    var currentTime = Math.floor(new Date().getTime() / 1000);
    // console.log('response');
    $.ajax({
      type: "post",
      url: "passer?users=",
      data: {
        get_user_chat_list: "",
        page: "chat",
        time: lastChatTime.value,
      },
      success: function (response) {
        // console.log(response);
        if (response != "null" && document.querySelector("#chat-users")) {
          // console.log(response);
          if(handleChatDisplay("chat-users", response, lastChatTime.value))  {
            lastChatTime.value = currentTime;
          }
        }
      },
    });
  }
}

function handleChatDisplay(displayID, content, type) {
  if(content == null || content == "null" || content == "") {
    return ;
  }
  if (!document.getElementById(displayID)) {
    return false;
  }
  var display = document.getElementById(displayID);
  if (type == 0) {
    display.innerHTML = content;
    return true;
  }
  if(!document.querySelector("#chatHolder")) {
    var chatHolder = createHiddenDiv("chatHolder");
    if (!chatHolder) {
      console.log("Unable to create chat holder");
      return false;
    }
  }
  
  var chatHolder = document.querySelector("#chatHolder");
  chatHolder.innerHTML = content;
  const liElements = chatHolder.querySelectorAll("li");
  for (let i = 0; i < liElements.length; i++) {
    const liElement = liElements[i];
    // console.log();
    currentChatID = liElement.querySelector("a").id;
    if (document.getElementById(currentChatID)) {
      mainDiv = document.getElementById(displayID);
      removeElement = mainDiv.querySelector("#" + currentChatID);
      const parent = removeElement.parentNode;
      mainDiv.removeChild(parent);
    }
    mainDiv.insertAdjacentHTML(
      "afterbegin",
      "<li>" + liElement.innerHTML + "</li>"
    );
    // Do something with the `liElement` element.
  }
  chatHolder.innerHTML = "";
  return true;
}

function createHiddenDiv(divID) {
  const div = document.createElement("div");
  div.id = divID;
  div.style.display = "none";
  document.body.appendChild(div);
  return true;
}

function disposeDiv(divID) {
  document.body.removeChild(divID);
}
