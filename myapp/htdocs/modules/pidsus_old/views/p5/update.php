<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'P5 - Laporan Hasil Penyelidikan';
//$this->subtitle ='Laporan Hasil Penyelidikan';
//$this->params['breadcrumbs'][] = ['label' => 'List Surat Lid', 'url' => ['../pidsus/default/viewlaporan', 'id'=>$modelLid->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'P5';
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-surat-update">


    <?= $this->render('_form', [
       			'model' => $model,
       			'modelLid' => $modelLid,
       			'modelSuratIsi' => $modelSuratIsi,
       			'modelTembusan' => $modelTembusan,
    			'titleForm' => $titleForm,
       			'readOnly' => false,
    ]) ?>

</div>
