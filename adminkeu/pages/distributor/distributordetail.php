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
        <div id="map" style="height: 800px;"></div>
        <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-2" onclick="history.back()">
          <i class="fa fa-arrow-left"></i> Kembali
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  var lt = <?= $row['lt']; ?>;
  var lg = <?= $row['lg']; ?>;
  var nama = "<?= $row['nama']; ?>";

  if (!lt){
    lt = -3.4960839506671517;
  }

  if (!lg){
    lg = 114.81016825291921;
  }
  var map = L.map('map').setView([lt, lg], 13);

  googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(map);

  map.addControl(new L.Control.Fullscreen());

  map.on("click", function(e) {
    const markerPlace = document.querySelector(".marker-position");
    markerPlace.textContent = e.latlng;
  });

  L.marker([lt, lg]).addTo(map)
    .bindPopup(nama)
    .openPopup();
</script>