
   
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

<script type="text/javascript">
window.onload=function(){
		
		$(document).on('click','#btn_hapus_tersangka',function(){
		$(this).parent().parent().remove();
		return false;
		});
	
        $('#pilih-tersangka').click(function(){

			
			
            $('input:checkbox:checked').each(function(index) {
                var value = $(this).val();
                var data = value.split('#');

                $('#tbody_tersangka').append(
                    '<tr id="trtersangka'+data[0]+'">' +
					 '<td><a class="btn btn-danger delete" id="btn_hapus_tersangka"></a></td>' +
                        '<td><input type="hidden" class="form-control" name="id_tersangka[]" readonly="true" value="'+data[0]+'"><input type="text" class="form-control" name="nama[]" readonly="true" value="'+data[1]+'"> </td>' +
                        '<td><input type="text" class="form-control" name="alamat[]" readonly="true" value="'+data[2]+'"> </td>' +
                        '<td><input type="text" class="form-control" name="pekerjaan[]" readonly="true" value="'+data[3]+'"> </td>' +
                       
                    '</tr>'
                );

            });
            $('#m_tersangka').modal('hide');
			
        });

};
</script>