<div class="registro">

	<div class="codigo">
		<?php echo CHtml::encode($data->getAttributeLabel('codpessoa')); ?>:
		<?php echo CHtml::link(CHtml::encode($data->codpessoa),array('view','id'=>$data->codpessoa)); ?>
	</div>
	<div class="detalhes">
	
		<?php echo CHtml::encode($data->getAttributeLabel('pessoa')); ?>:
		<b><?php echo CHtml::encode($data->pessoa); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('fantasia')); ?>:
		<b><?php echo CHtml::encode($data->fantasia); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('cadastro')); ?>:
		<b><?php echo CHtml::encode($data->cadastro); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('inativo')); ?>:
		<b><?php echo CHtml::encode($data->inativo); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('cliente')); ?>:
		<b><?php echo CHtml::encode($data->cliente); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('fornecedor')); ?>:
		<b><?php echo CHtml::encode($data->fornecedor); ?></b>

		<?php /*
		<?php echo CHtml::encode($data->getAttributeLabel('fisica')); ?>:
		<b><?php echo CHtml::encode($data->fisica); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('codsexo')); ?>:
		<b><?php echo CHtml::encode($data->codsexo); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('cnpj')); ?>:
		<b><?php echo CHtml::encode($data->cnpj); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('ie')); ?>:
		<b><?php echo CHtml::encode($data->ie); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('consumidor')); ?>:
		<b><?php echo CHtml::encode($data->consumidor); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('contato')); ?>:
		<b><?php echo CHtml::encode($data->contato); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('codestadocivil')); ?>:
		<b><?php echo CHtml::encode($data->codestadocivil); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('conjuge')); ?>:
		<b><?php echo CHtml::encode($data->conjuge); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('endereco')); ?>:
		<b><?php echo CHtml::encode($data->endereco); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:
		<b><?php echo CHtml::encode($data->numero); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('complemento')); ?>:
		<b><?php echo CHtml::encode($data->complemento); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('codcidade')); ?>:
		<b><?php echo CHtml::encode($data->codcidade); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('bairro')); ?>:
		<b><?php echo CHtml::encode($data->bairro); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('cep')); ?>:
		<b><?php echo CHtml::encode($data->cep); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('enderecocobranca')); ?>:
		<b><?php echo CHtml::encode($data->enderecocobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('numerocobranca')); ?>:
		<b><?php echo CHtml::encode($data->numerocobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('complementocobranca')); ?>:
		<b><?php echo CHtml::encode($data->complementocobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('codcidadecobranca')); ?>:
		<b><?php echo CHtml::encode($data->codcidadecobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('bairrocobranca')); ?>:
		<b><?php echo CHtml::encode($data->bairrocobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('cepcobranca')); ?>:
		<b><?php echo CHtml::encode($data->cepcobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('telefone1')); ?>:
		<b><?php echo CHtml::encode($data->telefone1); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('telefone2')); ?>:
		<b><?php echo CHtml::encode($data->telefone2); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('telefone3')); ?>:
		<b><?php echo CHtml::encode($data->telefone3); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:
		<b><?php echo CHtml::encode($data->email); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('emailnfe')); ?>:
		<b><?php echo CHtml::encode($data->emailnfe); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('emailcobranca')); ?>:
		<b><?php echo CHtml::encode($data->emailcobranca); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('codformapagamento')); ?>:
		<b><?php echo CHtml::encode($data->codformapagamento); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('credito')); ?>:
		<b><?php echo CHtml::encode($data->credito); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('creditobloqueado')); ?>:
		<b><?php echo CHtml::encode($data->creditobloqueado); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('observacoes')); ?>:
		<b><?php echo CHtml::encode($data->observacoes); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('mensagemvenda')); ?>:
		<b><?php echo CHtml::encode($data->mensagemvenda); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('vendedor')); ?>:
		<b><?php echo CHtml::encode($data->vendedor); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('rg')); ?>:
		<b><?php echo CHtml::encode($data->rg); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('desconto')); ?>:
		<b><?php echo CHtml::encode($data->desconto); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('notafiscal')); ?>:
		<b><?php echo CHtml::encode($data->notafiscal); ?></b>

		*/ ?>
	</div>
</div>