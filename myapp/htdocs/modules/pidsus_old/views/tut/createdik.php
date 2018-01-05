<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Create Pengaduan/Laporan';
//$this->params['breadcrumbs'][] = ['label' => 'Pengaduan/Laporan', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;
if (!isset($model->id_status)||$model->id_status==null){
	$model->id_status='1';
}
?>
<div class="pds-lid-create">


    <?= $this->render('_formdik', [
        'model' => $model,
    	'titleForm' => $titleForm,	
    ]) ?>

</div>
