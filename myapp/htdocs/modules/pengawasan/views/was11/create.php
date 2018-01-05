<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was11 */
$session = Yii::$app->session;
$this->title = 'WAS-11';
$this->subtitle = 'SURAT BANTUAN PENYAMPAIAN SURAT PANGGILAN SAKSI';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>

<div class="was10-create">
	
	<br />

    <?= $this->render('_form', [
        'model' => $model,
		'searchSatker' => $searchSatker,
		'dataProviderSatker' => $dataProviderSatker,
		'modelTembusanMaster' => $modelTembusanMaster,
		'modelSaksiIn' => $modelSaksiIn,
		'modelSaksiEk' => $modelSaksiEk,
		'modelSaksiIn_trans' => $modelSaksiIn_trans,
		'modelSaksiEk_trans' => $modelSaksiEk_trans,
		'modelSpwas1' => $modelSpwas1,
    ]) ?>

</div>
