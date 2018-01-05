<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Klari */

$this->title = 'WAS 27';
$this->subtitle ='NOTA DINAS USUL PENGHENTIAN KLARIFIKASI';
$this->params['breadcrumbs'][] = ['label' => 'Was27 Klaris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="was27-klari-create">

     <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelTerlapor' => $modelTerlapor,
        'modelPelapor' => $modelPelapor,
        'modelLapdu' => $modelLapdu,
		// 'spwas1' => $spwas1,
    ]) ?>

</div>
