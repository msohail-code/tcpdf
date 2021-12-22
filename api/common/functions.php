<?php

define('K_TCPDF_PARSER_THROW_EXCEPTION_ERROR', true);
define('K_TCPDF_THROW_EXCEPTION_ERROR', true);
define('K_TCPDF_EXTERNAL_CONFIG', true);
require_once(dirname(__FILE__) . '/../../vendor/tecnickcom/tcpdf/tcpdf_autoconfig.php');


function createPdfObj($useMyPdf = false, $page = 'P')
{
  $pdf = new TCPDF($page, 'mm', 'LETTER');
  $pdf->SetPrintFooter(false);

  if ($useMyPdf) {
    $pdf = new MYPDF($page, 'mm', 'LETTER');
    $pdf->SetPrintFooter(true);
    $pdf->SetPrintHeader(true);
  }
  $pdf->SetAutoPageBreak(TRUE, 50);
  $pdf->SetHeaderMargin(20);
  $pdf->SetFooterMargin(40);

  $pdf->SetTextColor(34, 31, 32);
  
  $pdf->AddPage();

  try {
    $pdf->SetFont($family = 'courier_new', $style = '', $size = 18, '', $out = false);
    $pdf->SetFont($family = 'helvetica', $style = '', $size = 8, '', $out = false);

  } catch (Exception $e) {
    echo json_encode($e);
    exit;
  }
  return $pdf;
}

function createImageHeader(TCPDF $pdf, string $header_html)
{
  $pdf->Image($header_html, 0, 0, 217, 60, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
}

function saveToDisk($pdf, string $filename = null)
{
  $pdf->Output('C:\\xampp\\htdocs\\newpdf\\api\\generated_pdfs\\' . $filename, 'F');
}

function insertVariables(array $data, string $template): string
{
  foreach ($data as $name => $value) {
    if (is_array($value)) continue;
    if (is_object($value)) continue;

    // replacing < and > signs
    $value = preg_replace('/<\$/', '<span>&lt;</span>_$', $value);
    $value = preg_replace('/>\$/', '<span>&gt;</span>_$', $value);
    $value = preg_replace('/_/', '', $value);

    $template = str_replace("{{ $name }}", $value, $template);
  }

  return $template;
}