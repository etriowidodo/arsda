<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapat */

$this->title = $model->no_register_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Nota Pendapats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-nota-pendapat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'no_register_perkara' => $model->no_register_perkara, 'jenis_nota_pendapat' => $model->jenis_nota_pendapat, 'id_nota_pendapat' => $model->id_nota_pendapat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'no_register_perkara' => $model->no_register_perkara, 'jenis_nota_pendapat' => $model->jenis_nota_pendapat, 'id_nota_pendapat' => $model->id_nota_pendapat], [
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
            'jenis_nota_pendapat',
            'id_nota_pendapat',
            'kepada',
            'dari_nip_jaksa_p16a',
            'dari_nama_jaksa_p16a',
            'dari_jabatan_jaksa_p16a',
            'dari_pangkat_jaksa_p16a',
            'tgl_nota',
            'perihal_nota',
            'dasar_nota:ntext',
            'pendapat_nota:ntext',
            'flag_saran',
            'saran_nota:ntext',
            'flag_pentunjuk',
            'petunjuk_nota:ntext',
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