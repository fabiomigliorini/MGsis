<?php if ($model->emitida): ?>
	<?php
		if ($model->codstatus != NotaFiscal::CODSTATUS_AUTORIZADA
		&& $model->codstatus != NotaFiscal::CODSTATUS_CANCELADA
		&& $model->codstatus != NotaFiscal::CODSTATUS_INUTILIZADA
		):
	?>
		<input type="button" class="btn btn-small btn-block btn-primary btnEnviarNfe" value="Enviar (F9)" id="btnEnviarNfe" data-codnotafiscal="<?php echo $model->codnotafiscal; ?>" data-modelo="<?php echo $model->modelo; ?>">
		<?php if (!empty($model->numero)): ?>
			<input type="button" class="btn btn-small btn-block btn-danger btnInutilizarNfe" value="Inutilizar" data-codnotafiscal="<?php echo $model->codnotafiscal; ?>" id="btnInutilizarNfe">
		<?php endif; ?>
	<?php endif; ?>
	<?php if ($model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA): ?>
		<input type="button" class="btn btn-small btn-block btn-primary btnAbrirDanfe" data-modelo="<?php echo $model->modelo; ?>" value="Danfe" data-codnotafiscal="<?php echo $model->codnotafiscal; ?>" id="btnAbrirDanfe">
		<?php
			$email = $model->Pessoa->emailnfe;
			if (empty($email))
				$email = $model->Pessoa->email;
			if (empty($email))
				$email = $model->Pessoa->emailcobranca;
		?>
        <pre>
            <?php print_r($email); ?>
    </pre>
		<input type="button" class="btn btn-small btn-block btn-primary btnEnviarEmail" value="Email" data-codnotafiscal="<?php echo $model->codnotafiscal; ?>" data-email="<?php echo $email; ?>" id="btnEnviarEmail">
		<input type="button" class="btn btn-small btn-block btn-danger btnCancelarNfe" value="Cancelar" data-codnotafiscal="<?php echo $model->codnotafiscal; ?>" id="btnCancelarNfe">
	<?php endif; ?>
	<?php if (!empty($model->nfechave)): ?>
		<input type="button" class="btn btn-small btn-block btn-info btnConsultarNfe" data-codnotafiscal="<?php echo $model->codnotafiscal; ?>" value="Consultar" id="btnConsultarNfe">
	<?php endif; ?>
<?php endif; ?>
