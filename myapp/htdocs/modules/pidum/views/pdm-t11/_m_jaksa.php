<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<script>
    function pilihJaksa(id, param){
        var value = $("#pilihJaksa"+id).val();
            
        var data = value.split('#');
        var count = 1;
//        alert(data[0]);
//        alert(data[1]);
//        alert(data[2]);
//        alert(data[3]);
        
        $('#tbody_jaksa'+param).append(
            '<tr id="tr_jaksa'+data[0]+'">' +
                '<td><input type="hidden" class="form-control" name="id_jaksa[]" readonly="true" value="'+data[0]+'"><input type="hidden" class="form-control" name="jabatan[]" readonly="true" value="'+data[4]+'"></td>' +
                '<td><input type="text" class="form-control" name="nama[]" readonly="true" value="'+data[1]+'"> </td>' +
                '<td><input type="text" class="form-control" name="pangkat[]" readonly="true" value="'+data[2]+'"> </td>' +
                '<td><input type="text" class="form-control" name="nip[]" readonly="true" value="'+data[3]+'"> </td>' +
                '<td><?= Html::Button('Hapus', ['class' => 'btn btn-primary', 'id'=>'hapusJaksa[]']) ?></td>' +
            '</tr>'
        );
        $('#m_jaksa').modal('hide');
    }
</script>

<?php
    //$searchModel = new \app\modules\pidum\models\PdmT11Search();
    $searchModel = new \app\modules\pidum\models\VwJaksaPenuntut();
    $dataProvider = $searchModel->searchJaksaPelaksana(Yii::$app->request->queryParams);
    $dataProvider->pagination->pageSize=10;
    $gridColumn = [
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'id',
        'label' => 'ID',
        ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'peg_nama',
        'label' => 'Nama',
        ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'pangkat',
        'label' => 'Pangkat',
        ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'peg_nip',
        'label' => 'NIP',
        ],
        [
        'class' => '\kartik\grid\ActionColumn',
         'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model,$key) use($param) {
                        return Html::button('Pilih', ['onClick'=>'pilihJaksa('.$model['id'].',"'.$param.'")', 
                                        'id'=>'pilihJaksa'.$model['id'], 'value'=>$model['id'].'#'.
                                        $model['peg_nama'].'#'.
                                        $model['pangkat'].'#'.
                                        $model['peg_nip'].'#'.
                                        $model['jabatan']
                                        ]);
                    }
		],
        ],
    ];
    echo GridView::widget([
         'id'=>'tembusan-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => $gridColumn,
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
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]);
?>
