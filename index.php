<?php
  session_start();
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<?php include "database/database.php"; ?>
<?php include "partials/head.php"; ?>
<?php include_once "partials/scripts.php"; ?>


<body class="hold-transition sidebar-mini">
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

</html>