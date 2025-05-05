<?php
require_once('tcpdf/tcpdf.php');
include('includes/config.php');

$selectedMonth = $_GET['month'];

// Extract the year and month from the selected value
$year = date('Y', strtotime($selectedMonth));
$month = date('m', strtotime($selectedMonth));

$query = "SELECT payment_id, user_id, booking_id, payment_date, Amount FROM payments WHERE YEAR(payment_date) = '$year' AND MONTH(payment_date) = '$month'";
$result = mysqli_query($mysqli, $query);

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MMU Hostel');
$pdf->SetTitle('Payment Report');
$pdf->SetSubject('Payment Report');
$pdf->SetKeywords('Payment, Report');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('Helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Payment Report', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Helvetica', '', 12);

// Add your paragraph here
$pdf->MultiCell(0, 10, 'Dear MMU Hostel Treasurer,', 0, 'L');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, 'I am writing to provide you with a detailed payment report for the MMU Hostel. This report contains important information about the payments made by the users.', 0, 'L');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, 'Below are the key details of the payments:', 0, 'L');
$pdf->Ln(5);

$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(25, 10, 'Payment ID', 1, 0, 'C');
$pdf->Cell(25, 10, 'User ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Booking ID', 1, 0, 'C');
$pdf->Cell(35, 10, 'Payment Date', 1, 0, 'C');
$pdf->Cell(25, 10, 'Amount', 1, 1, 'C');

$pdf->SetFont('Helvetica', '', 10);

$count = 0; // Initialize a counter

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $count++; // Increment the counter

        if ($count > 10) {
            break; // Exit the loop if more than ten records are processed
        }

        $pdf->Cell(25, 10, $row['payment_id'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['user_id'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['booking_id'], 1, 0, 'C');
        $pdf->Cell(35, 10, $row['payment_date'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['Amount'], 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No data found', 1, 1, 'C');
}
$pdf->Output('payment_report.pdf', 'D');
?>
