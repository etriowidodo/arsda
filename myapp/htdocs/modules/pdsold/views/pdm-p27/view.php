<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP27 */

$this->title = $model->no_register_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P27s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p27-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'no_register_perkara' => $model->no_register_perkara, 'no_surat_p27' => $model->no_surat_p27], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'no_register_perkara' => $model->no_register_perkara, 'no_surat_p27' => $model->no_surat_p27], [
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
            'no_register_perkara',
            'no_surat_p27',
            'tgl_ba',
            'no_putusan',
            'tgl_putusan',
            'id_tersangka',
            'keterangan_tersangka',
            'keterangan_saksi',
            'dari_benda',
            'dari_petunjuk',
            'alasan:ntext',
            'dikeluarkan',
            'tgl_surat',
            'id_penandatangan',
            'id_kejati',
            'id_kejari',
            'id_cabjari',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>