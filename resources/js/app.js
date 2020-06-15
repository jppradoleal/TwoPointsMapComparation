require("./bootstrap");

var platform = new H.service.Platform({
    apikey: "24KZioKxe2yeiTg5a9fbHY3gMizMQXSc-dnoBsFvl3E",
});

var defaultLayers = platform.createDefaultLayers();

var map = new H.Map(
    document.getElementById("map"),
    defaultLayers.vector.normal.map,
    {
        zoom: 10,
        center: { lat: -23.55152682009365, lng: -46.62598755364678 },
    }
);

var ui = H.ui.UI.createDefault(map, defaultLayers);
var mapEvents = new H.mapevents.MapEvents(map);
var behavior = new H.mapevents.Behavior(mapEvents);
var service = platform.getSearchService();

var inputs = document.querySelectorAll("input");
var currentClick = 1;
var markers = [
    new H.map.Marker(
        { lat: inputs[1].value, lng: inputs[2].value } || map.getCenter()
    ),
    new H.map.Marker(
        { lat: inputs[3].value, lng: inputs[4].value } || map.getCenter()
    ),
];

markers.forEach((v) => {
    map.addObject(v);
});

console.log(inputs);
map.addEventListener("tap", (e) => {
    var coords = map.screenToGeo(
        e.currentPointer.viewportX,
        e.currentPointer.viewportY
    );
    currentClick = (currentClick + 1) % 2;
    markers[currentClick].setGeometry(coords);
    map.addObject(markers[currentClick]);
    if (currentClick == 0) {
        inputs[1].value = coords.lat;
        inputs[2].value = coords.lng;
    } else {
        inputs[3].value = coords.lat;
        inputs[4].value = coords.lng;
    }
});
