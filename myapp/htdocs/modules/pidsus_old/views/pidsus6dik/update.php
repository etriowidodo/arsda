<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'Pidsus 6 - Surat Perintah Penunjukan Penelaah (Tahap Penyidikan)';
//$this->subtitle='Surat Perintah Penunjukan Penelaah';
//$this->params['breadcrumbs'][] = ['label' => 'Pds Dik Surat', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_lid_surat, 'url' => ['view', 'id' => $model->id_pds_lid_surat]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-surat-update">


    <?= $this->render('_form', [
       			'model' => $model,
       			'modelDik' => $modelDik,
       			'modelSuratIsi' => $modelSuratIsi,
       			'modelTembusan' => $modelTembusan,
       			'modelJaksa' => $modelJaksa,
       			'modelSuratJaksa' => $modelSuratJaksa,
       			'titleForm' => $titleForm,
       			'readOnly' => false,
    ]) ?>

</div>
