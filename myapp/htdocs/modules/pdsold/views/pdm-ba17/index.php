<?php

use yii\helpers\Html;

use kartik\grid\GridView;

use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBa17Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba17-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-ba17/delete'
    ]);
    ?>
    
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
            


   	<div class="row">
                <div class="col-md-12">

       <?=
    GridView::widget([
        'id' => 'pdm-b16',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['no_surat_ba17']];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_surat_ba17',
                'label' => 'No. Surat BA-17',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_ba17;
                },
            ],
            [
                'attribute'=>'tgl_surat',
                'label' => 'Tgl. Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tgl_surat;
                },
            ],
//            [
//                'attribute'=>'sifat',
//                'label' => 'Sifat',
//                'format' => 'raw',
//                'value'=>function ($model, $key, $index, $widget) {
//                    $sifat  = MsSifatSurat::findOne(['id'=>$model['sifat']]);
//                    return $sifat->nama;
//                },
//            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_surat_ba17'], 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba17/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>
