google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
    var mapCanvas = jQuery('.lulav .map');

    if (!mapCanvas.length) { return; }

    var mapOptions = {
        center: new google.maps.LatLng(53.904847, 27.559519),
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(mapCanvas[0], mapOptions);

	jQuery('.lulav .list a').each(function () {
		var latLng = {
			lat: parseFloat(jQuery('div', this).data('lat')),
			lng: parseFloat(jQuery('div', this).data('lng'))
		}

		var marker = new google.maps.Marker({
			position: latLng,
			map: map,
			title: jQuery('span', this).text()
		});

		var infoWindow = new google.maps.InfoWindow({
			content: jQuery('div', this).html()
		});

		marker.addListener('click', function() {
			infoWindow.open(map, this);
		});
	});
}
