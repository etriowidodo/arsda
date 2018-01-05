<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'WAS-27 NOTA DINAS PENGHENTIAN PEMERIKSAAN';
$this->params['breadcrumbs'][] = ['label' => 'WAS-27 Inspeksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="dipa-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model, 
        'modelTerlapor' => $modelTerlapor, 
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelPelapor' => $modelPelapor, 
    ]) ?>

</div>
