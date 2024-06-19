<?php
session_start();
require_once('../recursos/funcionalidad/php/db_connection.php');
require_once '../vendor/tcpdf/tcpdf.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];
$result_group = $conn->query("SELECT g.group_name FROM groups g INNER JOIN group_assignments ga ON g.id = ga.group_id WHERE ga.user_id = $logged_in_user_id");

if ($result_group->num_rows > 0) {
    $group_row = $result_group->fetch_assoc();
    $group_name = $group_row['group_name'];
} else {
    $group_name = "No asignado a un grupo";
}

$result_tasks = $conn->query("SELECT * FROM tasks WHERE assigned_to = $logged_in_user_id");
$tareas = array('Pendientes' => [], 'En Progreso' => [], 'Realizadas' => []);
while ($row = $result_tasks->fetch_assoc()) {
    if ($row['status'] == 'pendiente') {
        $tareas['Pendientes'][] = $row;
    } elseif ($row['status'] == 'en progreso') {
        $tareas['En Progreso'][] = $row;
    } elseif ($row['status'] == 'finalizado') {
        $tareas['Realizadas'][] = $row;
    }
}

class MYPDF extends TCPDF
{
    public function Header()
    {
        $image_file = '../recursos/img/logo2.png';
        $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);

        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, 'Informe de Tareas', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(15);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SGO');
$pdf->SetTitle('Informe de Tareas');
$pdf->SetSubject('Informe');
$pdf->SetKeywords('PDF, informe, tareas, usuario');

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Informe de Tareas de Usuario', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Nombre de Grupo: ' . $group_name, 0, 1);
$pdf->Cell(0, 10, 'Fecha: ' . date('d-m-Y'), 0, 1);
$pdf->Ln(5);

function generateTaskTable($pdf, $tareas, $title)
{
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, $title, 0, 1);
    $pdf->SetFont('helvetica', '', 12);

    foreach ($tareas as $tarea) {
        $pdf->MultiCell(0, 10, '- ' . $tarea['task_name'] . ': ' . $tarea['description'], 0, 'L');
    }
    $pdf->Ln(5);
}

generateTaskTable($pdf, $tareas['Pendientes'], 'Tareas Pendientes');
generateTaskTable($pdf, $tareas['En Progreso'], 'Tareas En Progreso');
generateTaskTable($pdf, $tareas['Realizadas'], 'Tareas Realizadas');

$pdf->Output('informe_tareas.pdf', 'I');
