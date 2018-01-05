<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbukSurat */

$this->title = $model->id_penetapan_barbuk_surat;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penetapan Barbuk Surats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penetapan-barbuk-surat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penetapan_barbuk_surat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penetapan_barbuk_surat], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_penetapan_barbuk_surat',
            'id_penetapan_barbuk',
            'nama_surat',
            'no_surat',
            'tgl_surat',
            'tgl_diterima',
        ],
    ]) ?>

</div>
