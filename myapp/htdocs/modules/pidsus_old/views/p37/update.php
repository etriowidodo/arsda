<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikSurat */

$this->title = 'P37';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus8', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_lid_surat, 'url' => ['view', 'id' => $model->id_pds_lid_surat]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noSpdpTut'];
if($model->id_jenis_surat=="p37sks"){
	$type='sks';
	$this->title = 'P37 - Surat Panggilan Saksi Ahli';
}
else if($model->id_jenis_surat=="p37tdw"){
	$type='tdw';
	$this->title = 'P37 - Surat Panggilan Terdakwa/Terpidana';
}
?>
<div class="pds-lid-surat-update">

    <?= $this->render("_form$type", [
                'model' => $model,
                'modelTut' => $modelTut,
            	'modelSuratIsi' => $modelSuratIsi,
            	//'modelKeterangan' =>$modelKeterangan,
            	//'modelPermintaanData' => $modelPermintaanData,
            	//'modelPermintaanData4' => $modelPermintaanData4,
		'modelSuratJaksa' => $modelSuratJaksa,
            	'titleForm' => 'p37',	
			//	'modelKpPegawai' =>$modelKpPegawai,
    			'modelSaksiTersangka'=>$modelSaksiTersangka,
				'modelJaksa' =>$modelJaksa,
            	'readOnly' => false,
    ]) ?>

</div>
