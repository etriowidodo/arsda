<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT15Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>

<script>
    var urlAjax = '<?= Url::toRoute('pdm-t15/delete'); ?>';
</script>

<div class="pdm-t15-index">

    <!--<h1><? /*= Html::encode($this->title) */ ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah T15', ['create'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?php
    $form = ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pidum/pdm-t15/delete'
    ]);
    ?>
    <div id="divHapus" style="text-align: right;">
        <a class="btn btn-warning btnHapusCheckboxIndex">hapus</a>
    </div>
    <?php ActiveForm::end() ?>

    <?=
    GridView::widget([
        'id' => 'pdm-t15',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_t15']];
            },
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_t15',
            //'id_t8',
            'no_surat',
            'nama',
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_t15'], 'class' => 'checkHapusIndex'];
                    }
                /*'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',*/

                /*'buttons' => [
                    'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'update?id=' . $model['id_t15'], ['style' => 'color:#4cc521;',
                                'title' => Yii::t('app', 'Ubah'),
                            ]);
                        },
                    'delete' => function ($url, $model, $key) {
                            /*return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete?id=' . $model['id_t15'], [ 'style' => 'color:#4cc521;',
                                'title' => Yii::t('app', 'Hapus'),
                            ]);*/
                            /*return Html::a('<span class="glyphicon glyphicon-trash"></span>',"#", [
                                'class' => 'activity-delete-link',
                                'style' => 'color:#4cc521;',
                                //'title' => 'test',
                                'data-toggle' => 'modal',
                                'data-target' => '#modal-prompt-hapus',
                                'data-id' => $model['id_t15'],
                                //'data-id' => $key,
                                'data-pjax' => '0',
                            ]);
                        }
                ],*/
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        /*'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
        ],*/
    ]); ?>

</div>

<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-t15/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>

<?php /*$this->registerJs(
    "$(document).on('click', '.activity-delete-link', function() {
        var elemenId = $(this).data('id');
        $('#hapusTersangka').val(elemenId);
    });

    $('#hapusTersangka').click(function() {
        var idPdmT15 = $(this).val();
        $('#modal-prompt-hapus').modal('hide');
        $.ajax({
            url: urlAjax,
            type:'POST',
            data:{id_pdmt15: idPdmT15},
            dataType:'JSON',
            cache: false,
        });
    });"
); */?>
<?php
/*Modal::begin([
    'id' => 'modal-prompt-hapus',
    'header' => 'Confirm',
    'footer' => '<button id="hapusTersangka" class="btn btn-danger delete hapus ">YA</button><a href="#" class="btn btn-danger delete hapusTersangka" data-dismiss="modal">TIDAK</a>',
    /*'options' => [
        'data-url' => '',
    ],*/
/*]);
*/?><!--

<div>Apakah anda ingin menghapus data ini?</div>

--><?php
/*Modal::end();
*/?>