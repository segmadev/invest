// var loaddata = document.querySelectorAll("[data-load]");
// for (var i in loaddata) {
//   if (loaddata.hasOwnProperty(i)) {
//     what = loaddata[i].getAttribute("data-load");
//     displayId = loaddata[i].getAttribute("data-displayId");
//     start = loaddata[i].getAttribute("data-start") || 0;
//     limit = loaddata[i].getAttribute("data-limit") || 1;
//     fetchData(what, displayId, limit, start);
//   }
// }


document.querySelectorAll("[data-load]").forEach(loaddata => {
  const what = loaddata.getAttribute("data-load");
  const displayId = loaddata.getAttribute("data-displayId");
  const start = loaddata.getAttribute("data-start") || 0;
  const limit = loaddata.getAttribute("data-limit") || 1;
  fetchData(what, displayId, limit, start);
});


function fetchData(what, displayId, limit = 1, start = 0) {
  data = { page: what, what: what, start: start };
  request = $.ajax({
    type: "POST",
    url: "passer"+gets(),
    data: data,
  });

}


document.querySelectorAll("[data-ajax-data]").forEach(loaddata => {
  const what = loaddata.getAttribute("data-ajax-data");
  const displayId = loaddata.getAttribute("data-displayId");
  const start = loaddata.getAttribute("data-start") || 0;
  const limit = loaddata.getAttribute("data-limit") || 1;
  loadAjaxData(what, displayId, limit, start);
});

function loadAjaxData(what, displayId, limit = 1, start = 0) {
  request = $.ajax({
    type: "POST",
    url: "fetcher"+gets()+"&start="+start+"&limit="+limit,
    data: {what: what},
  });

  request.done(function (response) {
    if (response == null || response == "null" || response == "" || response == "No data found") {
        start = 0;
        return null;
    }
    document.getElementById(displayId).innerHTML += response;
    start = parseInt(start) + parseInt(limit);
    loadAjaxData(what, displayId, limit, start);
  });

}

function fetchData(what, displayId, limit = 1, start = 0) {
  data = { page: what, what: what, start: start };
  request = $.ajax({
    type: "POST",
    url: "passer"+gets(),
    data: data,
  });

  request.done(function (response) {
    if (response == null || response == "null" || response == "") {
        start = 0;
        return null;
    }
    document.getElementById(displayId).innerHTML += response;
    start = start + limit;
    fetchData(what, displayId, limit, start);
  });
}

function get_user_info(userID) {
    if(!document.getElementById(userID)) { return null; }
    data = document.getElementById(userID);
    if(data.innerHTML != "" || data.innerHTML != "loading...") { return null;}
    request = $.ajax({
        type: "POST",
        url: "passer",
        data: {userdetails: userID},
      });
      request.done(function (response) {
        data.innerHTML = response;
      });
}

function display_content(data) {
    document.querySelectorAll('.chat-list').forEach(function(el) {
        el.style.visibility = 'hidden';
        el.style.display = 'none';
     });
   var id = $(data).data('user-id');
   if(!document.getElementById("content"+id)) {
    fetchUserData("displayDetails", id);
}else{
    document.getElementById("content"+id).style.visibility = "visible";
    document.getElementById("content"+id).style.display = "block";
}


}

function fetchUserData(displayId, id) {
    request = $.ajax({
        type: "POST",
        url: "passer",
        data: { page: "userdetails", what: "userdetails", ID: id, start: 0 },
      });
      request.done(function (response) {
        if (response == null || response == "null" || response == "") {
            start = 0;
            return null;
        }
        document.getElementById(displayId).innerHTML += response;
        document.getElementById("content"+id).style.visibility = "visible";
        document.getElementById("content"+id).style.display = "block";
      });
}

function getwalletinfo(id, displayId='display-wallet-info') {
  document.getElementById(displayId).innerHTML = "<b class='text-warning'>getting data...</b>";

  request = $.ajax({
    type: "POST",
    url: "passer",
    data: { page: "wallets", what: "wallet", ID: id},
  });
  request.done(function (response) {
    document.getElementById(displayId).innerHTML = response;
    qr = document.getElementById("genqr");
    get_qr_code(qr);
  });
}


function gets() {
  const urlParams = new URLSearchParams(window.location.search);
  var params = "?o=0";

  for (const [key, value] of urlParams) {
      params += "&"+key+"="+value;
  }
  return params;
}