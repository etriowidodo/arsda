<?php


use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

      <?php
    $form = ActiveForm::begin(
        [
            'id' => 'p44-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 2,
                'showLabels' => false

            ]
        ]);
		
    ?>
	
	<div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">

                </h3>
            </div>
            <div class="box-body">
				<div class="form-group">
					<label class="control-label col-sm-2">Wilayah Kerja</label>
					<div class="col-sm-4">
						<input type="text" name="wilayah_kerja" class="form-control" id="wilayah_kerja" value="<?= $wilayah ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Tanggal Pembuatan</label>
					<div class="col-sm-2">
						<?=
                $form->field($model, 'tgl_ba6')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tanggal Pembuatan',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?>

					</div>
				</div>
				<div class="form-group">
				<div class="col-sm-2">
					Lokasi
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'lokasi'); ?>
				</div>
			</div>
				<div class="form-group">
								<div class="box-header with-border" style="border-color: #c7c7c7;">
									<h3 class="box-title">
										<a class="btn btn-primary addJPU2" id="popUpJpuPenerima">Jaksa Penerima</a>
									</h3>
								</div>
							</div>
				<div class="form-group">
			<table id="table_jpu_penerima" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Urut</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>JABATAN</th>
                            <th>PANGKAT</th>
                            <th><a class='btn btn-danger delete'></a></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu_penerima">
                         <?php if (!$model->isNewRecord): ?>
                            <?php $modelJpuPenerima = json_decode($model->jaksa_penerima); ?>
                            <?php for ($i=0; $i < count($modelJpuPenerima->nip); $i++) {  ?>
                                <tr data-id="<?= $value['id_jpp'] ?>">
                                    <td><input type="text" name="no_urut_penerima[]" class="form-control" value="<?= $modelJpuPenerima->urut[$i] ?>" style="width: 50px;"></td>
                                    <td><input type="text" name="nip_baru_penerima[]" class="form-control" readonly="true" value="<?= $modelJpuPenerima->nip[$i] ?>"><input type="hidden" name="nip_jpu_penerima[]" class="form-control" readonly="true" value="<?= $value['nip'] ?>"></td>
                                    <td><input type="text" name="nama_jpu_penerima[]" class="form-control" readonly="true" value="<?= $modelJpuPenerima->nama[$i] ?>"></td>
                                    <td><input type="text" name="jabatan_jpu_penerima[]" class="form-control" readonly="true" value="<?= $modelJpuPenerima->jabatan[$i] ?>"></td>
                                    <td><input type="text" name="gol_jpu_penerima[]" class="form-control" readonly="true" value="<?= $modelJpuPenerima->gol[$i] ?>"></td>
                                    <td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus_jaksa"></a></td>
                                </tr>
                            <?php } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
				</div>
				
				<div class="form-group">
								<div class="box-header with-border" style="border-color: #c7c7c7;">
									<h3 class="box-title">
										<a class="btn btn-primary addJPU2" id="popUpJpu">Saksi</a>
									</h3>
								</div>
							</div>
				<div class="form-group">
			<table id="table_jpu" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Urut</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>JABATAN</th>
                            <th>PANGKAT</th>
                            <th><a class='btn btn-danger delete'></a></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu">
                         <?php if (!$model->isNewRecord): ?>
                            <?php $modelJpu = json_decode($model->jaksa_saksi); //echo '<pre>';print_r($modelJpu);exit; ?>
                            <?php for ($i=0; $i < count($modelJpu->nip); $i++) { ?>
                                <tr data-id="<?= $modelJpu->nip[$i] ?>">
                                    <td><input type="text" name="no_urut_saksi[]" class="form-control" value="<?= $modelJpu->urut[$i] ?>" style="width: 50px;"></td>
                                    <td><input type="text" name="nip_baru_saksi[]" class="form-control" readonly="true" value="<?= $modelJpu->nip[$i] ?>"></td>
                                    <td><input type="text" name="nama_jpu_saksi[]" class="form-control" readonly="true" value="<?= $modelJpu->nama[$i] ?>"></td>
                                    <td><input type="text" name="jabatan_jpu_saksi[]" class="form-control" readonly="true" value="<?= $modelJpu->jabatan[$i] ?>"></td>
                                    <td><input type="text" name="gol_jpu_saksi[]" class="form-control" readonly="true" value="<?= $modelJpu->gol[$i] ?>"></td>
                                    <td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus_saksi"></a></td>
                                </tr>
                            <?php } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
				</div>
				
				
				
			</div>
		</div>
	</div>
	
	<div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
					TUJUAN
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
				<div class="col-sm-2">
					Nama
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'nama'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Alamat
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'alamat'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Pekerjaan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'pekerjaan'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Alasan
				</div>
				<div class="col-sm-6">
                                    <?php
                                        echo $form->field($model, 'id_sts')->dropDownList(
                                        ArrayHelper::map(\app\modules\pidum\models\PdmMsStatusData::findAll(['is_group' => 'BA-6 ']), 'id', 'nama'), // Flat array ('id'=>'label')
                                        []    // options
                                        );
                                    ?>
				</div>
			</div>
			
			
           </div>
		</div>
	</div>
	
	<div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="row" style="height: 45px">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Barang Bukti</label>
                                    <div class="col-md-8">
                                        <table id="table_barbuk" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="4%" style="text-align: center;vertical-align: middle;">No</th>
                                                    <th width="35%" style="text-align: center;vertical-align: middle;">Nama Barang Bukti</th>
                                                    <th width="4%" style="text-align: center;vertical-align: middle;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_barbuk">
                                                <?php


                                                    if (!$model->isNewRecord) {
                                                        $arr = json_decode($model->desk_barbuk);
                                                        //echo '<pre>';print_r($arr);exit;
                                                        //$arr = $dec->undang;
                                                        $jum_undang= count($arr);
                                                    }

                                                    $ix = 0;
                                                    foreach ($modelBarbuk as $listbarbuk):

                                                        $check='';
                                                    if (!$model->isNewRecord) {
                                                        for ($i=0; $i < $jum_undang; $i++) { 
                                                            if($listbarbuk['no_urut_bb'] == $arr[$i]){
                                                                $check=' checked "true" '.$listbarbuk['no_urut_bb'];
                                                            }
                                                        }
                                                    }
                                                    $nama = Yii::$app->globalfunc->GetDetBarbuk(Yii::$app->session->get('no_register_perkara'),$listbarbuk['no_urut_bb']);
                                                    //echo '<pre>';print_r($nama);exit;




                                                    echo '<tr id="row-'.$listbarbuk['no_urut_bb'].'">';
                                                        echo '<td style="text-align: center">'.$listbarbuk['no_urut_bb'].'</td>';
                                                        echo '<td style="text-align: left">'.$nama.'</td>';
                                                        echo '<td style="text-align: left; "><input type="checkbox" name="barbuk[]" "'.$check.'" value="'.$listbarbuk['no_urut_bb'].'" style="width:100%"></td>';
                                                    echo '</tr>';
                                                        $ix++;
                                                    endforeach;//exit;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
	 <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-ba6/cetak?id=' . $model->tgl_ba6]) ?>">Cetak</a>
          <?php endif ?>  
        </div>
		
  <?php ActiveForm::end(); ?>

