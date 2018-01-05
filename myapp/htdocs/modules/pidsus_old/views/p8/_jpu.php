<div class="modal-content">
    <div class="modal-header">
        JAKSA PENYELIDIK
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
                //'peg_nik',
                'peg_nip_baru',
                'peg_nama',
            	['label' => 'Jabatan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model->golongan->gol_pangkatjaksa;
					},] ,	
				['label' => 'Golongan',
					'format' => 'raw',
					'value'=>function ($model, $key, $index, $grid) {
						return $model->golongan->gol_kd;
					},] ,
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{select}',
                    'buttons' => [
                        'select' => function ($url, $model) {
                            return Html::checkbox('pilih', false, ['value' => $model['peg_nik'].'#'.$model['peg_nama'].'#'.$model['peg_nip_baru'].'#'.$model->pegJbtakhirstk->ref_jabatan_desc.'#'.$model->golongan->gol_pangkatjaksa.'#'.$model->golongan->gol_kd]);
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
                    'enablePushState'=>true,
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
                var isExist=document.getElementById("trjpu"+data[0]);
				if(isExist ==null){
                $('#tbody_jpu').append(
                    '<tr id="trjpu'+data[2]+'">' +
                    '<td><input type="text" class="form-control" name="nip_jpu[]" readonly="true" value="'+data[0]+'"></td><td> <input type="text" class="form-control" readonly="true" value="'+data[2]+'"> </td>' +
                        '<td><input type="text" class="form-control" name="nama_jpu[]" readonly="true" value="'+data[1]+'"> </td>' +
                        '<td><input type="text" class="form-control" readonly="true" value="'+data[3]+'"> </td>' +
                        '<td><input type="text" class="form-control" readonly="true" value="'+data[4]+'"> </td>' +
                         '<td><input type="text" class="form-control" readonly="true" value="'+data[5]+'"> </td>' +
                    	'<td><input type="checkbox" name="hapusNewJaksaCheck" value="'+data[2]+'" ></td>'+	
                    '</tr>'
                );
				}
            });
            $('#m_jpu').modal('hide');
        });

        $('#btnCloseModal').click(function(){
           
            $('#m_jpu').modal('hide');
        });

    });
</script>