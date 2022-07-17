<?php

require_once '../../vendor/autoload.php';

ob_start();
include '../../pages/report/reportheader.php';
$header = ob_get_clean();
// ob_end_clean();

ob_start();
include 'reportpengajuanupahdetail-res.php';
$html = ob_get_clean();
// ob_end_clean();

ob_start();
include '../../pages/report/reportfooter.php';
$footer = ob_get_clean();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
  'format' => 'A4-P',
  'margin_top' => '32'
]);

$mpdf->SetHTMLHeader($header);
$mpdf->WriteHTML($html);
$mpdf->SetHTMLFooter($footer);
$mpdf->Output();
