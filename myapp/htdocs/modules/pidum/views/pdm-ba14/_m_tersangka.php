
   
    <div class="modal-body">
        <?php
        // Generate a bootstrap responsive striped table with row highlighted on hover
        use kartik\grid\GridView;
        use yii\helpers\Html;

        echo GridView::widget([
            'id'=>'jpu-grid',
            'dataProvider'=> $dataTersangka,
            //'filterModel' => $searchTersangka,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
				'nama',
				'alamat',
				'pekerjaan',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{select}',
                    'buttons' => [
                        'select' => function ($url, $model) {
                            return Html::checkbox('pilih', false, ['value' => $model['id_tersangka'].'#'.$model['nama'].'#'.$model['alamat'].'#'.$model['pekerjaan']]);
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

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
                'afterGrid'=>'<a id="pilih-tersangka" class="btn btn-success">Pilih</a>',
            ]

        ]);
        ?>
    </div>
