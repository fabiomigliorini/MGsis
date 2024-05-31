<?php

class GrupoEconomicoController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = GrupoEconomico::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAjaxBuscaGrupoEconomico($texto, $limite = 20, $pagina = 1, $inativo = 0, $vendedor = 0)
    {

        $texto  = str_replace(' ', '%', trim($texto));

        // corrige pagina se veio sujeira
        if ($pagina < 1) $pagina = 1;

        // calcula de onde continuar a consulta
        $offset = ($pagina - 1) * $limite;

        // inicializa array com resultados
        $resultados = array();

        // se o texto foi preenchido
        if (strlen($texto) >= 1) {

            // somente grupoeconomicos ativas
            $condition = 'inativo is null and ';

            // se quiser inativas limpa o filtro de ativas
            if (isset($_GET['inativo']) && $_GET['inativo'])
                $condition = '';

            if (!empty($vendedor))
                $condition .= "vendedor = true AND ";

            // busca pelos campos "fantasia" e "grupoeconomico"
            $condition .= '(grupoeconomico ILIKE :grupoeconomico';

            $params = array(
                ':grupoeconomico' => '%' . $texto . '%',
            );

            // se o texto for um numero busca pelo "codgrupoeconomico" e "cnpj"
            $numero = (int)MGFormatter::numeroLimpo($texto);
            if ($numero > 0) {
                $condition .= ' OR codgrupoeconomico = :codgrupoeconomico ILIKE :cnpj';
                $params = array_merge(
                    $params,
                    array(
                        ':codgrupoeconomico' => $numero,
                    )
                );
            }
            $condition .= ')';

            // busca grupoeconomicos
            $grupoeconomicos = GrupoEconomico::model()->findAll(
                array(
                    'select' => 'codgrupoeconomico, grupoeconomico, inativo',
                    'order' => 'grupoeconomico',
                    'condition' => $condition,
                    'params' => $params,
                    'limit' => $limite,
                    'offset' => $offset,
                )
            );

            //monta array com resultados
            foreach ($grupoeconomicos as $grupoeconomico) {
                $resultados[] = array(
                    'id' => $grupoeconomico->codgrupoeconomico,
                    'grupoeconomico' => $grupoeconomico->grupoeconomico,
                    'inativo' => !empty($grupoeconomico->inativo),
                );
            }
        }

        // transforma o array em JSON
        echo CJSON::encode(
            array(
                'mais' => count($resultados) == $limite ? true : false,
                'pagina' => (int) $pagina,
                'itens' => $resultados
            )
        );

        // FIM
        Yii::app()->end();
    }

    public function actionAjaxInicializaGrupoEconomico()
    {
        if (isset($_GET['cod'])) {
            $grupoeconomico = GrupoEconomico::model()->findByPk(
                $_GET['cod'],
                array(
                    'select' => 'codgrupoeconomico, grupoeconomico',
                    'order' => 'grupoeconomico',
                )
            );
            echo CJSON::encode(array('id' => $grupoeconomico->codgrupoeconomico, 'grupoeconomico' => $grupoeconomico->grupoeconomico));
        }
        Yii::app()->end();
    }
}
