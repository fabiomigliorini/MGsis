<?php
$this->pagetitle = Yii::app()->name . ' - NCM';
$this->breadcrumbs=array(
	'NCM',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<style>
.submenu {
    //min-height:20px;
    //padding:19px;
    //margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.tree {
    //min-height:20px;
    //padding:19px;
    //margin-bottom:20px;
    //background-color:#fbfbfb;
    //border:1px solid #999;
    //-webkit-border-radius:4px;
    //-moz-border-radius:4px;
    //border-radius:4px;
    //-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    //-moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    //box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #999;
    border-radius:5px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none
}
.tree li.parent_li>span {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
    background:#eee;
    border:1px solid #94a0b4;
    color:#000
}	
</style>

<script type='text/javascript'>

$(document).ready(function(){
	$('#search-form').change(function(){
		var ajaxRequest = $("#search-form").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'Listagem',
			{data: ajaxRequest}
		);
    });

    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
		
});


</script>

<h1>NCM</h1>
<hr>
<div class="row-fluid">
	<div class="span4 submenu">
		<ul class="nav nav-list">
			<?php foreach ($caps as $cap): ?>
				<li class="<?php echo ($cap->codncm == $id)?'active':''; ?>">
					<a tabindex="-1" href="<?php echo Yii::app()->createUrl('ncm/index', array('id' => $cap->codncm))?>">
						<?php echo $cap->ncm ?> <i class="icon-chevron-right"></i> <?php echo $cap->descricao ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>	
	<div class="span8">
		<?php if (isset($ncm)): ?>
			<h2>
				<?php echo $ncm->ncm; ?>
				<?php echo CHtml::link(CHtml::encode($ncm->descricao), array('ncm/view','id'=>$ncm->codncm)); ?>
			</h2>
			<div class="tree">
				<?php
				listaArvoreNcm($ncm->Ncms, '');
				?>
			</div>
		<?php endif; ?>
	</div>
</div>	
<?php
function listaArvoreNcm ($ncms, $css = 'display: none')
{
	?>
    <ul>
		<?php 
		foreach ($ncms as $ncm)
		{
			?>
			<li style="<?php echo $css; ?>">
				<span>
					<?php if (sizeof($ncm->Ncms) > 0): ?>
						<i class="icon-plus-sign"></i>
					<?php endif; ?>
					<?php echo Yii::app()->format->formataNcm($ncm->ncm); ?> 
				</span>
				<?php echo CHtml::link(CHtml::encode($ncm->descricao), array('ncm/view','id'=>$ncm->codncm)); ?>
				<?php listaArvoreNcm($ncm->Ncms);
				?>
			</li>
			<?
		}
		?>
    </ul>
<?php
}
?>