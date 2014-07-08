<div class="registro <?php echo (!empty($data->inativo))?"alert-danger":""; ?>">
	<h4>
	</h4>
	<div class="row-fluid">
		<div class="span4">
			<b class="row">
				<a href="<?php echo Yii::app()->createUrl('pessoa/view', array('id'=>$data->codpessoa)); ?>">
					<?php echo CHtml::encode($data->fantasia); ?>
				</a>
				<?php if (!empty($data->inativo)): ?>
					<span class="label label-important pull-right">Inativado em <?php echo CHtml::encode($data->inativo); ?></span>
				<?php endif; ?>
				<?php if (!empty($data->inclusaoSpc)): ?>
					<span class="label label-warning pull-right">SPC em <?php echo CHtml::encode($data->inclusaoSpc); ?></span>
				<?php endif; ?>
			</b>
			<small class="muted">
				<b><?php echo CHtml::encode($data->pessoa); ?></b>
			</small><br>
			<small class="muted">
				<a href="<?php echo Yii::app()->createUrl('pessoa/view', array('id'=>$data->codpessoa)); ?>">
				<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codpessoa)); ?>
				</a>
			</small>
			<?php if (!empty($data->contato)): ?>
				<br>
				<small class="muted">
					<?php echo CHtml::encode($data->contato); ?>
				</small>
			<?php endif; ?>
			<?php if (!empty($data->GrupoCliente)): ?>
				<br>
				<small class="muted">
					<?php echo CHtml::link(CHtml::encode($data->GrupoCliente->grupocliente), array("grupoCliente/view", "id"=>$data->codgrupocliente)); ?>
				</small>
			<?php endif; ?>				
		</div>
		<div class="span6">
			<div>
				<b>
					<a href='tel:<?php echo CHtml::encode($data->telefone1); ?>'>
						<?php echo CHtml::encode($data->telefone1); ?>
					</a>
					<a href='tel:<?php echo CHtml::encode($data->telefone2); ?>'>
						<?php echo CHtml::encode($data->telefone2); ?>
					</a>
					<a href='tel:<?php echo CHtml::encode($data->telefone3); ?>'>
						<?php echo CHtml::encode($data->telefone3); ?>
					</a>
				</b>
			</div>
			<small class="muted">
				<?php echo Yii::app()->format->formataEndereco($data->endereco, $data->numero, $data->complemento, $data->bairro, $data->Cidade->cidade, $data->Cidade->Estado->sigla, $data->cep); ?>
			</small>
			<?php if (!$data->cobrancanomesmoendereco): ?>
				<br>
				<small class="muted">
					<?php echo Yii::app()->format->formataEndereco($data->enderecocobranca, $data->numerocobranca, $data->complementocobranca, $data->bairrocobranca, $data->CidadeCobranca->cidade, $data->CidadeCobranca->Estado->sigla, $data->cepcobranca); ?>
				</small>
			<?php endif; ?>
			<?php if (!empty($data->contato) or !empty($data->email) or !empty($data->emailnfe) or !empty($data->emailcobranca)): ?>
				<br>
				<small class="muted">
					<a href="mailto:<?php echo CHtml::encode($data->email); ?>"><?php echo CHtml::encode($data->email); ?></a>
					<?php if ($data->email <> $data->emailnfe): ?>
						<a href="mailto:<?php echo CHtml::encode($data->emailnfe); ?>"><?php echo CHtml::encode($data->emailnfe); ?></a>
					<?php endif; ?>
					<?php if ($data->email <> $data->emailcobranca and $data->emailnfe <> $data->emailcobranca): ?>
						<a href="mailto:<?php echo CHtml::encode($data->emailcobranca); ?>"><?php echo CHtml::encode($data->emailcobranca); ?></a>
					<?php endif; ?>
				</small>
			<?php endif; ?>
		</div>
		<small class="span2 muted text-right">
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
		</small>
	</div>
	<br>
</div>