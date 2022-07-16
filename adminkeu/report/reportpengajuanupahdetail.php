<?php

require_once '../../vendor/autoload.php';

ob_start();
include 'reportpengajuanupahdetail-res.php';
$content = ob_get_clean();

$mpdf = new \Mpdf\Mpdf([
  'format' => 'A4-P'
]);
$mpdf->WriteHTML($content);
$mpdf->Output();
