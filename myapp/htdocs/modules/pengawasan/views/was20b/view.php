<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was20b */

$this->title = $model->id_tingkat;
$this->params['breadcrumbs'][] = ['label' => 'Was20bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was20b-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_tingkat' => $model->id_tingkat, 'id_kejati' => $model->id_kejati, 'id_kejari' => $model->id_kejari, 'id_cabjari' => $model->id_cabjari, 'no_register' => $model->no_register, 'id_sp_was2' => $model->id_sp_was2, 'id_ba_was2' => $model->id_ba_was2, 'id_l_was2' => $model->id_l_was2, 'id_was15' => $model->id_was15, 'id_was_20b' => $model->id_was_20b], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_tingkat' => $model->id_tingkat, 'id_kejati' => $model->id_kejati, 'id_kejari' => $model->id_kejari, 'id_cabjari' => $model->id_cabjari, 'no_register' => $model->no_register, 'id_sp_was2' => $model->id_sp_was2, 'id_ba_was2' => $model->id_ba_was2, 'id_l_was2' => $model->id_l_was2, 'id_was15' => $model->id_was15, 'id_was_20b' => $model->id_was_20b], [
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
            'id_tingkat',
            'id_kejati',
            'id_kejari',
            'id_cabjari',
            'no_register',
            'id_sp_was2',
            'id_ba_was2',
            'id_l_was2',
            'id_was15',
            'id_was_20b',
            'id_wilayah',
            'id_level1',
            'id_level2',
            'id_level3',
            'id_level4',
            'kpd_was_20b',
            'id_terlapor',
            'nip_pegawai_terlapor',
            'nrp_pegawai_terlapor',
            'nama_pegawai_terlapor',
            'pangkat_pegawai_terlapor',
            'golongan_pegawai_terlapor',
            'jabatan_pegawai_terlapor',
            'satker_pegawai_terlapor',
            'unit_kerja_terlapor',
            'dari',
            'tgl_was_20b',
            'no_was_20b',
            'sifat_surat',
            'lampiran',
            'perihal',
            'tgl_disampaikan_ba',
            'tgl_keberatan_ba',
            'nip_penandatangan',
            'nama_penandatangan',
            'pangkat_penandatangan',
            'golongan_penandatangan',
            'jabatan_penandatangan',
            'jbtn_penandatangan',
            'upload_file',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
