<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Was-10';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Was-10', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_dipa, 'url' => ['view', 'id' => $model->id_dipa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dipa-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'spWas2' => $spWas2,
        'modelTembusan' => $modelTembusan,
        'result_expire' => $result_expire,
    ]) ?>

</div>
