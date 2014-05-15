var beer = {
    'bounds': null,
    'default_latlng': new google.maps.LatLng(GLOBALS.center_lat, GLOBALS.center_lng),

    /**
     * initialize the beer application
     */
    'init': function () {
        var self = this;

        // get elements from page
        self.$beer_map = $('#beer-map');
        self.$updated_time = $('#update-time');
        self.$loading = $('#loading');
        self.template_checkin = $('#template-checkin').html();

        self.$updated_time.text(moment.utc(self.$updated_time.text()).local().format('LLL'));

        self.initMap();
        self.fillMap();
    },

    /**
     * initialize the map
     */
    'initMap': function () {
        var self = this;

        self.map = new google.maps.Map(
            self.$beer_map.get(0),
            {
                center: self.default_latlng,
                zoom  : 10
            }
        );

        // keep map centered responsively
        $(window).on('resize', function () {
            // if bounds are set, fit them
            if(self.bounds !== null){
                self.map.fitBounds(self.bounds);
            }
            // get current center, and then recenter the map in respect to current view port
            var center = self.map.getCenter();
            google.maps.event.trigger(self.map, 'resize');
            self.map.setCenter(center);
        });
    },

    /**
     * fill map with latest check-ins
     */
    'fillMap': function () {
        var self = this;

        // images for markers
        var beer_marker = {
            url       : 'img/beer.png',
            size      : new google.maps.Size(16, 24),
            scaledSize: new google.maps.Size(16, 24),
            origin    : new google.maps.Point(0, 0),
            anchor    : new google.maps.Point(8, 24)
        };

        $.ajax({
            'url'     : 'service/get_checkins.php',
            'dataType': 'json',
            'success' : function (data) {
                self.$loading.fadeOut();
                if (data && data.response && data.response.checkins) {
                    self.bounds = new google.maps.LatLngBounds();
                    var items = data.response.checkins.items;

                    $.each(items, function (i, checkin) {
                        // local pub only returns posts with locations
                        var latlng = new google.maps.LatLng(checkin.venue.location.lat, checkin.venue.location.lng),
                            marker = new google.maps.Marker({
                                position: latlng,
                                map     : self.map,
                                icon    : beer_marker,
                                title   : checkin.beer.beer_name + ' - ' + checkin.beer.beer_style
                            }),
                            $info = $(Mustache.render(self.template_checkin, checkin)),
                            $time = $info.find('.time');

                        // handle time conversion to local time from UTC
                        $time.text(moment.utc($time.text(), 'ddd, DD MMM YYYY HH:mm:ss ZZ').local().fromNow());
                        var info = new google.maps.InfoWindow({
                                position: latlng,
                                content: $info.get(0).outerHTML
                            });

                        // handles clicking on markers for mor info
                        var markerClick = function(i, m){
                            i.open(self.map, m);
                        };
                        google.maps.event.addListener(marker, 'click', markerClick.bind(this, info, marker));


                        self.bounds.extend(latlng);
                    });

                    // fits map to bounds set by all markers
                    self.map.fitBounds(self.bounds);
                }
            }
        });
    }
};

// initialize beer application
$(function () {
    beer.init();
});