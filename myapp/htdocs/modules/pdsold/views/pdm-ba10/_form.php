<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\MsLoktahanan;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA12 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <?php $form = ActiveForm::begin(
	[
                'id' => 'ba12-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]

	);

	?>
     <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
                        <div class="col-md-12 hide">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="kode_kejaksaan" class="control-label col-md-4">Wilayah Kejaksaan</label>
                        <div class="col-md-7">
                    <input type="text" class="form-control" value="">
                    <div class="help-block"></div>
                </div>
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                     </div>

						<div class="col-md-12">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Pembuatan</label>
                        <div class="col-md-6">

                            <?php
                             echo $form->field($model, 'tgl_ba10')->widget(DateControl::classname(), [
                             'type'=>DateControl::FORMAT_DATE,
                             'ajaxConversion'=>false,
                             'options' => [
                             'pluginOptions' => [
                             'autoclose' => true
                                                    ]
                                                ]
                                            ]);

                                        ?>
                     </div>
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                          </div>


						<div class="col-md-12 hide">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="id_ms_loktahanan" class="control-label col-md-4">Lokasi</label>
					    <div class="col-md-7">

                        </div>
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                     </div>


                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_ms_loktahanan" class="control-label col-md-4">Jaksa Pelaksana</label>
                                <div class="col-md-7">
                                    <!-- <select class="form-control" name="jaksa_pelaksana">
                                        <option value="">Pilih Jaksa</option>

                                        <option  'selected'  value="">

                                        </option>

                                    </select> -->
                                    <?php
                                        echo $form->field($model, 'nip_jaksa')->dropDownList(
                                            ArrayHelper::map($modeljaksiChoosen, 'nip', 'nama'), // Flat array ('id'=>'label')
                                                ['prompt' => 'Pilih Jaksa', 'class' => 'cmb_jaksa']    // options
                                        );
                                        //echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register_perkara, $modelTersangka->);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="clearfix"></div>

    </div>
    <?php /* ========================== DELETED ===================================
					<div class="box box-primary hide" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
					   <div class="box-header with-border">
                         <h3 class="box-title">
                    <a class="btn btn-primary addJPU2" id="popUpJpu" data-toggle="modal" data-target="#m_tersangka">Terdakwa</a>
                         </h3>
                     </div>
        <div class="box-header with-border">
        <table id="table_jpu" class="table table-bordered">
            <thead>
                <tr>
				<th></th>
                    <th>Nama</th>
                    <th>Alamat</th>
					<th>Pekerjaan</th>
                </tr>
            </thead>
            <tbody id="tbody_tersangka">

			<?php
					if(count($terdakwa)>0){
					foreach($terdakwa as $rowTerdakwa){
					$tersangka = $rowTerdakwa['id_tersangka']."#".$rowTerdakwa['id_perkara']."#".$rowTerdakwa['tmpt_lahir']."#";
					$tersangka .= date('d-m-Y',strtotime($rowTerdakwa['tgl_lahir']))."#".$rowTerdakwa['alamat']."#".$rowTerdakwa['no_identitas']."#";
					$tersangka .= $rowTerdakwa['no_hp']."#".$rowTerdakwa['warganegara']."#".$rowTerdakwa['pekerjaan']."#".$rowTerdakwa['suku']."#";
					$tersangka .= $rowTerdakwa['nama']."#".$rowTerdakwa['id_jkl']."#".$rowTerdakwa['id_identitas']."#".$rowTerdakwa['id_agama']."#".$rowTerdakwa['id_pendidikan'];
					?>
					<tr id="trtersangka">
					   <td><a class="btn btn-danger delete" id="btn_hapus"></a></td>
                        <td><input type="hidden" class="form-control" name="id_tersangka[]" readonly="true" value="<?php echo $rowTerdakwa['id_tersangka'];?>">
						<input type="text" class="form-control" name="nama[]" readonly="true" value="<?php echo $rowTerdakwa['nama'];?>"> </td>
                        <td><input type="text" class="form-control" name="pekerjaan[]" readonly="true" value="<?php echo $rowTerdakwa['pekerjaan'];?>"> </td>
                        <td><input type="text" class="form-control" name="alamat[]" readonly="true" value="<?php echo $rowTerdakwa['alamat'];?>"> </td>

                    </tr>
					<?php
					}
					}
					?>

            </tbody>
        </table>
        </div>
                </div>
    */?>

	<div class="box box-primary" style="border-color: #f39c12;">
        <div style="border-color: #c7c7c7;" class="box-header with-border">
            <h3 class="box-title">
                <!--<i class="glyphicon glyphicon-user"></i>--> <strong>TERDAKWA</strong>
            </h3>
        </div>

        <div class="col-md-12" style="margin-top: 15px;">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4">Nama</label>
                    <div class="col-sm-8">
                        <?php
                            echo $form->field($model, 'no_reg_tahanan_jaksa')->dropDownList(
                                ArrayHelper::map($dataTersangka, 'no_reg_tahanan', 'nama'), // Flat array ('id'=>'label')
                                    ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']    // options
                            );
                            //echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register_perkara, $modelTersangka->);
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="data-terdakwa">
                <?php
                if (!empty($model->id_tersangka))
                    echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
                ?>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4">No. Reg Perkara</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'no_register_perkara')->textInput(['value' => $no_register_perkara, 'readonly' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4">No. Reg Tahanan</label>
                    <div class="col-sm-8"><input type="text" readonly="true" class="form-control" id="no_reg_tahananx" name="no_reg_tahananx">
                    <!-- <input type="text" readonly="" name="no_surat_t8" id="no_surat_t8">
                    <input type="text" readonly="" name="nama_tersangka" id="nama_tersangka">
                    <input type="text" readonly="" name="no_urut_tersangka" id="no_urut_tersangka"> -->
                    <?php   
                            echo $form->field($model, 'no_surat_t8')->hiddenInput();
                            echo $form->field($model, 'id_tersangka')->hiddenInput(); 
                                echo $form->field($model, 'nama')->hiddenInput();  
                    ?>
                          </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4">Ditahan Sejak</label>
                    <div class="col-sm-8">
                    <!-- <input type="text" readonly="true" name="tgl_mulai" id="tgl_mulai"> -->
                    <?php //$form->field($model, 'tgl_penahanan')->textInput(['value' => $tgl_penahanan, 'readonly' => true]) ?>

                    <?php
                             echo $form->field($model, 'tgl_penahanan')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'ajaxConversion'=>false,
                                    'readonly' => true,
                                    'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);

                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>


	<div class="box box-primary hide" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
	                    <div class="col-md-12">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="no_sp" class="control-label col-md-4">No SP Kepala Kejaksaan </label>
                        <div class="col-md-7" style="margin-left:-20px;"><?= $form->field($model, 'no_sp')->textInput(['value' => $modelt8->no_surat]) ?></div>
                        <input type="hidden" name="PdmBa12[no_sp]" value="">
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                     </div>

						<div class="col-md-12" style="margin-top:-70px; margin-left:400px">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label col-md-4" style="margin-top:30px">Tanggal SP</label>
                        <div class="col-md-6" style="margin-top:20px; margin-left:-35px;">

                            <?php
                             echo $form->field($model, 'tgl_sp')->widget(DateControl::classname(), [
                             'type'=>DateControl::FORMAT_DATE,
                             'ajaxConversion'=>false,
                             'options' => [
                             'pluginOptions' => [
                             'autoclose' => true
                                                    ]
                                                ]
                                            ]);

                                        ?>
                     </div>
                        <input type="hidden" name="PdmBa12[tgl_sp]" value="<?= $modelt8['tgl_permohonan'] ?>">

                     </div>
                     </div>
                        <div class="col-md-6"></div>
                          </div>

						<div class="col-md-12">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="kepala_kejaksaan_asal" class="control-label col-md-4">Kepala Kejaksaan Asal</label>
                        <div class="col-md-7" style="margin-left:-20px;"><?= $form->field($model, 'kepala_rutan') ?></div>
                        <!-- <input type="hidden" name="PdmBa12[kepala_rutan]" value="<?= Yii::$app->globalfunc->getSatker()->inst_lokinst ?>"> -->
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                     </div>
	 </div>

    <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
        <div style="border-color: #c7c7c7;" class="box-header with-border">
            <h3 class="box-title">
                <!--<i class="glyphicon glyphicon-user"></i>--> <strong>TINDAKAN</strong>
            </h3>
        </div>
        <div class="clearfix"><br></div>
        
        <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tindakan" class="control-label col-md-2">Diberikan</label>
                        <div class="col-md-10">
                                    
                        <?= $form->field($model, 'tindakan')->radioList(['pengeluaran terdakwa' => 'pengeluaran terdakwa', 'pengeluaran tersangka' => 'pengeluaran tersangka'],['inline'=>true]) ?>
                        
                        </div>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label for="register_perkara" class="control-label col-md-3">Atas Pasal</label>
                    <div class="col-md-2"></div>
                </div>-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_ms_loktahanan" class="control-label col-md-3">Dari Tahanan</label>
                        <div class="col-md-9">
                                    
                            <?= $form->field($model, 'id_ms_loktahanan')->radioList($modelLokTahanan, ['inline'=>true]) ?>
                    
                        </div>
                    </div>
                </div>
            </div>



        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Terhitung Sejak</label>
                    <div class="col-md-6">
                        <?php
                             echo $form->field($model, 'tgl_mulai')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'ajaxConversion'=>false,
                                    'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);

                        ?>
                    </div>
                </div>
            </div>
        <div class="col-md-6"></div>
          </div>
	 </div>

	 <div class="box box-primary hide" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

                        <div class="col-md-12 hide">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label col-md-4">Atas Pasal</label>
                        <div class="col-md-6">
	                    <?php //$pasal = PdmPasal::findOne(['id_perkara' =>$model->id_perkara]);?>
	                    <input type="text" class="form-control" value="<?php echo $pasal->pasal; ?>">
                     </div>
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                     </div>

						<div class="col-md-12 hide">
                        <div class="col-md-6">
                        <div class="form-group">
                        <label for="dari-penahanan" class="control-label col-md-4" style="margin-top:20px">Dari Penahanan</label>
                        <div class="col-md-6" style="margin-top:20px">
                        <input type="text" class="form-control" value="">
                     </div>
                     </div>
                     </div>
                        <div class="col-md-6"></div>
                     </div>


	 </div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba10/cetak?id='.$model->id_tersangka.'&tgl_surat='.$model->tgl_ba10] ) ?>">Cetak</a>
		<?php } ?>
    </div>
        <div id="hiddenId"></div>




    <?php ActiveForm::end(); ?>


