<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PdmBa4Tersangka */

$this->title = $model->no_register_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba4 Tersangkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba4-tersangka-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'no_register_perkara' => $model->no_register_perkara, 'tgl_ba4' => $model->tgl_ba4, 'no_urut_tersangka' => $model->no_urut_tersangka], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'no_register_perkara' => $model->no_register_perkara, 'tgl_ba4' => $model->tgl_ba4, 'no_urut_tersangka' => $model->no_urut_tersangka], [
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
            'tgl_ba4',
            'id_peneliti',
            'no_reg_tahanan',
            'no_reg_perkara',
            'alasan:ntext',
            'id_penandatangan',
            'upload_file',
            'no_urut_tersangka',
            'tmpt_lahir',
            'tgl_lahir',
            'alamat',
            'no_identitas',
            'no_hp',
            'warganegara',
            'pekerjaan',
            'suku',
            'nama',
            'id_jkl',
            'id_identitas',
            'id_agama',
            'id_pendidikan',
            'umur',
            'id_kejati',
            'id_kejari',
            'id_cabjari',
            'created_ip',
            'created_time',
            'updated_ip',
            'nama_ttd',
            'pangkat_ttd',
            'jabatan_ttd',
            'updated_time',
            'created_by',
            'updated_by',
            'foto:ntext',
        ],
    ]) ?>

</div>
