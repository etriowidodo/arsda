<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */

$this->title = $model->id_ba16;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba16s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba16-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ba16], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ba16], [
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
            'id_ba16',
            'id_perkara',
            'tgl_surat',
            'id_tersangka',
            'nama1',
            'umur1',
            'pekerjaan1',
            'nama2',
            'umur2',
            'pekerjaan2',
            'penggeledahan:ntext',
            'nama_geledah',
            'alamat_geledah',
            'pekerjaan_geledah',
            'penyitaan:ntext',
            'nama_sita',
            'alamat_sita',
            'pekerjaan_sita',
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
