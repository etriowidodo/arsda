<?php

/**
 * Created by PhpStorm.
 * User: rio
 * Date: 25/06/15
 * Time: 16:03
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;

use kartik\widgets\FileInput;
use yii\helpers\Url;
use app\models\MsSifatSurat;
use app\models\KpInstSatker;
use app\components\GlobalConstMenuComponent;

$this->registerJs(
  "$('#pelimpahan-form').on('afterValidate', function (event, messages) {
     
    if(typeof $('.has-error').first().offset() !== 'undefined') {
      var scroll     = $('.has-error').first().closest(':visible').offset().top;
      var minscroll  = (86.6/100)*scroll;
        $('html, body').animate({
            scrollTop: ($('.has-error').first().closest(':visible').offset().top)-minscroll
        }, 1500);
        var lenghInput = $('.has-error div input[type=text]').length;
        var lenghSearch = $('.has-error div input[type=search]').length;
         $('.has-error div input').first().focus();  
        if(lenghInput==0)
        {
          var minscrollText = (39/100)*($(document).height()-$(window).height());
          $('html, body').animate({
            scrollTop: ($(document).height()-$(window).height())-minscrollText
        }, 1500);
           $('.has-error div textarea').first().focus();
        }
        
      }
  });"
  );
?>

<?php

$form = ActiveForm::begin([
            'id' => 'pelimpahan-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ],
            'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
        ]);
?>
<div class="modal-loading-new"></div>
	<div class="modal-content" style="margin: 2% auto;">
		<div class="modal-header">Surat Pengantar Pelimpahan</div>
		<div class="modal-body">

			<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

    <div class="col-md-12">
		<div class="form-group">
					<label class="control-label col-md-2">Wilayah Pelimpahan</label>
					<div class="col-md-4">
						<div class="form-group field-pdmpenyelesaianpratutlimpah-kd_satker_pelimpahan">
							<div class="col-sm-12">
							<div class="input-group">
								<input id="nama_satker" class="form-control" value="<?=KpInstSatker::findOne(['inst_satkerkd'=>$modelLimpah->kd_satker_pelimpahan])->inst_nama?>" type="text">
								<div class="input-group-btn">
									<a class="btn btn-warning" data-backdrop="static" data-keyboard="false" id="popupSatker" data-target="#modalSatker" data-toggle="modal" >Pilih</a>
								</div>
							</div>
							</div>
							<div class="col-sm-12"></div>
							<div class="col-sm-12"><div class="help-block"></div></div>
						</div>
						<div class="hide">
						 <?php
                            echo $form->field($modelLimpah, 'kd_satker_pelimpahan')->hiddenInput()->label(false);
                            ?>
						</div>
					</div>
		</div>
	</div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Nomor</label>
            <div class="col-sm-3">
                <?= $form->field($modelLimpah, 'no_surat')->input('text',
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
                    if($modelLimpah->isNewRecord){
                       echo $form->field($modelLimpah, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                    }else{
                       echo $form->field($modelLimpah, 'dikeluarkan');
                    } 
				
				
					//$MinTgl  = date('d-m-Y', strtotime('+1 days', strtotime($TglTerima))); 
					//$MaxTgl  = date('d-m-Y', strtotime('+30 days', strtotime($TglTerima))); 
				

							
                ?>
            </div>
			 <label class="control-label col-sm-2" style="width: 9%;">Tanggal</label>
            <div class="col-sm-2" style="width:12%;">			
                <?=
                $form->field($modelLimpah, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tgl Surat',//dikeluarkan jadi surat
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                             'startDate' => date('d-m-Y',strtotime($date_akhir)),
                             'endDate'   => date('d-m-Y') ,
                        ]
                    ]
                ]);
                ?>		
            </div>
        </div>
    </div>




    <?php

    //CMS_PIDUM04_57 #default kepada Yth mengarah pada id penyidik SPDP 06 junni 2016
	if($modelLimpah->kepada ==''){
        $connection = \Yii::$app->db;
    
			$id_perkara = Yii::$app->session->get('id_perkara');
            $spdp = $connection->createCommand("SELECT id_penyidik,id_asalsurat FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_inst_pelak_penyidikan WHERE kode_ip = '$spdp[id_asalsurat]' AND kode_ipp = '$spdp[id_penyidik]'")->queryOne();
            $value1 = "Kepala ".$instansiPenyidik['nama'];
	}else{
		$value1 = $modelLimpah->kepada;
	}

    ?>
	
    <div class="col-md-12">
          <div class="form-group">
            <label class="control-label col-sm-2" >Sifat</label>
            <div class="col-sm-3">
                <?= $form->field($modelLimpah, 'sifat')->dropDownList(
                    ArrayHelper::map(MsSifatSurat::find()->all(), 'id', 'nama'), 
                    ['prompt' => 'Pilih Sifat']) ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Kepada Yth.</label>
            <div class="col-sm-4" style="width:40%;"><?= $form->field($modelLimpah, 'kepada')->textarea(['rows' => 2, 'value' => $value1]) ?></div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Lampiran</label>
            <div class="col-sm-3">
			<?php if($modelLimpah->isNewRecord){
			?>
                <?= $form->field($modelLimpah, 'lampiran')->textInput(['value' => '-'])  ?>
			<?php } else { ?>
			<?= $form->field($modelLimpah, 'lampiran')  ?>
		<?php	} ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Di</label>
            <div class="col-sm-3"><?= $form->field($modelLimpah, 'di_kepada') ?></div>
        </div>
    </div>
	<div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Perihal</label>
            <div class="col-sm-3">
                <?php 
				if($modelLimpah->isNewRecord){
					echo $form->field($modelLimpah, 'perihal')->textArea(['value' => '-']);  
				}else{
					echo $form->field($modelLimpah, 'perihal')->textArea();
				}	
				?>
            </div>
            
        </div>
    </div>
</div>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
	  <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Nomor</label>
            <div class="col-sm-3">
                <input type="text" readonly class="form-control" value="<?=$modelBerkas['no_berkas']?>"  />
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Tanggal</label>
            <div class="col-sm-2" style="width:10%"><input type="text" readonly class="form-control" value="<?=$modelBerkas['tgl_berkas']?>"  /></div>
			<label class="control-label col-sm-2" style="width: 15%;">Tanggal Diterima</label>
            <div class="col-sm-2" style="width:10%"><input type="text" readonly class="form-control" value="<?=$modelBerkas['tgl_terima']?>" /></div>
        </div>
    </div>
</div>

<div class="box box-primary" style="border-color: #f39c12">
	<div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">
			<a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2" id="popUpJpu">+ Menunjuk Jaksa P-16A</a>
		</h3>
	</div>
	<div class="box-header with-border">

	<!-- jaka | rubah grid jaksa -->
		<table id="table_jpu" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="text-align:center;" width="45px"></th>
					<th style="text-align:center;" width="45px">#</th>
					<th>Nama<br>NIP</th>
					<th>Pangkat / Golongan<br>Jabatan</th>
				</tr>
			</thead>
			<tbody id="tbody_jpu">
				<?php $i=1;foreach ($modelJaksa as $key => $value): ?>
					<tr>
						<td>
							<input id="hapusJaksa" class="hapusJaksa" type="checkbox"  name="jaksa[]">
							<input type="hidden" name="nip_baru[]" value="<?=$value['peg_nip']?>"  /> 
							<input type="hidden" name="gol_jpu[]" value="<?=$value['pangkat']?>"  /> 
							<input type="hidden" name="nama_jpu[]" value="<?=$value['nama']?>"  /> 
							<input type="hidden" name="jabatan_jpu[]" value="<?=$value['jabatan']?>"  /> 
						</td>
						<td><?=$i?></td>
						<td><?php echo $value['nama']."<br/>".$value['peg_nip']?></td>
						<td><?php echo $value['pangkat']."<br/>".$value['jabatan']?></td>
					</tr>
				<?php $i++;endforeach; ?>
			</tbody>
		</table>
	 <!-- END -->
	</div>
</div>

<div class="box box-primary" style="border-color: #f39c12">
	<div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">
		   Tersangka
		</h3>
	</div>
	<div class="box-header with-border">
		  <table id="table_grid_tersangka" class="table table-bordered table-striped">
			<thead>
					<th style="text-align:center;width:60px;">#</th>
					<th>Nama</th>
					<th>Tanggal Lahir</th>
					<th>Jenis Kelamin</th>
					<th>Status Penahanan</th>
				</tr>
			</thead>
			<tbody id="tbody_grid_tersangka">
				 <?php $i=1; foreach ($modelTersangka as $key => $value): ?>
						<tr>
							<td><?=$i?></td>
							<td><?=$value['nama']?></td>
							<td><?=$value['tgl_lahir']?></td>
							<td><?php echo $value['kelamin']?></td>
							<td>
								<input type="hidden" name="hdn_id_tersangka[]" value="<?=$value['id_tersangka']?>" />
								<label class="radio-inline">
								<input type="radio" value="0" <?php if($value['status_penahanan']=='0'){ echo 'checked';} ?> name="chk_status_penahanan[<?=($i-1)?>]" >
								Ditahan
								</label>
								<label class="radio-inline">
								<input type="radio" value="1" <?php if($value['status_penahanan']=='1'){ echo 'checked';} ?> name="chk_status_penahanan[<?=($i-1)?>]">
								Tidak Ditahan
								</label>
							</td>
						</tr>
					<?php $i++;endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php  echo $this->render('//default/_formFooter', ['form' => $form, 'model' => $modelLimpah, 'GlobalConst' => GlobalConstMenuComponent::LimpahBerkas, 'id_table' => $modelLimpah->id_pratut_limpah]) ?>

  <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $modelLimpah]) ?>
		<?php //if(!$modelLimpah->isNewRecord){ ?>
			<!--<a class="btn btn-warning" href="<?php //echo yii\helpers\Url::to(['pdm-penyelesaian-pratut-limpah/cetak?id='.$modelLimpah->id_pratut_limpah] ) ?>">Cetak</a> -->
		<?php //} ?>
		<a class="btn btn-danger" id='batal-pelimpahan'>Batal</a>
    </div>
	
		</div>
	</div>


<?php
ActiveForm::end();
?>

	


<?php
 
    $js = <<< JS
	
	$('#batal-pelimpahan').click(function(){
                $('#bannerformmodal').modal('hide');
				$('div.modal-backdrop').remove();
				$('body.modal-open').removeClass('modal-open');
				$('body').removeAttr( 'style' );
            });

	
JS;
    $this->registerJs($js);
?>

	

