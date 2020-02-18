<script src="/lib/md5.js"></script>
<script>
var salt;
getSalt();

function getSalt() {
    getJSON("/api/salt", handleGetSalt);
}

function handleGetSalt(s) {
    //console.log('handleGetSalt');
    salt = s.salt;
}

function addHash() {
  //console.log('addHash');
  if (!salt) {
    alert('no Salt!');
    return;
  }
  var form = document.forms["myform"];
  var test = salt;
  test += 'version=' + form.version.value;
  test += 'id=' + form.id.value;
  test += 'activity=' + form.activity.value;
  test += 'lat=' + form.lat.value;
  test += 'lon=' + form.lon.value;
  test += 'hdop=' + form.hdop.value;
  test += 'speed=' + form.speed.value;
  form.hash.value = md5(test);
  //alert(test + ',' + md5(test));
  form.submit();
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  var form = document.forms["myform"];
  form.lat.value = Math.round(position.coords.latitude*1000000)/1000000;
  form.lon.value = Math.round(position.coords.longitude*1000000)/1000000;
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation")
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable")
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out")
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.")
      break;
  }
}
</script>
