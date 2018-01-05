<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getSita'], 'method'=>'get', 'id'=>'searchFormSita', 'options'=>['name'=>'searchFormSita']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="q1" id="q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-sita" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="get-sita-index">
    <p style="margin-bottom:10px;"></p>
    <div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalSita', 'timeout' => false, 'formSelector' => '#searchFormSita', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'sita-tabel-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['nama_barang_disita'].'|#|'.$data['disita_dari'].'|#|'.$data['jenis_barang_disita'].
                                        '|#|'.$data['tempat_penyitaan'].'|#|'.$data['jumlah_barang_disita'].'|#|'.$data['nama_pemilik'].
                                        '|#|'.$data['pekerjaan_pemilik'].'|#|'.$data['alamat_pemilik'].'|#|'.$data['keperluan'].'|#|'.$data['keterangan'];
				return ['data-id' => $idnya];
			},
			'columns' => [
                                '0'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'header'=>'No', 
					'class' => 'yii\grid\SerialColumn',
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal Pidsus-16 Umum', 
					'value'=>function($data){
						return ($data['tgl_pidsus16_umum'])?date('d-m-Y',strtotime($data['tgl_pidsus16_umum'])):'';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Barang yang disita', 
					'value'=>function($data){
                                                return $data['nama_barang_disita'];
					}, 
				],
                                '3'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Keperluan', 
					'value'=>function($data){
						return $data['keperluan'];
					}, 
				],
                                '4'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Keterangan', 
					'value'=>function($data){
						return $data['keterangan'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all_sita" id="selection_all_sita" />',  
					'value'=>function($data, $index){
						$idnya = $data['nama_barang_disita'].'|#|'.$data['disita_dari'].'|#|'.$data['jenis_barang_disita'].
                                        '|#|'.$data['tempat_penyitaan'].'|#|'.$data['jumlah_barang_disita'].'|#|'.$data['nama_pemilik'].
                                        '|#|'.$data['pekerjaan_pemilik'].'|#|'.$data['alamat_pemilik'].'|#|'.$data['keperluan'].'|#|'.$data['keterangan'];
						return '<input type="checkbox" name="selection_one_sita[]" id="selection_one_sita'.($index+1).'" value="'.$idnya.'" class="selection_one_sita"  />';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    </div>
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih-sita" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/pidsus/pds-b4-umum/listsita?q1='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
</div>
<style>
	.get-sita-index.loading {overflow: hidden;}
	.get-sita-index.loading .modal-loading-new {display: block;}
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

<script type="text/javascript">
	$(document).ready(function(){
            localStorage.removeItem("modalnyaDataSITA");
            var modalnyaDataSITA = {};
            var formValuesSita = JSON.parse(localStorage.getItem('formValuesSita')) || {};	
            $(".get-sita-index").find(".selection_one_sita").each(function(i, v){
                    var idnya = $(v).val().toString().split('|#|');
                    (idnya[10] in formValuesSita)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
            });
        
            $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$("#myPjaxModalSita").on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$(".get-sita-index").addClass("loading");
		}).on('pjax:success', function(){
                    $(".get-sita-index").find(".selection_one_sita").each(function(i, v){
			var idnya = $(v).val().toString().split('|#|');
			(idnya[10] in formValuesSita)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
			(idnya[10] in modalnyaDataSITA)?$(v).prop({'checked':'checked'}):$(v);
                    });
                    $(".get-sita-index").removeClass("loading");
                    $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
                    $(".get-sita-index").removeClass("loading");
		});
                
            $(".reset-cari-sita").on("click", function(){
                $("#q1").val("");
                $("#searchFormSita").trigger("submit");
            });
            
            $(".get-sita-index").on("ifChecked", "input[name=selection_all_sita]", function(){
                    $(".selection_one_sita").not(':disabled').iCheck("check");
            }).on("ifUnchecked", "input[name=selection_all_sita]", function(){
                    $(".selection_one_sita").not(':disabled').iCheck("uncheck");
            });
            
            $("#searchFormSita").on("submit", function(){localStorage.removeItem("modalnyaDataSITA");});
            $(".get-sita-index").on("ifChecked", ".selection_one_sita", function(){
                    var nilai = $(this).val();
                    var pecah = nilai.toString().split("|#|");
                    modalnyaDataSITA[pecah[0]] = nilai;
                    localStorage.setItem("modalnyaDataSITA", JSON.stringify(modalnyaDataSITA));
            }).on("ifUnchecked", ".selection_one_sita", function(){
                    var nilai = $(this).val();
                    var pecah = nilai.toString().split("|#|");
                    delete modalnyaDataSITA[pecah[0]];
                    localStorage.setItem("modalnyaDataSITA", JSON.stringify(modalnyaDataSITA));
            });
	});
</script>