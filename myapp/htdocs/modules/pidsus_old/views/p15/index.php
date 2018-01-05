<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDik */

$this->title = 'P15 - Surat Perintah Penyerahan Berkas Perkara/Tanggung Jawab Tersangka dan Barang Buktinya';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Dilanjutkan ke Penyelidikan setelah penelitian', 'url' => ['index?id='.$modelDik->id_pds_dik]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noLapDik'];
?>
<div class="pds-dik-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'modelDik' => $modelDik,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
    	'modelSuratDetail'=>$modelSuratDetail,
		'modelKpPegawai' =>$modelKpPegawai,
    	'modelJaksa'=>$modelJaksa,		
    	'typeSurat' => 'p15',
    	'titleForm' => 'Surat Perintah Penyerahan',
    	'readOnly' => false,	
    ]) ?>

</div>
