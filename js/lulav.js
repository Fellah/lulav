google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
    var mapCanvas = jQuery('.lulav .map');

    if (!mapCanvas.length) {
        return;
    }

    var mapOptions = {
        center: new google.maps.LatLng(53.904847, 27.559519),
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(mapCanvas[0], mapOptions);

    jQuery('.lulav ul li').each(function () {
        var coordinates = jQuery('div', this).data('coordinates').split(', ');

        var latLng = {
            lat: parseFloat(coordinates[0]),
            lng: parseFloat(coordinates[1])
        };

        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            //title: jQuery('span', this).text()
            title: 'test'
        });

        var infoWindow = new google.maps.InfoWindow({
            content: jQuery('div', this).html()
        });

        marker.addListener('click', function () {
            infoWindow.open(map, this);
        });
    });

    jQuery('.lulav .thumbnails .cell').each(function () {
        var thumbnail = jQuery(this).data('thumbnail');

        if (thumbnail != '') {
            jQuery(this).css('background-image', 'url(' + thumbnail + ')');
        }
    });
}
