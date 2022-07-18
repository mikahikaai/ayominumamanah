<?php

require_once '../../vendor/autoload.php';

ob_start();
include '../../pages/report/reportheader.php';
$header = ob_get_clean();
// ob_end_clean();

ob_start();
include 'reportrekapinsentifdetail-res.php';
$html = ob_get_clean();
// ob_end_clean();

ob_start();
include '../../pages/report/reportfooter.php';
$footer = ob_get_clean();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
  'format' => 'A4-L',
  'margin_top' => '32',
  'margin_bottom' => '30'
]);

$mpdf->SetTitle('Amanah | Cetak Rekap Insentif Per Karyawan');
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);
$mpdf->WriteHTML($html);
$mpdf->Output('Rekap Insentif Per Karyawan.pdf', 'I');
