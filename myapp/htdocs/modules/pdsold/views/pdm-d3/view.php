<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD3 */

$this->title = $model->id_d3;
$this->params['breadcrumbs'][] = ['label' => 'Pdm D3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-d3-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_d3], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_d3], [
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
            'id_d3',
            'id_perkara',
            'nama',
            'alamat',
            'is_keputusan',
            'no_surat',
            'tgl_putus',
            'biaya_perkara',
            'jml_denda',
            'angsur_denda',
            'sisa_denda',
            'jml_denda_ganti',
            'angsur_denda_ganti',
            'sisa_denda_ganti',
            'jml_uang_ganti',
            'angsur_uang_ganti',
            'sisa_uang_ganti',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'flag',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
