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
            var cell = jQuery('.lulav .cell[data-id="' + this.id + '"]');
            var select = jQuery(document.createElement('div')).addClass('select');

            var next = cell.parents('.thumbnails');
            if (!next.hasClass('active')) {
                var collection = jQuery('.lulav .carousel .thumbnails.active');

                console.log(next);
                console.log(collection);

                next.addClass('animation');
                next.css('left', -collection.width());
                next.css('z-index', collection.css('z-index') + 50);

                next.animate({'left': 0}, 800, function() {
                    collection.removeClass('active');
                    next.removeClass('animation');
                    next.addClass('active');
                    next.css('z-index', collection.css('z-index'));
                });
            }

            jQuery('.lulav .cell .select').remove();
            select.width(cell.width());
            select.height(cell.height());
            cell.append(select);

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
        var select = jQuery(document.createElement('div')).addClass('select');

        jQuery('.lulav .cell .select').remove();
        select.width(cell.width());
        select.height(cell.height());
        cell.append(select);

        //map.panTo(markers[id].getPosition());

        for (var i in infoWindows) {
            infoWindows[i].close();
        }
        infoWindows[id].open(map, markers[id]);
    });
}

jQuery(document).ready(function() {
    jQuery('.lulav .carousel .thumbnails:first').addClass('active');

    jQuery('.lulav .left').click(function () {
        var collection = jQuery('.lulav .carousel .thumbnails.active');
        var next = collection.prev();
        if (!next.length) {
            next = jQuery('.lulav .carousel .thumbnails:last');
        }

        next.addClass('animation');
        next.css('left', -collection.width());
        next.css('z-index', collection.css('z-index') + 50);

        next.animate({'left': 0}, 800, function() {
            collection.removeClass('active');
            next.removeClass('animation');
            next.addClass('active');
            next.css('z-index', collection.css('z-index'));
        });

        return false;
    });

    jQuery('.lulav .right').click(function () {
        var collection = jQuery('.lulav .carousel .thumbnails.active');
        var next = collection.next();
        if (!next.length) {
            next = jQuery('.lulav .carousel .thumbnails:first');
        }

        next.addClass('animation');
        next.css('left', collection.width());
        next.css('z-index', collection.css('z-index') + 50);

        next.animate({'left': 0}, 800, function() {
            collection.removeClass('active');
            next.removeClass('animation');
            next.addClass('active');
            next.css('z-index', collection.css('z-index'));
        });

        return false;
    });
});
