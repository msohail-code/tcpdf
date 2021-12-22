<?php
require_once __DIR__ . '/common/init.php';
require_once __DIR__ . '/common/MyPdf.php';

$pdf = createPdfObj($useMyPdf = true);
// The starting X point for all page content

// ------------------------------------------------------------
// PAGE 1
$x = '8';
$template = file_get_contents(dirname(__FILE__) . '/templates/page_1.html');
$pdf->writeHTMLCell($w = 0, $h = 0, $x = $x, $y = '35', $template);

$x = '105';
$template = file_get_contents(dirname(__FILE__) . '/templates/page_1_table.html');
// add customer information inform on HTML
$dynamic_data['customer_information'] = '<span> <br>shahzad </span><br>hussain<br>Adress thing here<br>';
// Description
$dynamic_data['address_information'] = '<span>TOFFALETTI CONSTRUZAIONO GENERALI S.R.L<br><br>VIA MARCONI, 21 <br> 37042 CALDIERO (VR) <br/> P.IVA: 04319840239 <br/>C.P.:</span>';
$template = insertVariables($dynamic_data, $template);
$pdf->writeHTMLCell($w = 0, $h = 0, $x = $x, $y = '37', $template);

// tipo documento
$x = '8';
$template = file_get_contents(dirname(__FILE__) . '/templates/page_1_static_area.html');
$data_descr['inform'] = 'Documento di Transporto';
$data_descr['count'] = '2158';
$template = insertVariables($data_descr, $template);
$pdf->writeHTMLCell($w = 0, $h = 0, $x = $x, $y = '80', $template);

// details
$x = '8';
$template2 = array();
$template2[] = file_get_contents(dirname(__FILE__) . '/templates/product_det_heading.html');

for($i = 0; $i < 10; $i++){
	$data_descr['artico'] = 'FC'.$i;
	$data_descr['descrizione'] = 'FERo sadlhsdfsaiudfh sadhfjksdf asdkljf djskafh jhdsfjh asdjlkfhasjdhfjksdafjhadsf sad fj sdhafg'.$i;
	$data_descr['um'] = 'KG'.$i;
	$data_descr['quantita'] = '6400-'.$i;
	$data_descr['importo'] = '6400-'.$i;
	$template = file_get_contents(dirname(__FILE__) . '/templates/product_dynamic.html');
	$template2[] = insertVariables($data_descr, $template);
}

$template = implode(" ",$template2);
$pdf->writeHTMLCell($w = 235, $h = 0, $x = $x, $y = '104', $template);

// ------------------------------------------------------------
// Save and send
$filename = 'New Pdf.pdf';
saveToDisk($pdf, $filename);