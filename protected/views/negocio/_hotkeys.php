<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.hotkeys.js');

?>
<script type="text/javascript">
function redireciona (btn) {
	var url = $(btn).attr("href");
	if (url != null)
		window.location = url;
	return false
}
	
$(document).ready(function(){
	$("body, input").bind('keydown.f1',function (e){ return redireciona ("#btnListagem"); });
	$("body, input").bind('keydown.f2',function (e){ return redireciona ("#btnNovo"); });
	$("body, input").bind('keydown.f3',function (e){ return redireciona ("#btnFechar"); });
	$("body, input").bind('keydown.f4',function (e){ return redireciona ("#btnDetalhes"); });
});
</script>