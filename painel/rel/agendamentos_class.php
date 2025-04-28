<?php 
require_once("../../conexao.php");

$status = $_POST['status'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$procedimento = urlencode($_POST['procedimento']);
$convenio = urlencode($_POST['convenio']);
$pago = $_POST['pago'];

$html = file_get_contents($url_sistema."painel/rel/agendamentos.php?pago=$pago&dataInicial=$dataInicial&dataFinal=$dataFinal&status=$status&procedimento=$procedimento&convenio=$convenio");

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$pdf = new DOMPDF($options);


//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();
//NOMEAR O PDF GERADO


$pdf->stream(
	'procedimentos.pdf',
	array("Attachment" => false)
);



 ?>