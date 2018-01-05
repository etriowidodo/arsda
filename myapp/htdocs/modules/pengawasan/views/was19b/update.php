<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was19b */

$this->title = 'Update Was19b';
$this->params['breadcrumbs'][] = ['label' => 'Was19bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_19b, 'url' => ['view', 'id' => $model->id_was_19b]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was19b-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelwas19b'   => $modelwas19b,
    ]) ?>

</div>
