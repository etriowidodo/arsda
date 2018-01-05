<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was27KlariSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was27';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was27-klari-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <div class="col-sm-12"  style="margin-top:10px;">
        <div class="btn-toolbar">
          <a class="btn btn-primary btn-sm pull-right" id="hapus_was27klari" href="/pengawasan/was27-klari/delete?id="><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
          <a class="btn btn-primary btn-sm pull-right" id="ubah_was27klari" href="/pengawasan/was27-klari/update?id="><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp; 
          <a class="btn btn-primary btn-sm pull-right" id="tambah_was27klari" href="/pengawasan/was27-klari/create"><i class="glyphicon glyphicon-plus"> Tambah</i></a>
        </div>

    </div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_was_27_klari',
            'no_register',
            'inst_satkerkd',
            'no_was_27_klari',
            'tgl',
            // 'sifat_surat',
            // 'jml_lampiran',
            // 'satuan_lampiran',
            // 'data_data',
            // 'upload_file_data',
            // 'analisa',
            // 'kesimpulan',
            // 'rncn_henti_was27klari_ 1_was_27_kla',
            // 'rncn_henti_was27klari_ 2_was_27_kla',
            // 'pendapat_1_was_27_kla',
            // 'pendapat',
            // 'persetujuan',
            // 'ttd_was_27_klari',
            // 'ttd_peg_nik',
            // 'ttd_id_jabatan',
            // 'upload_file',
            // 'flag',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

             [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions'=>['style'=>'width: 3%;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['id_was_27_klari'],'class'=>'checkbox-row'];
                        },
                ],
        ],
    ]); ?>

</div>
