<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Was15';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Was15', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was15, 'url' => ['view', 'id' => $model->id_was15]];
$this->params['breadcrumbs'][] = 'Update';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="dipa-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelTerlapor' => $modelTerlapor,
        'modelDetail' => $modelDetail,
        'modelTembusan' => $modelTembusan,
        
    ]) ?>

</div>
