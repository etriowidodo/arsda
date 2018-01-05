<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="modalContent">
<?= GridView::widget([
        'dataProvider' => $dataUU,
        'filterModel' => $searchUU,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['uu']];
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
                                    "uu" => $model['uu'],
                                    "tentang" => $model['tentang'],
                                    "onClick" => "pilihUU($(this).attr('uu'),$(this).attr('tentang'))"]);
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
            <a class="btn btn-danger" data-dismiss="modal" style="color: white">Batal</a>
    </div>

<script>
    function pilihUU(uu,tentang) {

        $("#mspasal-uu").val(uu);
        $("#label_tentang").text('Tentang : '+tentang);
        $("#mspedoman-uu").val(uu);
        $("#mspedoman-pasal").val('');
        $('#_undang').modal('hide');
    }
	
	
</script>


<?php
$js = <<< JS
	$(document).ajaxSuccess(function(){
		$(".panel-heading").hide();
		$(".kv-panel-before").hide();
		$(".close").hide();
	 });
	
	 
JS;
$this->registerJs($js);
?>
