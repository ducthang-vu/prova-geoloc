require('./bootstrap');
import $ from 'jquery/dist/jquery.min.js';
import L from 'leaflet/dist/leaflet'

if (!document.getElementById('noAppJs')) {
    place();

    function place() {
        var address = document.querySelector('#address');
        var places = require('places.js');

        var placesAutocomplete = places({
            appId: 'pl9SBUILJO03',
            apiKey: '707374d54fdaf7af334afaba53bce3c3',
            container: address,
            accessibility: {
                pinButton: {
                    'aria-label': 'use browser geolocation',
                    'tab-index': 12,
                },
                clearButton: {
                    'tab-index': 13,
                }
            }
        });

        var address = document.querySelector('#address-value');
        placesAutocomplete.on('change', function (e) {
            address = e.suggestion.latlng;
            // document.querySelector('#latlong').value = address.lat + ', ' + address.lng + ', ' + parseInt('1');
            // document.querySelector('#latlong').value = address.lat + ', ' + address.lng + ', 1';
            document.querySelector('#latlong').value = [45.0677, 7.6824];
            var marker = L.marker([address.lat, address.lng], { title: 'casa' }).addTo(map);
            marker.bindPopup('Casa');
            map.setView(new L.LatLng(address.lat, address.lng), 15);
            console.log(address);
        });

        placesAutocomplete.on('clear', function () {
            address.textContent = 'none';
        });

        var map = L.map('map-example-container', {
            scrollWheelZoom: true,
            zoomControl: true,
            zoomAnimation: true,
            fadeAnimation: true
        });

        var osmLayer = new L.TileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 1,
                maxZoom: 20,
                attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
            }
        );

        // var marker = L.marker([45.0754, 7.688], { title: 'casa'}).addTo(map);

        // marker.bindPopup('Casa');

        map.setView(new L.LatLng(0, 0), 1);
        map.addLayer(osmLayer);

    }


}


