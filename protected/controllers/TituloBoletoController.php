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
        $abertos = TituloBoleto::abertos();
        $tipo = isset($_GET['tipo'])?$_GET['tipo']:'vencidos';
        $boletos = TituloBoleto::boletosAbertos($tipo);
		$this->render('index', [
            'abertos' => $abertos,
            'tipo' => $tipo,
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