</section>

<script type="text/javascript">
//JPU
    window.onload = function () {
	        $(document).on('click', '#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });


	//Terdakwa
        var lel = $("#pdmba10-no_reg_tahanan_jaksa :selected").text();
        var lol = $("#pdmba10-no_reg_tahanan_jaksa :selected").val();
        $("#pdmba10-nama").val(lel);
        $("#no_reg_tahananx").val(lol);

        $('#pilih-tersangka').click(function(){
		$('input:checkbox:checked').each(function(index) {
		var value = $(this).val();
		var data = value.split('#');

		$('#tbody_tersangka').append(
			'<tr id="trtersangka'+data[0]+'">' +
			'<td><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
				'<td><input type="hidden" class="form-control" name="id_tersangka[]" readonly="true" value="'+data[0]+'"><input type="text" class="form-control" name="nama[]" readonly="true" value="'+data[1]+'"> </td>' +
				'<td><input type="text" class="form-control" name="alamat[]" readonly="true" value="'+data[2]+'"> </td>' +
				'<td><input type="text" class="form-control" name="pekerjaan[]" readonly="true" value="'+data[3]+'"> </td>' +

			'</tr>'
		);

	});
	$('#m_tersangka').modal('hide');
	 });

    $('.cmb_terdakwa').change(function(){
        var lel = $("#pdmba10-no_reg_tahanan_jaksa :selected").text();
        var lol = $("#pdmba10-no_reg_tahanan_jaksa :selected").val();
        $.ajax({
            type: "POST",
            url: '/pdsold/pdm-ba10/terdakwa',
            data: 'no_reg_tahanan='+$('.cmb_terdakwa').val(),
            success:function(data){
                console.log(data);
                $('#data-terdakwa').html(
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                        '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                        '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                        '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                        '<div class="col-sm-4">'+data.alamat+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Agama</label>'+
                        '<div class="col-sm-4">'+data.agama+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Pekerjaan</label>'+
                        '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Pendidikan</label>'+
                        '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                    '</div>'
                );
                

                var tglawal = new Date(data.ditahan_sejak);


                                console.log(tglawal);
                function pad(s) {
                    return (s < 10) ? '0' + s : s;
                }
                var tgl = [pad(tglawal.getDate()), pad(tglawal.getMonth() + 1), tglawal.getFullYear()].join('-');
                var tgl2 = [tglawal.getFullYear(), pad(tglawal.getMonth() + 1), pad(tglawal.getDate())].join('-');
                console.log(tgl);
                console.log(tgl2);
                //$("#pdmba12-tgl_penahanan-disp").val(tgl);
                //$("#pdmba12-tgl_penahanan").val(tgl2);
                $("#tgl_mulai").val(tgl);
                $("#pdmba10-no_surat_t8").val(data.no_surat_t8);
                $("#pdmba10-nama").val(lel);
                $("#no_reg_tahananx").val(lol);
                $("#pdmba10-id_tersangka").val(data.no_urut_tersangka);
                $("#pdmba10-tgl_penahanan-disp").val(data.tgl_mulai)
               //$("#pdmba10-no_reg_tahanan").val(data.no_reg_tahanan);
                $('#no_reg_tahanan_jaksa').val(data.no_reg_tahanan);
            }
        });
    });
};

    function pilihJPU(nip, nama, jabatan, pangkat) {

        var i = $('table#gridJPU tr:last').index() + 1;

        $('#gridJPU').append(
                "<tr id='trJPU" + i + "'>" +
                "<td id='tdJPU" + i + "'><a class='btn btn-danger delete' id='btn_hapus'></a></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtnip[]' id='txtnip' value='" + nip + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtnama[]' id='txtnama' value='" + nama + "' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtpangkat[]' id='txtpangkat' value='" + pangkat + "' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtjabatan[]' id='txtjabatan' value='" + jabatan + "' style='width:510px;' readonly='true' class='form-control' readonly='true'></td>" +
                "</tr>"
                );
        i++;

        $('#jpu_').modal('hide');

    }



</script>
