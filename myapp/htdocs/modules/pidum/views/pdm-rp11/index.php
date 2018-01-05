<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\VwTerdakwaT2;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmRP11Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-rp11-index">
    <?php //echo count($dataProvider) ?>
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-rp11/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button type="button" id="apus" class='btn btn-warning '>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_akta']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_register_perkara',
                'label' => 'No Register Perkara',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_register_perkara;
                },


            ],
            [
                'attribute'=>'no_akta',
                'label' => 'Nomor Akta',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_permohonan.' Tanggal '.date("d-m-Y", strtotime($model->tgl_permohonan));
                },


            ],
            [
                'attribute'=>'id_status_yakum',
                'label' => 'Status Upaya Hukum',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    if($model->id_status_yakum==1){
                        return 'Banding';
                    }else{
                        return 'Kasasi';
                    }
                    
                },


            ],
            [
                'attribute'=>'id_pemohon',
                'label' => 'Pemohon',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    if($model->id_pemohon==1){
                        return 'Jaksa';
                    }else{
                        return 'Tersangka';
                    }
                    
                },


            ],
            [
                'attribute'=>'no_reg_tahanan',
                'label' => 'Nama Terdakwa',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $nama = VwTerdakwaT2::find()->select('nama')->where(['no_register_perkara'=>$model->no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan])->scalar();
                    return $nama;
                },


            ],

            [
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->no_register_perkara.'#'.$model->no_akta.'#'.$model->id_status_yakum.'#'.$model->no_reg_tahanan, 'class' => 'checkHapusIndex'];
                }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

</div>


<?php
    $js = <<< JS
            
        $(document).ready(function(){
			$('body').addClass('fixed sidebar-collapse');
		});
            
    $('td').dblclick(function (e) {
        var no_akta = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-rp11/update?no_akta="+no_akta;
        $(location).attr('href',url);
    });


    $("#apus").on("click",function(){
        $('form').submit();
    });
JS;

    $this->registerJs($js);
?>