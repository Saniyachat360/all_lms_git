<?php
    class pdfexample extends CI_Controller{ 
    function __construct()
    { parent::__construct(); } 
	
	
function index() {
    $this->load->library('Pdf');
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Pdf Example');
    $pdf->SetHeaderMargin(30);
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->Write(5, 'CodeIgniter TCPDF Integration');
    $pdf->Output('pdfexample.pdf', 'I'); }
    }
  
	/* function index()
    {
        $this->load->library('pdf');
        $html = $this->load->view('GeneratePdfView', [], true);
        $this->pdf->createPDF($html, 'mypdf', false);
    }
   


   
   function convertpdf(){


// Load pdf library
        $this->load->library('pdf');
$filename = "generatepdf";

$html = "<table border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <th>Username</th><th>Email</th>
        </tr>
        <tr>
            <td>yssyogesh</td>
            <td>yogesh@makitweb.com</td>
        </tr>
        <tr>
            <td>sonarika</td>
            <td>sonarika@gmail.com</td>
        </tr>
        <tr>
            <td>vishal</td>
            <td>vishal@gmail.com</td>
        </tr>
        </table>";

 $this->pdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
 $this->pdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$this->pdf->render();

// Output the generated PDF to Browser
$this->pdf->stream($filename);








   }
}

*/
	
	
    ?>