<?php
require __DIR__ . '/../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$conn = new mysqli("localhost", "root", "", "sheetless");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM traveler_data2";
$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Traveler Data 2");

$headers = [
    'ID', 'Date Submitted', 'Step 21', 'Step 22', 'Step 23', 'Step 24', 'Step 25',
    'Step 26', 'Step 27', 'Step 28', 'Step 29', 'Step 30', 'Step 31', 'Step 32',
    'Step 33', 'Step 34', 'Step 35', 'Step 36', 'Step 37', 'Step 38', 'Step 39', 'Step 40'
];

$sheet->fromArray($headers, NULL, 'A1');

$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray(array_values($row), NULL, 'A' . $rowIndex);
    $rowIndex++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="traveler_data2.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>