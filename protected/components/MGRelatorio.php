<?php

Yii::import('application.vendors.html2pdf.*');

require_once('html2pdf.class.php');

class MGRelatorio
{
	
	public $html;
	
	public function __construct()
	{
	}

	public function getPDF()
	{
		//$html2pdf = new HTML2PDF('P','A4','pt', true, 'UTF-8', array(1, 1, 1, 1));
		//$html2pdf = new HTML2PDF('P','A4','fr');
		//$html2pdf = new HTML2PDF('P','A4','pt', false, 'ISO-8859-15', array("6", "6", "6", "10")); 

		$html2pdf = new HTML2PDF('P','A4','pt');
		$html2pdf->WriteHTML($this->html);
		$html2pdf->Output('exemple.pdf');
	}
	
}