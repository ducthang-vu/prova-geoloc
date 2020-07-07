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
    
@endsection