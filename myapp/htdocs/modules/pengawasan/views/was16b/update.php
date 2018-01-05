<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16b */

$this->title = 'Was16b';
$this->params['breadcrumbs'][] = ['label' => 'Was16bs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_16b, 'url' => ['view', 'id' => $model->id_was_16b]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was16b-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelwas16b' => $modelwas16b,
    ]) ?>

</div>
