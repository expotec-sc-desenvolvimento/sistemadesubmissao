<?php 

    require_once 'vendor/autoload.php';
    include 'inc/includes.php';
    
    $nome = "<strong>RODRIGO LOPES BARRETO</strong>";
    $trabalho = "<strong>AS AVENTURAS DE UM HOMEM DOIDO</strong>";
    
    $html = "
    <html>
    <head>
        <style>
            .moldura {
                background-image: url('moldura.jpg');
                background-repeat: no-repeat;
                background-size: 100%;
                height: 100%;
                width: 100%;
                border: solid;
            }
            h1 {
                text-align: center;
                margin-top: 140px;
                margin-bottom: 50px;
            }
            p {
                text-align: justify;
                line-height: 2.0;
                text-indent: 10em;
                margin-left: 90px;
                margin-right: 90px;
                font-size: 20px;
            }
        </style>
    </head>

    <body>
        <div class='moldura'>
            <h1>Certificado de Apresentação de Trabalho</h1>
            
            <p>Certificamos para os devidos e fins que $nome apresentou o trabalho entitulado $trabalho no evento</p>
        </div>
    </body>
    </html>
    ";
    
    $mpdfConfig = array(
                    'mode' => 'utf-8', 
                    'format' => 'A4',    // format - A4, for example, default ''
                    'default_font_size' => 0,     // font size - default 0
                    'default_font' => '',    // default font family
                    'margin_top' => 0,    	// 15 margin_left
                    'margin_bottom' => 0,    	// 15 margin_left
                    'margin_left' => 0,    	// 15 margin_left
                    'margin_right' => 0,    	// 15 margin right
                    // 'mgt' => $headerTopMargin,     // 16 margin top
                    // 'mgb' => $footerTopMargin,    	// margin bottom
                    'margin_header' => 0,     // 9 margin header
                    'margin_footer' => 0,     // 9 margin footer
                    'orientation' => 'L'  	// L - landscape, P - portrait
            );

    $mpdf=new \Mpdf\Mpdf($mpdfConfig);
    
   // $mpdf->SetMargins(0, 0, 0);
    
    
    
   // $mpdf->AddPage('L');
    //$css = file_get_contents("css/estilo.css");
    //$mpdf->WriteHTML($css,1);
    $mpdf->WriteHTML($html);
	
	
    
    $mpdf->Output();

    
    exit;
    