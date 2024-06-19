<?php
require_once('../vendor/tcpdf/tcpdf.php');
require_once('../recursos/funcionalidad/php/db_connection.php');
class MYPDF extends TCPDF
{
    public function Header()
    {
        $image_file = '../recursos/img/logo2.png';
        $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);

        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, 'Informe Administrativo', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
$pdf->SetTitle('Informe Administrativo');
$pdf->SetSubject('Informe');
$pdf->SetKeywords('PDF, informe, administrativo');

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Informe Administrativo', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Fecha: ' . date('d-m-Y'), 0, 1);
$pdf->Ln(5);

$result_users = $conn->query("SELECT id, username AS nombre_de_usuario, role_id AS rol FROM users");
$result_groups = $conn->query("SELECT id, group_name AS nombre_del_grupo FROM groups");
$result_group_assignments = $conn->query("SELECT group_assignments.id, group_name AS nombre_del_grupo, username AS nombre_del_usuario FROM group_assignments JOIN groups ON group_assignments.group_id = groups.id JOIN users ON group_assignments.user_id = users.id");
$result_roles = $conn->query("SELECT id, role_name AS nombre_del_rol FROM roles");
$result_tasks = $conn->query("SELECT tasks.id, task_name AS nombre_de_tarea, description AS descripcion, status AS estado, username AS asignado_a FROM tasks LEFT JOIN users ON tasks.assigned_to = users.id");

function generateTable($pdf, $data, $columns, $title)
{
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, $title, 0, 1);
    $pdf->SetFont('helvetica', '', 12);

    $html = '<table border="1" cellpadding="4"><thead><tr>';
    foreach ($columns as $column) {
        $html .= '<th>' . $column . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    while ($row = $data->fetch_assoc()) {
        $html .= '<tr>';
        foreach ($columns as $column) {
            $column_key = strtolower(str_replace(' ', '_', $column));
            $html .= '<td>' . (isset($row[$column_key]) ? $row[$column_key] : '') . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    $pdf->writeHTML($html, true, false, true, false, '');
}

generateTable($pdf, $result_users, ['ID', 'nombre_de_usuario', 'rol'], 'Usuarios');
$pdf->Ln(10);
generateTable($pdf, $result_groups, ['ID', 'nombre_del_grupo'], 'Grupos');
$pdf->Ln(10);
generateTable($pdf, $result_group_assignments, ['ID', 'nombre_del_grupo', 'nombre_del_usuario'], 'Asignaciones de Grupos');
$pdf->Ln(10);
generateTable($pdf, $result_roles, ['ID', 'nombre_del_rol'], 'Roles');
$pdf->Ln(10);
generateTable($pdf, $result_tasks, ['ID', 'nombre_de_tarea', 'descripcion', 'estado', 'asignado_a'], 'Tareas');

$pdf->Output('informe_administrativo.pdf', 'I');
