<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\typeahead\TypeaheadAsset;
use kartik\select2\Select2Asset;
use app\modules\pidum\models\PdmMsUu;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\modules\pidum\models\PdmMsRentut;
use app\modules\pidum\models\PdmPidanaPengawasan;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP29 */
/* @var $form yii\widgets\ActiveForm */
// TypeaheadAsset::register($this);
// Select2Asset::register($this);
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'rencana-dakwaan-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ]
        ]);
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6 hide">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input class="form-control" readonly="true" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No Reg Perkara</label>
                        <div class="col-md-8">
						<input type="text" id="pdmrencanadakwaan-no_perkara" class="form-control" name="PdmRencanaDakwaan[no_perkara]" readonly="" value="<?php echo $id_berkas->no_pengiriman ?>">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="glyphicon glyphicon-user"></i> Calon Terdakwa
                    </h3>
                </div>
                <?= $form->field($model, 'id_tersangka')->hiddenInput(); ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama</label>
                        <div class="col-sm-4">
                            <?php
                                if ($model->isNewRecord) {
                                    echo $this->context->getTerdakwa($form, $model, $modelSpdp, $readonly = false);
                                }else{
                                    echo $this->context->getTerdakwa($form, $model, $modelSpdp, $readonly = true);
                                }
                            ?>
                        </div>
                    </div>
                    <div id="data-terdakwa">
                        <?php
                        if ($model->id_tersangka != null)
                            echo Yii::$app->globalfunc->getIdentitasTerdakwa($model->id_tersangka);
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <div class="col-md-6">
                    <h3 class="box-title"> Undang-Undang & Pasal</h3>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="box-body" id="undang-pasal">

                    <div class="col-sm-12" style="margin-bottom:10px;">
                        <div class="pull-left"><a class="btn btn-warning" id="tambah-undang-pasal">+</a></div>
                    </div>
                    <div class="col-sm-9">
                            <div class="undang-pasal-append"></div>
                        <?php if(!$modelPasal->isNewRecord):?>
                        <?php foreach ($modelPasal as $key => $value): ?>
                        <div class="hapus<?php echo $key+1 ?>" style="margin-bottom:10px">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>Undang-undang</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="col-sm-9">
                                        <input type="text" name="undang1[]" class="form-control" readonly="true" value="<?= $value['undang'] ?>" placeholder="undang - undang">
                                    </div>
                                    <div class="col-sm-3"><a class='btn btn-danger delete' onclick="hapusPasal(<?php echo $key+1 ?>,'<?php echo $value['id_pasal'] ?>')"></a></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>Pasal</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="col-sm-9">
                                        <input type="text" name="pasal1[]" class="form-control" readonly="true" value="<?= $value['pasal'] ?>" placeholder="pasal - pasal">
                                    </div>
                                </div>
                            </div>
                         </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="box box-primary hide" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <div class="col-md-6">
                    <h3 class="box-title"> Tuntutan Pidana</h3>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="box-body" id="undang-pasal">
                <?php
                    if (!$model->isNewRecord) {
                        echo $form->field($modelAmarPutusan, 'id_amar')->hiddenInput();
                    }
                ?>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Rencana Tuntutan</label>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="form-control" id="input_rentut" name="PdmAmarPutusP29[id_ms_rentut]">
                                            <option value="">Pilih Rencana Tuntutan</option>
                                            <?php foreach (PdmMsRentut::find()->orderBy('id asc')->all() as $key => $value): ?>
                                                <option value="<?php echo $value->id ?>" <?php echo $value->id == $modelAmarPutusan->id_ms_rentut ? "selected" : "" ; ?>>
                                                    <?php echo $value->nama ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="pidana_kurungan_denda">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Kurungan</label>
                            <div class="col-md-2" style="width:17%">
                                <?= $form->field($modelAmarPutusan, 'bulan_kurung')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-20px;">Bulan</label>
                            <div class="col-md-2" style="margin-left:-30px;width:17%;">
                                <?= $form->field($modelAmarPutusan, 'hari_kurung')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-20px;">Hari</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pidana_penjara">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Masa Percobaan</label>
                            <div class="col-md-2" style="width:11%">
                                <?= $form->field($modelAmarPutusan, 'tahun_coba')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                            <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                <?= $form->field($modelAmarPutusan, 'bulan_coba')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                            <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                <?= $form->field($modelAmarPutusan, 'hari_coba')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pidana_penjara">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Pidana Badan</label>
                            <div class="col-md-2" style="width:11%">
                                <?= $form->field($modelAmarPutusan, 'tahun_badan')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                            <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                <?= $form->field($modelAmarPutusan, 'bulan_badan')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                            <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                <?= $form->field($modelAmarPutusan, 'hari_badan')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="denda">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Denda</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">Rp</div>
                                    <?= MaskedInput::widget([
                                            'name' => 'PdmAmarPutusP29[denda]',
                                            'value' => $modelAmarPutusan->denda,
                                            'mask' => '9',
                                            'clientOptions' => [
                                                'repeat' => 10, 
                                                'greedy' => false
                                            ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-12"></div>
                                <div class="col-sm-12">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pidana_penjara">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">SubSidair</label>
                            <div class="col-md-2" style="width:11%">
                                <?= $form->field($modelAmarPutusan, 'tahun_sidair')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                            <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                <?= $form->field($modelAmarPutusan, 'bulan_sidair')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                            <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                <?= $form->field($modelAmarPutusan, 'hari_sidair')->textInput(['type' => 'number', 'min' => 0]); ?>
                            </div>
                            <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pidana_penjara">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Biaya Perkara</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">Rp</div>
                                    <?= MaskedInput::widget([
                                            'name' => 'PdmAmarPutusP29[biaya_perkara]',
                                            'value' => $modelAmarPutusan->biaya_perkara,
                                            'mask' => '9',
                                            'clientOptions' => [
                                                'repeat' => 10, 
                                                'greedy' => false
                                            ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-12"></div>
                                <div class="col-sm-12">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="pidana_tambahan">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Pidana Tambahan</label>
                            <div class="col-md-5">
                                <?= $form->field($modelAmarPutusan, 'pidana_tambahan')->textArea(['rows' => 2]); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pidana_penjara">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Pidana Pengawasan</label>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="form-control" id="input_pidanapengawasan" name="PdmAmarPutusP29[id_ms_pidanapengawasan]">
                                            <option value="">Pilih Pengawasan</option>
                                            <?php foreach (PdmPidanaPengawasan::find()->all() as $key => $value): ?>
                                                <option value="<?php echo $value->id ?>" <?php echo $value->id == $modelAmarPutusan->id_ms_pidanapengawasan ? 'selected' : '' ; ?>>
                                                    <?php echo $value->nama ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Dakwaan</label>
                        <div class="col-md-8">
                            <?php
                                echo $form->field($model, 'dakwaan')->textArea(['rows' => 3]);
                            ?>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Dikeluarkan</label>
                        <div class="col-md-5">
                            <?php
                                echo $form->field($model, 'dikeluarkan')->textInput(
                                    [
                                        'placeholder' => 'Dikeluarkan',
                                        'value' => Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst
                                    ]
                                );
                            ?>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tgl Dikeluarkan</label>
                        <div class="col-md-2" style="width:14%"><?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'DD-MM-YYYY'],//jaka | rubah format placeholder
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Penandatangan (JPU)</label>
                        <div class="col-md-5">
					
 <?php
			//	print_r($modelJpu2->nama);exit;
					 echo "<select id='pdmrencanadakwaan-id_penandatangan' class='form-control' name='PdmRencanaDakwaan[id_penandatangan]'>
					 <option>Pilih Penanda Tangan
	  </option>"; 
	  if($model->id_penandatangan != null and $model->id_penandatangan!=$modelJPU->nip){
 
	 echo  "<option value='".$model->id_penandatangan."' selected>".$modelJpu2->nama."
	 </option>";
  foreach ($modelJpu3 as $key => $value){
	  
		   echo  "<option value='".$value->peg_nip_baru."'>".$value->nama."
	 </option>";
 
		  }
	  }
	  else {
		  foreach ($modelJPU as $key => $value){
			   echo  "<option value='".$value->peg_nip_baru."'>".$value->nama."
	 </option>";
 
		  }
	  }
 echo "</select><br>";
                    ?>
                            <?php
							//print_r($model->id_penandatangan);exit;
                             //   echo $form->field($model, 'id_penandatangan')->dropDownList(
                               //     ArrayHelper::map($modelJPU, 'nip', 'nama'), ['prompt' => 'Pilih JPU']);
                            ?>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hapus_undang_pasal"></div>
        <div class="box-footer">
		 <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
             <?php if (!$model->isNewRecord): ?>    
                <?= Html::a('Cetak', ['cetak', 'id' => $model->id_rencana_dakwaan], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
            <!-- jaka | 24 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', ['../pidum/pdm-rencana-dakwaan/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
        </div>
    </div>
</section>
<script type="text/javascript">
    var list_uu = JSON.parse('<?php echo json_encode(PdmMsUu::find()->select('uu as id, uu as text')->asArray()->all()); ?>');
    console.log(list_uu);
</script>
<?php
$script = <<< JS
        $(document).ready(function(){
            var id = $('#input_rentut').val();
            console.log(id);
            if (id == 4) { // pidana kurungan denda
                $('.pidana_penjara').hide();
                $('#pidana_tambahan').hide();
                $('#pidana_kurungan_denda').show();
                $('#denda').show();
            }else if (id == 3){
                $('.pidana_penjara').show();
                $('#pidana_tambahan').show();
                $('#pidana_kurungan_denda').hide();
                $('#denda').show();
            }else if (id == "") {
                $('.pidana_penjara').hide();
                $('#pidana_tambahan').hide();
                $('#pidana_kurungan_denda').hide();
                $('#denda').hide();
            }
            else {
                $('.pidana_penjara').hide();
                $('#pidana_tambahan').show();
                $('#pidana_kurungan_denda').hide();
                $('#denda').hide();
            }
        });

        var i = 1;
        $('#tambah-undang-pasal').click(function(){
            $('.undang-pasal-append').append(
                '<div class="hapus_pasal_awal'+i+'" style="margin-bottom:10px">'+
                    '<div class="form-group">'+
                        '<div class="col-sm-3">'+
                            '<label>Undang-undang</label>'+
                        '</div>'+
                        '<div class="col-sm-9">'+
                            '<div class="col-md-9">'+
                                '<input type="hidden" class="input_undang" name="undang[]">'+
                            '</div>'+
                            '<div class="col-sm-3">'+
                                '<a class="btn btn-danger delete" onclick=hapusPasalAwal("'+i+'")></a>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<div class="col-sm-3">'+
                            '<label>Pasal</label>'+
                        '</div>'+
                        '<div class="col-sm-9">'+
                            '<div class="col-sm-9">'+
                                '<input type="text" name="pasal[]" class="form-control" placeholder="pasal - pasal">'+
                            '</div>'+   
                        '</div>'+
                    '</div>'+    
                '</div>'
                
                
            );
            $(".input_undang").select2({
                minimumInputLength: 2,
                placeholder: 'Pilih Undang-undang',
                data: list_uu,
                width: '400',
            });
            i++;
        });

        $('#input_rentut').change(function(){
            var id = $(this).val();
            console.log(id);
            if (id == 4) { // pidana kurungan denda
                $('.pidana_penjara').hide();
                $('#pidana_tambahan').hide();
                $('#pidana_kurungan_denda').show();
                $('#denda').show();
            }else if (id == 3){
                $('.pidana_penjara').show();
                $('#pidana_tambahan').show();
                $('#pidana_kurungan_denda').hide();
                $('#denda').show();
            }else {
                $('.pidana_penjara').hide();
                $('#pidana_tambahan').show();
                $('#pidana_kurungan_denda').hide();
                $('#denda').hide();
            }
        });

        $('#input_ubah').click(function(e){
            e.preventDefault();
            var ttd = $('#pdmp29-id_penandatangan');
            var div = $('.field-pdmp29-id_penandatangan');
            if(ttd.val() == ''){
                div.addClass('has-error');
                div.find('.help-block').html("Penandatangan Harus Diisi").css("display", "block");
            }else{
                $("#p29-form").submit();
            }
        });
JS;
$this->registerJs($script);
?>

<script>
    function hapusPasalAwal(key)
    {
        $('.hapus_pasal_awal'+key).remove();
    }
    
    function hapusPasal(key, id_pasal)
    {
        $('.hapus'+key).remove();
        $('.hapus_undang_pasal').append(
            '<input type="hidden" name="hapus_undang_pasal[]" value="'+id_pasal+'">'
        );
    }
</script>

<?php /* CODING NOT USED
*
*

        <div class="box box-primary hide" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12 hide">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Ditahan Penyidik
                    </h3>
                </div><br>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Tahanan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Tgl. Mulai</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Tgl. Selesai</label>
                    </div>
                </div>
                <div class="box-header with-border">
                </div><br>
            </div>
            <div class="col-md-12 hide">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Rutan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_awal_rutan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Mulai'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_akhir_rutan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Selesai'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hide">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Rumah</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_awal_rumah')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Mulai'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_akhir_rumah')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Selesai'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hide">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Kota</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_awal_kota')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Mulai'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_akhir_kota')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Selesai'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <strong>Penahanan</strong>
                </h3>
            </div>
            <br>
            <div class="col-md-12 with-border"></div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Perpanjangan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'perpanjangan');
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tgl.</label>
                        <div class="col-md-10"><?=
                            $form->field($model, 'tgl_perpanjangan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Perpanjangan'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Pengalihan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'pengalihan');
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tgl.</label>
                        <div class="col-md-10"><?=
                            $form->field($model, 'tgl_pengalihan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Pengalihan'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Penangguhan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'tgl_penangguhan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Penangguhan'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Pencabutan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'pencabutan');
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tgl.</label>
                        <div class="col-md-10"><?=
                            $form->field($model, 'tgl_pencabutan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Pencabutan'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-12">Dikeluarkan tahanan</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-12"><?=
                            $form->field($model, 'dikeluarkan');
                            ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tgl.</label>
                        <div class="col-md-10"><?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Pencabutan'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?></div>
                    </div>
                </div>
            </div>
        </div>
**/