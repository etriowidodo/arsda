<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->
<div class="modal-content" style="width: 780px;margin: 30px auto;">    
    <div class="modal-header">
        Wilayah Kerja
        <a class="close" data-dismiss="modal" style="color: white">&times;</a>
    </div>

    <div class="modal-body">
            <?php
            // Generate a bootstrap responsive striped table with row highlighted on hover
            use kartik\grid\GridView;
            use yii\helpers\Html;

            echo GridView::widget([
                'id'=>'satker-grid',
                'dataProvider'=> $dataProvider,
                // 'summary' => '',
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                     'label' => 'Nama Satker',
                     'attribute' => 'inst_nama',
                    ],
                    [
                      'label' => 'Lokasi',
                      'attribute' => 'inst_lokinst',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{select}',
                        'buttons' => [
                            'select' => function ($url, $model, $key) {
                                return Html::button("Pilih", ["id" => "pilih_satker", "class" => "btn btn-warning",
                                    "kd" => $model['inst_satkerkd'],
                                    "nama" => $model['inst_nama'],
                                    "onClick" => "pilihSatker($(this).attr('kd'), $(this).attr('nama'))"]);
                            },
                        ]
                    ],
                ],                   
                'export' => false,
                'pjax' => true,
                'responsive'=>true,
                'hover'=>true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-book"></i>',
                ], 
            ]);
            ?>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer hide">
            <a id="pilih-jpu" class="btn btn-warning">Pilih</a>
    </div>

    </div>
<?php
$this->registerJs(\yii\web\View::POS_BEGIN);
        $js = <<< JS
        $(document).ready(function(){
            $('.kv-panel-before').hide();
        });
        function pilihSatker(kd, nama) {

            $("#satker_tujuan").val(kd);
            $("#satker_nama").val(nama);
            $('#m_satker').modal('hide');
        }
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>