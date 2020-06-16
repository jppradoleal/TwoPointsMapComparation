require('./bootstrap');
const inputs = document.querySelectorAll('input');
const cityNames = document.getElementsByClassName('cityName');

const platform = new H.service.Platform({
    apikey: '24KZioKxe2yeiTg5a9fbHY3gMizMQXSc-dnoBsFvl3E',
});

const defaultLayers = platform.createDefaultLayers();

const map = new H.Map(
    document.getElementById('map'),
    defaultLayers.vector.normal.map,
    {
        zoom: 1,
        center: {
            lat: inputs[2].value || -23.55152682009365,
            lng: inputs[3].value || -46.62598755364678,
        },
    }
);

const ui = H.ui.UI.createDefault(map, defaultLayers);
const mapEvents = new H.mapevents.MapEvents(map);
const behavior = new H.mapevents.Behavior(mapEvents);
const service = platform.getSearchService();
let currentClick = 1;
const markers = [
    new H.map.Marker(
        { lat: inputs[2].value, lng: inputs[3].value } || map.getCenter()
    ),
    new H.map.Marker(
        { lat: inputs[5].value, lng: inputs[6].value } || map.getCenter()
    ),
];

markers.forEach((v) => {
    map.addObject(v);
});

const linestring = new H.geo.LineString();
linestring.pushPoint(
    { lat: inputs[2].value, lng: inputs[3].value } || map.getCenter()
);
linestring.pushPoint(
    { lat: inputs[5].value, lng: inputs[6].value } || map.getCenter()
);
const polyline = new H.map.Polyline(linestring, { style: { lineWidth: 10 } });
map.addObject(polyline);

if (Object.values(inputs).every((v) => v.value.length > 0)) {
    map.getViewModel().setLookAtData({ bounds: polyline.getBoundingBox() });
}

map.addEventListener('tap', (e) => {
    let coords = map.screenToGeo(
        e.currentPointer.viewportX,
        e.currentPointer.viewportY
    );
    currentClick = (currentClick + 1) % 2;
    markers[currentClick].setGeometry(coords);
    map.addObject(markers[currentClick]);
    linestring.pushPoint(coords);
    linestring.removePoint(0);
    polyline.setGeometry(linestring);
    map.addObject(polyline);
    if (currentClick == 0) {
        inputs[2].value = coords.lat;
        inputs[3].value = coords.lng;
    } else {
        inputs[5].value = coords.lat;
        inputs[6].value = coords.lng;
    }
    service.reverseGeocode({ at: `${coords.lat},${coords.lng}` }, (result) => {
        cityNames[currentClick].value =
            result.items[0].address.city || result.items.title.split(',')[0];
    });
});
