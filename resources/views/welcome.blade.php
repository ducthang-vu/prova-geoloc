@extends('layouts.main')
@section('content')
    <div id="noAppJs"></div>
    @dump($users)
    <ul>
        @foreach ($users as $user)
            <li>
                {{ $loop->index }}
                {{ $user->name }}
                {{ $user->latlong }}
                @php
                    preg_match_all("(-?\d+.\d{6})", $user->latlong, $matches);
                    var_dump($matches);
                    var_dump((float) $matches[0][1]);
                    echo (float) $matches[0][1];
                @endphp
            </li>
        @endforeach
    </ul>
@endsection
