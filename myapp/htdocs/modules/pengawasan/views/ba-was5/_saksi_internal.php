<script type="text/javascript">

function Pilih(id_jabatan, peg_nik, peg_jabatan, peg_pangkat, peg_nip, peg_nama){
var counter = parseInt($("#counter").val())+1;

var html = '<tr data-key="0">';
html += '<td>'+counter+'</td>';
html += '<td data-col-seq="1">'+peg_nama+'<input type="hidden" name="id_h_jabatan[]" value="'+id_jabatan+'" ></td>';
html += '<td data-col-seq="2">'+peg_nip+'<input type="hidden" name="peg_nik[]" value="'+peg_nik+'" ></td>';
html += '<td data-col-seq="3">'+peg_jabatan+'</td>';
html += '<td class="skip-export kv-align-center kv-align-middle kv-row-select" data-col-seq="4" style="width:50px;"><input id="checkboxInternal" class="checkWas10" type="checkbox" value="0200002015000006" name="selection[]"></td>';
html += '</tr>';	

$("#counter").val(counter);	
$("#tbody-saksiinternal").append(html);

if(counter<2){
$("#btn-tambah-saksiinternal").prop('disabled', false);
}
else{
$("#btn-tambah-saksiinternal").prop('disabled', true);
}
$("#saksi_internal").modal("hide")	
}

</script>
    
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

$searchModel = new \app\models\KpPegawaiSearch();
$dataProvider = $searchModel->searchPegawai(Yii::$app->request->queryParams);
?>


       <?= GridView::widget([
            'id'=>'jpu-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'peg_nip',
                'peg_nip_baru',
                'peg_nama',
                            
                'jabat_tmt',
              //  'jabat_tmt',
                'jabatan',
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary','onclick'=>'Pilih('.$model['id'].','.$model['peg_nik'].',\''.$model['jabatan'].'\', \''.$model['jabat_tmt'].'\', \''.$model['peg_nip_baru'].'\', \''.$model['peg_nama'].'\')']);
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