@extends('layouts.app')

@section('title', __('imovel.create'))

@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('imovel.create') }}</div>
                
                <form method="POST" action="{{ route('imoveis.store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>{{ __('imovel.tipo') }}</label>
                                <div class="form-check">
                                    <label class="form-check-label" for="tipo_territorial">
                                        <input type="radio" name="tipo" id="tipo_territorial" value="territorial" class="form-check-input form-check-inline" {{ old('tipo') == 'territorial' ? 'checked' : '' }}>
                                        {{ __('Territorial') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="tipo_predial">
                                        <input type="radio" name="tipo" id="tipo_predial" value="predial" class="form-check-input form-check-inline" {{ old('tipo') == 'predial' ? 'checked' : '' }}>
                                        {{ __('Predial') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="seq" class="control-label">{{ __('imovel.seq') }}</label>
                                <input id="seq" type="text" oninput="mascara(this)" class="form-control{{ $errors->has('seq') ? ' é inválido' : '' }}" name="seq" value="{{ old('seq') }}" required>
                                {!! $errors->first('seq', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>

                            <div class="form-group col-md-2">
                                <label for="setor" class="control-label">{{ __('imovel.setor') }}</label>
                                <input id="setor" type="number" class="form-control{{ $errors->has('setor') ? ' é inválido' : '' }}" name="setor" value="{{ old('setor') }}" required>
                                {!! $errors->first('setor', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                            <div class="form-group col-md-2">
                                <label for="quadra" class="control-label">{{ __('imovel.quadra') }}</label>
                                <input id="quadra" type="number" type="text" class="form-control{{ $errors->has('quadra') ? ' é inválido' : '' }}" name="quadra" value="{{ old('quadra') }}" required>
                                {!! $errors->first('quadra', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                            <div class="form-group col-md-2">
                                <label for="lote" class="control-label">{{ __('imovel.lote') }}</label>
                                <input id="lote" type="number" class="form-control{{ $errors->has('lote') ? ' é inválido' : '' }}" name="lote" value="{{ old('lote') }}" required>
                                {!! $errors->first('lote', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <label for="cpf" class="control-label">{{ __('imovel.cpf') }}</label>
                            <input id="cpf" type="text" oninput="mascara(this)" class="form-control{{ $errors->has('cpf') ? ' é inválido' : '' }}" name="cpf" value="{{ old('owner.cpf') }}" required>
                            {!! $errors->first('cpf', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="name_owner" class="control-label">{{ __('imovel.name_owner') }}</label>
                            <input id="name_owner" type="text" class="form-control{{ $errors->has('name_owner') ? ' é inválido' : '' }}" name="name_owner" value="{{ old('owner.name_owner') }}" required>
                            {!! $errors->first('name_owner', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude" class="control-label">{{ __('imovel.latitude') }}</label>
                                    <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' é inválido' : '' }}" name="latitude" value="{{ old('latitude', request('latitude')) }}" required>
                                    {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude" class="control-label">{{ __('imovel.longitude') }}</label>
                                    <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' é inválido' : '' }}" name="longitude" value="{{ old('longitude', request('longitude')) }}" required>
                                    {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="images">{{ __('imovel.images') }}</label>
                            <input id="images" type="file" class="form-control{{ $errors->has('images') ? ' é inválido' : '' }}" name="images[]" multiple>
                            {!! $errors->first('images', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>

                        <div id="mapid"></div>
                        
                    </div>
                    <div class="card-footer">
                        <input type="submit" value="{{ __('imovel.create') }}" class="btn btn-success">
                        <a href="{{ route('imoveis.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
  

@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin=""/>

    <style>
        #mapid { height: 300px; }
    </style>
@endsection

@push('scripts')

   
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
    integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
    crossorigin=""></script>
    <script>
        var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }}, {{ request('longitude', config('leaflet.map_center_longitude')) }}];
        var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

        L.tileLayer('https://api.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Imagery &copy; <a href="http://mapbox.com">Mapbox</a>',
            id: 'mapbox.satellite',
            accessToken: 'pk.eyJ1Ijoia2VsbDA0IiwiYSI6ImNsZG5pYmdzOTAxeDYzcXFyZHJoNHlzNmUifQ.Qb2-srEYdNcn0NuLksaNLA',
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);
        function updateMarker(lat, lng) {
            marker
            .setLatLng([lat, lng])
            .bindPopup("Localização:  " + marker.getLatLng().toString())
            .openPopup();
            return false;
        };

        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            updateMarker(latitude, longitude);
        });

        var updateMarkerByInputs = function() {
            return updateMarker( $('#latitude').val() , $('#longitude').val());
        }
        $('#latitude').on('input', updateMarkerByInputs);
        $('#longitude').on('input', updateMarkerByInputs);


        //Aplica a máscara de seq e CPF no campo de input

        function mascara(i) {
            var v = i.value;

            if (isNaN(v[v.length - 1])) {
                i.value = v.substring(0, v.length - 1);
                return;
            }

            if (i.id === 'cpf') {
                i.setAttribute('maxlength', '14');
                if (v.length === 3 || v.length === 7) {
                    i.value += '.';
                }
                if (v.length === 11) {
                    i.value += '-';
                }
            } else if (i.id === 'seq') {
                i.setAttribute('maxlength', '9');
                if (v.length === 7) {
                    i.value += '.';
                }
                if (v.length === 8) {
                    i.value += '';
                }
            }
        }

    </script>
@endpush
