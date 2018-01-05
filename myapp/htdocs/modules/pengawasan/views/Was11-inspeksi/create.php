<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was11 */
$session = Yii::$app->session;
$this->title = 'WAS-11 Inspeksi';
$this->subtitle = 'SURAT BANTUAN PENYAMPAIAN SURAT PANGGILAN SAKSI';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>

<div class="was10-create">
	
	<br />
	<?//php print_r($model);
	//exit(); ?>
    <?= $this->render('_form', [
        'model' => $model,
		// 'searchSatker' => $searchSatker,
		// 'dataProviderSatker' => $dataProviderSatker,
		'modelTembusanMaster' => $modelTembusanMaster,
		'modelSaksiIn' => $modelSaksiIn,
		'modelSaksiEk' => $modelSaksiEk,
		// 'modelSaksiIn_trans' => $modelSaksiIn_trans,
		// 'modelSaksiEk_trans' => $modelSaksiEk_trans,
		 'modelSpwas2' => $modelSpwas2,
    ]) ?>

</div>
