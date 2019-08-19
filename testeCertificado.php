<?php 

    require_once __DIR__ . '/vendor/autoload.php';
    include dirname(__FILE__) . './inc/includes.php';
    
    $html = "
    <html>
    <head>
           <meta charset='UTF-8'>
                   <style type='text/css'>
                           p {
                                   text-align: justify;
                                   line-height: 2.0;
                                   text-indent: 10em;
                                   margin-left: 70px;
                                   margin-right: 70px;
                                   font-size: 20px;
                           }
                   </style>

    <body>
    <fieldset>
    <h1 ALIGN=CENTER>CERTIFICADO DE APRESENTAÇÃO DE TRABALHO</h1>
    <p>
    Nº <strong>0001</strong> - 
    VALOR <strong>R$ 700,00 dassssssssssssssssssssssssssssssss sssssssssssssssssssssssssssssss dsakld lkdsalkmds alksda kmlds alkmdsakmldsalkmdsaklmdsa lkmdsakmlds aklmdsakmlsda lkmsd alkmsd aklmsda lkmsd alkmdsa lkmdsamlksda mlksda mlksda lmkdsa lkmsda kmlsdamkldsa lmkdsa lkmdsa </strong>
    </p>
    </div>
    </body>
    </html>
    ";

    $mpdf=new \Mpdf\Mpdf();
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->AddPage('L');
    //$css = file_get_contents("css/estilo.css");
    //$mpdf->WriteHTML($css,1);
    $mpdf->WriteHTML($html);
	
	
    $nome = 'downloads/certificados/ba3cc83797f797af4ff1.pdf';
     $mpdf->Output($nome,'F');

    
    if (Certificado::adicionarCertificado(23, 2, 1, 'teste.pdf')) {
        echo "OK";
    }
    else echo "NAO";
    