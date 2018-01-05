<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'P36 - Berita Acara Pendapat Bersama';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'Pidsus 12';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'modelSuratJaksa' =>$modelSuratJaksa,
        'modelSuratTersangka' =>$modelSuratTersangka,	          	
    	'typeSurat' => $model->id_jenis_surat,
    	'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>
