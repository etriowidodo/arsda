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
            'id'=>'tersangka-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nama_tersangka',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{select}',
                    'buttons' => [
                        'select' => function ($url, $model) {
                            return Html::checkbox('pilih', false, ['value' => $model['id_pds_tut_tersangka'].'#'.$model['nama_tersangka']]);
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
                'afterGrid'=>'<a id="pilih-tersangka" class="btn btn-success">Pilih</a><a id="btnCloseModal" class="btn btn-danger">Batal</a>',
            ]

        ]);
        ?>
    </div>

<script>
    $(document).ready(function(){
        $('#pilih-tersangka').click(function(){
            $('input:checkbox:checked').each(function(index) {
                var value = $(this).val();
                var data = value.split('#');

                $('#tbody_tersangka').append(
                    '<tr id="trtersangka'+data[0]+'">' +
                        '<td><input type="hidden" class="form-control" name="id_tersangka[]" readonly="true" value="'+data[0]+'"> ' +
                        '<input type="text" class="form-control" name="nama_tersangka[]" readonly="true" value="'+data[1]+'"> </td>' +
                    	'<td><input type="checkbox" name="hapusNewTersangkaCheck" value="'+data[0]+'" ></td>'+	
                    '</tr>'
                );

            });
            $('#m_tersangka').modal('hide');
        });
        $('#btnCloseModal').click(function(){            
            $('#m_tersangka').modal('hide');
        });
    });
</script>