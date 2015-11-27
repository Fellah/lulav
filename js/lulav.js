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

    var markers = {};
    var infoWindows = {};

    jQuery('.lulav ul li').each(function () {
        var id = jQuery(this).data('id');
        var coordinates = jQuery('div', this).data('coordinates').split(', ');

        var latLng = {
            lat: parseFloat(coordinates[0]),
            lng: parseFloat(coordinates[1])
        };

        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            id: id
        });
        markers[id] = marker;

        var infoWindow = new google.maps.InfoWindow({
            content: jQuery('div', this).html()
        });
        infoWindows[id] = infoWindow;

        marker.addListener('click', function () {
            jQuery('.lulav .cell').removeClass('active');
            jQuery('.lulav .cell[data-id="' + this.id + '"]').addClass('active');

            for (var id in infoWindows) {
                infoWindows[id].close();
            }
            infoWindow.open(map, this);
        });
    });

    jQuery('.lulav .thumbnails .cell').each(function () {
        var cell = jQuery(this);

        var thumbnail = cell.data('thumbnail');

        if (thumbnail != '') {
            cell.css('background-image', 'url(' + thumbnail + ')');
        }
    });

    jQuery('.lulav .thumbnails .cell').click(function () {
        var cell = jQuery(this);
        var id = cell.data('id');

        jQuery('.lulav .cell').removeClass('active');
        cell.addClass('active');

        for (var i in infoWindows) {
            infoWindows[i].close();
        }
        infoWindows[id].open(map, markers[id]);
    });
}
