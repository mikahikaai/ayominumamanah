<?php
session_start();
if (!isset($_SESSION['jabatan'])) {
  echo '<meta http-equiv="refresh" content="0;url=/login.php">';
  die();
} else {
  if ($_SESSION['jabatan'] == "ADMINKEU") {
    echo '<meta http-equiv="refresh" content="0;url=adminkeu/"/>';
    die();
  } else if ($_SESSION['jabatan'] == "SPVDISTRIBUSI") {
    echo '<meta http-equiv="refresh" content="0;url=spvdist/"/>';
    die();
  } else if ($_SESSION['jabatan'] == "MGRDISTRIBUSI") {
    echo '<meta http-equiv="refresh" content="0;url=mgrdist/"/>';
    die();
  } else if ($_SESSION['jabatan'] == "DRIVER" || $_SESSION['jabatan'] == "HELPER") {
    echo '<meta http-equiv="refresh" content="0;url=karyawan/"/>';
    die();
  }
}