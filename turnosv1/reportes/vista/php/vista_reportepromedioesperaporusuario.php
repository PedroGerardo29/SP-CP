<?php
error_reporting(\E_ERROR);
include_once '../../../configuracion/configuracion.php';
include_once '../../../configuracion/conexionlogin.php';
include_once '../../../seguridades/modelo/php/modelo.php';
$validar = new Usuario();
if (!$validar->VerificarLogin()) {
   echo "Usted no se encuentra logueado en el sistema por lo tanto no tiene permisos para generar este reportes.";
    exit;
}
if (isset($_GET['fecini']) && isset($_GET['fecfin']) && isset($_GET['personal']) && isset($_GET['tipo'])) {
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once('../../../reportes/modelo/php/modelo.php');
    $vista = new Reporte();
    $vista->setUsuario($_GET['personal']);
    $vista->setFechaFin($_GET['fecfin']);
    $vista->setFechaInicio($_GET['fecini']);
    $cuereporte = json_decode($vista->GenerarReporteTiempoPromedioEsperaPorUsuarios());
    if ($_GET['tipo'] == 'pdf') {
        require_once '../../../includes/0.12-rc14/src/Cezpdf.php';
        $pdf = new Cezpdf('a4', 'landscape');
        $pdf->selectFont('fonts/Helvetica.afm');
        $configuracion = $pdf->openObject();
        $pdf->ezSetCmMargins(2.5, 2.5, 3, 3);
        $pdf->addPngFromFile("../../../includes/img/logoinstitucion.png", 85, 475, 70, 70);
        $pdf->ezText("<strong>" . strtoupper($_SESSION['PAR_NOMINS']) . "\n</strong>", 13, array('justification' => 'center'));
        $pdf->ezText("<strong>" . $_SESSION['PAR_UBIINS'] . "\n</strong>", 12, array('justification' => 'center'));
        $pdf->line(80, 475, 770, 475);
        $pdf->line(80, 115, 770, 115);
        $pdf->ezSetY(110);
        $pdf->ezText("Dirección:" . $_SESSION['PAR_DIRINS'], 8, array("justification" => "left"));
        $pdf->ezText("Teléfono: " . $_SESSION['PAR_TELINS'], 8, array("justification" => "left"));
        $pdf->ezText("E-mail: " . strtolower($_SESSION['PAR_EMAINS']), 8, array("justification" => "left"));
        $pdf->ezText("Sitio Web: " . $_SESSION['PAR_WEBINS'], 8, array("justification" => "left"));
        $pdf->ezStartPageNumbers(765, 105, 8, 'right', '{PAGENUM} de {TOTALPAGENUM}');
        $datacreator = array(
            'Title' => $_SESSION['PAR_NOMINS'],
            'Subject' => 'REPORTE DE TIEMPO PROMEDIO DE ESPERA  POR USUARIOS',
            'Author' => $_SESSION['PAR_NOMINS'],
            'Producer' => $_SESSION['PAR_NOMINS']
        );
        $pdf->ezSetY(715);
        $pdf->addInfo($datacreator);
        date_default_timezone_set("America/Bogota");
        $pdf->closeObject();
        $pdf->addObject($configuracion, "all");
        $pdf->ezSetCmMargins(4.5, 4.5, 3, 3);
        $pdf->ezText("<strong>REPORTE DE TIEMPO PROMEDIO DE ESPERA  POR USUARIOS\n</strong>", 13, array('justification' => 'center'));
        if (count($cuereporte) == 0) {
            $pdf->ezText("<strong>NO SE ENCONTRARON REGISTROS\n</strong>", 12, array('justification' => 'left'));
        } else {
            for ($y = 0; $y < count($cuereporte); $y++) {
                $data[$y] = array(
                    'nombres' => $cuereporte[$y]->apellidos . " " . $cuereporte[$y]->nombres,
                    'fecha' => $cuereporte[$y]->fecha,
                    'turnos' => $cuereporte[$y]->turnos,
                    'promedio' => substr($cuereporte[$y]->promedio, 0, 8)
                );
            }
            $cols = array(
                'nombres' => "<strong>NOMBRE</strong>",
                'fecha' => "<strong>FECHA</strong>",
                'turnos' => "<strong>TURNOS</strong>",
                'promedio' => "<strong>TIEMPO PROMEDIO</strong>"
            );
            $coloptions = array(
                'nombres' => array(
                    'justification' => 'left',
                    'width' => '400'),
                'fecha' => array(
                    'justification' => 'center',
                    'width' => '70',
                ),
                'turnos' => array(
                    'justification' => 'center',
                    'width' => '60',
                ),
                'promedio' => array(
                    'justification' => 'center',
                    'width' => '110',
                )
            );
            $pdf->ezTable($data, $cols, '', array(
                'justification' => 'right',
                'xOrientation' => 'center',
                'width' => 640,
                'showHeadings' => 3,
                'shaded' => 0,
                'gridlines' => 31,
                'cols' => $coloptions)
            );
        }
        $stream_options = array(
            'Content-Disposition' => 'REPORTE_DE_TIEMPO_PROMEDIO_ESPERA_POR_USUARIOS_' . date("d/m/y") . '_' . rand(0, 10000) . '.pdf',
            'compress' => 1,
        );
        ob_end_clean();
        $pdf->ezStream($stream_options);
    } else if ($_GET['tipo'] == 'excel') {
        require_once '../../../includes/PHPExcel-1.8/PHPExcel-1.8/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                ->setCreator($_SESSION['nombre'] . ' ' . $_SESSION['apellido'])
                ->setLastModifiedBy($_SESSION['nombre'] . ' ' . $_SESSION['apellido'])
                ->setTitle("Reporte Tiempo Espera Por Usuarios")
                ->setSubject("Reporte Tiempo Espera Por Usuarios")
                ->setDescription("Reporte Tiempo Espera Por Usuarios")
                ->setKeywords("Tiempo Espera Usuarios")
                ->setCategory("Reporte Tiempo Espera Por Usuarios");
        if (count($cuereporte) == 0) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B2', 'REPORTE DE TIEMPO PROMEDIO DE ESPERA POR USUARIOS')
                    ->setCellValue('B3', 'NO SE ENCONTRARON REGISTROS')
            ;
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:C3');
        } else {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B2', 'REPORTE DE TIEMPO PROMEDIO DE ESPERA POR USUARIOS')
                    ->setCellValue('B3', 'NOMBRE')
                    ->setCellValue('C3', 'FECHA')
                    ->setCellValue('D3', 'TURNOS')
                    ->setCellValue('E3', 'TIEMPO PROMEDIO ESPERA')
            ;
            for ($y = 0; $y < count($cuereporte); $y++) {

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . ($y + 4), $cuereporte[$y]->apellidos . " " . $cuereporte[$y]->nombres)
                        ->setCellValue('C' . ($y + 4), $cuereporte[$y]->fecha)
                        ->setCellValue('D' . ($y + 4), $cuereporte[$y]->turnos)
                        ->setCellValue('E' . ($y + 4), substr($cuereporte[$y]->promedio, 0, 8))
                ;
            }
        }
        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:E2');
        for ($col = 'B'; $col != 'F'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        $celda = 'E' . (count($cuereporte) + 3);
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'size' => 12,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => '495b79',
                ),
                'endcolor' => array(
                    'argb' => '495b79',
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('B2:' . $celda)->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('B2:E3')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setTitle('PROMEDIO ATENCIÓN POR USUARIOS');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_de_Tiempo_Promedio_Espera_por_Usuarios_' . $_GET['fecini'] . '_' . $_GET['fecfin'] . '_' . rand(100, 1000) . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
else {
    echo "Error de envío de parámetros al tratar de generar el reporte, por favor contactese con el proveedor del servicio";
}
?>
