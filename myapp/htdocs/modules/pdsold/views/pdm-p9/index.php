<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'P9';
//$this->params['breadcrumbs'][] = $this->title;

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p9-index">

<div id="divTambah" class="col-md-11">

   <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-p9/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
		'rowOptions'   => function ($model, $key, $index, $grid) {
        return ['data-id' => $model['id_p9']];
		},
		'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			// [
   //              'attribute'=>'id_perkara',
   //              'label' => 'Id Perkara',
   //              'format' => 'raw',
   //              'value'=>function ($model, $key, $index, $widget) {
   //                  return $model['id_perkara'];
   //              },
   //          ],
			
			[
                'attribute'=>'no_surat',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_surat'];
                },
            ],
			
			[
                'attribute'=>'kepada',
                'label' => 'Kepada',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['kepada'];
                },
            ],
			
			
			[
                'attribute'=>'di_kepada',
                'label' => 'Kepada',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['di_kepada'];
                },
            ],

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model['id_p9'], 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
		'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>


<?php
     $js = <<< JS
        $('td').dblclick(function (e) {
        var idp9 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p9/update?id_p9=" + idp9;
        $(location).attr('href',url);
    });

JS;
    $this->registerJs($js);
?>
