<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\VwTerdakwaT2;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP48Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p48-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning tambahkan']) ?>
        <!-- <a class="btn btn-warning tambahkan" href="#">Tambah</a> -->
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-p48/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_surat']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_surat',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat;
                },


            ],

            [
                'attribute'=>'tgl_dikeluarkan',
                'label' => 'Tanggal Dikeluarkan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                },


            ],
            [
                'attribute'=>'no_register_perkara',
                'label' => 'Nomor Register Perkara',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_register_perkara;
                },


            ],
            [
                'attribute'=>'no_reg_tahanan',
                'label' => 'Nama Terpidana',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    
                    return VwTerdakwaT2::findOne(['no_register_perkara'=>$model->no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan])->nama;
                },
            ],

            [
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->no_surat, 'class' => 'checkHapusIndex'];
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
            var id_p48 = $(this).closest('tr').data('id');
            var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p48/update?id_p48="+id_p48;
            $(location).attr('href',url);
        });
JS;

    $this->registerJs($js);
?>