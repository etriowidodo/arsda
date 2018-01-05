<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmMsStatusData;


$this->title = "Agenda Persidangan";
//$this->subtitle = $sysMenu->keterangan;

?>

<div class="pdm-agenda-persidangan-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pidum/pdm-agenda-persidangan/delete'
    ]);
    ?>
    
    <div id="divHapus" class="col-md-1">
        <a type="button" id="apus" class='btn btn-warning'>Hapus</a>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model->no_agenda];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute' => 'no_register_perkara',
                      'label' => 'No. Register Perkara',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_register_perkara;
                        },
                    ],
                    [
                      'attribute' => 'no_agenda',
                      'label' => 'Sidang ke',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_agenda;
                        },
                    ],
                    [
                      'attribute' => 'tgl_acara_sidang',
                      'label' => 'Tgl. Sidang',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->tgl_acara_sidang;
                        },
                    ],
                    [
                      'attribute' => 'acara_sidang',
                      'label' => 'Acara Sidang',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            $sifat  = PdmMsStatusData::findOne(['id'=>$model->acara_sidang,'is_group'=> 'P-39 ']);
                            return $sifat->keterangan;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_agenda, 'class' => 'checkHapusIndex'];
                            }
                    ],
                ],
                        'export' => false,
                        'pjax' => true,
                        'responsive' => true,
                        'hover' => true,
                    ]);
                    ?>

        </div>
    </div>
</div>

<?php
$js = <<< JS
    $('td').dblclick(function (e) {
    var no_agenda = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-agenda-persidangan/update?no_agenda="+no_agenda;
    $(location).attr('href',url);
});
  
  $("#apus").on("click",function(){
        $('form').submit();
    });

JS;

$this->registerJs($js);
?>

<!--</div>-->
