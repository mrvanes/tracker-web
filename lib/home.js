var uid;
var marker = {};
var positions = {};
var hdop = {};
var trail = {};
var done = false;
var loc;
var selector;
var stopUpdateInfoText = false;
var map;
var tms = 'https://maps.heigit.org/openmapsurfer/tiles/roads/webmercator/{z}/{x}/{y}.png';
var info;
var viewall;

var act = {};
act['IDLE'] = '...';
act['STATUS_A'] = 'Heen';
act['STATUS_B'] = 'Wachten';
act['STATUS_C'] = 'Lossen';
act['STATUS_D'] = 'Terug';
act['STATUS_E'] = 'Pauze';

document.onclick = hideSelector;

var mapOptions = {
  attribution: 'Tiles courtesy of <a href="https://heigit.org/" target=blank>Heidelberg Institute for Geoinformation Technology</a>',
  maxZoom: 17,
  subdomains: '1234',
};

var hdopOptions = {
  color: '#88f',
  weight: 2,
  opacity: 0.5,
  fillOpacity: 0.1,
  clickable: false
};

var trailOptions = {
    color: '#88f',
    weight: 4,
    opacity: 0.5,
    clickable: false
}

// Location (centrale) icon
var locIcon = L.icon({
    iconUrl: '/style/centrale.png',
    iconSize:     [25, 25], // size of the icon
    iconAnchor:   [13, 25], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20], // point from which the popup should open relative to the iconAnchor
});

// Dynamic mixer icons
var mixerIcon = L.Icon.extend({
  options: {
    shadowUrl: '/style/truc-shadow.png',
    iconSize:     [25, 35], // size of the icon
    shadowSize:   [38, 21], // size of the shadow
    iconAnchor:   [12, 35], // point of the icon which will correspond to marker's location
    shadowAnchor: [2, 18],  // the same for the shadow
    popupAnchor:  [0, -30], // point from which the popup should open relative to the iconAnchor
    labelAnchor:  [0, 0],   // point where the label should be attached
  }
});

var statusDropDown = "<div class=status onclick='toggle(\"a_dd_%s\", event);'>&#x25BC" +
"<div class=cstatus id='a_dd_%s' style='display: none;'><ul class=cstatus>" +
"<li><a href=\"?id=%s&a=STATUS_A\">Heen</a></li>" +
"<li><a href=\"?id=%s&a=STATUS_B\">Wachten</a></li>" +
"<li><a href=\"?id=%s&a=STATUS_C\">Lossen</a></li>" +
"<li><a href=\"?id=%s&a=STATUS_D\">Terug</a></li>" +
"<li><a href=\"?id=%s&a=STATUS_E\">Pauze</a></li>" +
"</ul></div></div>";

var posIcon = {};
posIcon['IDLE'] = new mixerIcon({ iconUrl: '/style/mixer.php?a=IDLE' });
posIcon['STATUS_A'] = new mixerIcon({ iconUrl: '/style/mixer.php?a=STATUS_A' });
posIcon['STATUS_B'] = new mixerIcon({ iconUrl: '/style/mixer.php?a=STATUS_B' });
posIcon['STATUS_C'] = new mixerIcon({ iconUrl: '/style/mixer.php?a=STATUS_C' });
posIcon['STATUS_D'] = new mixerIcon({ iconUrl: '/style/mixer.php?a=STATUS_D' });
posIcon['STATUS_E'] = new mixerIcon({ iconUrl: '/style/mixer.php?a=STATUS_E' });

function initmap(my_uid, my_viewall) {
  uid = my_uid;
  viewall = my_viewall;
  setupMap();
  setupInfo();
  addLocation();
  resetView();
  //updateView();
  updateTimeOut = setInterval(updateView, 5000);
}

function setupMap() {
  map = L.map('map');
  var TL = L.tileLayer(tms, mapOptions);
  TL.addTo(map);
}

function setupInfo() {
  info = document.getElementById('info');
}

function addLocation() {
    //console.log('addLocation');
    if (uid) getJSON("/api/location?id=" + uid, handleAddLocation);
}

function handleAddLocation(l) {
    loc = l; // set global location coordinates
    var my_location = L.marker([loc.lat, loc.lon], {icon: locIcon}).addTo(map);
    my_location.bindPopup(loc.name + "<br>" + loc.description);
}

