<?php include_once "../partials/cssdatatables.php" ?>
<?php
$database = new Database;
$db = $database->getConnection();

include '../plugins/phpqrcode/qrlib.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../plugins/php-mailer/src/Exception.php';
require '../plugins/php-mailer/src/PHPMailer.php';
require '../plugins/php-mailer/src/SMTP.php';

if (isset($_GET['acc_code'])) {
  $selectSql = "SELECT d.*, u.*, p.*, k.*, p.id id_pengajuan_upah FROM pengajuan_upah_borongan p
  INNER JOIN gaji u ON p.id_upah = u.id
  INNER JOIN distribusi d ON d.id = u.id_distribusi
  INNER JOIN karyawan k ON k.id = u.id_pengirim
  WHERE acc_code=? AND terbayar='1'";
  $stmt = $db->prepare($selectSql);
  $stmt->bindParam(1, $_GET['acc_code']);
  $stmt->execute();
}

if (isset($_POST['verif'])) {
  if (!empty($_POST['cid'])) {
    $checkbox_id_pengajuan_upah = $_POST['cid'];

    $id_qr_code = uniqid();
    $text_qrcode = "http://" . "adisasoftwaredev.com" . "/verify.php?code=$id_qr_code";
    $tempdir = "../dist/verif/";
    $namafile = $id_qr_code . ".png";
    $quality = "H";
    $ukuran = 10;
    $padding = 2;

    QRcode::png($text_qrcode, $tempdir . $namafile, $quality, $ukuran, $padding);

    $acc_code = uniqid();

    for ($i = 0; $i < sizeof($checkbox_id_pengajuan_upah); $i++) {
      $updateSql = "UPDATE pengajuan_upah_borongan SET terbayar='2', tgl_verifikasi=?, id_verifikator=?, acc_code=?, qrcode=? WHERE id=?";
      $tgl_verifikasi = date('Y-m-d');
      $stmt_update = $db->prepare($updateSql);
      $stmt_update->bindParam(1, $tgl_verifikasi);
      $stmt_update->bindParam(2, $_SESSION['id']);
      $stmt_update->bindParam(3, $acc_code);
      $stmt_update->bindParam(4, $id_qr_code);
      $stmt_update->bindParam(5, $checkbox_id_pengajuan_upah[$i]);
      $stmt_update->execute();
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $emailTo = $row["email"]; //email kamu atau email penerima link reset

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    try {
      //Server settings
      //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = "mikahikaai100@gmail.com";             // SMTP username
      $mail->Password = 'sorydvrpfvncnxmc';                         // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom("admin@gmail.com", "Admin PKS"); //email pengirim
      $mail->addAddress($emailTo); // Email penerima
      $mail->addReplyTo("no-reply@gmail.com");

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = "Pemberitahuan Verifikasi Upah";
      $mail->Body    = "<h1>Penganjuan upah Anda dengan No. " . $row['no_pengajuan'] . " telah terverifikasi</h1><p> Silahkan ambil upah Anda diloket pengambilan upah</p>";
      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $mail->send();
    } catch (Exception $e) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    $sukses = true;

    if ($sukses) {
      $_SESSION['hasil_verifikasi_upah'] = true;
    } else {
      $_SESSION['hasil_verifikasi_upah'] = false;
    }

    echo '<meta http-equiv="refresh" content="0;url=?page=pengajuanupah"/>';
    exit;
  }
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pengajuan Upah</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
          <li class="breadcrumb-item"><a href="?page=pengajuanupah">Verifikasi Upah</a></li>
          <li class="breadcrumb-item active">Detail Pengajuan Upah</li>
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
      <h3 class="card-title">Data Detail Upah Belum Terbayar</h3>
      <!-- <a href="export/penggajianrekap-pdf.php" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Export PDF
      </a> -->
    </div>
    <form action="" method="post">
      <div class="card-body">
        <table id="mytable" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th><input type="checkbox" name="selectAll" id="selectAll"></th>
              <th>No.</th>
              <th>Tanggal & Jam Berangkat</th>
              <th>No Perjalanan</th>
              <th>Nama</th>
              <th>Upah</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $no = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <tr>
                <td><input type="checkbox" name="cid[]" value="<?= $row['id_pengajuan_upah']; ?>"></td>
                <td><?= $no++ ?></td>
                <td><?= tanggal_indo($row['jam_berangkat']) ?></td>
                <td><a href="?page=detaildistribusi&id=<?= $row['id_distribusi'] ?>"><?= $row['no_perjalanan'] ?></a></td>
                <td><?= $row['nama'] ?></td>
                <td style="text-align: right;"><?= 'Rp. ' . number_format($row['upah'], 0, ',', '.') ?></td>
              </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" style="text-align: center; font-weight: bold;">TOTAL</td>
              <td style="text-align: right; font-weight: bold;"></td>
            </tr>
          </tfoot>
        </table>
        <button type="button" class="btn btn-sm mt-2 btn-danger float-right" onclick="history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
        <button type="submit" name="verif" class="btn btn-sm float-right btn-success mt-2 mr-1"><i class="fa fa-check"></i> Verifikasi</button>
    </form>
  </div>
</div>
</div>
<!-- /.content -->
<?php
include_once "../partials/scriptdatatables.php";
?>
<script>
  $(function() {
    $('#selectAll').click(function(e) {
      $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#mytable').DataTable({
      footerCallback: function(row, data, start, end, display) {
        var api = this.api();

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ? i.replace(/[^0-9]+/g, "") * 1 : typeof i === 'number' ? i : 0;
        };

        // Total over all pages
        nb_cols = api.columns().nodes().length;
        var j = 5;
        while (j < nb_cols) {
          total = api
            .column(j)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);
          $(api.column(j).footer()).html('Rp. ' + total.toLocaleString('id-ID'));
          j++
        }
        // Total over this page
        // pageTotal = api
        //   .column(4, {
        //     page: 'current'
        //   })
        //   .data()
        //   .reduce(function(a, b) {
        //     return intVal(a) + intVal(b);
        //   }, 0);

        // Update footer
        // $(api.column(j).footer()).html('Rp. ' + total.toLocaleString('id-ID'));
      },
      "columnDefs": [{
        "orderable": false,
        "targets": [0]
      }]
    });
  });
</script>