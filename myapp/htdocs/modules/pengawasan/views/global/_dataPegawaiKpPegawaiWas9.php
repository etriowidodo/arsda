
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php $form = ActiveForm::begin([
        'action' => ['gettable'],
        'method' => 'get',
        'id'=>'searchForm', 
        'options'=>['name'=>'searchForm']
    ]); ?>
<div class="col-md-5">
         <div class="form-group">
             <label class="control-label col-md-2">Cari</label>
                <div class="col-md-10">
                <input type="text" class="form-control" value="" id="kriteria" name="cari">
                </div>
         </div>
          
    </div>
    <div class="col-md-1">
         <div class="form-group">
          <button type="submit" class="btn btn-primary" id="cari">Cari</button>
         </div>
    </div>
   <?php ActiveForm::end(); ?>
<?php 
                        
    // $searchModel = new \app\models\KpPegawaiSearch();
    $searchModel = new \app\modules\pengawasan\models\SPWas1TerlaporSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->pagination->pageSize = 10;	

?>
<div class="col-sm-12">
    <?php Pjax::begin(['id' => 'rekam-grid', 'timeout' => false,'formSelector' => '#searchForm','enablePushState' => false]) ?>
       <?= GridView::widget([
            'id'=>'terlapor-grid',
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                [   'label'=>'Nip baru',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'peg_nip_baru',
                ],

                [   'label'=>'Nama',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=> 'peg_nama', 
                ],

                [   'label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=> 'jabatan', 
                ],
                 
                [   'label'=>'Golongan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'gol_kd',
                ],  

                [   'label'=>'Pangkat',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'pangkat',
                ],

                [   'label'=>'Instansi',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'inst_nama',
                ],              
                
                
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['id'=>'btn-terlapor-kp','class' => 'btn btn-primary btn-terlapor','onclick'=>'$("#'.$param.'-nama_pegawai_terlapor").val("'.$model['peg_nama'].'");$("#'.$param.'-nip").val("'.(empty($model['peg_nip_baru']) ? $model['nip']:$model['peg_nip_baru']) .'");$("#'.$param.'-golongan_pegawai_terlapor").val("'.$model['gol_kd'].'");$("#'.$param.'-jabatan_pegawai_terlapor").val("'.$model['jabatan'].'");$("#'.$param.'-pangkat_pegawai_terlapor").val("'.$model['pangkat'].'");$("#'.$param.'-satker_pegawai_terlapor").val("'.$model['inst_nama'].'");$("#peg_terlapor").modal("hide");']);
                        },
                    ]
                ],
               
            ],
            'responsive' => true,
            'hover' => true,
            'export' => false,
            'pjax' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ],
                'neverTimeout' => true,
            //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]); ?>
<?php Pjax::end(); ?>
</div>
<script type="text/javascript">
    // $("#cari").click(function(){
    //     var kriteria=$("#kriteria").val();
    //     $.ajax({
    //         url:'gettable',
    //         type:'POST',
    //         data:'id='+kriteria,
    //         success:function(data){
    //             $(".panel-primary").html(data);
    //         }
    //     })
    // });
</script>