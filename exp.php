<?php
require_once dirname(__FILE__) . '/config/config.php';


function DetailData($IdJ){
    $sql = "SELECT a.Nilai, b.*, c.Judul as LOKER FROM careesma_nilai a INNER JOIN careesma_data_diri b ON a.UserId = b.Id INNER JOIN careesma_job_vacansy c ON a.IdJobVacancy = c.Id WHERE a.IdJobVacancy = '$IdJ'";
    $query = $GLOBALS['db']->query($sql);
    $row = $query->rowCount();
    $r = array();
    if($row > 0){
        while($res = $query->fetch(PDO::FETCH_ASSOC)){
            $r['data'][] = $res;
        }
        $r['row'] = $row;
    }else{
        $r['data']=array();
        $r['row'] = $row;
    }
    return $r;
}
// echo "<pre>";
// print_r(DetailData($_GET['IdJ']));
// exit;

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */

require_once dirname(__FILE__) . '/lib/PHPExcel/Classes/PHPExcel.php';
//require_once dirname(__FILE__) . '/fungsi.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("PT ISMA")
							 ->setLastModifiedBy("PT ISMA")
							 ->setTitle("Rekap Pelmar")
							 ->setSubject("Rekap Pelmar")
							 ->setDescription("Rekap Pelmar")
							 ->setKeywords("Rekap Pelmar")
							 ->setCategory("Rekap Pelmar");

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
$styleArraya = array(
   'font'  => array(
        'bold'  => true,
        'size'  => 14,
        'name'  => 'Calibri'
    ));  
// Add some data
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A2:I2")->applyFromArray($styleArraya);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'REKAP DATA TKDB')
            ->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'NO KTP')
            ->setCellValue('C3', 'NAMA')
            ->setCellValue('D3', 'TTL')
            ->setCellValue('E3', 'JK')
            ->setCellValue('F3', 'NOHP')
            ->setCellValue('G3', 'LOKER')
            ->setCellValue('H3', 'NILAI')
            ->setCellValue('I3', 'HASIL');
            
$Row = 4;
$IdJ = $_GET['IdJ'];
$Data = DetailData($IdJ);
if($Data['row'] > 0){
    $No=1;
    $JK = array("L"=> "Laki-Laki","P"=> "Perempuan");
    foreach($Data['data'] as $key => $r){
        if($r['Nilai'] >= 90){
            $Hasil = "Disarankan";
        }elseif($r['Nilai'] >= 45 && $r['Nilai'] <= 89){
            $Hasil = "Dipertimbangkan";
        }else{
            $Hasil = "Tidak Disarankan";
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$Row, $No)
            ->setCellValueExplicit('B'.$Row, $r['NoKtp'],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('C'.$Row, $r['Nama'])
            ->setCellValue('D'.$Row, $r['TptLahir'].", ".$r['TglLahir'])
            ->setCellValue('E'.$Row, $JK[$r['JK']])
            ->setCellValueExplicit('F'.$Row, $r['NoHp'],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('G'.$Row, $r['LOKER'])
            ->setCellValue('H'.$Row, intval($r['Nilai']))
            ->setCellValue('I'.$Row, $Hasil);
            $No++;
            $Row++;
    }
}

$Num = $Row-1;
$border_style= array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A3:I".$Num)->applyFromArray($border_style);
$sheet = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFFF00')
        ));

$objPHPExcel->setActiveSheetIndex(0)->getStyle("A3:I3")->applyFromArray($sheet);

 $styleArray = array(
   'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 11,
        'name'  => 'Calibri'
    ));  
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("REKAP DATA TKDB");


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$Time = time();

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$Time.'-Rekap-Data-TKDB.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
