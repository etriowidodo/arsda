<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */


if($model->id_jenis_surat=='pidsus5a'){
	$this->title = 'Pidsus 5A';
	$this->subtitle = 'Permintaan Keterangan';
}
else if($model->id_jenis_surat=='pidsus5b'){
	$this->title = 'Pidsus 5B';
	$this->subtitle = 'Bantuan Pemanggilan';
}
else if($model->id_jenis_surat=='pidsus5c'){
	$this->title = 'Pidsus 5C';
	$this->subtitle = 'Bantuan Permintaan Data\Tindakan Lain';
}
//$this->params['breadcrumbs'][] = ['label' => 'Create', 'url' => ['index?id='.$modelLid->id_pds_lid]];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-create">


    <?= $this->render('_form', [
        'model' => $model,
        'modelSuratIsi' => $modelSuratIsi,
        'modelTembusan'	 =>$modelTembusan,
        'modelLid' => $modelLid,
    	'typeSurat' => '1',	
    	'titleForm' => $titleForm,
    	'readOnly' => false,		
    ]) ?>

</div>
