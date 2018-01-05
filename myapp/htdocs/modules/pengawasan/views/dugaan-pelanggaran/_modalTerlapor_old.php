<script>

function pilihPegawai(id, peg_nik, nip,nama,jabatan,satuan_kerja){
 $('#tbody_terlapor').append(
                    '<tr id="trterlapor'+nip+'">' +
                        '<td><input type="text" class="form-control" name="namaTerlapor[]"value="'+nama+'">'+ 
						'<input type="hidden" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="'+nip+'">'+
						'<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="'+id+'">'+
						'<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="'+peg_nik+'">'+
						'</td>' +
						/*
						'<td><input type="text" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="'+nip+'">'+
						'<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="'+id+'">'+
						'<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="'+peg_nik+'">'+
						'</td>' +
						*/
                        '<td><input type="text" class="form-control" name="jabatanTerlapor[]" readonly="true" value="'+jabatan+'"> </td>' +
                        '<td><input type="text" class="form-control" name="satuan_kerja[]" readonly="true" value="'+satuan_kerja+'"> </td>' +
						'<td><a class="btn btn-primary" id="btn_delete_terlapor">Hapus</a></td>'+
                    '</tr>'
	);

$('#m_terlapor').modal('hide');
}

</script>


<?php

use yii\helpers\Html;
use kartik\grid\GridView;	

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalContent">

	<?= GridView::widget([
            'id'=>'gridPegawai',
            'dataProvider'=> $dataProviderPegawai,
            'filterModel' => $searchPegawai,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['label'=>'NIP',
				'attribute' => 'peg_nip_baru',
				],
				['label'=>'Nama',
				'attribute' => 'peg_nama',
				],
                ['label'=>'Jabatan',
				'attribute' => 'jabatan',
				],
                ['label'=>'Satker',
                'attribute' => 'inst_nama',
                ],
				
				/*
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{select}',
                    'buttons' => [
                        'select' => function ($url, $model) {
                            return Html::checkbox('pilih', false, ['value' => $model['peg_nip'].'#'.$model['peg_nama'].'#'.$model['peg_tmplahirkab'].'#'.$model['peg_tgllahir']]);
                        },
                    ]
                ],
				*/
				
				[
        'class' => '\kartik\grid\ActionColumn',
         'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model,$key) {
                        return Html::button("Pilih", ["id"=>"buttonPilihPegawai", "class"=>"btn btn-success",
						"idPegawai"=>$model['id'],
						"peg_nik"=>$model['peg_nik'],
						"peg_nip"=>$model['peg_nip_baru'],
						"peg_nama"=>$model['peg_nama'],	
						"jabatan"=>$model['jabatan'],
                        "satuan_kerja"=>$model['inst_nama'],	
						"onClick"=>"pilihPegawai($(this).attr('idPegawai'), $(this).attr('peg_nik'), $(this).attr('peg_nip'),$(this).attr('peg_nama'),$(this).attr('jabatan'),$(this).attr('satuan_kerja'))"]);
                    }
        
       
		],
        ]
				
            ],
            'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],
			
			/*
            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
                'afterGrid'=>'<a id="pilih-terlapor" class="btn btn-success">Pilih</a>',
            ]
			*/

        ]); ?>
	
</div>	