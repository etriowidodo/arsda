<div class="modal-content" style="width: 780px;margin: 30px auto;">    
    <div class="modal-header">
        Data Pasal
        
    </div>

    <div class="modal-body">
<?php


use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

			<?= GridView::widget([
		'id'=>'grid_master_pasal',
        'dataProvider' => $dataPasal,
        'filterModel' => $searchPasal,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'pasal',
            'bunyi',
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihPasal", "class" => "btn btn-warning",
                                    "pasal" => $model['pasal'],
                                    "onClick" => "pilihPasal($(this).attr('pasal'))"]);
                    }
                        ],
            ],
        ],
		'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
		'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ]
    ]); ?>
		</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
     
		
	
	   <div class="modal-footer">
            
            <a class="btn btn-danger" id="batal-modal-pasal">Batal</a>
            
        </div>

<script>
    
    $('#batal-modal-pasal').on('click',function(){
        $('#m_pasal').modal('hide');
    });
</script>
