@extends('layouts.app')

@section('content')
<div class="card">
    
    <div class="card-body" id="mapid"></div>

    <footer>
        <div>
          Clique no mapa para adicionar a localização do imóvel
        </div>
      </footer>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-GEtoDpZ/eLlRZHbBc+85r+I1pBKb+D4vPdKX9C4vhJf3Z3z3v2tL5hJ+tG17tVcWAF+uG7fX9BNQrb2Jz0ZD1g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="css/stilo.css">

<style>
    #mapid { min-height: 500px; }
</style>
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>


<script>

  var map = L.map('mapid').setView([{{ config('leaflet.map_center_latitude') }}, 
                                      {{ config('leaflet.map_center_longitude') }}], 
                                      {{ config('leaflet.zoom_level') }});

    
  L.tileLayer('https://api.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
  attribution: 'Imagery &copy; <a href="http://mapbox.com">Mapbox</a>',
  id: 'mapbox.satellite',
  accessToken: 'pk.eyJ1Ijoia2VsbDA0IiwiYSI6ImNsZG5pYmdzOTAxeDYzcXFyZHJoNHlzNmUifQ.Qb2-srEYdNcn0NuLksaNLA',
  }).addTo(map);

    // create custom button
  const customControl = L.Control.extend({
  // button position
    options: {
    position: "topleft",
    className: "locate-button leaflet-bar",
    html: '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0 0 13 3.06V1h-2v2.06A8.994 8.994 0 0 0 3.06 11H1v2h2.06A8.994 8.994 0 0 0 11 20.94V23h2v-2.06A8.994 8.994 0 0 0 20.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/></svg>',
    style: "margin-top: 0; left: 0; display: flex; cursor: pointer; justify-content: center; font-size: 2rem;",
  },

  // method
  onAdd: function (map) {
    this._map = map;
    const button = L.DomUtil.create("div");
    L.DomEvent.disableClickPropagation(button);

    button.title = "Localização";
    button.innerHTML = this.options.html;
    button.className = this.options.className;
    button.setAttribute("style", this.options.style);

    L.DomEvent.on(button, "click", this._clicked, this);

    return button;
  },
  _clicked: function (e) {
    L.DomEvent.stopPropagation(e);

    // this.removeLocate();

    this._checkLocate();

    return;
  },
  _checkLocate: function () {
    return this._locateMap();
  },

  _locateMap: function () {
    const locateActive = document.querySelector(".locate-button");
    const locate = locateActive.classList.contains("locate-active");
    // add/remove class from locate button
    locateActive.classList[locate ? "remove" : "add"]("locate-active");

    // remove class from button
    // and stop watching location
    if (locate) {
      this.removeLocate();
      this._map.stopLocate();
      return;
    }

    // location on found
    this._map.on("locationfound", this.onLocationFound, this);
    // locataion on error
    this._map.on("locationerror", this.onLocationError, this);

    // start locate
    this._map.locate({ setView: true, enableHighAccuracy: true });
  },
  onLocationFound: function (e) {
    // add circle
    this.addCircle(e).addTo(this.featureGroup()).addTo(map);

    // add marker
    this.addMarker(e).addTo(this.featureGroup()).addTo(map);

    // add legend
  },
  // on location error
  onLocationError: function (e) {
    this.addLegend("Acesso negado ao local.");
  },
  // feature group
  featureGroup: function () {
    return new L.FeatureGroup();
  },
  // add legend
  addLegend: function (text) {
    const checkIfDescriotnExist = document.querySelector(".description");

    if (checkIfDescriotnExist) {
      checkIfDescriotnExist.textContent = text;
      return;
    }

    const legend = L.control({ position: "bottomleft" });

    legend.onAdd = function () {
      let div = L.DomUtil.create("div", "description");
      L.DomEvent.disableClickPropagation(div);
      const textInfo = text;
      div.insertAdjacentHTML("beforeend", textInfo);
      return div;
    };
    legend.addTo(this._map);
  },
  addCircle: function ({ accuracy, latitude, longitude }) {
    return L.circle([latitude, longitude], accuracy / 2, {
      className: "circle-test",
      weight: 2,
      stroke: false,
      fillColor: "#136aec",
      fillOpacity: 0.15,
    });
  },
  addMarker: function ({ latitude, longitude }) {
    return L.marker([latitude, longitude], {
      icon: L.divIcon({
        className: "located-animation",
        iconSize: L.point(17, 17),
        popupAnchor: [0, -15],
      }),
    }).bindPopup("Você está aqui :)");
  },
  removeLocate: function () {
    this._map.eachLayer(function (layer) {
      if (layer instanceof L.Marker) {
        const { icon } = layer.options;
        if (icon?.options.className === "located-animation") {
          map.removeLayer(layer);
        }
      }
      if (layer instanceof L.Circle) {
        if (layer.options.className === "circle-test") {
          map.removeLayer(layer);
        }
      }
    });
  },
});


    map.addControl(new customControl());
    var markers = L.markerClusterGroup();
       
    axios.get('{{ route('api.imoveis.index') }}')
    .then(function (response) {
        var marker = L.geoJSON(response.data, {
            pointToLayer: function(geoJsonPoint, latlng) {
              var setor = geoJsonPoint.properties.setor; // obtém o setor de imóvel a partir do campo "setor"
              var iconUrl = 'img/marcador-de-mapa'; // define o ícone padrão
            
            // define o ícone com base no setor de imóvel
            switch (setor) {
                case '1':
                    iconUrl = 'img/s1.png';
                    break;
                case '2':
                    iconUrl = 'img/s2.png';
                    break;
                case '3':
                    iconUrl = 'img/s2.png';
                    break;
                 case '4':
                    iconUrl = 'img/s4.png';
                    break;
                case '5':
                    iconUrl = 'img/s5.png';
                    break;
                case '6':
                    iconUrl = 'img/s6.png';
                    break;
                case '7':
                    iconUrl = 'img/s7.png';
                    break;
                
                // adicione mais casos para cada setor de imóvel
            }
            
            var icon = L.icon({
                iconUrl: iconUrl,
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });
            
               return L.marker(latlng, {icon: icon}).bindPopup(function (layer) {
                    return layer.feature.properties.map_popup_content;
                });
            }
        });
        markers.addLayer(marker);
    })

   

    .catch(function (error) {
        console.log(error);
    });
    map.addLayer(markers);
    
  @can('create', new App\Imovel)
    var theMarker;

    
    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);

        if (theMarker != undefined) {
            map.removeLayer(theMarker);
        };

        var popupContent = "<center></center>";
        popupContent += '<center><a class="btn-link-1" href="{{ route('imoveis.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Adicionar novo lote</a></center>';
        theMarker = L.marker([latitude, longitude]).addTo(map);
        theMarker.bindPopup(popupContent)
        .openPopup();
    });

    
  @endcan
  </script>
@endpush
