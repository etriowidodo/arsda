<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */

$this->title = 'SPDP';
$this->subtitle = 'Surat Pemberitahuan Dimulainya Penyidikan';
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
            'id_asalsurat',
            'id_penyidik',
            'no_surat',
            'tgl_surat',
            'tgl_terima',
            'ket_kasus:ntext',
        ],
    ]) ?>

</div>
