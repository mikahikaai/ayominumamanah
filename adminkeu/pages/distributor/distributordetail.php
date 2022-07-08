<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_GET['id'])) {
  $selectsql = "SELECT * FROM distributor where id=?";
  $stmt = $db->prepare($selectsql);
  $stmt->bindParam(1, $_GET['id']);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Distributor</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item"><a href="?page=distributorread">Distributor</a></li>
          <li class="breadcrumb-item active">Detail Distributor</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Data Detail Distributor</h3>
    </div>
    <div class="card-body">
      <form action="" method="post">
        <div class="form-group">
          <label for="id_da">ID Distributor</label>
          <input type="text" class="form-control" value="<?= $row['id_da']; ?>" style="text-transform: uppercase;" readonly>
        </div>
        <div class="form-group">
          <label for="nama">Nama Lengkap</label>
          <input type="text" class="form-control" value="<?= $row['nama']; ?>" style="text-transform: uppercase;" readonly>
        </div>
        <div class="form-group">
          <label for="paket">Paket</label>
          <input type="text" class="form-control" value="<?= $row['paket']; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="alamat_dropping">Alamat Dropping</label>
          <input type="text" class="form-control" value="<?= $row['alamat_dropping']; ?>" style="text-transform: uppercase;" readonly>
        </div>
        <div class="form-group">
          <label for="no_telepon">No. Telepon</label>
          <input type="text" class="form-control" value="<?= $row['no_telepon']; ?>" readonly>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="jarak">Jarak Dari Pabrik</label>
              <input type="text" class="form-control" value="<?= $row['jarak']; ?>" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="status_keaktifan">Status Keaktifan</label>
              <input type="text" class="form-control" value="<?= $row['status_keaktifan']; ?>" readonly>
            </div>
          </div>
        </div>
        <label for="">Map</label>
        <div id="map"></div>
        <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-2" onclick="history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  var lat = <?= $row['lat']; ?>;
  var lng = <?= $row['lng']; ?>;
  var nama = "<?= $row['nama']; ?>";

  if (!lat) {
    lat = -3.4960839506671517;
    nama = "Pabrik Air Minum Amanah";
  }

  if (!lng) {
    lng = 114.81016825291921;
  }
  var map = L.map('map', {
    zoomControl: false,
    center: [lat, lng],
    zoom: 18,
    gestureHandling: true,
    gestureHandlingOptions: {
      text: {
        touch: "Gunakan 2 jari untuk menggeser map",
        scroll: "Gunakan Ctrl + Scroll untuk memperbesar map",
        scrollMac: "Gunakan \u2318 + scroll untuk memperbesar map"
      },
      duration: 1000
    }
  });

  var LeafIcon = L.Icon.extend({
    options: {
      iconSize: [38, 38],
      shadowSize: [50, 64],
      iconAnchor: [22, 45],
      shadowAnchor: [4, 62],
      popupAnchor: [-3, -45]
    }
  });

  var zoomHome = L.Control.zoomHome();
  zoomHome.addTo(map);

  var greenIcon = new LeafIcon({
    iconUrl: '../images/logooo cropped resized compressed.png',
    // shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
  })

  googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
  }).addTo(map);

  map.addControl(new L.Control.Fullscreen());

  var routeControl = L.Routing.control({
    waypoints: [
      L.latLng(lat, lng),
      L.latLng(-3.4960839506671517, 114.81016825291921)
    ]
  }).addTo(map);

  routeControl.on('routesfound', function(e) {
    var routes = e.routes;
    var summary = routes[0].summary;
    // alert time and distance in km and minutes
    alert('Total distance is ' + summary.totalDistance / 1000 + ' km and total time is ' + Math.round(summary.totalTime % 3600 / 60) + ' minutes');
  });

  L.marker([lat, lng], {
      icon: greenIcon,
    }).addTo(map)
    .bindPopup(nama)
    .openPopup().on("click", centered);;

  function centered(e) {
    map.setView(e.target.getLatLng(), 18);
  }
</script>