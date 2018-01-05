<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikSurat */

if($model->id_jenis_surat=='ba1tsk'){
	$this->title = 'BA 1 - Berita Acara Pemeriksaan Tersangka';
}
else  $this->title = 'BA 1 - Berita Acara Pemeriksaan Saksi';
//$this->subtitle= '';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus8', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_lid_surat, 'url' => ['view', 'id' => $model->id_pds_lid_surat]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-surat-update">

    <?= $this->render('_form', [
                'model' => $model,
                'modelDik' => $modelDik,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelKeterangan' =>$modelKeterangan,
            	//'modelPermintaanData' => $modelPermintaanData,
            	//'modelPermintaanData4' => $modelPermintaanData4,
				'modelSuratJaksa' => $modelSuratJaksa,
            	'titleForm' => 'Ba1',	
			//	'modelKpPegawai' =>$modelKpPegawai,
    			'modelSuratSaksi'=>$modelSuratSaksi,
				'modelJaksa' =>$modelJaksa,
            	'readOnly' => false,
    ]) ?>

</div>