function updateView() {
    //console.log('updateView');
    if (uid) getJSON("/api/positions?id=" + uid + "&viewall=" + viewall, handleUpdateView);
}

function handleUpdateView(p) {
    if (!done) {
        console.log('handleUpdateView failed')
        //setTimeout(handleUpdateView(positions), 100);
        return;
    }
    positions = p; // Set global positions
    var infoText = "";
    for (i in positions) {
        if (positions[i].activity == 'null') continue;
//        infoText += "<span class='link' onclick='setView(\"" + positions[i].id + "\"); return false;'>"
        infoText += "<span class='link' onclick='setView(\"" + i + "\"); return false;'>"
        infoText += positions[i].name + ": " + act[positions[i].activity] + "</span> " + statusDropDown.replace(/%s/g, positions[i].id) + "<br>\n";
        marker[positions[i].id].setLatLng([positions[i].lat, positions[i].lon]);
        marker[positions[i].id].setIcon(posIcon[positions[i].activity]);
        marker[positions[i].id].setPopupContent(positions[i].name + "<br>" + act[positions[i].activity] + "<br>" + positions[i].time);
        marker[positions[i].id].updateLabelContent(positions[i].name);
        hdop[positions[i].id].setLatLng([positions[i].lat, positions[i].lon]);
        hdop[positions[i].id].setRadius(positions[i].hdop);
        trail[positions[i].id].setLatLngs(positions[i].trail);
    }
    if (!stopUpdateInfoText) info.innerHTML = infoText;
}

function resetView() {
    //console.log('resetView');
    if (uid) getJSON("/api/positions?id=" + uid + "&viewall=" + viewall, handleResetView);
}

function handleResetView(positions) {
  var lonmin = 0;
  var latmin = 0;
  var lonmax = 0;
  var latmax = 0;
  var activity;

  for (t in trail) {
      map.removeLayer(trail[t]);
  }

  for (m in marker) {
    map.removeLayer(marker[m]);
  }

  for (h in hdop) {
    map.removeLayer(hdop[h]);
  }

  for (i in positions) {
    activity = positions[i].activity;
    if (activity == 'null' ) continue;
    if (latmax == 0) latmax = positions[i].lat;
    else latmax = Math.max(latmax, positions[i].lat);
    if (latmin == 0) latmin = positions[i].lat;
    else latmin = Math.min(latmin, positions[i].lat);
    if (lonmax == 0) lonmax = positions[i].lon;
    else lonmax = Math.max(lonmax, positions[i].lon);
    if (lonmin == 0) lonmin = positions[i].lon;
    else lonmin = Math.min(lonmin, positions[i].lon);
    marker[positions[i].id] = L.marker([positions[i].lat, positions[i].lon], {icon: posIcon[positions[i].activity]}).addTo(map);
    marker[positions[i].id].bindPopup(positions[i].name + "<br>" + positions[i].activity + "<br>" + positions[i].time);
    marker[positions[i].id].bindLabel(positions[i].name, { noHide: true });
    marker[positions[i].id].showLabel();
    hdop[positions[i].id] = L.circle([positions[i].lat, positions[i].lon], 0,  hdopOptions).addTo(map);
    hdop[positions[i].id].setRadius(positions[i].hdop);
    trail[positions[i].id] = L.polyline(positions[i].trail, trailOptions).addTo(map);
  }
  map.fitBounds([[latmin, lonmin], [latmax, lonmax]]);
  done = true;
  updateView();
}

function setView(id) {
    map.setView([positions[id].lat, positions[id].lon], 15);
}

function viewLocation() {
    map.setView([loc.lat, loc.lon], 15);
}

function hideSelector() {
  stopUpdateInfoText = false;
  if (selector) selector.style.display = "none";
}

function toggle(id, e) {
  if (e.stopPropagation) e.stopPropagation(); else if (window.event) window.event.cancelBubble = true; else e.cancelBubble = true;
  new_selector = document.getElementById(id);
  if (selector && new_selector != selector && selector.style.display == "block") selector.style.display = "none";
  if (new_selector.style.display == "none") {
    stopUpdateInfoText = true;
    new_selector.style.display = "block";
  } else {
    stopUpdateInfoText = false;
    new_selector.style.display = "none";
  }
  selector = new_selector;
}

