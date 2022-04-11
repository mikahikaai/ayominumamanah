<?php
session_start();
$host = $_SERVER['REQUEST_URI'];
// die();
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<?php
include "database/database.php";
$title = '';
include "partials/head.php";
include_once "partials/scripts.php";
?>
<style>
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background-color: #343A40;
  }

  .preloader .loading {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  #preloader {
    font-weight: 800;
    font-size: larger;
    color: lightblue;
    display: flex;
    justify-content: center;
  }
</style>

<body class="hold-transition sidebar-mini">
  <?php

  if ($host == '/') {
  ?>
    <div class="preloader">
      <div class="loading">
        <img src="./images/hampirsampaicompressed.gif"><br>
        <p id="preloader">. . .Hampir sampai. . .</p>
      </div>
    </div>
  <?php } ?>

  <div class="wrapper">
    <?php include "partials/nav.php"; ?>
    <?php include "partials/sidebar.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php include "routes.php"; ?>
    </div>
    <!-- /.content-wrapper -->

    <?php include "partials/control.php"; ?>
    <?php include "partials/footer.php"; ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
</body>

<script src="plugins/tempusdominus-bootstrap-4/js/jQuery-provider.min.js"></script>


<script>
  // new tempusDominus.TempusDominus(document.getElementById('datetimepicker1'));
  $("title").html("Amanah | <?= $title ?>");
  $(document).ready(function() {
    $('#datetimepicker1Input').tempusDominus({
      useCurrent : true
    });
    $(".preloader").delay(5000).fadeOut();
    var title = '<?= $title; ?>';
    if (title == "Home") {
      $("a#home").addClass("active");
    } else if (title == "Armada") {
      $("a#armada").addClass("active");
      $("li#master_data").addClass("menu-open");
      $("a#link_master_data").addClass("active");
    } else if (title == "Karyawan") {
      $("a#karyawan").addClass("active");
      $("li#master_data").addClass("menu-open");
      $("a#link_master_data").addClass("active");
    } else if (title == "Distributor") {
      $("a#distributor").addClass("active");
      $("li#master_data").addClass("menu-open");
      $("a#link_master_data").addClass("active");
    } else if (title == "Distribusi") {
      $("a#distribusi").addClass("active");
      $("li#master_data").addClass("menu-open");
      $("a#link_master_data").addClass("active");
    }
  });
</script>

</html>