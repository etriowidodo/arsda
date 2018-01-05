<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT11Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t11-index">

<div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-t13/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_t13']];
        },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_surat',
                'label' => 'No Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat;
                },


            ],
         
            [
                'attribute'=>'tgl_surat',
                'label' => 'Tanggal Dikeluarkan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_surat));
                },


            ],

            // [
            //     'attribute'=>'id_tersangka',
            //     'label' => 'Tersangka',
            //     'format' => 'raw',
            //     'value'=>function ($model, $key, $index, $widget) {
            //         return $model->tersangka->nama;
            //     },


            // ],
            // [
            //     'attribute'=>'dokter',
            //     'label' => 'Dokter',
            //     'format' => 'raw',
            //     'value'=>function ($model, $key, $index, $widget) {
            //         return $model->dokter;
            //     },


            // ],      
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->id_t13, 'class' => 'checkHapusIndex'];
                }
            ],
            
        ],

        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,

    ]);  ?>

</div>
<?php

  $js = <<< JS
        $('td').dblclick(function (e) {
        var idt13 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-t13/update?id_t13=" + idt13;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>