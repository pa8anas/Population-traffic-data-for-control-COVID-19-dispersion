var map_init = L.map('map', {
    center: [9.0820, 8.6753],
    zoom: 8
});
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map_init);
L.Control.geocoder().addTo(map_init);
if (!navigator.geolocation) {
    console.log("Your browser doesn't support geolocation feature!")
} else {
    setInterval(() => {
        navigator.geolocation.getCurrentPosition(getPosition)
    }, 5000);
};
var marker, circle, lat, long, accuracy;
/*
function getPosition(position) {
    // console.log(position)
    lat = position.coords.latitude
    long = position.coords.longitude
    accuracy = position.coords.accuracy

    if (marker) {
        map_init.removeLayer(marker)
    }

    if (circle) {
        map_init.removeLayer(circle)
    }

    marker = L.marker([lat, long])
    circle = L.circle([lat, long], { radius: accuracy })

    var featureGroup = L.featureGroup([marker, circle]).addTo(map_init)

    map_init.fitBounds(featureGroup.getBounds())

    console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
}
*/

var x = document.cookie;
var numbers = [];
x.replace(/[-+]?[0-9]*\.?[0-9]+/g, function( x ) { var n = Number(x); if (x == n) { numbers.push(x); }  })
var average = numbers[0];
visit_estimation = numbers[1];
latitude = numbers[2];
longitude = numbers[3];
console.log(latitude);
console.log(longitude);
console.log(average);
console.log(numbers);
console.log(visit_estimation);
console.log(x);

var greenIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

var orangeIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

var redIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

if (visit_estimation <= 32) {
    var marker2 = L.marker([latitude, longitude], {icon: greenIcon}).addTo(map_init);
} else if (33 <= visit_estimation && visit_estimation <= 65) {
    var marker2 = L.marker([latitude, longitude], {icon: orangeIcon}).addTo(map_init);
} else {
    var marker2 = L.marker([latitude, longitude], {icon: redIcon}).addTo(map_init);
}

//var marker2 = L.marker([latitude, longitude], {icon: redIcon}).addTo(map_init);
var popup = marker2.bindPopup('<h3>Visit declaration:</h3><br>The visit estimation of the poi in % is:</br>'+visit_estimation+'<br>The average number of the visitors is:</br>'+average+'\
  <div class="declaration" id="popup">\
  <form action="popup.php" method="post" enctype="multipart/form-data">\
  <label for="input-speed">Estimation of the crowd:</label>\
  <input id="estimation" class="estimation" type="number" name="estimation"/>\
  <button id="button-submit" type="submit">Declare Visit</button>\
</form>\
</div>');








