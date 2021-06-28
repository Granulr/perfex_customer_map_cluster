<?php init_head(); ?>
<style>
#clustermap {
    height: 100%;
}
.map-responsive{
    overflow:hidden;
    padding-bottom:56.25%;
    position:relative;
    height:0;
}
.map-responsive iframe{
    left:0;
    top:0;
    height:100%;
    width:100%;
    position:absolute;
}
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
              <div id="clustermap" class="map-responsive"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&callback=initMap"></script>
<script>
  function initMap() {
    var map = new google.maps.Map(document.getElementById('clustermap'), {
      zoom: 2,
      center: {lat: 53.729826, lng: -0.560759}
    });

    var infoWin = new google.maps.InfoWindow();
    // Add some markers to the map.
    // Note: The code uses the JavaScript Array.prototype.map() method to
      // create an array of markers based on a given "locations" array.
      // The map() method here has nothing to do with the Google Maps API.
      var markers = locations.map(function(location, i) {
        var marker = new google.maps.Marker({
          position: location
        });
        google.maps.event.addListener(marker, 'click', function(evt) {
          infoWin.setContent(location.info);
          infoWin.open(map, marker);
        })
        return marker;
      });

    // Add a marker clusterer to manage the markers.
    var markerCluster = new MarkerClusterer(map, markers,
        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
  }

  var locations = <?php echo $cluster; ?>
</script>

<?php init_tail(); ?>
</body>
</html>
