<?php
use app\modules\pidsus\models\PdsPidsus16;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
?>
<div class="sita-index" id="dom-target">
	<div id="#wrapper-table">
		<?php
			
                echo GridView::widget([
				'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'sita-sita-modal'],
				'dataProvider' => $dataProvider,
				'rowOptions' => function($data){
					$idnya = $data['peg_nip_baru'].'#'.$data['nama'].'#'.$data['pangkatgol'].'#'.$data['gol_kd'].'#'.$data['gol_pangkatjaksa'].'#'.$data['jabatan'];
					return ['data-id' => $idnya];
				},
                'columns' => [
                    'nomor'=>[
                        'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
                        'class'=>'yii\grid\SerialColumn',
                        'header'=>'No',
                        'contentOptions'=>['class'=>'text-center'],
                    ],
                    '1'=>[
                        'headerOptions'=>['style'=>'width:38%', 'class'=>'text-center'],
                        'format'=>'raw',
                        'header'=>'Nama',
                        'value'=>function($data){
                            return '<p style="margin-bottom:0px;">'.$data['peg_nip_baru'].'</p><p style="margin-bottom:0px;">'.$data['nama'].'</p>';
                        }, 
                    ],
                    '2'=>[
                        'headerOptions'=>['style'=>'width:47%', 'class'=>'text-center'],
                        'format'=>'raw',
                        'header'=>'Jenis',
                        'value'=>function($data){
                            return '<p style="margin-bottom:0px;">'.$data['jabatan'].'</p><p style="margin-bottom:0px;">'.$data['pangkatgol'].'</p>';
                        }, 
                    ],
                    '2'=>[
                        'headerOptions'=>['style'=>'width:47%', 'class'=>'text-center'],
                        'format'=>'raw',
                        'header'=>'Jumlah',
                        'value'=>function($data){
                            return '<p style="margin-bottom:0px;">'.$data['jabatan'].'</p><p style="margin-bottom:0px;">'.$data['pangkatgol'].'</p>';
                        }, 
                    ],
                    'Aksi'=>[
                        'headerOptions'=>['style'=>'width:7%', 'class'=>'text-center'],
                        'contentOptions'=>['class'=>'text-center aksinya'],
                        'format'=>'raw',
                        'header'=>'<input type="checkbox" name="selection_all_jpn" id="selection_all_jpn" />', 
                        'value'=>function($data, $index){
                            $idnya = $data['peg_nip_baru'].'#'.$data['nama'].'#'.$data['pangkatgol'].'#'.$data['gol_kd'].'#'.$data['gol_pangkatjaksa'].'#'.$data['jabatan'];
							return '<input type="checkbox" name="selection_one_jpn[]" id="selection_one_jpn'.($index+1).'" value="'.$idnya.'" class="selection_one_jpn"  />';
                        }, 
                    ],
                ],
            ]);
		?>			
	</div>
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih-jpn" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
	<div class="modal-loading-new"></div> 
</div>

<style>
	.sita-index.loading {overflow: hidden;}
	.sita-index.loading .modal-loading-new {display: block;}
	ul.pagination {margin:0px;}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: inherit;
		font-size: inherit;
	}
</style>

<div class="modal-loading-new"></div> 
<script type="text/javascript">
	$(document).ready(function(){
           $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
           
	});
</script>