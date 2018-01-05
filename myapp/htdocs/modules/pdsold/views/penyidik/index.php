<?php

use app\modules\pdsold\models\MsAsalsurat;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\MsPenyidikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penyidik';
$this->subtitle ='Ms Penyidik';
?>
<div class="ms-penyidik-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/penyidik/delete/'
        ]);  
    ?>  
	<div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'   => function ($model, $key, $index, $grid) {
        return ['data-id' => $model['id_penyidik']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama',
            // 'id_asalsurat',
            [
                'attribute' => 'penyidik',
                'label' => 'Penyidik',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {   
                    $status = MsAsalsurat::findOne(['id_asalsurat'=>$model->id_asalsurat]);                 
                    return $status['nama'];
                },
            ],
            
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_penyidik'], 'class' => 'checkHapusIndex'];
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
        var idpenyidik = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/penyidik/update?id_penyidik=" + idpenyidik;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>