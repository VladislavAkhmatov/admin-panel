<?php
require_once 'secure.php';

if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

require 'phpoffice/phpexcel/Classes/PHPExcel.php';

$fileName = "Оценки_" . time() . ".xlsx";

$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);
$sheet = $excel->getActiveSheet();

$fields = array('fio', 'subject', 'grade', 'date', 'attend');

// Записываем заголовки столбцов
$col = 'A';
foreach ($fields as $field) {
    $sheet->setCellValue($col . '1', $field);
    $col++;
}
$date = '';
$subject_id = 0;
$gruppa_id = 0;

if (isset($_GET['date']) && $_GET['date'] != '') {
    $date = $_GET['date'];
    $subject_id = $_GET['subject_id'];
    $gruppa_id = $_GET['gruppa_id'];
} else {
    header('Location: select-subject?message=err');
    exit();
}

$gradesMap = new GradeMap();
$grades = $gradesMap->findBySubjectId($date, $subject_id, $gruppa_id);

if ($grades) {
    $row = 2;
    foreach ($grades as $grade) {
        $col = 'A';
        foreach ($fields as $field) {
            $sheet->setCellValue($col . $row, $grade->$field);
            $col++;
        }
        $row++;
    }
} else {
    $sheet->setCellValue('A2', "Записи не найден...");
}

// Устанавливаем заголовки для файла Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Выводим содержимое в браузер
$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>