<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD2 */

$this->title = $model->id_d2;
$this->params['breadcrumbs'][] = ['label' => 'Pdm D2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-d2-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_d2], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_d2], [
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
            'id_d2',
            'id_perkara',
            'nama',
            'tgl_lahir',
            'alamat',
            'pekerjaan',
            'tgl_setor1',
            'tgl_setor2',
            'is_lunas',
            'nilai',
            'is_keputusan',
            'no_surat',
            'tgl_putus',
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
