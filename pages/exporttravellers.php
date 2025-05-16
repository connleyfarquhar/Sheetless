<?php
// Using PHPSpreadsheet within the project in order to export the data into excel.
require __DIR__ . '/../vendor/autoload.php'; // PhpSpreadsheet autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Set database connection.
$conn = new mysqli("localhost", "root", "", "sheetless");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Select all travellers from the traveler_data table.
$sql = "SELECT * FROM traveler_data";
$result = $conn->query($sql);

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Traveler Data Group 1");

// Setting headers which should in reality meet the same names as the database columns.
$headers = [
    'ID', 'Date Submitted', 'Step 1', 'Step 2', 'Step 3',
    'Step 4', 'Step 5', 'Step 6',
    'Step 7', 'Step 8', 'Step 9',
    'Step 10', 'Step 11', 'Step 12',
    'Step 13', 'Step 14', 'Step 15', 'Step 16',
    'Step 17', 'Step 18', 'Step 19', 'Step 20'
];

// Output headers to spreadsheet
$sheet->fromArray($headers, NULL, 'A1');

// Write rows
$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray(array_values($row), NULL, 'A' . $rowIndex);
    $rowIndex++;
}

// Setting header to use Microsoft Excel Formatting.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// Setting attachment name that appears in the end users browser, implement feature to set their own?.
header('Content-Disposition: attachment;filename="traveler_data_group1.xlsx"');
// Disable caching.
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>