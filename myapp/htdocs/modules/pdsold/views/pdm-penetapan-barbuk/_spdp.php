<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="modalContent">
<?= GridView::widget([
        'dataProvider' => $dataSPDP,
        'filterModel' => $searchSPDP,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'no_surat',
				'label' => 'NOMOR dan TANGGAL SPDP',
				'format' => 'raw',
				'value' => function ($model, $key, $index, $widget) {
					return $model['no_surat'];
				},
            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihSPDP", "class" => "btn btn-warning",
                                    "no_surat" => $model['no_surat'],
                                    "tgl_spdp" => $model['tgl_surat'],
                                    "tersangka" => Yii::$app->db->createCommand("select string_agg(nama,',') nama  from pidum.ms_tersangka where id_perkara='".$model['id_perkara']."' group by id_perkara")->queryScalar(),
                                    "onClick" => "pilihSpdp($(this).attr('no_surat'),$(this).attr('tgl_spdp'),$(this).attr('tersangka'))"]);
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
    function pilihSpdp(nomor,tanggal,tersangka) {

        $("#txt_tgl_spdp").val(tanggal);
        $("#txt_no_spdp").val(nomor);
        $("#pdmpenetapanbarbuk-tersangka").val(tersangka);
        $('#_spdp').modal('hide');
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
