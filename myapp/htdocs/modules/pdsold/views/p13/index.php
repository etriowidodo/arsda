<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use app\models\MsSifatSurat;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmB4Search */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>
<div class="p13-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>


    <?php
    $form = ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/p13/delete'
    ]);
    ?>
    <div id="divHapus" style="text-align: right;">
        <a class="btn btn-warning btnHapusCheckboxIndex">hapus</a>
    </div>
    <br/>
    
    <?php ActiveForm::end() ?>

    <?=
    GridView::widget([
        'id' => 'p13',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => rawurlencode($model['no_surat_p13'])];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
            [
                'attribute'=>'no_surat_p13',
                'label' => 'No Surat P13',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_surat_p13'];
                },


            ],
			
			[
                'attribute'=>'sifat',
                'label' => 'Sifat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                        $sifat = MsSifatSurat::findOne(['id'=>$model['sifat']]);
                    return $sifat['nama'];
                },
            ],
			
			[
                'attribute'=>'lampiran',
                'label' => 'Lampiran',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['lampiran'];
                },


            ],
            
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_surat_p13'], 'class' => 'checkHapusIndex'];
                    }
            ],
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
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/p13/update2?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>