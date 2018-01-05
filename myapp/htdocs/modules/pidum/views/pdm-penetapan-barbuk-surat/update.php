<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbukSurat */

$this->title = 'Update Pdm Penetapan Barbuk Surat: ' . ' ' . $model->id_penetapan_barbuk_surat;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penetapan Barbuk Surats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_penetapan_barbuk_surat, 'url' => ['view', 'id' => $model->id_penetapan_barbuk_surat]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-penetapan-barbuk-surat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
