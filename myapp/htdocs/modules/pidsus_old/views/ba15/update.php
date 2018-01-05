<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikSurat */

$this->title = 'Ba 15 - Berita Acara Penerimaan dan Penelitian Tersangka';
//$this->subtitle= 'Berita Acara Penerimaan dan Penelitian Tersangka';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus8', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_lid_surat, 'url' => ['view', 'id' => $model->id_pds_lid_surat]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapDik'];
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
    			'modelTersangka'=>$modelTersangka,
				'modelJaksa' =>$modelJaksa,
            	'readOnly' => false,
    ]) ?>

</div>
