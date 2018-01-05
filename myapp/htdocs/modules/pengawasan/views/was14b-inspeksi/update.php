<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */

$this->title = 'Was14b ';// . ' ' . $model->id_dasar_spwas;
$this->params['breadcrumbs'][] = ['label' => 'Was14b', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was14b, 'url' => ['view', 'id' => $model->id_was14b]];
$this->params['breadcrumbs'][] = 'Update';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="dasar-sp-was-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelwas14b' => $modelwas14b,
    ]) ?>

</div>
