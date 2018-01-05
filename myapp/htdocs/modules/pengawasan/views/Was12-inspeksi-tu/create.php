<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Was11 */

$this->title = 'WAS-12 Inspeksi';
$this->subtitle = 'SURAT BANTUAN UNTUK MELAKUKAN PEMANGGILAN TERHADAP TERLAPOR';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>

<div class="was12-create">

	<br />
    <?= $this->render('_form', [
        'model' => $model,
		'modelTembusanMaster' => $modelTembusanMaster,
		'modelTembusan' => $modelTembusan,
		'pemeriksaWas12' => $pemeriksaWas12,
		'modelWas10' => $modelWas10,
    ]) ?>

</div>

