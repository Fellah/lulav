google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
    var mapCanvas = jQuery('.lulav .map')[0];

    var mapOptions = {
        center: new google.maps.LatLng(53.904847, 27.559519),
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);
}
