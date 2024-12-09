require_once '../libraries/fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Invoice Transaksi', 0, 1, 'C');
$pdf->Ln(10);

// Detail Produk
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Produk A - 2 x Rp50,000', 0, 1);
$pdf->Cell(0, 10, 'Produk B - 1 x Rp100,000', 0, 1);
$pdf->Ln(10);

// Total Harga
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total Harga: Rp200,000', 0, 1, 'R');

// Simpan ke file
$pdf->Output('F', '../invoices/invoice_1234.pdf');

// Atau tampilkan langsung
$pdf->Output();
