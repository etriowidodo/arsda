<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
if(strpos($model->id_jenis_surat,'3alit')!==false){
	$this->title = 'Pidsus 3A Setelah Penelitian';
}
else if(strpos($model->id_jenis_surat,'3alid')!==false){
	$this->title = 'Pidsus 3A Setelah Penyelidikan';
}
else if(strpos($model->id_jenis_surat,'3blit')!==false){
	$this->title = 'Pidsus 3B Setelah Penelitian';
}
else {
	$this->title = 'Pidsus 3B Setelah Penyelidikan';
}
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/viewlaporan','id'=>$model->id_pds_lid]];
if (strpos($model->id_jenis_surat,'3blit') !== false) {
	//$this->params['breadcrumbs'][] = ['label' => 'Daftar Pidsus 3B', 'url' => ['indexblit']];	
}
else if (strpos($model->id_jenis_surat,'3blid') !== false) {
	//$this->params['breadcrumbs'][] = ['label' => 'Daftar Pidsus 3B', 'url' => ['indexblid']];	
}
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'modelLid' => $modelLid,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'typeSurat' => '1',
    	'titleForm' => 'Update Laporan/Pengaduan',
    	'readOnly' => $readOnly,	
    ]) ?>

</div>
