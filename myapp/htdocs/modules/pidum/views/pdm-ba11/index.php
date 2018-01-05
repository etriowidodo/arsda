<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA12Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba11-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-ba11/delete/'
        ]);  
    ?>  
    <!-- <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div> -->
    <div id="divHapus" class="col-md-1">
            <button type="button" id="apus" class='btn btn-warning btnHapusCheckboxIndexi'>Hapus</button>
    </div>

    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_register_perkara'], 'data-tersangka'=>$model['id_tersangka']];
        },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            /*[
                'attribute'=>'no_sp',
                'label' => 'Nomor Surat Perintah',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_sp;
                },


            ],*/

            [
                'attribute'=>'nama',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->nama;
                },


            ],


            [
                'attribute'=>'tgl_ba11',
                'label' => 'Tanggal Pembuatan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_ba11));
                },


            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' =>$model->id_tersangka.'#'.$model->tgl_ba11, 'class' => 'checkHapusIndex'];
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
        var no_register_perkara = $(this).closest('tr').data('id');
        var id_tersangka = $(this).closest('tr').attr('data-tersangka');
        //alert(no_register_perkara);exit;
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-ba11/update?id_tersangka=" +id_tersangka+"&no_register_perkara="+no_register_perkara;
        //alert(url);exit;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);

    $("#apus").on("click",function(){
        $('form').submit();
           });

JS;

    $this->registerJs($js);
?>