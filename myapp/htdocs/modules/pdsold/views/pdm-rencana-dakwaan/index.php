<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT8Search */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = "Rencana Dakwaan";
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-rencana-dakwaan-index">

   <!-- <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>--->

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-rencana-dakwaan/delete'
    ]);
    ?>
  <!---  <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>--->
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_rencana_dakwaan'],'data-idberkas' => $model['id_berkas']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_tgl_berkas',
                  'label' => 'No & Tanggal Berkas',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_tgl_berkas'];
                },


            ],

            [
                'attribute'=>'id_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama_tersangka'];
                },


            ],

            [
                'attribute'=>'status input',
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
					if($model['id_rencana_dakwaan'] == 0){
						return "belum di input";
					}else
					{
					return "sudah di input";	
					}
                    
                },


            ],
        /*    [
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
            return ['value' => $model->id_rencana_dakwaan, 'class' => 'checkHapusIndex'];
        }
            ],*/
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

</div>

<?php
    $js = <<< JS
        $('td').dblclick(function (e) {
        var id_rencana_dakwaan = $(this).closest('tr').data('id');
		        var idberkas = $(this).closest('tr').data('idberkas');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-rencana-dakwaan/update?id_rencana_dakwaan="+id_rencana_dakwaan+"&id_berkas=" +idberkas;
        $(location).attr('href',url);
    });


JS;

    $this->registerJs($js);
?>