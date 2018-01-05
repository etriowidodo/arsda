<div class="modal-content">
    <div class="modal-header">
        JPU
        <a class="close" data-dismiss="modal">&times;</a>
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
                'peg_nik',
                'peg_nama',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{select}',
                    'buttons' => [
                        'select' => function ($url, $model) {
                            return Html::checkbox('pilih', false, ['value' => $model['peg_nik'].'#'.$model['peg_nama'].'#Jaksa Fungsional#IV/d (Jaksa Utama Madya)']);
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
                
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
                'afterGrid'=>'<a id="pilih-jpu" class="btn btn-success">Pilih</a><a id="btnCloseModal" class="btn btn-danger">Batal</a>',
            ]

        ]);
        ?>
    </div>

<script>
    $(document).ready(function(){
        $('#pilih-jpu').click(function(){
            $('input:checkbox:checked').each(function(index) {
                var value = $(this).val();
                var data = value.split('#');

                $('#tbody_jpu').append(
                    '<tr id="trjpu'+data[0]+'">' +
                        '<td><input type="text" class="form-control" name="nip_jpu[]" readonly="true" value="'+data[0]+'"> </td>' +
                        '<td><input type="text" class="form-control" name="nama_jpu[]" readonly="true" value="'+data[1]+'"> </td>' +
                    	'<td><input type="checkbox" name="hapusNewJaksaCheck" value="'+data[0]+'" ></td>'+	
                    '</tr>'
                );

            });
            $('#m_jpu').modal('hide');
        });
        $('#btnCloseModal').click(function(){
            
            $('#m_jpu').modal('hide');
        });
    });
</script>