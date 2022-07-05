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
        <button type="button" class="btn btn-danger btn-sm float-right mr-1" onclick="history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
        </button>
      </form>
      <!-- <div id="map"></div> -->
    </div>
  </div>
</div>
<!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-mh8f7L4bNcs5uXEYW-sSJY4vBfxEq0&callback=initMap">
  </script>
<script type="text/javascript">
  let map;
  let infoWindow;
  let mapOptions;
  let bounds;

  function initMap() {
    // infoWindow ini digunakan untuk menampilkan pop-up diatas marker terkait lokasi markernya
    infoWindow = new google.maps.InfoWindow;
    //  Variabel berisi properti tipe peta yang bisa diubah-ubah
    mapOptions = {
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    // Deklarasi untuk melakukan load map Google Maps API
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // Variabel untuk menyimpan batas kordinat
    bounds = new google.maps.LatLngBounds();
    // Pengambilan data dari database MySQL
    <?php
    // Sesuaikan dengan database yang sudah Anda buat diawal
    $query = "SELECT * FROM distributor";
    $stmtq = $db->prepare($query);
    $stmtq->execute();
    while ($rowq = $stmtq->fetch(PDO::FETCH_ASSOC)) {
      $nama = $row["nama"];
      $lat  = $row["lt"];
      $long = $row["lg"];
      echo "addMarker($lat, $long, '$nama');\n";
    }
    ?>
    // Proses membuat marker 
    var location;
    var marker;

    function addMarker(lat, lng, info) {
      location = new google.maps.LatLng(lat, lng);
      bounds.extend(location);
      marker = new google.maps.Marker({
        map: map,
        position: location
      });
      map.fitBounds(bounds);
      bindInfoWindow(marker, map, infoWindow, info);
    }
    // Proses ini dapat menampilkan informasi lokasi Kota/Kab ketika diklik dari masing-masing markernya
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
  }
</script>
/.content -->