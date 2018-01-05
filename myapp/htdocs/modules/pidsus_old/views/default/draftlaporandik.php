<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Laporan Terjadinya Tindak Pidana P-6';
//$this->subtitle=$typeSurat=='p1'?'Penerimaan Laporan Penyidikan':'Catatan Singkat Isi Penyidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Pidsus', 'url' => ['listsurat', 'id' => $model->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-update2">


    <?= $this->render('_formdik', [
        'model' => $model,
        'typeSurat' => $typeSurat,
        'titleForm' => 'Update Laporan/Pengaduan',
    ]) ?>

</div>
