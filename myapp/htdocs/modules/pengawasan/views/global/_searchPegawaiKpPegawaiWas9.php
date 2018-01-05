
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php 
                        
    // $searchModel = new \app\models\KpPegawaiSearch();
    // $searchModel = new \app\modules\pengawasan\models\SPWas1TerlaporSearch();
    // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    // $dataProvider->pagination->pageSize = 15;	

?>

       <?= GridView::widget([
            'id'=>'terlapor-grid',
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'peg_nip_baru',
                'peg_nama', 
                'jabatan',              
                'gol_kd',
                'pangkat',
                'inst_nama',
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

<script type="text/javascript">
    // $("#cari").click(function(){
    //     var kriteria=$("#kriteria").val();
    //     $.ajax({
    //         url:'gettable',
    //         type:'POST',
    //         data:'id='+kriteria,
    //         success:function(data){
    //             $(".kv-table-wrap").html(data);
    //         }
    //     })
    // });
</script>