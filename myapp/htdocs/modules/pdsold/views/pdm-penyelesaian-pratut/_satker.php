<div class="modal-content" style="width: 780px;margin: 30px auto;overflow-y: auto;">    
    <div class="modal-header">
        Data Satker
        
    </div>
	
	 <div class="modal-body">
<div class="modalContent">
<?php 
use yii\helpers\Html;
use kartik\grid\GridView;
echo GridView::widget([
		'id'=>'grid_satker',
        'dataProvider' => $dataSatker,
        'filterModel' => $searchSatker,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->inst_satkerkd];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'inst_satkerkd',
            'inst_nama',

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihSatker", "class" => "btn btn-warning",
                                    "inst_satkerkd" => $model->inst_satkerkd,
                                    "nama" => $model->inst_nama,
                                    "onClick" => "pilihSatker($(this).attr('inst_satkerkd'),$(this).attr('nama'))"]);
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
                ],
    ]); ?>
	
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
            <a class="btn btn-danger" id='btn_close_satker' style="color: white">Batal</a>
    </div>
</div>
<script>
    function pilihSatker(inst_satkerkd,nama) {
        $("#nama_satker").val(nama);
        $("#pdmpenyelesaianpratutlimpah-kd_satker_pelimpahan").val(inst_satkerkd);
        $('#modalSatker').modal('hide');
		$('div.modal-backdrop').remove();
				$('body.modal-open').removeClass('modal-open');
				$('body').removeAttr( 'style' );
				$('#bannerformmodal').css( 'overflow-y','scroll' );
				$('body').css( 'overflow-y','hidden' );
    }
	
	
</script>


<?php
$js = <<< JS

	$('#btn_close_satker').click(function(){
		$('#modalSatker').modal('hide');
		$('#modalSatker.modal.in').modal('hide');
		$('body').css( 'overflow-y','hidden' );
		$('#bannerformmodal').css( 'overflow-y','scroll' );	
    });
			
	$(document).ajaxSuccess(function(){
		
		$(".panel-heading").hide();
		$(".kv-panel-before").hide();
		$(".close").hide();
		
	 });
	
	 $(".panel-heading").hide();
		$(".kv-panel-before").hide();
		$(".close").hide();
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>