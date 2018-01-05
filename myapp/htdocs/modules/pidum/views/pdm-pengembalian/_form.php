<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\builder\Form;
use app\models\MsSifatSurat;
use app\components\GlobalConstMenuComponent;
use kartik\widgets\FileInput;
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php $form = ActiveForm::begin(
    [
        'id' => 'pdm-pengembalian-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'labelSpan' => 1,
            'showLabels' => false

        ],
		'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
    ]); 


   $tgl_p21a = date('Y-m-d',strtotime($modelP21a->tgl_dikeluarkan));

   $date_awal  = date('Y-m-d');

    $date_akhir = date_create((date('Y-m-d',strtotime($tgl_p21a))));
    date_add($date_akhir, date_interval_create_from_date_string('30 days'));
    $date_akhir = $date_akhir->format('Y-m-d');

     // echo $date_awal.'-'.$date_akhir ;
    ?>

    <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

    <div class="col-md-12 hide">
        <div class="form-group">
            <label class="control-label col-sm-2">Wilayah Kerja</label>
            <div class="col-sm-3" >
                <input class="form-control" readonly='true' value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Nomor</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'no_surat')->input('text',
                                ['oninput'  =>'
										var number =  /^[A-Za-z0-9-/]+$/;
                                        if(this.value.length>50)
                                        {
                                          this.value = this.value.substr(0,50);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        var str   = "";
                                        var slice = "";
                                        var b   = 0;
                                        for(var a =1;a<=this.value.length;a++)
                                        {
											
                                            slice = this.value.substr(b,1);
                                            if(slice.match(number))
                                            {
												
                                                str+=slice;
												
                                            }
                                            
                                            b++
                                        }
                                        this.value=str;
                                        '])  ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Dikeluarkan</label>
            <div class="col-sm-3" style="width: 19%;">
                <?php
                    if($model->isNewRecord){
                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                    }else{
                       echo $form->field($model, 'dikeluarkan');
                    } 
				
				
					//$MinTgl  = date('d-m-Y', strtotime('+1 days', strtotime($TglTerima))); 
					//$MaxTgl  = date('d-m-Y', strtotime('+30 days', strtotime($TglTerima))); 
				

							
                ?>
            </div>
			 <label class="control-label col-sm-2" style="width: 9%;">Tanggal</label>
            <div class="col-sm-2" style="width:12%;"><!-- jaka merubah lebar field tanggal -->
			<?php if ($_SESSION['tgl_terima'] != '')
			{
				
				?>
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							//'startDate' => $MinTgl,
							'endDate'   => date('d-m-Y'),
                        ]
                    ]
                ]);
				//End Danar
                ?>
				<?php
			}else {	?>
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tgl Surat',//dikeluarkan jadi surat
                        ],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?>
		<?php		
			}
		//End Danar
		?>
            </div>
        </div>
    </div>




    <?php

    //CMS_PIDUM04_57 #default kepada Yth mengarah pada id penyidik SPDP 06 junni 2016
	if($model->kepada ==''){
        $connection = \Yii::$app->db;
    
			$id_perkara = Yii::$app->session->get('id_perkara');
            $spdp = $connection->createCommand("SELECT id_penyidik,id_asalsurat FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_inst_pelak_penyidikan WHERE kode_ip = '$spdp[id_asalsurat]' AND kode_ipp = '$spdp[id_penyidik]'")->queryOne();
            $value1 = "Kepala ".$instansiPenyidik['nama'];
	}else{
		$value1 = $model->kepada;
	}

    ?>
	
    <div class="col-md-12">
          <div class="form-group">
            <label class="control-label col-sm-2" >Sifat</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'sifat')->dropDownList(
                    ArrayHelper::map(MsSifatSurat::find()->all(), 'id', 'nama'),  ['options' =>  ['1'=>['Selected'=>true]]]) ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Kepada Yth.</label>
            <div class="col-sm-4" style="width:40%;"><?= $form->field($model, 'kepada')->textarea(['rows' => 2, 'value' => $value1]) ?></div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Lampiran</label>
            <div class="col-sm-3">
			<?php if($model->isNewRecord){
			?>
                <?= $form->field($model, 'lampiran')->textInput(['value' => '-'])  ?>
			<?php } else { ?>
			<?= $form->field($model, 'lampiran')  ?>
		<?php	} ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Di</label>
            <div class="col-sm-3"><?= $form->field($model, 'di_kepada') ?></div>
        </div>
    </div>
	<div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Perihal</label>
            <div class="col-sm-3">
                <?php 
				if(!$model->isNewRecord){
					echo $form->field($model, 'perihal')->textArea();  
				}else{
					echo $form->field($model, 'perihal')->textArea(['value' => "Pengembalian Surat pemberitahuan dimulainya penyidikan a.n ".Yii::$app->globalfunc->getListTerdakwa(Yii::$app->session->get('id_perkara'))]);  
				}
				?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Alasan</label>
            <div class="col-sm-3"><?= $form->field($model, 'alasan')->textArea(); ?></div>
        </div>
    </div>
