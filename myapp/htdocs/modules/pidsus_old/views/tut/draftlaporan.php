<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = $typeSurat=='p1'?'P1':'Pidsus1';
$this->subtitle=$typeSurat=='p1'?'Penerimaan Laporan':'Catatan Singkat Isi Laporan/Pengaduan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Pidsus', 'url' => ['listsurat', 'id' => $model->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noSpdpLid'];
?>
<div class="pds-lid-update2">


    <?= $this->render('_form', [
        'model' => $model,
    	'typeSurat' => $typeSurat,
    	'titleForm' => 'Update Laporan/Pengaduan',	
    ]) ?>

</div>
