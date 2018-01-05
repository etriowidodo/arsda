<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['listgldh'], 'method'=>'get', 'id'=>'searchFormGeledah', 'options'=>['name'=>'searchFormGeledah']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="q1" id="q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-gldh" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="get-geledah-index">
    <p style="margin-bottom:10px;"></p>
    <div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalGeledah', 'timeout' => false, 'formSelector' => '#searchFormGeledah', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'geledah-tabel-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['penggeledahan_terhadap'].'|#|'.$data['nama'].'|#|'.$data['jabatan'].
                                        '|#|'.$data['tempat_penggeledahan'].'|#|'.$data['alamat_penggeledahan'].'|#|'.$data['nama_pemilik'].
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
					'header'=>'Subyek/Obyek', 
					'value'=>function($data){
                                                if($data['penggeledahan_terhadap'] == 'Subyek'){
                                                    $ygDigeledah = $data['nama'].'<br />'.$data['jabatan'];
                                                } else if($data['penggeledahan_terhadap'] == 'Obyek'){
                                                    $ygDigeledah = $data['tempat_penggeledahan'].'<br />'.$data['alamat_penggeledahan'];
                                                }
						return $ygDigeledah;
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
					'header'=>'<input type="checkbox" name="selection_all_gldh" id="selection_all_gldh" />',  
					'value'=>function($data, $index){
						$idnya = $data['penggeledahan_terhadap'].'|#|'.$data['nama'].'|#|'.$data['jabatan'].
                                                        '|#|'.$data['tempat_penggeledahan'].'|#|'.$data['alamat_penggeledahan'].'|#|'.$data['nama_pemilik'].
                                                        '|#|'.$data['pekerjaan_pemilik'].'|#|'.$data['alamat_pemilik'].'|#|'.$data['keperluan'].'|#|'.$data['keterangan'].'|#|'.$data['no_pidsus16_umum'].$data['no_urut_penggeledahan'];
						return '<input type="checkbox" name="selection_one_gldh[]" id="selection_one_gldh'.($index+1).'" value="'.$idnya.'" class="selection_one_gldh"  />';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    </div>
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih-gldh" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/pidsus/pds-b4-umum/listgldh?q1='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
</div>
<style>
	.get-geledah-index.loading {overflow: hidden;}
	.get-geledah-index.loading .modal-loading-new {display: block;}
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
            localStorage.removeItem("modalnyaDataGLDH");
            var modalnyaDataGLDH = {};
            var formValuesGldh = JSON.parse(localStorage.getItem('formValuesGldh')) || {};	
            $(".get-geledah-index").find(".selection_one_gldh").each(function(i, v){
                    var idnya = $(v).val().toString().split('|#|');
                    (idnya[10] in formValuesGldh)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
            });
        
            $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$("#myPjaxModalGeledah").on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$(".get-geledah-index").addClass("loading");
		}).on('pjax:success', function(){
                    $(".get-geledah-index").find(".selection_one_gldh").each(function(i, v){
			var idnya = $(v).val().toString().split('|#|');
			(idnya[10] in formValuesGldh)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
			(idnya[10] in modalnyaDataGLDH)?$(v).prop({'checked':'checked'}):$(v);
                    });
                    $(".get-geledah-index").removeClass("loading");
                    $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
                    $(".get-geledah-index").removeClass("loading");
		});
                
            $(".reset-cari-gldh").on("click", function(){
                $("#q1").val("");
                $("#searchFormGeledah").trigger("submit");
            });
            
            $(".get-geledah-index").on("ifChecked", "input[name=selection_all_gldh]", function(){
                    $(".selection_one_gldh").not(':disabled').iCheck("check");
            }).on("ifUnchecked", "input[name=selection_all_gldh]", function(){
                    $(".selection_one_gldh").not(':disabled').iCheck("uncheck");
            });
            
            $("#searchFormGeledah").on("submit", function(){localStorage.removeItem("modalnyaDataGLDH");});
            $(".get-geledah-index").on("ifChecked", ".selection_one_gldh", function(){
                    var nilai = $(this).val();
                    var pecah = nilai.toString().split("|#|");
                    modalnyaDataGLDH[pecah[10]] = nilai;
                    localStorage.setItem("modalnyaDataGLDH", JSON.stringify(modalnyaDataGLDH));
            }).on("ifUnchecked", ".selection_one_gldh", function(){
                    var nilai = $(this).val();
                    var pecah = nilai.toString().split("|#|");
                    delete modalnyaDataGLDH[pecah[10]];
                    localStorage.setItem("modalnyaDataGLDH", JSON.stringify(modalnyaDataGLDH));
            });
	});
</script>