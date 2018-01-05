<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */


?>
<div class="dugaan-pelanggaran-view">

    <h1><?= Html::encode($this->title) ?></h1>

   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_register',
            'no_register',
            'inst_satkerkd',
            'wilayah',
            'inspektur',
            'tgl_dugaan',
            'sumber_dugaan',
            'perihal',
            'ringkasan:ntext',
            'sumber_pelapor',
            'status',
            'upload_file',
           
        ],
    ]) ?>

</div>
