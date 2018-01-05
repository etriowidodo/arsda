<script>

function pilihKejaksaan(inst_satkerkd,inst_nama){

$("#inst_satkerkd").val(inst_satkerkd);
$("#inst_nama").val(inst_nama);
$('#m_kejaksaan').modal('hide');

if(inst_satkerkd=='00') { //3rd radiobutton
			$("#cbWilayah").removeAttr("disabled"); 
    		$("#cbInspektur").removeAttr("disabled"); 
    	}
    	else {
    		$("#cbWilayah").attr("disabled", "disabled"); 
    		$("#cbInspektur").attr("disabled", "disabled"); 
    	}
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
            'dataProvider'=> $dataProviderSatker,
            'filterModel' => $searchSatker,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'inst_satkerkd',
                'inst_nama',
				
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
                        return Html::button("Pilih", ["id"=>"buttonPilihKejaksaan", "class"=>"btn btn-success",
						"inst_satkerkd"=>$model['inst_satkerkd'],
						"inst_nama"=>$model['inst_nama'],	
						"onClick"=>"pilihKejaksaan($(this).attr('inst_satkerkd'),$(this).attr('inst_nama'))"]);
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
                'heading' => '<i class="glyphicon glyphicon-book"></i>',
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