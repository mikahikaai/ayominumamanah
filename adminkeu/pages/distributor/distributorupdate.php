<?php
$database = new Database;
$db = $database->getConnection();

if (isset($_POST['button_edit'])) {
  $updatesql = "UPDATE distributor SET nama=?, paket=?, alamat_dropping=?, no_telepon=?, jarak=?, status_keaktifan=?  WHERE id=?";
  $stmt = $db->prepare($updatesql);
  $stmt->bindParam(1, $_POST['nama']);
  $stmt->bindParam(2, $_POST['paket']);
  $stmt->bindParam(3, $_POST['alamat_dropping']);
  $stmt->bindParam(4, $_POST['no_telepon']);
  $stmt->bindParam(5, $_POST['jarak']);
  $stmt->bindParam(6, $_POST['status_keaktifan']);
  $stmt->bindParam(7, $_GET['id']);

  if ($stmt->execute()) {
    $_SESSION['hasil_update'] = true;
    $_SESSION['pesan'] = "Berhasil Mengubah Data";
  } else {
    $_SESSION['hasil_update'] = false;
    $_SESSION['pesan'] = "Gagal Mengubah Data";
  }
  echo '<meta http-equiv="refresh" content="0;url=?page=distributorread"/>';
}

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
          <li class="breadcrumb-item active">Ubah Distributor</li>
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
      <h3 class="card-title">Data Ubah Distributor</h3>
      <a href="?page=distributorread" class="btn btn-danger btn-sm float-right">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>
    </div>
    <div class="card-body">
      <form action="" method="post">
        <div class="form-group">
          <label for="id_da">ID Distributor</label>
          <input type="text" name="id_da" class="form-control" value="<?= $row['id_da']; ?>" style="text-transform: uppercase;" readonly required>
        </div>
        <div class="form-group">
          <label for="nama">Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" value="<?= $row['nama']; ?>" style="text-transform: uppercase;" required>
        </div>
        <div class="form-group">
          <label for="paket">Paket</label>
          <select name="paket" class="form-control" required>
            <option value="">--Pilih Jenis Paket--</option>
            <?php
            $options = array('DISTRIBUTOR', 'SUB DISTRIBUTOR', 'BUKAN SUB/DISTRIBUTOR');
            foreach ($options as $option) {
              $selected = $row['paket'] == $option ? 'selected' : '';
              echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="alamat_dropping">Alamat Dropping</label>
          <input type="text" name="alamat_dropping" class="form-control" value="<?= $row['alamat_dropping']; ?>" style="text-transform: uppercase;" required>
        </div>
        <div class="form-group">
          <label for="no_telepon">No. Telepon</label>
          <input type="text" name="no_telepon" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= $row['no_telepon']; ?>" required>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="jarak">Jarak Dari Pabrik</label>
              <input type="text" name="jarak" class="form-control" onkeypress="return (event.charCode > 47 && event.charCode <58) || event.charCode == 46" min="0" maxlength="14" value="<?= $row['jarak']; ?>" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="status_keaktifan">Status Keaktifan</label>
              <select name="status_keaktifan" class="form-control" required>
                <option value="">--Pilih Status Keaktifan--</option>
                <?php
                $options = array('AKTIF', 'NON AKTIF');
                foreach ($options as $option) {
                  $selected = $row['status_keaktifan'] == $option ? 'selected' : '';
                  echo "<option value=\"" . $option . "\"" . $selected . ">" . $option . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <label for="">Map</label>
        <div class="auto-search-wrapper mb-2">
          <input type="text" autocomplete="off" id="search" class="full-width" placeholder="Ketik nama tempat yang ingin anda cari..." />
        </div>
        <div id="map" style="height: 800px;"></div>
        <div class="marker-position"></div>
        <input type="hidden" id="lat" name="lat">
        <input type="hidden" id="lng" name="lng">
        <a href="?page=distributorread" class="btn btn-danger btn-sm float-right mt-2">
          <i class="fa fa-times"></i> Batal
        </a>
        <button type="submit" name="button_edit" class="btn btn-primary btn-sm float-right mr-1 mt-2">
          <i class="fa fa-save"></i> Ubah
        </button>
      </form>
    </div>
  </div>
</div>
<!-- /.content -->
<script>
  new Autocomplete("search", {
    // default selects the first item in
    // the list of results
    selectFirst: true,

    // The number of characters entered should start searching
    howManyCharacters: 2,

    // onSearch
    onSearch: ({
      currentValue
    }) => {
      // You can also use static files
      // const api = '../static/search.json'
      const api = `https://nominatim.openstreetmap.org/search?format=geojson&limit=10&q=${encodeURI(currentValue)}`;

      /**
       * jquery
       */
      // return $.ajax({
      //     url: api,
      //     method: 'GET',
      //   })
      //   .done(function (data) {
      //     return data
      //   })
      //   .fail(function (xhr) {
      //     console.error(xhr);
      //   });

      // OR -------------------------------

      /**
       * axios
       * If you want to use axios you have to add the
       * axios library to head html
       * https://cdnjs.com/libraries/axios
       */
      // return axios.get(api)
      //   .then((response) => {
      //     return response.data;
      //   })
      //   .catch(error => {
      //     console.log(error);
      //   });

      // OR -------------------------------

      /**
       * Promise
       */
      return new Promise((resolve) => {
        fetch(api)
          .then((response) => response.json())
          .then((data) => {
            resolve(data.features);
          })
          .catch((error) => {
            console.error(error);
          });
      });
    },
    // nominatim GeoJSON format parse this part turns json into the list of
    // records that appears when you type.
    onResults: ({
      currentValue,
      matches,
      template
    }) => {
      const regex = new RegExp(currentValue, "gi");

      // if the result returns 0 we
      // show the no results element
      return matches === 0 ?
        template :
        matches
        .map((element) => {
          return `
          <li class="loupe">
            <p>
              ${element.properties.display_name.replace(
                regex,
                (str) => `<b>${str}</b>`
              )}
            </p>
          </li> `;
        })
        .join("");
    },

    // we add an action to enter or click
    onSubmit: ({
      object
    }) => {
      // remove all layers from the map
      map.eachLayer(function(layer) {
        if (!!layer.toGeoJSON) {
          map.removeLayer(layer);
        }
      });

      const {
        display_name
      } = object.properties;
      const [lng, lat] = object.geometry.coordinates;

      const marker = L.marker([lat, lng], {
        title: display_name,
      });

      marker.addTo(map).bindPopup(display_name);

      map.setView([lat, lng], 16);
    },

    // get index and data from li element after
    // hovering over li with the mouse or using
    // arrow keys ↓ | ↑
    onSelectedItem: ({
      index,
      element,
      object
    }) => {
      console.log("onSelectedItem:", index, element, object);
    },

    // the method presents no results element
    noResults: ({
        currentValue,
        template
      }) =>
      template(`<li>No results found: "${currentValue}"</li>`),
  });

  var lat = <?= $row['lt']; ?>;
  var lng = <?= $row['lg']; ?>;
  var nama = "<?= $row['nama']; ?>";

  if (!lat) {
    lat = -3.4960839506671517;
  }

  if (!lng) {
    lng = 114.81016825291921;
  }

  var map = L.map('map').setView([lat, lng], 18);

  googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
  }).addTo(map);

  var LeafIcon = L.Icon.extend({
    options: {
      iconSize: [38, 38],
      shadowSize: [50, 64],
      iconAnchor: [22, 94],
      shadowAnchor: [4, 62],
      popupAnchor: [-3, -76]
    }
  });

  var greenIcon = new LeafIcon({
    iconUrl: '../images/logooo cropped resized compressed.png',
    // shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
  })

  L.marker([lat, lng]).addTo(map)
    .bindPopup(nama)
    .openPopup().on("click", centered);

  map.addControl(new L.Control.Fullscreen());

  var marker;
  const markerPlace = document.querySelector(".marker-position");
  map.on("click", function(e) {
    if (marker) { // check
      map.removeLayer(marker); // remove
    }
    marker = new L.marker(e.latlng, {
      icon: greenIcon,
      draggable: true,
      autopan: true
    }).bindPopup(nama + " " + "(NEW)").addTo(map).on("click", centered); // set
    marker.on("dragend", function(e) {
      markerPlace.textContent = `${marker.getLatLng().lat}, ${
        marker.getLatLng().lng
      }`;
      document.getElementById('lat').value = marker.getLatLng().lat;
      document.getElementById('lng').value = marker.getLatLng().lng;
    });
    markerPlace.textContent = `${marker.getLatLng().lat}, ${
        marker.getLatLng().lng
      }`;
    document.getElementById('lat').value = marker.getLatLng().lat;
    document.getElementById('lng').value = marker.getLatLng().lng;
  });
  // const marker2 = new L.marker([lat, lng], {
  //     draggable: true,
  //     autoPan: true,
  //   })
  //   .bindPopup(nama)
  //   .addTo(map);

  function centered(e) {
    map.setView(e.target.getLatLng(), 18);
  }




  // dragging the marker
</script>