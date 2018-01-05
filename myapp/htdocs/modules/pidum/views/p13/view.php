<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */

$this->title = 'P13';
$this->subtitle = 'usul penghentian Penuntutan';
?>
<div class="pidum-pdm-spdp-view">

    <!--<p>
        <?/*= Html::a('Update', ['update', 'id' => $model->id_perkara], ['class' => 'btn btn-primary']) */?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id_perkara], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_perkara',
            'no_surat',
            'sifat',
            'lampiran',
            'kepada',
            'di_kepada',
            'no_sp',
            'tgl_sp',
            'id_tersangka',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'ket_saksi',
            'ket_ahli',
            'ket_surat',
            'petunjuk',
            'ket_tersangka',
            'hukum',
            'yuridis',
            'kesimpulan',
            'saran',
            'id_penandatangan',
            'upload_file',
        ],
    ]) ?>

</div>
