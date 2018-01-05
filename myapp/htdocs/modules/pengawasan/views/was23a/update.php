<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was23a */

$this->title = 'WAS-23A';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'lapdu', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Was23a';
?>
<div class="was23a-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan'   => $modelTembusan,
    ]) ?>

</div>
