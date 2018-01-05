<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA10Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba7-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-ba7/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button id="apus" type="button"  class='btn btn-warning btnHapusCheckboxIndexi'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
         'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['tgl_ba7'],'data-no_reg'=> $model['no_register_perkara']];
         },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
      
            [
                'attribute'=>'tgl_ba7',
                'label' => 'Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model['tgl_ba7']));
                },


            ],

            [
                'attribute'=>'nama_tersangka_ba4',
                'label' => 'Nama Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama_tersangka_ba4'];
                },


            ],

            'kepala_rutan', 
            
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model["no_register_perkara"]."#".$model["tgl_ba7"]."#".$model["no_surat_t7"], 'class' => 'checkHapusIndex'];
                }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]);
    ?>

</div>
<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var tgl_ba7 = $(this).closest('tr').data('id');
        var no_reg  = $(this).closest('tr').data('no_reg');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba7/update?tgl_ba7="+tgl_ba7+"&no_reg="+no_reg;
        $(location).attr('href',url);
    });

       $("#apus").on("click",function(){
        $('form').submit();
           });
JS;

$this->registerJs($js);
?>