</div>
    </section>
	
		
<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pdsold/pdm-ba6/jpu');
        $('#m_jpu').modal('show');
	});
	
	$('#popUpJpuPenerima').click(function(){
		$('#m_jpu_penerima').html('');
        $('#m_jpu_penerima').load('/pdsold/pdm-ba6/jpupenerima');
        $('#m_jpu_penerima').modal('show');
	});
	
	$("#btn_isibarbuk").click(function() {
		$('#pdmba17-desk_barbuk').val('');
	    var chkArray = [];
	
		$(".chk:checked").each(function() {
			chkArray.push($(this).val());
		});
		
		var no = 1;
		$.each(chkArray , function(i, val) { 
		  $('#pdmba17-desk_barbuk').val($('#pdmba17-desk_barbuk').val()+no+'. '+val+"\\n"); 
		  no++;
		});
	});

     $(document).on('click', 'a#btn_hapus_jaksa', function () {
            $(this).parent().parent().remove();
            return false;
        });

     $(document).on('click', 'a#btn_hapus_saksi', function () {
            $(this).parent().parent().remove();
            return false;
        });

/*
      $( document ).on('click', '.hapusJaksa', function(e) {
        var input = $( this );
            $(".hapus").click(function(event){
                event.preventDefault();
                if(input.prop( "checked" ) == true){
                    bootbox.dialog({
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){
                                    $("#trjpu"+e.target.value).remove();
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });

                }else if(input.prop( "checked" ) == false){
                    $(".hapus").off("click");
                }
            });


    });*/

JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
Modal::begin([
    'id' => 'm_jpu_penerima',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
?>
