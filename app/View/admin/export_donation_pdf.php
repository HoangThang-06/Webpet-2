<?php
require '../../../public/libs/tcpdf/tcpdf.php';
require '../../controller/dbconnect.php';
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->SetCreator('PetRescueHub');
$pdf->SetAuthor('PetRescueHub');
$pdf->SetTitle("Sao kê ủng hộ năm $year");
$pdf->SetMargins(10, 15, 10);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);
$pdf->Cell(0, 10, "SAO KÊ ỦNG HỘ NĂM $year", 0, 1, 'C');
$pdf->Ln(5);
$grandTotal = 0;
for ($month = 1; $month <= 12; $month++) {
    $sql = "
        SELECT d.id, u.fullname, d.amount, d.message, d.created_at
        FROM donations d
        JOIN users u ON d.user_id = u.id_user
        WHERE d.status = 'approved'
          AND YEAR(d.created_at) = ?
          AND MONTH(d.created_at) = ?
        ORDER BY d.created_at ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        continue;
    }
    $pdf->Ln(4);
    $pdf->SetFont('dejavusans', 'B', 11);
    $pdf->Cell(0, 8, "Tháng $month", 0, 1);
    $pdf->SetFont('dejavusans', '', 10);
    $html = '
    <table border="1" cellpadding="5">
    <thead>
        <tr style="background-color:#f0f0f0;">
            <th width="8%">ID</th>
            <th width="22%">Người ủng hộ</th>
            <th width="15%">Số tiền</th>
            <th width="35%">Lời nhắn</th>
            <th width="20%">Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
    ';
    $monthTotal = 0;
    while ($row = $result->fetch_assoc()) {
        $monthTotal += $row['amount'];
        $grandTotal += $row['amount'];

        $html .= '
        <tr>
            <td>'.$row['id'].'</td>
            <td>'.htmlspecialchars($row['fullname']).'</td>
            <td>'.number_format($row['amount']).'</td>
            <td>'.htmlspecialchars($row['message']).'</td>
            <td>'.$row['created_at'].'</td>
        </tr>
        ';
    }
    $html .= '
        <tr>
            <td colspan="2"><b>Tổng tháng '.$month.'</b></td>
            <td colspan="3"><b>'.number_format($monthTotal).' VND</b></td>
        </tr>
    </tbody>
    </table>
    ';

    $pdf->writeHTML($html, true, false, true, false, '');
}
$pdf->Ln(6);
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0, 10, "TỔNG CỘNG NĂM $year: ".number_format($grandTotal)." VND", 0, 1, 'R');

$pdf->Output("sao-ke-ung-ho-nam-$year.pdf", 'I');
