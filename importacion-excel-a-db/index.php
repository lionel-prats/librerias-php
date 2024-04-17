<?php 

// http://localhost/scripts/importacion-excel-a-db/

require 'vendor/autoload.php';
require 'connection.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file_name = "estadisticas-inflacion.xlsx";
$file_content = IOFactory::load($file_name);

// total de hojas de calculo del archivo
$total_sheets = $file_content->getSheetCount();

// bloque para iterar las pestañas del archivo, si este tuviera mas de una
// for($i = 0; $i < $total_sheets; $i++){
//     $current_sheet = $file_content->getSheet($i);
// }
// fin bloque 

// "Hoja 1" del archivo (sabemos que el archivo tiene una sola pestaña)
$current_sheet = $file_content->getSheet(0);

// calculo el nro de la ultima fila con data de "Hoja 1"
$last_row = $current_sheet->getHighestDataRow();

// calculo la letra de la ultima columna con data de "Hoja 1"
$last_column = $current_sheet->getHighestDataColumn();

// array que contiene desde la "A" hasta la ultima columna con data del "Hoja 1"
$array_columns = range("A", $last_column);

for($row = 1; $row <= $last_row; $row++) {
    $sql_insert = "INSERT INTO inflation (month, monthly_inflation, year_on_year_inflation, cumulative_annual_inflation, historic) VALUES (";
    if($row > 1) {
        foreach ($array_columns as $column) {
            $sql_insert .= "'" . $current_sheet->getCell("$column$row")->getValue() . "', ";
        }
        $sql_insert = substr_replace($sql_insert, ");", -2); 
        // $result_insert = $mysqli->query($sql_insert);
        // if($result_insert) echo "el registro de la linea $row se insertó correctamente.\n";

        echo "$sql_insert<br>";
    }
}