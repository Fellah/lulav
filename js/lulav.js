google.maps.event.addDomListener(window, 'load', lulavInitialize);

function lulavInitialize() {
    var mapCanvas = jQuery('.lulav .llv-map');
    var thumbs = jQuery('.lulav .llv-thumbs');

    if (!mapCanvas.length) {
        return;
    }

    var mapOptions = {
        center: new google.maps.LatLng(53.904847, 27.559519),
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(mapCanvas[0], mapOptions);

    var markers = {};
    var infoWindows = {};

    jQuery('td', thumbs).each(function () {
        var id = jQuery(this).data('id');
        var coordinates = jQuery(this).data('coordinates').split(', ');

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
            content: jQuery('.llv-desc', this).html()
        });
        infoWindows[id] = infoWindow;

        marker.addListener('click', function () {
            var cell = jQuery('.lulav .llv-thumbs td[data-id="' + this.id + '"]');
            var select = jQuery(document.createElement('div')).addClass('llv-select');

            var next = cell.parents('table');
            if (!next.hasClass('active')) {
                var collection = jQuery('.lulav .llv-thumbs table.active');

                next.addClass('animation');
                next.css('left', -collection.width());
                next.css('z-index', collection.css('z-index') + 20);

                next.animate({'left': 0}, 800, function () {
                    collection.removeClass('active');
                    next.removeClass('animation');
                    next.addClass('active');
                    next.css('z-index', collection.css('z-index'));
                });
            }

            jQuery('.llv-select', thumbs).remove();
            select.width(cell.innerWidth());
            select.height(cell.innerHeight());
            cell.append(select);

            for (var id in infoWindows) {
                infoWindows[id].close();
            }
            infoWindow.open(map, this);
        });
    });

    jQuery('td', thumbs).each(function () {
        var cell = jQuery(this);
        var thumbnail = cell.data('thumbnail');

        if (thumbnail != '') {
            cell.css('background-image', 'url(' + thumbnail + ')');
        }
    });

    jQuery('td', thumbs).click(function () {
        var cell = jQuery(this);
        var id = cell.data('id');
        var select = jQuery(document.createElement('div')).addClass('llv-select');

        jQuery('.llv-select', thumbs).remove();
        select.width(cell.innerWidth());
        select.height(cell.innerHeight());
        cell.append(select);

        //map.panTo(markers[id].getPosition());

        for (var i in infoWindows) {
            infoWindows[i].close();
        }
        infoWindows[id].open(map, markers[id]);
    });

    jQuery('table:first', thumbs).addClass('active');

    jQuery('.lulav .llv-controls .left').click(function () {
        var collection = jQuery('.lulav .llv-thumbs table.active');
        var next = collection.prev();
        if (!next.length) {
            next = jQuery('.lulav .llv-thumbs table:last');
        }

        next.addClass('animation');
        next.css('left', -collection.width());
        next.css('z-index', collection.css('z-index') + 20);

        next.animate({'left': 0}, 800, function () {
            collection.removeClass('active');
            next.removeClass('animation');
            next.addClass('active');
            next.css('z-index', collection.css('z-index'));
        });

        return false;
    });

    jQuery('.lulav .llv-controls .right').click(function () {
        var collection = jQuery('.lulav .llv-thumbs table.active');
        var next = collection.next();
        if (!next.length) {
            next = jQuery('.lulav .llv-thumbs table:first');
        }

        next.addClass('animation');
        next.css('left', collection.width());
        next.css('z-index', collection.css('z-index') + 20);

        next.animate({'left': 0}, 800, function () {
            collection.removeClass('active');
            next.removeClass('animation');
            next.addClass('active');
            next.css('z-index', collection.css('z-index'));
        });

        return false;
    });
};
