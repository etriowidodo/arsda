<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Buat  Penerimaan SPDP';
//$this->params['breadcrumbs'][] = ['label' => 'Pengaduan/Laporan', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;
/*if (!isset($model->id_status)||$model->id_status==null){
	$model->id_status='1';
}*/
?>
<div class="pds-lid-create">


    <?= $this->render('_form', [
        'model' => $model,
    	'modelTersangkaUpdate'=>$modelTersangkaUpdate,	
    	'typeSurat' => $typeSurat,	
    	'titleForm' => $titleForm,	
    ]) ?>

</div>
