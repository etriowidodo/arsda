<script>

function pilihKejaksaan(inst_satkerkd,inst_nama,param){
$("#inst_satkerkd_"+param).val(inst_satkerkd);
$("#inst_nama_"+param).val(inst_nama);
$('#m_kejaksaan_'+param).modal('hide');

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

<?php
echo "test".$param;
?>
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
                    'pilih' => function ($url, $model,$key) use ($param){
                        return Html::button("Pilih", ["id"=>"buttonPilihKejaksaan", "class"=>"btn btn-success",
						"inst_satkerkd"=>$model['inst_satkerkd'],
						"inst_nama"=>$model['inst_nama'],	
						"param"=>$param,	
						"onClick"=>"pilihKejaksaan($(this).attr('inst_satkerkd'),$(this).attr('inst_nama'),$(this).attr('param'))"]);
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