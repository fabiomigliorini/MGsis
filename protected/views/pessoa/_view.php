<div class="registro">
	<div class="row-fluid">
		<div class="span4">
			<?php if (!empty($data->inativo)): ?>
				<span class="label label-warning">Inativado em <?php echo CHtml::encode($data->inativo); ?></span>
			<?php endif; ?>
			<div class="codigo">
				<a href="<?php echo Yii::app()->createUrl('pessoa/view', array('id'=>$data->codpessoa)); ?>">
				<?php echo CHtml::encode($data->fantasia); ?>
				</a>
			</div>
			<div class="detalhes ">
				<b><?php echo CHtml::encode($data->pessoa); ?></b>
			</div>
			<?php if (!empty($data->contato)): ?>
				<div class="detalhes">
					<?php echo CHtml::encode($data->contato); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="span6">
			<div>
				<b>
					<?php echo CHtml::encode($data->telefone1); ?>
					<?php echo CHtml::encode($data->telefone2); ?>
					<?php echo CHtml::encode($data->telefone3); ?>
				</b>
			</div>
			<div class="detalhes">
				<?php echo CHtml::encode(Yii::app()->format->formataEndereco($data->endereco, $data->numero, $data->complemento, $data->bairro, $data->Cidade->cidade, $data->Cidade->Estado->sigla, $data->cep)); ?>
			</div>
			<?php if ($data->enderecosdiferentes): ?>
				<div class="detalhes">
					<?php echo CHtml::encode(Yii::app()->format->formataEndereco($data->enderecocobranca, $data->numerocobranca, $data->complementocobranca, $data->bairrocobranca, $data->CidadeCobranca->cidade, $data->CidadeCobranca->Estado->sigla, $data->cepcobranca)); ?>
				</div>
			<?php endif; ?>
			<?php if (!empty($data->contato) or !empty($data->email) or !empty($data->emailnfe) or !empty($data->emailcobranca)): ?>
				<div class="detalhes">
					<a href="mailto:<?php echo CHtml::encode($data->email); ?>"><?php echo CHtml::encode($data->email); ?></a>
					<?php if ($data->email <> $data->emailnfe): ?>
						<a href="mailto:<?php echo CHtml::encode($data->emailnfe); ?>"><?php echo CHtml::encode($data->emailnfe); ?></a>
					<?php endif; ?>
					<?php if ($data->email <> $data->emailcobranca and $data->emailnfe <> $data->emailcobranca): ?>
						<a href="mailto:<?php echo CHtml::encode($data->emailcobranca); ?>"><?php echo CHtml::encode($data->emailcobranca); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="span2 detalhes">
			<div>
				<b><?php echo CHtml::encode(Yii::app()->format->formataCnpjCpf($data->cnpj, $data->fisica)); ?> </b>
			</div>
			<div>
				<?php 
				if (!empty($data->ie))
					echo CHtml::encode(Yii::app()->format->formataInscricaoEstadual($data->ie, $data->Cidade->Estado->sigla)); 
				?>
				<?php echo CHtml::encode($data->rg); ?>
			</div>
			<div>
				<b><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codpessoa)); ?></b>
			</div>
		</div>
	</div>
		
		<?php /*

		<?php echo CHtml::encode($data->getAttributeLabel('inativo')); ?>:
		<b><?php echo CHtml::encode($data->inativo); ?></b>


		*/ ?>
</div>