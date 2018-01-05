<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'B21 - Surat Perintah Pemanfaatan/Penyerahan/Pemusnahan Barang Terlarang/Barang Bukti yang Dikembalikan Tetapi Tidak Diambil/Barang Temuan  ';

//$this->params['breadcrumbs'][] = 'B12';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    	'modelSuratIsi'=>$modelSuratIsi,
    	'modelTembusan'=>$modelTembusan,
		'modelSuratDetail'=>$modelSuratDetail,
    	'typeSurat' => $model->id_jenis_surat,
		'modelJaksa' =>$modelJaksa,
		'modelSuratJaksa'=>$modelSuratJaksa,

		'titleForm' => $this->title,
    	'readOnly' => false,	
    ]) ?>

</div>