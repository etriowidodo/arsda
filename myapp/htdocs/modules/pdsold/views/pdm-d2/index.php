<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmD2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm D2';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-d2-index">

<div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-d2/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_surat']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
					
			[
                'attribute'=>'nama',
                'label' => 'Nama',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama'];
                },
            ],
			
						
			[
                'attribute'=>'alamat',
                'label' => 'Alamat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['alamat'];
                },
            ],
			
			[
                'attribute'=>'tgl_setor',
                'label' => 'Tanggal Setor',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_setor1'];
                },
            ],
			

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_d2'], 'class' => 'checkHapusIndex'];
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
        var idd2 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-d2/update?id_d2=" + idd2;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>

