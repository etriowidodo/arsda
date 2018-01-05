<style type="text/css">
    .modal-dialog{
        width:800px;
    }
</style>
    
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
	$from_tabel = $param;
    $searchModel = new \app\modules\pengawasan\models\JabatanMasterSearch;
    // $searchModel = new \app\modules\pengawasan\models\Pegawai2Search();
    $dataProvider = $searchModel->searchJabatan(Yii::$app->request->queryParams,$from_tabel);
    $dataProvider->pagination->pageSize=10;

?>
       <?= GridView::widget([
            'id'=>'jbtn-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                // 'nip',
                [
                    'attribute'=>'id_jabatan',
                    'label' =>'Kode Jabatan',
                ],
                [
                    'attribute'=> 'nama',
                    'label' => 'Nama Jabatan',
                ],
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            $result=json_encode($model);
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary pilih-jbtn','json'=>$result]);
                        },
                    ]
                ],
               //$("#'.$param.'-peg_nip_baru").val("'.$model['peg_nip_baru'].'");$("#'.$param.'-nama").val("'.$model['nama'].'");$("#'.$param.'-gol_kd").val("'.$model['gol_kd'].'");$("#'.$param.'-jabatan").val("'.$model['jabatan'].'");$("#'.$param.'-gol_pangkat2").val("'.$model['gol_pangkat2'].'");$("#'.$param.'-jbtn_penandatangan").val("'.$model['jabatan_penandatangan'].'");$("#peg_tandatangan").modal("hide");$("#peg_tandatanganeks").modal("hide");
            ],
            'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]); ?>

