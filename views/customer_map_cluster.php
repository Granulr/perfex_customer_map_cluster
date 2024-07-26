<?php init_head(); ?>
<style>

</style>
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
function initMap() {
    const mapOptions = {
        zoom: 3,
        center: {lat: 53.729826, lng: -0.560759}
    };

    const map = new google.maps.Map(document.getElementById('clustermap'), mapOptions);
    const infoWin = new google.maps.InfoWindow();
    const markers = locations.map(function(location) {
        const marker = new google.maps.Marker({
            position: location,
            map: map
        });
        marker.addListener('click', function() {
            infoWin.setContent(location.info);
            infoWin.open(map, marker);
        });
        return marker;
    });

    new MarkerClusterer(map, markers, { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' });
}

var locations = <?php echo $cluster; ?>;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&callback=initMap&libraries=places" async defer></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

<?php init_tail(); ?>
</body>
</html>
