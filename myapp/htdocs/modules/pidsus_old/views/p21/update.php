<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'P21 - Pemberitahuan Hasil Penyidikan Sudah Lengkap';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'P23';
$this->params['idtitle']=$_SESSION['noSpdpTut'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
		'modelTut' => $modelTut,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'typeSurat' => $model->id_jenis_surat,
    	'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
