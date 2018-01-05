<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was12 */

$this->title = 'WAS-12 Inspeksi';
$this->subtitle = 'SURAT BANTUAN UNTUK MELAKUKAN PEMANGGILAN TERHADAP TERLAPOR';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="was12-update">

    <br />
    <?= $this->render('_form', [
        'model' => $model,
		'dataProviderSatker' => $dataProviderSatker,
		'modelTembusan' => $modelTembusan,
		'modelPemeriksa' => $modelPemeriksa,
		'modelTerlapor' => $modelTerlapor,
		'modelWas10' => $modelWas10,
    ]) ?>

</div>
