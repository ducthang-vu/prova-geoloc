@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1/leaflet.css" />
<script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>
<div id="map-example-container"></div>
<style>
    #map-example-container {
        height: 300px
    };
</style>

<form action="{{ route('user.store')}}" method="POST">
    @csrf
    @method('POST')
    <label for="address">Indirizzo</label>
    <input type="text" name="address" id="address">
    <input type="hidden" name="latlong" id="latlong">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <input type="submit" value="Crea">
</form>

{{-- form 2 --}}

<style>
    .reverse-geo-controls {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
    }
</style>
<div style="display: none;">
    <input id="reverse-demo-ignored" />
</div>

<div class="reverse-geo-controls">
    <div class="form-group" style="flex-grow: 1; margin-right: 8px;">
        <label for="reverse-geo-lat">Latitude</label>
        <input id="reverse-geo-lat" class="form-control" placeholder="try 48.87" />
    </div>
    <div class="form-group" style="flex-grow: 1; margin-left: 8px; margin-right: 8px;">
        <label for="reverse-geo-lng">Longitude</label>
        <input id="reverse-geo-lng" class="form-control" placeholder="try 2.31" />
    </div>
    <div class="form-group" style="margin-left: 8px;">
        <button id="reverse-locate-me" class="btn btn-black" style="width: 150px;">Locate me</button>
    </div>
</div>

<form action="/locate" class="form">
    <div class="form-group">
        <label for="reverse-address">Address</label>
        <input type="text" class="form-control" id="reverse-address" placeholder="Street number and name" />
    </div>
    <div class="form-group">
        <label for="reverse-town">City*</label>
        <input type="text" class="form-control" id="reverse-town" placeholder="City">
    </div>
    <div class="form-group">
        <label for="reverse-zip">ZIP code*</label>
        <input type="text" class="form-control" id="reverse-zip" placeholder="ZIP code">
    </div>
</form>

<script src="https://cdn.jsdelivr.net/algoliasearch/3.31/algoliasearchLite.min.js"></script>
<script>
    (function() {
  var places = algoliasearch.initPlaces('<YOUR_PLACES_APP_ID>', '<YOUR_PLACES_API_KEY>');
  
  function updateForm(response) {
    var hits = response.hits;
    var suggestion = hits[0];

    if (suggestion && suggestion.locale_names && suggestion.city) {
      document.querySelector('#reverse-address').value = suggestion.locale_names.default[0] || '';
      document.querySelector('#reverse-town').value = suggestion.city.default[0] || '';
      document.querySelector('#reverse-zip').value = (suggestion.postcode || [])[0] || '';
    }
  }

  var lat, lng;

  var $button = document.querySelector('#reverse-locate-me');
  var $latInput = document.querySelector('#reverse-geo-lat');
  var $lngInput = document.querySelector('#reverse-geo-lng');

  $latInput.addEventListener('change', function(e) {
    try {
      lat = parseFloat(e.target.value);

      if (typeof lat !== 'undefined' && typeof lng !== 'undefined') {
        places.reverse({
          aroundLatLng: lat + ',' + lng,
          hitsPerPage: 1,
        }).then(updateForm);
      }
    } catch (e) {
      lat = undefined;
    }
  });

  $lngInput.addEventListener('change', function(e) {
    try {
      lng = parseFloat(e.target.value);

      if (typeof lat !== 'undefined' && typeof lng !== 'undefined') {
        places.reverse({
          aroundLatLng: lat + ',' + lng,
          hitsPerPage: 1,
        }).then(updateForm);
      }
    } catch (e) {
      lng = undefined;
    }
  });

  $button.addEventListener('click', function() {
    $button.textContent = 'Locating...';

    navigator.geolocation.getCurrentPosition(function(response) {
      var coords = response.coords;
      lat = coords.latitude.toFixed(6);
      lng = coords.longitude.toFixed(6);
      
      $latInput.value = lat;
      $lngInput.value = lng;

      $button.textContent = 'Locate me';
      
      places.reverse({
        aroundLatLng: lat + ',' + lng,
        hitsPerPage: 1
      }).then(updateForm);
    });
  });
})();
</script>
@endsection