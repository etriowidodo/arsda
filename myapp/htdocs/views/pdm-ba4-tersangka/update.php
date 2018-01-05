<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdmBa4Tersangka */

$this->title = 'Update Pdm Ba4 Tersangka: ' . ' ' . $model->no_register_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba4 Tersangkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_register_perkara, 'url' => ['view', 'no_register_perkara' => $model->no_register_perkara, 'tgl_ba4' => $model->tgl_ba4, 'no_urut_tersangka' => $model->no_urut_tersangka]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-ba4-tersangka-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
