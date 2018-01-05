<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmT7;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT8Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t8-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-t8/delete'
        ]);  
    ?> 
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->no_register_perkara];
        },
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_surat_t8',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_t8;
                },


            ],
                     
            [
                'attribute'=>'id_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                                        $tsk = PdmT7::findAll(['no_register_perkara'=>$model->no_register_perkara,'no_urut_tersangka'=>$model->id_tersangka]);
                                        foreach($tsk as $rowtsk){
                                                $isi .= $rowtsk->nama_tersangka_ba4."<br/>";
                                        }
                    return $isi;
                },
            ],


            [
                'attribute'=>'putusan',
                'label' => 'Putusan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    //$status_putusan = $model->id_ms_status_t8;
                    switch ($model->id_ms_status_t8){
                        case 1:
                            $status_putusan='PENANGGUHAN PENAHANAN';
                            break;
                        case 2:
                            $status_putusan='PENGELUARAN DARI TAHANAN';
                            break;
                        case 3:
                            $status_putusan='PENCABUTAN PENANGGUHAN PENAHANAN';
                            break;
                    }
                    $statusT8 = ucwords($status_putusan);
                    return $statusT8;
                },


            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->no_surat_t8, 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>

<?php

 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var no_surat_t8 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-t8/update?no_surat_t8=" + no_surat_t8;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").prop("disabled",true);
           
JS;

    $this->registerJs($js);
?>