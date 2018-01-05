<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsLoktahanan;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA11Search */
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
            'action' => '/pdsold/pdm-ba8/delete/'
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
            return ['data-id' => $model['no_register_perkara'],'data-tgl_ba8'=> $model['tgl_ba8']];
         },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
              [
                'attribute'=>'tgl_surat',
                'label' => 'Tgl Berita Acara',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_ba8'];
                },
            ],  
            [
                'attribute'=>'reg_nomor',
                'label' => 'Nomor Register Tahanan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_register_tahanan'];
                },
            ],

             [
                'attribute'=>'reg_nomor',
                'label' => 'Nama Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama_tersangka_ba4'];
                },
            ],
                        
            [
                'attribute'=>'tahanan',
                'label' => 'Dari Tahanan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return MsLoktahanan::findOne(['id_loktahanan' => $model['tahanan']])->nama;
                },
            ],
             [
                'attribute'=>'tahanan',
                'label' => 'Ke Tahanan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return MsLoktahanan::findOne(['id_loktahanan' => $model['ke_tahanan']])->nama;
                },
            ],
                        
 
                  [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_register_perkara']."_".$model['tgl_ba8'], 'class' => 'checkHapusIndex'];
                    }
                 ],                              
                ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
            ]);
            ?>

</div>

    
<?php
 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var no_register_perkara = $(this).closest('tr').data('id');
        var tgl_ba8 = $(this).closest('tr').data('tgl_ba8');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba8/update?no_register_perkara=" + no_register_perkara+"&tgl_ba8="+tgl_ba8;
        $(location).attr('href',url);
    });
       $("#apus").on("click",function(){
        $('form').submit();
           });
JS;

    $this->registerJs($js);
?>
