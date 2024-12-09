<?php
// Load pustaka FPDF
require_once 'libraries/fpdf/fpdf.php';

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Tambahkan teks ke PDF
$pdf->Cell(0, 10, 'FPDF Test Berhasil!', 0, 1, 'C');

// Output PDF
$pdf->Output();
?>
