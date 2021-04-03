<?php

class NfeTerceiroController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	/*
	public function actionCreate()
	{
		$model=new NfeTerceiro;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}

		$this->render('create',array(
			'model'=>$model,
			));
	}
	*/

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if (!$model->podeEditar())
			throw new CHttpException(409, 'Registro não permite edição.');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}

		$this->render('update',array(
			'model'=>$model,
			));
	}

	public function actionImportar($id)
	{
		$model=$this->loadModel($id);

		if ($model->importar())
		{
			Yii::app()->user->setFlash("success", "NFe de Terceiro Importada com sucesso!");
			$this->redirect(array('view','id'=>$model->codnfeterceiro));
			// $this->redirect(array('index'));
		}
		else
		{
			$erros = $model->getErrors();

			$msgs = array("Erro(s) ao Importar:");

			foreach ($erros as $campo => $mensagens)
				foreach ($mensagens as $msg)
					$msgs[] = "[$campo] => $msg";

			$msgs = implode("<BR>", $msgs);

			Yii::app()->user->setFlash("error", $msgs);
			$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	/*
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			try
			{
				$this->loadModel($id)->delete();
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}
			catch(CDbException $e)
			{
				// Cannot delete or update a parent row: a foreign key constraint fails
				if($e->errorInfo[1] == 7)
				{
					throw new CHttpException(409, 'Registro em uso, você não pode excluir.');
				}
				else
					throw $e;
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	 *
	 */

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new NfeTerceiro('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['NfeTerceiro']))
			Yii::app()->session['FiltroNfeTerceiroIndex'] = $_GET['NfeTerceiro'];

		if (isset(Yii::app()->session['FiltroNfeTerceiroIndex']))
			$model->attributes=Yii::app()->session['FiltroNfeTerceiroIndex'];
		else
		{
			//$model->indsituacao = NfeTerceiro::INDSITUACAO_AUTORIZADA;
			$model->codnotafiscal = 1;
		}

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
			));
	}

	/**
	* Manages all models.
	*/
	/*
	public function actionAdmin()
	{

		$model=new NfeTerceiro('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['NfeTerceiro']))
			$model->attributes=$_GET['NfeTerceiro'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}
	 *
	 */

	public function actionUpload()
	{
		/**
		 * @var NfeTerceiro
		 */
		$model=new NfeTerceiro;

		/*
		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
            $model->arquivoxml=CUploadedFile::getInstance($model,'arquivoxml');
			if ($model->importarXmlViaArquivo())
				$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}
		*/

		$this->render(
			'upload',
			array(
				'model'=>$model,
			)
		);
	}

	public function actionPesquisarSefaz($codfilial = null, $nsu = null)
	{
		$model = new NfeTerceiro('search');

		$model->codfilial = $codfilial;
		$model->nsu = $nsu;

		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
		}

		$nsu = $model->nsu;

		/*
		if (!empty($model->codfilial))
		{
			$acbr = new MGAcbrNfeMonitor(null, $model);

			$leituras = 0;

			$nsuinicial = $nsu;
			$fim = false;

			$importadas = array();

			do {

				$leituras++;

				if ($leituras > 100)
					break;

				//echo "<hr>Pesquisando $nsu <br>";

				if (!$acbr->consultaNfeDest($nsu))
				{
					//echo "<h1>Erro ao enviar comando</h1>";
				}
				usleep(500000);
				//echo "<pre>";
				//print_r($acbr->retorno);
				//echo "</pre>";


				//if ($acbr->retornoMonitor["Mensagem"][0] != "OK")
				//	break;

				for ($i=1; $i<1000; $i++)
				{
					$chave = "RESNFE" . str_pad($i, 3, 0, STR_PAD_LEFT);

					if (!isset($acbr->retornoMonitor[$chave]))
						break;

					$arr = $acbr->retornoMonitor[$chave];

					$nfe = NfeTerceiro::model()->find("nfechave = :nfechave", array("nfechave"=>$arr["chNFe"]));

					if ($nfe === null)
						$nfe = new NfeTerceiro();

					$nfe->codfilial = $model->codfilial;

					//[NSU] => 10220440943
					$nfe->nsu = $arr["NSU"];

					//[chNFe] => 51140628053619009644550010000146501273515829
					$nfe->nfechave = $arr["chNFe"];

					//[CNPJ] => 28053619009644
					if (isset($arr["CNPJ"]))
						$nfe->cnpj = $arr["CNPJ"];

					//[xNome] => Chocolates Garoto S.A.
					if (isset($arr["xNome"]))
						$nfe->emitente = MGFormatter::removeAcentos(utf8_encode($arr["xNome"]));
					else
						$nfe->emitente = "<Vazio>";

					//[IE] => 134342763
					if (isset($arr["IE"]))
						$nfe->ie = $arr["IE"];

					//[dEmi] => 24/06/2014
					if (isset($arr["dEmi"]))
						$nfe->emissao = $arr["dEmi"];

					//[tpNF] => 1
					if (isset($arr["tpNF"]))
						$nfe->codoperacao = $arr["tpNF"]+1;

					//[vNF] => 222,84
					if (isset($arr["vNF"]))
						$nfe->valortotal = Yii::app()->format->unformatNumber($arr["vNF"]);

					//[digVal] => WAFS3wPj/69U7sJI412ygTDk7+I=
					//[dhRecbto] => 24/06/2014 07:25:09
					if (isset($arr["dhRecbto"]))
						$nfe->nfedataautorizacao = $arr["dhRecbto"];

					//[cSitNFe] => 1
					if (isset($arr["cSitNFe"]))
						$nfe->indsituacao = $arr["cSitNFe"];

					//[cSitConf] => 0
					if (isset($arr["cSitConf"]))
						$nfe->indmanifestacao = $arr["cSitConf"];

					$importadas[] = $arr["chNFe"];

					$nfe->save();

				}

				//echo "</pre>";

				if (isset($acbr->retornoMonitor[""]["ultNSU"]))
				{
					if ($nsu == $acbr->retornoMonitor[""]["ultNSU"])
					{
						//echo "<h1>Repetiu ult nsu</h1>";
						break;
					}
					$nsu = $acbr->retornoMonitor[""]["ultNSU"];
				}
				else
				{
					//echo "<h1>Nao achou ult nsu</h1>";
					break;
				}


				if (isset($acbr->retornoMonitor[""]["indCont"]))
				{
					if ($acbr->retornoMonitor[""]["indCont"] != 1)
					{
						$fim = true;
						break;
					}
				}

			} while (true);

			$model->nsu = $nsu;

			$lidas = Yii::app()->format->formatNumber($model->nsu - $nsuinicial, 0);

			if ($acbr->retornoMonitor["Mensagem"][0] != "OK")
			{
				$class = "error";
				$mensagem = $acbr->retorno;
			}
			else
			{
				$mensagem = "Lidos {$lidas} NSU's ({$nsuinicial} ao {$model->nsu}).";

				$mensagem .= "<br>Importadas <b>" . sizeof($importadas) . "</b> Chaves (" . implode(", ", $importadas) . ")";

				if ($fim)
				{
					$mensagem .= "<br>Lidas todas as notas!";
					$class = "success";
				}
				else
				{
					$mensagem .= "<br>Existem mais registros para ler, <b>continue</b>!";
					$class = "info";
				}
			}
			Yii::app()->user->setFlash($class, $mensagem);

		}
		*/

		$this->render('pesquisar_sefaz',array(
			'model'=>$model,
			));

	}

	/**
	 * Efetua Download de uma NFE e Carrega os dados na tabela do sistema
	 * @param bigint $id
	 * @throws CHttpException
	 */
	public function actionDownloadNfe($id)
	{
		/**
		 * @var NfeTerceiro Description
		 */
		//$model = $this->loadModel($id);
		$model = NfeTerceiro::model()->findByPk($id);
		$acbr = new MGAcbrNfeMonitor(null, $model);

		$res = $acbr->downloadNfe();

		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);

	}

	public function actionEnviarEventoManifestacao($id, $indManifestacao, $justificativa = "")
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor(null, $model);

		$res = $acbr->enviarEventoManifestacao($indManifestacao, $justificativa);

		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);

	}

	public function actionIcmsst($id)
	{
		$model = $this->loadModel($id);
		$sql = "
			with final as (
				with itens as (
					select
						nti.codnfeterceiroitem,
						nti.nitem,
						nti.cprod,
						nti.xprod,
						--nti.cean,
						nti.ncm as ncmnota,
						n.ncm as ncmproduto,
						nti.cest as cestnota,
						c.cest as cestproduto,
						round(1 + (c.mva / 100), 4) as mva,
						coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) + coalesce(ipivipi, 0) - coalesce(vdesc, 0) as valor,
						case when coalesce(n.bit, false) then
							0.4117
						else
							1.0
						end as reducao,
						case when coalesce(picms, 0) > 7 then
							(coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) - coalesce(vdesc, 0)) * 0.07
						else
							case when coalesce(vicms, 0) = 0 then
								case when p.importado then
									(coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) - coalesce(vdesc, 0)) * 0.04
								else
									(coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) - coalesce(vdesc, 0)) * 0.07
								end
							else
								coalesce(vicms, 0)
							end
						end as vicms,
						vicmsst
					from tblnfeterceiroitem nti
					left join tblprodutobarra pb on (pb.codprodutobarra = nti.codprodutobarra)
					left join tblproduto p on (p.codproduto = pb.codproduto)
					left join tblncm n on (n.codncm = p.codncm)
					left join tblcest c on (c.codcest = p.codcest)
					where nti.codnfeterceiro = {$model->codnfeterceiro}
					order by nti.ncm, nti.xprod
				)
				select *, round((valor * reducao * mva * 0.17) - (vicms * reducao), 2) as vicmsstcalculado from itens
			)
			select
				*,
				coalesce(vicmsstcalculado, 0) - coalesce(vicmsst, 0) as diferenca
			from final
		";

		$command = Yii::app()->db->createCommand($sql);
		$itens = $command->queryAll();
		$this->render('icmsst',[
			'model'=>$model,
			'itens'=>$itens,
		]);
	}


	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=NfeTerceiro::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nfe-terceiro-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGerarGuiaSt ($id, $valor, $vencimento)
	{

		// Validacao Valor
		$valor = floatval($valor);
		if ($valor <= 0.01) {
			throw new \Exception("Valor Não Informado!", 1);
		}

		// Carrega NFE Terceiro
		$model = $this->loadModel($id);

		// Variaveis para Requisicao
		$periodoReferencia = DateTime::createFromFormat('d/m/Y H:i:s', $model->emissao)->format("m/Y");
		$numrDocumentoDestinatario = $model->Filial->Pessoa->ie;
		$numrNota1 = $model->nfechave;
		$numrInscEstadual = $model->Filial->Pessoa->ie;
		$numrDocumento = $model->Filial->Pessoa->cnpj;
		$valorFormatado = number_format($valor, 2, ",", ".");

		// CNAE
		$arrCodgCnae = [
			101 => '4751201',
		];
		if (!isset($arrCodgCnae[$model->codfilial])) {
			throw new \Exception("Impossível determinar Cnae!", 1);
		}
		$codgCnae = $arrCodgCnae[$model->codfilial];

		// Numero do numrContribuinte
		$arrNumrContribuinte = [
			101 => '611107',
		];
		if (!isset($arrNumrContribuinte[$model->codfilial])) {
			throw new \Exception("Impossível determinar Número do Contribuinte!", 1);
		}
		$numrContribuinte = $arrNumrContribuinte[$model->codfilial];

		// Requisicao CURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.sefaz.mt.gov.br/arrecadacao/darlivre/pj/gerardar");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		$data = [
			'periodoReferencia' => $periodoReferencia,
			'tipoVenda' => '1',
			'tributo' => '1538',
			'cnpjBeneficiario' => '',
			'numrDuimp' => '',
			'numrDocumentoDestinatario' => $numrDocumentoDestinatario,
			'txtCaminhoArquivo' => '(binary)',
			'isNFE1' => 'on',
			'numrNota1' => $numrNota1,
			'isNFE2' => 'on',
			'numrNota2' => '',
			'isNFE3' => 'on',
			'numrNota3' => '',
			'isNFE4' => 'on',
			'numrNota4' => '',
			'isNFE5' => 'on',
			'numrNota5' => '',
			'isNFE6' => 'on',
			'numrNota6' => '',
			'isNFE7' => 'on',
			'numrNota7' => '',
			'isNFE8' => 'on',
			'numrNota8' => '',
			'isNFE9' => 'on',
			'numrNota9' => '',
			'isNFE10' => 'on',
			'numrNota10' => '',
			'numrPessoaDestinatario' => $numrContribuinte,
			'statInscricaoEstadual' => 'Ativo',
			'notas' => '1',
			'nfeNota1' => '',
			'nfeNota2' => '',
			'nfeNota3' => '',
			'nfeNota4' => '',
			'nfeNota5' => '',
			'nfeNota6' => '',
			'nfeNota7' => '',
			'nfeNota8' => '',
			'nfeNota9' => '',
			'nfeNota10' => '',
			'numrParcela' => '',
			'totalParcela' => '',
			'numrNai' => '',
			'numrTad' => '',
			'multaCovid' => '',
			'numeroNob' => '',
			'codgConvDesc' => '',
			'dataVencimento' => $vencimento,
			'qtd' => '',
			'qtdUnMedida' => '',
			'valorUnitario' => '',
			'valorCampo' => $valorFormatado,
			'valorCorrecao' => '',
			'diasAtraso' => '',
			'juros' => '',
			'tipoDocumento' => '2',
			'nota1' => '',
			'nota2' => '',
			'nota3' => '',
			'nota4' => '',
			'nota5' => '',
			'nota6' => '',
			'nota7' => '',
			'nota8' => '',
			'nota9' => '',
			'nota10' => '',
			'informacaoPrevista' => '',
			'informacaoPrevista2' => '',
			'municipio' => '255009',
			'numrContribuinte' => $numrContribuinte,
			'pagn' => 'emitir',
			'numrDocumento' => $numrDocumento,
			'numrInscEstadual' => $numrInscEstadual,
			'tipoContribuinte' => '1',
			'codgCnae' => $codgCnae,
			'tipoTributoH' => '',
			'codgOrgao' => '',
			'valor' => $valorFormatado,
			'valorPadrao' => '0',
			'valorMulta' => '',
			'tributoTad' => '1538',
			'tipoVendaX' => '',
			'tipoUniMedida' => '',
			'valorUnit' => '',
			'upfmtFethab' => '',
		];
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		// valida se veio um PDF
		if ($info['content_type'] != 'application/pdf') {
			@$doc = new DOMDocument();
			@$doc->loadHTML($output);
			$xpath = new DomXPath($doc);
			$nodeList = $xpath->query("//font[@class='SEFAZ-FONT-MensagemErro']");
			if ($node = $nodeList->item(0)) {
				throw new \Exception(trim($node->nodeValue), 1);
			}
			throw new \Exception("Falha ao gerar PDF da DAR!", 1);
		}

		// Cria diretorio pra salvar o PDF
		$arquivo = "/opt/www/GuiaST/" . DateTime::createFromFormat('d/m/Y H:i:s', $model->emissao)->format("Y/m") . "/";
		if (!file_exists($arquivo)) {
			mkdir($arquivo, 0755, true);
		}

		// Reserva Codtitulo
		$codtitulo = Yii::app()->db->createCommand("SELECT NEXTVAL('tbltitulo_codtitulo_seq')")->queryScalar();

		// Cria o Titulo
		$titulo = new Titulo();
		$titulo->codtitulo = $codtitulo;
		$titulo->codfilial = $model->codfilial;
		$titulo->numero = "ICMS ST {$codtitulo}";
		$titulo->codtipotitulo = 928; // Boleto a Pagar
		$titulo->valor = $valor;
		$titulo->codpessoa = 3899; // sefaz
		$titulo->codcontacontabil = 147; // ICMS ST
		$titulo->transacao = date('d/m/Y');
		$titulo->emissao = date('d/m/Y');
		$titulo->vencimento = $vencimento;
		$titulo->vencimentooriginal = $vencimento;
		$titulo->observacao = "ICMS ST NFe {$model->numero} - {$model->Pessoa->fantasia}\n{$model->nfechave}";
		if (!$titulo->save()) {
			$errors = $titulo->getErrors();
			foreach ($errors as $error) {
				throw new \Exception($error[0], 1);
			}
		};

		// Salva PDF
		$arquivo .= "{$model->nfechave}-{$titulo->codtitulo}.pdf" ;
		file_put_contents($arquivo, $output);

		// Amarra titulo a NfeTerceiro
		$tituloNfeTerceiro = new TituloNfeTerceiro();
		$tituloNfeTerceiro->codtitulo = $titulo->codtitulo;
		$tituloNfeTerceiro->codnfeterceiro = $model->codnfeterceiro;
		if (!$tituloNfeTerceiro->save()) {
			$errors = $tituloNfeTerceiro->getErrors();
			foreach ($errors as $error) {
				throw new \Exception($error[0], 1);
			}
		};

		echo CJSON::encode(
			array(
				'id' => $id,
				'valor' => $valor,
				'vencimento' => $vencimento,
				'codtitulo' => $titulo->codtitulo,
				'codtitulonfeterceiro' => $tituloNfeTerceiro->codtitulonfeterceiro,
			)
		);

	}

	public function actionGuiaSt($codtitulonfeterceiro)
	{
			$tituloNfeTerceiro=TituloNfeTerceiro::model()->findByPk($codtitulonfeterceiro);
			if($tituloNfeTerceiro===null) {
				throw new CHttpException(404,'The requested page does not exist.');
			}
			$arquivo = "/opt/www/GuiaST/" . DateTime::createFromFormat('d/m/Y H:i:s', $tituloNfeTerceiro->NfeTerceiro->emissao)->format("Y/m") . "/";
			$arquivo .= "{$tituloNfeTerceiro->NfeTerceiro->nfechave}-{$tituloNfeTerceiro->codtitulo}.pdf" ;
			if (!file_exists($arquivo)) {
				throw new CHttpException(404,'The requested page does not exist.');
			}
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="' . basename($arquivo) . '"');
			readfile($arquivo);
	}
}
