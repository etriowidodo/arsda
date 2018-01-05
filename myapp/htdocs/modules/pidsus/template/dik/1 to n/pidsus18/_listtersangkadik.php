<div class="modal-content">
    
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
	            'tempat_lahir',
	            'tgl_lahir',
	        	'nomor_id',	
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{select}',
                    'buttons' => [
                        'select' => function ($url, $model) {
                            return Html::checkbox('pilih', false, ['value' => $model['id_pds_dik_tersangka'].'#'.$model['nama_tersangka'].'#'.$model['nomor_id']]);
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
                'afterGrid'=>'<a id="pilih-tersangka" class="btn btn-success">Pilih</a>',
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
                    '<tr id="tr_id'+data[0]+'">' +
                        '<td><input type="hidden" class="form-control" name="id_pds_dik_tersangka[]" readonly="true" value="'+data[0]+'">' +
                        '<input type="text" class="form-control" name="nama_tersangka[]" readonly="true" value="'+data[1]+'"> </td>' +
                        '<td><input type="text" class="form-control" name="nomor_id[]" readonly="true" value="'+data[2]+'"> </td>' +
                        '<td><a class="btn btn-danger" onclick="hapusTersangka(\''+data[0]+'\')">Hapus</a> </td>' +
                    '</tr>'
                );

            });
            $('#m_tersangka').modal('hide');
        });

    });
</script>