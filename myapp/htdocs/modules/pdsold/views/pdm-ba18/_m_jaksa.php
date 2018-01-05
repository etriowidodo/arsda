<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->
<script>
    
</script>
<div class="modal-content" style="width: 780px;margin: 30px auto;">    
    <div class="modal-header">
        Data Jaksa
        <a class="close" data-dismiss="modal" style="color: white">&times;</a>
    </div>

    <div class="modal-body">
            <?php
            // Generate a bootstrap responsive striped table with row highlighted on hover
            use kartik\grid\GridView;
            use yii\helpers\Html;

            echo GridView::widget([
                'id'=>'jpu-grid',
                'dataProvider'=> $dataJPU,
                'filterModel' => $searchJPU,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['label' => 'NIP',
                        'attribute' => 'peg_nip',
                    ],
                    ['label' => 'Nama',
                        'attribute' => 'peg_nama',
                    ],
                    ['label' => 'Pangkat',
                        'attribute' => 'pangkat',
                    ],
                    ['label' => 'Jabatan',
                        'attribute' => 'jabatan',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{select}',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::button('Pilih', ['class' => 'btn btn-warning',  
                                                            "onClick" => "pilihJPU($(this).attr('nip'),$(this).attr('nama'),$(this).attr('jabatan'),$(this).attr('pangkat'))"]);
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
    <div class="modal-footer">
            <a id="pilih-jpu" class="btn btn-warning">Pilih</a>
    </div>

    </div>

</div>