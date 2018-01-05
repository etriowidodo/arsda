<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'Pidsus 8 - Berita Acara Permintaan Keterangan';
//$this->subtitle= 'Berita Acara Permintaan Keterangan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus8', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_lid_surat, 'url' => ['view', 'id' => $model->id_pds_lid_surat]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-surat-update">

    <?= $this->render('_form', [
                'model' => $model,
                'modelLid' => $modelLid,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelKeterangan' =>$modelKeterangan,
            	//'modelPermintaanData' => $modelPermintaanData,
            	//'modelPermintaanData4' => $modelPermintaanData4,
		'modelSuratJaksa' => $modelSuratJaksa,
            	'titleForm' => 'Pidsus8',	
			//	'modelKpPegawai' =>$modelKpPegawai,
    			'modelSaksi'=>$modelSaksi,
				'modelJaksa' =>$modelJaksa,
            	'readOnly' => false,
    ]) ?>

</div>
