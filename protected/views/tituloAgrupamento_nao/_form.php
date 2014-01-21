<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'titulo-agrupamento-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<script>
	$(document).ready(function() {
		$('#TituloAgrupamento_codpessoa').on('change', function(){
			console.log('mudou');
			var ajaxRequest = $("#titulo-agrupamento-form").serialize();
			$.fn.yiiListView.update(
				// this is the id of the CListView
				'Listagem',
				{data: ajaxRequest}
			);
		});
	});
</script>

<fieldset>
	<?php
		echo $form->select2PessoaRow($model, 'codpessoa');
	?>
	<div id="Listagem">
	<?php
		if (empty($model->codpessoa) and isset($_GET["TituloAgrupamento"]["codpessoa"]))
			$model->codpessoa = $_GET["TituloAgrupamento"]["codpessoa"] ;
		
		if (empty($model->codpessoa))
			$model->codpessoa = -1;
			
		$criteria=new CDbCriteria;
		$criteria->addcondition('saldo <> 0');
		$criteria->compare('codpessoa', $model->codpessoa, false);
		$dp = new CActiveDataProvider(Titulo::model(), array('criteria' => $criteria));
		$dp->setPagination(false);

		$this->widget(
			'zii.widgets.CListView', 
			array(
				'id' => 'Listagem',
				'dataProvider' => $dp,
				'itemView' => '_form_titulos_listagem',
				'template' => '{items} {pager}',
				'pager' => null
			)
		);
	?>
	</div>
	<?php
		echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>200));
	?>
</fieldset>
<div class="form-actions">

    
    <?php 
	

        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
	<?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'reset',
                'label' => 'Limpar',
                'icon' => 'icon-refresh'
                )
            );
    ?>
    
</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#titulo-agrupamento-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
});

</script>