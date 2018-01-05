<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was17 */

$this->title = 'Was17';
$this->params['breadcrumbs'][] = ['label' => 'Was17s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_16b, 'url' => ['view', 'id' => $model->id_was_16b]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was17-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelwas17' => $modelwas17,
    ]) ?>

</div>
