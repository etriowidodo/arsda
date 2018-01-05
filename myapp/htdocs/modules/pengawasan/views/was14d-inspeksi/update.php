<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */

$this->title = 'Was14d ';// . ' ' . $model->id_dasar_spwas;
$this->params['breadcrumbs'][] = ['label' => 'Was14bd', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was14d, 'url' => ['view', 'id' => $model->id_was14d]];
$this->params['breadcrumbs'][] = 'Update';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="dasar-sp-was-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelwas14d' => $modelwas14d,
    ]) ?>

</div>
