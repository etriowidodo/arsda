<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidRenlid */
if($model->id_jenis_surat=='pidsus5a'){
	$this->title = 'Pidsus 5A - Permintaan Keterangan';
	
}
else if($model->id_jenis_surat=='pidsus5b'){
	$this->title = 'Pidsus 5B - Bantuan Pemanggilan';
	
}
else if($model->id_jenis_surat=='pidsus5c'){
	$this->title = 'Pidsus 5C - Bantuan Permintaan Data\Tindakan Lain';
	
}
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Rencana Penyelidikan', 'url' => ['index?id='.$model->id_pds_lid]];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-renlid-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelLid' => $modelLid,
        'modelSuratIsi' => $modelSuratIsi,
        'modelTembusan'	 =>$modelTembusan,
        'modelPermintaanData' => $modelPermintaanData,
        'modelPermintaanData4' => $modelPermintaanData4,	
        'titleForm' => $titleForm,	
        'readOnly' => $readOnly,
    ]) ?>

</div>
