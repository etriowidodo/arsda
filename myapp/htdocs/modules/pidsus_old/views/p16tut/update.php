<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'P16 - Surat Perintah Penujukan Jaksa Penuntut Umum';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'Pidsus 12';
$this->params['idtitle']=$_SESSION['noSpdpTut'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    	'modelTersangka'=>$modelTersangka,
        'modelJaksa' => $modelJaksa,
    	'modelSuratTersangka'=>$modelSuratTersangka,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'typeSurat' => $model->id_jenis_surat,
    	'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
