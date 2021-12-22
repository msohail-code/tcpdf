<?php

if (!class_exists('TCPDF')) {
  require_once(dirname(__FILE__) . '/../../vendor/tecnickcom/tcpdf/tcpdf_autoconfig.php');
}

class MYPDF extends TCPDF
{
  protected $last_page_flag = false;

  public function Close() {
    $this->last_page_flag = true;
    parent::Close();
  }
  public function Footer()
  {
      $template = file_get_contents(dirname(__FILE__) . '/../templates/footer.html');
      $this->writeHTMLCell($w = 235, $h = 0, $x = 5, $y = '220', $template);
  }
  public function Header()
  {
    $this->Image($file = dirname(__FILE__).'/../images/intestazione.jpg', $x = 5, $y = 2, $w = 207, $h = 32, $type = 'JPG', $resize = true, $dpi = 150);
    $template = file_get_contents(dirname(__FILE__) . '/../templates/top_heading.html');
    $this->writeHTMLCell($w = 0, $h = 0, $x = '45', $y = '27', $template);
  }
}
