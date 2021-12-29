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
latitude = numbers[0];
longitude = numbers[1];
console.log(latitude);
console.log(longitude);

var marker2 = L.marker([latitude, longitude]).addTo(map_init);
var popup = marker2.bindPopup('\
  <div class="declaration">\
  <form action="popup.php" method="post" enctype="multipart/form-data">\
  <label for="input-speed">Visit declaration:</label>\
  <label for="input-speed">Estimation of the crowd:</label>\
  <input id="estimation" class="estimation" type="number" name="estimation"/>\
  <button id="button-submit" type="submit">Declare Visit</button>\
</form>\
</div>');








