<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Tun */

$this->title = 'Update Tun: ' . ' ' . $model->id_tun;
$this->params['breadcrumbs'][] = ['label' => 'Tuns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tun, 'url' => ['view', 'id' => $model->id_tun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tun-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
