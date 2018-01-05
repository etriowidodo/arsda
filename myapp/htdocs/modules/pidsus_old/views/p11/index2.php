<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDik */

$this->title = 'P 11 - Bantuan Pemanggilan Saksi/Ahli' ;
//$this->subtitle='Bantuan Pemanggilan Saksi/Ahli';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $titleForm;

$this->params['idtitle']=$_SESSION['noLapDik'];
?>
<div class="pds-lid-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'modelDik' => $modelDik,
    	'modelSuratIsi'=>$modelSuratIsi,


		'modelSuratPanggilan'=>$modelSuratPanggilan,

    	'typeSurat' => 'p11',
    	'titleForm' => $titleForm,
    	'readOnly' => $readOnly,	
    ]) ?>

</div>
