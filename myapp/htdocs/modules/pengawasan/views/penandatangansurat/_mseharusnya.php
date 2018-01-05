<style type="text/css">
    .modal-dialog{
        width: 800px;
    }
</style>
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\db\Query;
use yii\db\Command;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>



<?php 
           
    // $searchModel = new \app\models\KpPegawaiSearch();
	$from_tabel = $param;
    // $jabatanModel = new \app\modules\pengawasan\models\JabatanMasterSearch;
    $searchModel = new \app\modules\pengawasan\models\Pegawai2Search();
    $dataProvider = $searchModel->searchPenandaTangan(Yii::$app->request->queryParams,$from_tabel);
    $dataProvider->pagination->pageSize=10;

?>
       <?= GridView::widget([
            'id'=>'seharusnya-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                [
                    'attribute'=>'nip',
                    'label' =>'NIP',
                ],
                [
                    'attribute'=> 'nama_penandatangan',
                    'label' => 'Nama Penandatangan',
                ], 
                 [
                    'attribute'=> 'jabatan_penandatangan',
                    'label' => 'Jabatan',
                ],      
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($parameter){
                            $result=json_encode($model);
                            // $result_query=new Query;
                            // $connection = \Yii::$app->db;
                            // $sql="select string_agg(id_jabatan,',') from (select id_jabatan from was.was_jabatan where upper(nama) in ('".'PLT. '.rtrim(strtoupper($model['jabatan_penandatangan']))."','".'PLH. '.rtrim(strtoupper($model['jabatan_penandatangan']))."','".'AN. '.rtrim(strtoupper($model['jabatan_penandatangan']))."','".rtrim(strtoupper($model['jabatan_penandatangan']))."')order by id_jabatan)a";
                            // $result_query=$connection->createCommand($sql)->queryOne();
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary pilih-ttd_seharusnya','json'=>$result,'parameter'=>$parameter]);
                        },
                    ]
                ],
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

