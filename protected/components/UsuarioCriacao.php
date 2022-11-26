<?php

class UsuarioCriacao extends CWidget
{

	public $model;

	public function run()
	{
		?>
		<small class="muted">
			<?php if (isset($this->model->criacao) || isset($this->model->codusuariocriacao)): ?>
				Criado
				<?php echo isset($this->model->criacao)?CHtml::encode('em ' .$this->model->criacao):''; ?>
				<?php echo isset($this->model->codusuariocriacao)?'por ' . CHtml::link($this->model->UsuarioCriacao->usuario, array('usuario/view', 'id'=>$this->model->codusuariocriacao), ['tabindex' =>"-1"]):''; ?>
			<?php endif;?>
			<?php if (($this->model->criacao <> $this->model->alteracao) or ($this->model->codusuariocriacao <> $this->model->codusuarioalteracao)): ?>
				Alterado
				<?php echo (isset($this->model->alteracao) && ($this->model->criacao <> $this->model->alteracao))?CHtml::encode('em ' .$this->model->alteracao):''; ?>
				<?php echo (isset($this->model->codusuarioalteracao))?'por ' . CHtml::link($this->model->UsuarioAlteracao->usuario, array('usuario/view', 'id'=>$this->model->codusuarioalteracao), ['tabindex' =>"-1"]):''; ?>
			<?php endif;?>
		</small>
		<?
	}

}
