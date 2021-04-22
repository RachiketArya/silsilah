@extends('layouts.user-profile')

@section('subtitle', __('user.death'))

@section('user-content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                @can('edit', $user)
                    {{ link_to_route('users.edit', __('app.edit'), [$user->id, 'tab' => 'death'], ['class' => 'pull-right']) }}
                @endcan
                <h3 class="panel-title">{{ __('user.death') }}</h3>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <th>{{ __('address.location_name') }}</th>
                        <td>{{ $user->getMetadata('cemetery_location_name') }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('address.address') }}</th>
                        <td>{{ $user->getMetadata('cemetery_location_address') }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('user.dod') }}</th>
                        <td>{{ $user->dod ?: $user->yod }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('user.age') }}</th>
                        <td>
                            @if ($user->age)
                            {!! $user->age_string !!}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('user.cemetery_location') }}</h3></div>
            <div class="panel-body">
                <div id="mapid"></div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('ext_css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>

<style>
    #mapid { height: 300px; }
</style>
@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>

<script>
    var mapCenter = [{{ $mapCenterLatitude }}, {{ $mapCenterLongitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ $mapZoomLevel }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
</script>
@endsection
