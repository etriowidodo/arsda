<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'Pidsus 11 - Catatan Pelaksanaan Tindakan Lain';
//$this->params['breadcrumbs'][] = ['label' => 'Pds Lid Surats', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-surat-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    	'readOnly'=>$readOnly,
    	'modelJaksa'=>$modelJaksa,
    	'modelKpPegawai'=>$modelKpPegawai,
		'id'=>$id	
    ]) ?>

</div>
