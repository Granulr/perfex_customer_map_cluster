<?php init_head(); ?>
<div id="wrapper">

  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div class="clearfix"></div>
            <h4><?php echo _l('customer_map_cluster'); ?>
            <hr class="hr-panel-heading">
            <div class="mtop15">
              <div id="clustermap" class="map-responsive" style="height: 500px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
const markersEndpoint = <?php echo json_encode($markers_endpoint); ?>;
let clusterMap = null;
let infoWin = null;
let markerCluster = null;
let markers = [];
let markersRequestSeq = 0;
let idleTimer = null;

function initMap() {
    const mapOptions = {
        zoom: 3,
        center: { lat: 53.729826, lng: -0.560759 },
    };

    clusterMap = new google.maps.Map(document.getElementById('clustermap'), mapOptions);
    infoWin = new google.maps.InfoWindow();

    google.maps.event.addListener(clusterMap, 'idle', function() {
        if (idleTimer) {
            clearTimeout(idleTimer);
        }

        idleTimer = setTimeout(loadMarkersForCurrentBounds, 250);
    });
}

function clearMapMarkers() {
    markers.forEach(function(marker) {
        marker.setMap(null);
    });

    markers = [];

    if (markerCluster && typeof markerCluster.clearMarkers === 'function') {
        markerCluster.clearMarkers();
    }
}

function loadMarkersForCurrentBounds() {
    if (!clusterMap) {
        return;
    }

    const bounds = clusterMap.getBounds();
    if (!bounds) {
        return;
    }

    const ne = bounds.getNorthEast();
    const sw = bounds.getSouthWest();
    const requestSeq = ++markersRequestSeq;

    $.getJSON(markersEndpoint, {
        north: ne.lat(),
        east: ne.lng(),
        south: sw.lat(),
        west: sw.lng(),
    }).done(function(response) {
        if (requestSeq !== markersRequestSeq) {
            return;
        }

        const locations = (response && response.success && Array.isArray(response.data)) ? response.data : [];
        renderMarkers(locations);
    });
}

function renderMarkers(locations) {
    clearMapMarkers();

    locations.forEach(function(location) {
        const lat = Number(location.lat);
        const lng = Number(location.lng);

        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
            return;
        }

        const marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: clusterMap,
        });

        marker.addListener('click', function() {
            infoWin.setContent(location.info || '');
            infoWin.open(clusterMap, marker);
        });

        markers.push(marker);
    });

    if (window.markerClusterer && window.markerClusterer.MarkerClusterer) {
        markerCluster = new window.markerClusterer.MarkerClusterer({ map: clusterMap, markers: markers });
    }
}
</script>
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&callback=initMap&v=weekly" async defer></script>

<?php init_tail(); ?>
</body>
</html>
