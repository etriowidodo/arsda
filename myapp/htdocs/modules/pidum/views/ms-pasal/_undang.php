<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="modalContent">
<?= GridView::widget([
        'dataProvider'  => $dataUU,
        'filterModel'   => $searchUU,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'uu',
            'deskripsi',
            'tentang',
            'tanggal',

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihUU", "class" => "btn btn-warning",
                                    "uu" => $model['id'],
                                    "tentang" => $model['tentang'],
                                    "isi" => $model['uu'],
                                    "onClick" => "pilihUU($(this).attr('uu'),$(this).attr('tentang'),$(this).attr('isi'))"]);
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
		'pjaxSettings' => [
			'options' => [
				'enablePushState' => false,
			]
		]
    ]); ?>
	
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
            <a class="btn btn-danger" id="btn_close_undang" style="color: white">Batal</a>
    </div>

<script>
    function pilihUU(uu,tentang,isi) {
        $("#mspasal-id").val(uu);
        $("#label_tentang").text('Tentang : '+tentang);
        $("#mspedoman-id").val(uu);
        $("#mspedoman-id_pasal").val('');
        $('input.undang-undang:eq('+localStorage.indexUndang+')').val(isi);
        $('input.tentang-undang-undang:eq('+localStorage.indexUndang+')').val(tentang);
        $('input.undang-undang:eq('+localStorage.indexUndang+')').attr('attr-id',uu);
        $('#_undang').modal('hide');
        $('#pengantar').css( 'overflow-y','scroll' );
    }
</script>


<?php
$js = <<< JS
	$(document).ajaxSuccess(function(){
		$(".panel-heading").hide();
		$(".kv-panel-before").hide();
		$(".close").hide();
	 });
	
	  $("#btn_close_undang").click(function()
        {
			$("#_undang").modal('hide');
			$('#pengantar').css( 'overflow-y','scroll' );
		});
JS;
$this->registerJs($js);
?>
