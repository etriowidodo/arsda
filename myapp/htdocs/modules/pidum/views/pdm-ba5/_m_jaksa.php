<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->
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
                'dataProvider'=> $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                     'label' => 'NIP',
                     'attribute' => 'peg_nip_baru',
                    ],
                    [
                      'label' => 'Nama',
                      'attribute' => 'peg_nama',
                    ],
                    'jabatan',
                    'pangkat',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{select}',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::checkbox('pilih', false, ['value' => $model['peg_nip_baru'].'#'.$model['peg_nama'].'#'.$model['pangkat'].'#'.$model['jabatan'].'#'.$model['peg_nip_baru']]);
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
<?php
$this->registerJs(\yii\web\View::POS_BEGIN);
        $js = <<< JS
        $('#pilih-jpu').click(function () {
            
            $('#jpu-grid input:checkbox:checked').each(function (index) {
                var value = $(this).val();
                var data = value.split('#');
                var trCount = $("#table_jaksa_penerima tr").length;
                
                var nipBaruValue = [];
                $("input[name='nip_baru[]']").each(function(){
                    nipBaruValue.push($(this).val());
                });
                if(jQuery.inArray(data[4], nipBaruValue) > -1) {
                    console.log(nipBaruValue);
                    console.log(data[4]);
                    $('input:checkbox').prop('checked', false);
                    alert(data[1] + ' Sudah terpilih');return false;
                }else{
                    $('#table_jaksa_penerima').append(
                        '<tr id="trJPU-'+data[0]+'">' +
                        '<td><input type="text" name="penerima-no_urut_news[]" style="width: 50px;" class="form-control" value="'+(trCount)+'"></td>' +
                        '<td><input type="text" class="form-control" name="penerima-peg_nip_news[]" readonly="true" value="' + data[4] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="penerima-peg_nama_news[]" readonly="true" value="' + data[1] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="penerima-pangkat_news[]" readonly="true" value="' + data[2] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="penerima-jabatan_news[]" readonly="true" value="' + data[3] + '"> </td>' +
                        '<td id="tdJPU"><a class="btn btn-danger delete" data-id="'+ data[4] +'" id="btn_hapus"></a></td>' +
                        '</tr>'
                    );
                    $('#m_jpu').modal('hide');
                }

            });
        });
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>