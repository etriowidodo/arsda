<script>

function pilihsatker(nip,nama){

$("#pdmba11-asal_satker").val(nip);
$("#nama_satker").val(nama);
$('#m_satker').modal('hide');
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
            'id'=>'gridKejaksaan',
            'dataProvider'=> $dataSatker,
            'filterModel' => $searchSatker,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['label'=>'Kode',
				'attribute' => 'inst_satkerkd',
				],
				['label'=>'Nama',
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
                        return Html::button("Pilih", ["id"=>"buttonPilihsatker", "class"=>"btn btn-warning",
						"nip"=>$model['inst_satkerkd'],
						"nama"=>$model['inst_nama'],
						"onClick"=>"pilihsatker($(this).attr('nip'),$(this).attr('nama'))"]);
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