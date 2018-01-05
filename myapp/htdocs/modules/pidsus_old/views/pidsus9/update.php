<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'Pidsus 9 - Berita Acara Serah Terima Berkas';
//$this->subtitle='Berita Acara Serah Terima Berkas';
//$this->params['breadcrumbs'][] = ['label' => 'Lid', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat', 'url' => ['../pidsus/default/viewlaporan', 'id' => $model->id_pds_lid]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-surat-update">


    <?= $this->render('_form', [
       			'model' => $model,
       			'modelLid' => $modelLid,
       			'modelSuratIsi' => $modelSuratIsi,
				'modelSuratDetail' => $modelSuratDetail,
       			'titleForm' => $titleForm,
       			'readOnly' => false,
    ]) ?>

</div>
