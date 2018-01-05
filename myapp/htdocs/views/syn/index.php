<?php
// Generate a bootstrap responsive striped table with row highlighted on hover
use kartik\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
    'id'=>'jpu-grid',
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'no_p16',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{select}',
            'buttons' => [
                'select' => function ($url, $model) {
                    return Html::checkbox('no_p16[]', false, ['id' => 'no_p16','value' => $model['no_p16']]);
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
        'afterGrid'=>'<a id="sinkron" class="btn btn-success">Sinkron</a>',
    ]

]);

$this->registerJs("
    $(document).ready(function () {
        $('#sinkron').click(function(){
            $.ajax({
                type: 'POST',
                url: '/syn/save',
                data: $('input:checkbox:checked').each(function(index) {
                    var value = $(this).val();
                    var data = value.split('#');
                }),
                success:function(data){
                    alert('Success Update Data');
                    location.reload();
                }
            });
        });
    });
");
?>
<script>
    /*$(document).ready(function(){
        $('#sinkron').click(function(){
            $.ajax({
                type: "POST",
                url: baseurl + '/P16/syn/save',
                data: $('#no_p16').serialize(),
                success:function(data){
                    alert('Success Update Data');
                }
            });
        })
    });*/
</script>
