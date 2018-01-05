<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdmB11Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-b11-index">

  
   
	<?php
    $form = ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/pdm-b12/delete'
    ]);
    ?>
	
	  <div id="divHapus">
                <div class="pull-left"><?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div>
            </div>
	
	<div id="divHapus">
                <div class="pull-right"><a class='btn btn-danger delete hapusTembusan btnHapusCheckboxIndex'></a><br></div>
            </div>
  
    <!--<div id="btnHapus"></div><div id="btnUpdate"></div>-->
    <?php ActiveForm::end() ?>
	
	 
	 <div class="row">
                <div class="col-md-12">
	
	
    <?=
    GridView::widget([
        'id' => 'pdm-b4',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_b12']];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'no_surat',
                'label' => 'Nomor Surat',
                //'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'tgl_dikeluarkan',
                'label' => 'Tanggal',
				'format' => ['date', 'php:d-m-Y'],
            ],
			[
                'attribute' => 'barbuk',
                'label' => 'Barbuk',
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_b12'], 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

	</div>
	</div>
  

</div>

<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-b12/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>