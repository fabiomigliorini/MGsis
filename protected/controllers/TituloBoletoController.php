<?php

class TituloBoletoController extends Controller
{
	public function actionIndex()
	{
        $abertos = TituloBoleto::abertos();
        $tipo = isset($_GET['tipo'])?$_GET['tipo']:'vencidos';
        $boletos = TituloBoleto::boletosAbertos($tipo);
		$this->render('index', [
            'abertos' => $abertos,
            'tipo' => $tipo,
            'boletos' => $boletos
        ]);
	}

    public function actionLiquidados()
	{
        if (isset($_GET['dia'])) {
            $dia = DateTime::createFromFormat('Y-m-d', $_GET['dia']);

        } else {
            $dia = new DateTime();
        }
        $codportador = isset($_GET['codportador'])?$_GET['codportador']:null;

        $anos = [];
        for ($ano = 2021; $ano <= date('Y'); $ano++) {
            $anos[] = $ano;
        }
        $boletos = [];
        $meses = TituloBoleto::liquidadosPorMes($dia);
        $dias = TituloBoleto::liquidadosPorDia($dia);
        $portadores = TituloBoleto::liquidadosPorPortador($dia);
        $boletos = TituloBoleto::boletosLiquidados($dia, $codportador);
		$this->render('liquidados', [
            'anos' => $anos,
            'meses' => $meses,
            'dias' => $dias,
            'portadores' => $portadores,
            'dia' => $dia,
            'codportador' => $codportador,
            'boletos' => $boletos
        ]);
	}

    public function actionBaixados()
	{
        $boletos = TituloBoleto::boletosBaixados();
		$this->render('baixados', [
            'boletos' => $boletos
        ]);
	}

}