<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Pidsus 21 - Nota Dinas Usul Tindakan Lain';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'Pidsus 20A';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
		'model' => $model,
		'modelDik' => $modelDik,
		'modelSuratIsi' => $modelSuratIsi,
		'modelTembusan'	 =>$modelTembusan,
		'modelSuratDetail'	 =>$modelSuratDetail,

    	'typeSurat' => $model->id_jenis_surat,
    	'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
