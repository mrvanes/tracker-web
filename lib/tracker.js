//var xmlhttp;
function setupRequest() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlhttp;
}

function getJSON(url, callback) {
    var xmlhttp = setupRequest();
    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status==200) callback(JSON.parse(xmlhttp.responseText));
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send(null);
}