</div>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
	  <div class="col-md-12">
		<?php if($konstanta=='PengembalianSPDP'){ ?>
        <div class="form-group">
            <label class="control-label col-sm-2">Nomor SPDP</label>
            <div class="col-sm-3">
                <input type="text" readonly class="form-control" value="<?=$modelPengembalian->no_surat?>" />
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Tanggal</label>
            <div class="col-sm-2"><input type="text" readonly class="form-control" value="<?=$modelPengembalian->tgl_surat?>" /></div>
			<label class="control-label col-sm-2" style="width: 10%;">Tanggal Diterima</label>
            <div class="col-sm-2"><input type="text" readonly class="form-control" value="<?=$modelPengembalian->tgl_terima?>" /></div>
        </div>
		<?php }else{ ?>
		<div class="form-group">
            <label class="control-label col-sm-2">Nomor Berkas</label>
            <div class="col-sm-3">
                <input type="text" readonly class="form-control" value="<?=$modelPengembalian['no_berkas']?>" />
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Tanggal</label>
            <div class="col-sm-2"><input type="text" readonly class="form-control" value="<?=$modelPengembalian['tgl_berkas']?>" /></div>
			<label class="control-label col-sm-2" style="width: 10%;">Tanggal Diterima</label>
            <div class="col-sm-2"><input type="text" readonly class="form-control" value="<?=$modelPengembalian['tgl_terima']?>" /></div>
        </div>
		<?php } ?>
    </div>
</div>

<?php 
if($konstanta=='PengembalianSPDP'){
	$label = 'Unggah Surat Pengembalian SPDP...';
}else{
	$label = 'Unggah Surat Pengembalian Berkas...';
}
	
?>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
<div class="col-md-12" >
        <div class="col-md-6" >
            <div class="form-group form-inline">
        		
				<div class="col-md-2 inline" >
                <?php
						echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/pdf'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
								'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['pdf'],
                                'browseLabel'=>$label,
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pidum_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					
                        ?>  
						
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php if($konstanta=='PengembalianSPDP'){ ?>
 <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::PengembalianSPDP, 'id_table' => $model->id_pengembalian]) ?>
<?php }else{ ?>
 <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::PengembalianBerk, 'id_table' => $model->id_pengembalian]) ?>
<?php } ?>
	
    <div class="box-footer" style="text-align: center;">
    <?php if($tgl_p21a!=''&&($date_awal>$date_akhir)){?>
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
    <?php }?>
		<?php if(!$model->isNewRecord){ ?>
			<?php if($konstanta=='PengembalianSPDP'){ ?>
				<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-pengembalian/cetakspdp?id='.$model->id_pengembalian] ) ?>">Cetak</a>
			<?php }else{ ?>
				<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-pengembalian/cetakberkas?id='.$model->id_pengembalian] ) ?>">Cetak</a>
			<?php } ?>
		<?php } ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
</section>
 <?php
        $now = date('d-m-Y');
            $script = <<< JS

            
       $(document).ready(function(){
        var date_awal = Date.parse('$date_awal');
        var date_akhir = Date.parse('$date_akhir');
        if ('$tgl_p21a'=='')
        {
         bootbox.dialog({
                message: "Anda Belum Dapat Melakukan Input Pengembalian Berkas, Karena Belum melakukan input P21a",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
        else if (date_awal < date_akhir)
        {
         bootbox.dialog({
                message: "Anda Belum Dapat Melakukan Input Pengembalian Berkas, Karena Tanggal Belum Melebihi 30 Hari Dari Tanggal Dikeluarkan P21a",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
    });

    var date        = '$tgl_p21a';
        // date            = date[2]+'-'+date[1]+'-'+date[0];
        console.log(date);
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate()+1);
        endDate.setDate(endDate.getDate()+30);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmpengembalianberkas-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmpengembalianberkas-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmpengembalianberkas-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':finaldate ,'endDate':'$now','format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmpengembalianberkas-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmpengembalianberkas-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmpengembalianberkas-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmpengembalianberkas-tgl_dikeluarkan-disp').removeClass('.has-error');
          $('#pdmpengembalianberkas-tgl_dikeluarkan-disp').removeAttr('disabled');

JS;
            $this->registerJs($script);
            ?>