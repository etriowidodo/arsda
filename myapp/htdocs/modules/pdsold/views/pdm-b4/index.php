<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmB4Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'B4';
$this->subtitle = 'Surat Perintah Penggeledahan/Penyegelan/Penyitaan/Penitipan';
/*$this->params['breadcrumbs'][] = $this->title;*/
?>
    <div class="pdm-b4-index">

        <!--<h1><? /*= Html::encode($this->title) */ ?></h1>-->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <!--<p>

        </p>-->

        <?php
        $form = ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-b4/delete'
        ]);
        ?>
        <div id="divHapus"></div>
        <?= Html::a('Tambah B4', ['create'], ['class' => 'btn btn-warning']) ?>
        <div class="pull-right">
            <a class="btn btn-danger delete btnHapusCheckboxIndex"></a>
        </div>
        <!--<div id="btnHapus"></div><div id="btnUpdate"></div>-->
        <?php ActiveForm::end() ?>
        <br/>
        <?=
        GridView::widget([
            'id' => 'pdm-b4',
            'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['id_b4']];
                },
            'dataProvider' => $dataProvider,
            //'showOnEmpty' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id_perkara',
                    //'label' => 'Terdakwa',
                ],
                [
                    'attribute' => 'no_surat',
                    'label' => 'Nomor Surat',
                    //'format' => ['date', 'php:d-m-Y'],
                ],
                /*[
                    'attribute' => 'nama',
                    'label' => 'Tersangka',
                ],*/
                [
                    'class' => '\kartik\grid\CheckboxColumn',
                    //'header' => '',
                    'multiple' => true,
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model['id_b4'], 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-b4/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>