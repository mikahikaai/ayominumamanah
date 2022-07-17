<?php

require_once '../../vendor/autoload.php';

ob_start();
include 'reportheader.php';
$header = ob_get_clean();
// ob_end_clean();

ob_start();
include 'reportpengajuanupahdetail-res.php';
$html = ob_get_clean();
// ob_end_clean();

ob_start();
include 'reportfooter.php';
$footer = ob_get_clean();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
  'format' => 'A4-P'
]);

$mpdf->SetHTMLHeader($header);
$mpdf->WriteHTML($html);
$mpdf->SetHTMLFooter($footer);
$mpdf->Output();