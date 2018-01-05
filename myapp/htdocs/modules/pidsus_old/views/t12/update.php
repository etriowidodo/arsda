<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'T12 - Permintaan Pemeriksaan Kesehatan Tahanan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'B12';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,

    	'typeSurat' => $model->id_jenis_surat,


		'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
