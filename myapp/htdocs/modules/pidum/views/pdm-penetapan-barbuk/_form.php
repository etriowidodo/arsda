<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\modules\pidum\models\MsInstPenyidik;
use app\modules\pidum\models\PdmMsSatuan;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use yii\bootstrap\Modal;
use app\modules\pidum\models\VwPenandatangan;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbuk */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(

  "
  $('#pdm-penetapan-barbuk-form').on('afterValidate', function (event, messages) {
     
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
  });

  $('#sp_penyitaan').on('change',function(){
    var date        = $(this).val().split('-');
    date            = date[2]+'-'+date[1]+'-'+date[0];
    console.log(date);
    var someDate    = new Date(date);
    var endDate     = new Date();
    //someDate.setDate(someDate.getDate()+7);
    someDate.setDate(someDate.getDate()+1);
    endDate.setDate(endDate.getDate());
    var dateFormated        = someDate.toISOString().substr(0,10);
    var enddateFormated     = endDate.toISOString().substr(0,10);
    var resultDate          = dateFormated.split('-');
    var endresultDate       = enddateFormated.split('-');
    finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
    date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
    var input               = $('#tgl_dikeluarkan').html();
    var datecontrol         = $('#pdmpenetapanbarbuk-tgl_surat-disp').attr('data-krajee-datecontrol');
    $('#tgl_dikeluarkan').html(input);
    var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_001 = {'idSave':'pdmpenetapanbarbuk-tgl_surat','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
      $('#pdmpenetapanbarbuk-tgl_surat-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmpenetapanbarbuk-tgl_surat-disp').datecontrol(datecontrol_001);
      $('.field-pdmpenetapanbarbuk-tgl_surat').removeClass('.has-error');
      $('#pdmpenetapanbarbuk-tgl_surat-disp').removeAttr('disabled');
  });


  "
  );
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php $form = ActiveForm::begin(
    [
        'id' => 'pdm-penetapan-barbuk-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ]
    ]); ?>
		<!-- <div class="box box-primary" style="border-color: #f39c12;padding:20px">
			<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-sm-2">Nomor Penetapan</label>
				<div class="col-sm-10">
					 
				</div>
			</div>
			</div>
		</div> -->

        <div class="box box-primary" style="border-color: #f39c12;padding:20px">
            
            
            <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Instansi Penyidik</label>
                    <div class="col-md-8">
                        <?php
                        echo $form->field($model, 'id_inst_penyidik')->dropDownList(
                                ArrayHelper::map(MsInstPenyidik::find()->all(), 'kode_ip', 'nama'), // Flat array ('id'=>'label')
                                ['id' => 'InstansiPenyidik']    // options
                        );?>
                    </div> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Instansi Pelaksana Penyidikan</label>

                    <div class="col-md-6">
                        <?php
                        if($model->isNewRecord){
                            echo $form->field($model, 'id_inst_penyidik_pelaksana')->dropDownList(
                                ['' => 'Pilih Instansi Penyidik Dahulu']//, ['id' => 'InstansiPelaksanaPenyidik']
                            );
                        }else{
                            echo $form->field($model, 'id_inst_penyidik_pelaksana')->dropDownList(
                                ArrayHelper::map(MsInstPelakPenyidikan::findAll(['kode_ipp'=>$model->id_inst_penyidik_pelaksana]), 'kode_ipp', 'nama')//, // Flat array ('id'=>'label')
                                //['id' => 'InstansiPelaksanaPenyidik']
                            );
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Tersangka</label>
                <div class="col-md-8">
                    <?= $form->field($model, 'tersangka')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            </div>
                </div>
        
        </div>
		
		<div class="box box-primary" style="border-color: #f39c12;padding:20px">
			<div class="box-header with-border" style="border-color: #c7c7c7;">
				<div class="col-md-6" style="padding: 0px;">
					<h3 class="box-title">
					<a class='btn btn-danger delete hapus hapusSurat'></a>
					&nbsp;
					<a class="btn btn-primary tambah_memperhatikan">+ Memperhatikan</a>
					
					</h3>
				</div>
			</div>
			 <div class="box-header with-border">
                  <table id="table_grid_surat" class="table table-bordered table-striped">
					<thead>
						<th></th>
						<th>Memperhatikan Surat</th>
						<th>Nomor</th>
						<th>Tanggal</th>
					</thead>
                    <tbody id="tbody_grid_surat">
					<?php if(!$model->isNewRecord){ ?>
                        <?php foreach($modelSurat as $key =>$value): ?>
						<tr>
							<td></td>
                            <td><input type="text" class="form-control" name="txt_nama_surat[]" readonly value="<?=$value->nama_surat?>" /></td>
                            <td><input type="text" style="width:80%" class="form-control" name="txt_nomor_surat[]" value="<?=$value->no_surat?>" /></td>
                            <td>
								<input type="text" name="txt_tgl_surat[]" class="form-control date-picker" placeholder="DD-MM-YYYY" style="width:30%;float:left" value="<?=date('d-m-Y',strtotime($value->tgl_surat))?>" />
								<?php if($value->nama_surat=='SURAT PEMBERITAHUAN'){ ?>
								<label style="float:left;margin-right:10px;">s/d</label>
								 <input type="text" name="txt_tgl_terima" class="form-control date-picker" placeholder="DD-MM-YYYY" style="width:22%" value="<?=date('d-m-Y',strtotime($value->tgl_diterima))?>" />
								<?php } ?>
							</td>
                        </tr>
						<?php endforeach; ?>
					<?php }else{ ?>
						<tr>
							<td></td>
                            <td width="30%"><input type="text" class="form-control" name="txt_nama_surat[]" readonly value="SPDP" /></td>
                            <td width="40%"> <input id="txt_no_spdp" type="text" style="width:100%" class="form-control" name="txt_nomor_surat[]"  /></td>
                            <td> <input type="text" name="txt_tgl_surat[]" class="form-control date-picker" placeholder="DD-MM-YYYY" style="width:50%;float:left;margin-right:10px"  id="txt_tgl_spdp" /> <a data-toggle="modal" data-target="#_spdp" class="btn btn-primary cari_spdp">Pilih SPDP</a></td>
                        </tr>
						<tr>
							<td></td>
                            <td><input type="text"  class="form-control" name="txt_nama_surat[]" readonly value="SP PENYITAAN" /></td>
                           <td><input type="text" id="sp_penyitaan" style="width:100%" class="form-control" name="txt_nomor_surat[]"  /></td>
                            <td><input style="width:50%;float:left;margin-right:10px" type="text" id='sp_penyitaan' name="txt_tgl_surat[]" class="form-control date-picker" placeholder="DD-MM-YYYY" style="width:50%" /></td>
                        </tr>
						<tr>
							<td></td>
                            <td><input type="text" class="form-control" name="txt_nama_surat[]" readonly value="SURAT PEMBERITAHUAN PENYITAAN BARANG BUKTI" /></td>
                            <td> <input type="text" style="width:100%" class="form-control" name="txt_nomor_surat[]"  /></td>
                            <td> <input type="text" name="txt_tgl_surat[]" class="form-control date-picker" placeholder="DD-MM-YYYY" style="width:40%;float:left" /><label style="float:left;margin-right:10px;">s/d</label> <input type="text" name="txt_tgl_terima" class="form-control date-picker" placeholder="DD-MM-YYYY" style="width:40%" /></td>
                        </tr>
						<tr>
							<td></td>
                            <td><input type="text" class="form-control" name="txt_nama_surat[]" readonly value="SP PENYISIHAN" /></td>
                            <td> <input type="text" style="width:100%" class="form-control" name="txt_nomor_surat[]"  /></td>
                            <td><input style="width:50%;float:left;margin-right:10px" type="text" name="txt_tgl_surat[]" class="form-control date-picker" placeholder="DD-MM-YYYY"  /></td>
                        </tr>
					
					<?php } ?>
                    </tbody>
                </table>
            </div>
		</div>
		
                
                <div class="box box-primary" style="border-color: #f39c12;padding:20px">

                    <div class="box-header with-border">
                        <div class="row">
                         <div class="box-header with-border" style="border-color: #c7c7c7;">
                            <h3 class="box-title">
                                <a class="btn btn-danger delete hapusTembusan"></a> 
                                <a  class="btn btn-success tambah_data_barbuk" style="margin-top:0px;margin-right:3px;">Tambah</a>
                            </h3>
                        </div>
                        </div>
                        
                        <div class="box-header with-border">
                            <table id="table_grid_barbuk" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:1%">#</th>
                                        <th style="width:3%">NO</th>
                                        <th style="width:31%">Nama / Jenis Barang Bukti</th>
                                        <th style="width:3%">Jumlah</th>
                                        <th style="width:5%">Satuan</th>
                                        <th style="width:10%">Pemilik</th>
                                        <!-- <th style="width:7%">penyimpanan</th> -->
                                        <th style="width:3%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_data_barbuk">
                                <?php if(!$model->isNewRecord){ ?>
                                    <?php foreach($modelBarbuk as $key =>$value): ?>
                                    <tr>
                                        <td><input type="checkbox" name="new_check[]" class="hapusTembusanCheck" value=""></td>
                                        <td><input type="text" readonly ="true" name="barbuk_pratut[nobarbuk][]" class="form-control" value="<?=$value->no ?>"></td>
                                        <td><input type="text" name="barbuk_pratut[namabarbuk][]" class="form-control" value="<?=$value->nama ?>"></td>
                                        <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" name="barbuk_pratut[jumlahbarbuk][]" class="form-control" value="<?=$value->jumlah ?>"></td>
                                        <td>
                                        <!-- <input type="text" name="barbuk_pratut[satuanbarbuk][]" class="form-control" value="<?=$value->id_satuan ?>"> -->
                                        <select id="satuan" name="barbuk_pratut[satuanbarbuk][]" class="select2" style="width:100%;" ">
                                            <option><?=$value->id_satuan ?></option>
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                        </select>
                                        </td>
                                        <td><input type="text" name="barbuk_pratut[pemilikbarbuk][]" class="form-control" value="<?=$value->pemilik ?>"></td>
                                        
                                        <td><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal<?=$value->no ?>">Rincian</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php }else{ ?>
                                <tr>
                                        <td><input type="checkbox" name="new_check[]" class="hapusTembusanCheck" value=""></td>
                                        <td><input type="text" readonly ="true" name="barbuk_pratut[nobarbuk][]" class="form-control" value="1"></td>
                                        <td><input type="text" name="barbuk_pratut[namabarbuk][]" class="form-control" value=""></td>
                                        <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" name="barbuk_pratut[jumlahbarbuk][]" class="form-control" value=""></td>
                                        <td><!-- <input type="text" name="barbuk_pratut[satuanbarbuk][]" class="form-control" value=""></td> -->
                                        <select id="satuan" name="barbuk_pratut[satuanbarbuk][]" class="select2" style="width:100%;" ">
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                        </select>
                                        <td><input type="text" name="barbuk_pratut[pemilikbarbuk][]" class="form-control" value=""></td>
                                        <!-- <td><input type="text" name="barbuk_pratut[penyimpananbarbuk][]" class="form-control" value=""></td> -->
                                        <td><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">Detail</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

<!-- Modal -->  
            <?php if(!$model->isNewRecord){ ?>
                <?php foreach($modelKepentingan as $key =>$vals): ?>
                    <div class="modal fade" id="myModal<?=$vals['no']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Status Barang Bukti</h4>
                      </div>
                      <div class="modal-body">
                     <table id="table_grid_barbuk" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:40%">Penyisihan dan Pemusnahan Barang Bukti</th>
                                <th align="center">Jumlah</th>
                                <th align="center">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Kepentingan Pembuktian Perkara </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_pembuktian][]" value="<?=$vals['jumlah_pembuktian']?>"/></td>
                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_pembuktian][]" class="select2" style="width:100%;" ">
                                            <option value="<?=$vals['satuan_pembuktian']?>" selected><?=$vals['satuan_pembuktian']?></option>
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Kepentingan Pengembangan Ilmu Pengetahuan </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_iptek][]" value="<?=$vals['jumlah_iptek']?>" />
                                </td>

                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_iptek][]" class="select2" style="width:100%;" ">
                                            <option value="<?=$vals['satuan_iptek']?>" selected><?=$vals['satuan_iptek']?></option>
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Kepentingan Pendidikan dan Pelatihan </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_diklat][]"/ value="<?=$vals['jumlah_diklat']?>"></td>
                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_diklat][]" class="select2" style="width:100%;" ">
                                            <option value="<?=$vals['satuan_diklat']?>" selected><?=$vals['satuan_diklat']?></option>
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Dimusnahkan </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_dimusnahkan][]" value="<?=$vals['jumlah_dimusnahkan']?>" /></td>
                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_dimusnahkan][]" class="select2" style="width:100%;" ">
                                            <option value="<?=$vals['satuan_dimusnahkan']?>" selected><?=$vals['satuan_dimusnahkan']?></option>
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
            <?php }else{ ?>
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                        <h4 class="modal-title" id="myModalLabel">Status Barbuk</h4>
                      </div>
                      <div class="modal-body">
                     <table id="table_grid_barbuk" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:40%;">Penyisihan dan Pemusnahan Barang Bukti</th>
                                <th align="center">Jumlah</th>
                                <th align="center">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Kepentingan Pembuktian Perkara </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_pembuktian][]"/></td>
                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_pembuktian][]" class="select2" style="width:100%;" ">
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Kepentingan Pengembangan Ilmu Pengetahuan </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_iptek][]"/>
                                </td>

                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_iptek][]" class="select2" style="width:100%;" ">
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Kepentingan Pendidikan dan Pelatihan </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_diklat][]"/></td>
                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_diklat][]" class="select2" style="width:100%;" ">
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> Dimusnahkan </td>
                                <td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_dimusnahkan][]"/></td>
                                <td>
                                    <select name="pdm_kepentingan_barbuk[satuan_dimusnahkan][]" class="select2" style="width:100%;" ">
                                            <option value=''></option>
                                            <?php 
                                                $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    echo '<option value="'.$dOpt['nama'].'">'.$dOpt['nama'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
		  <?php } ?>
        
	<!-- end modal -->
		
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">

                <div class="col-md-6">

                    &nbsp;
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Penetapan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_penetapan')->input('text',
                                ['onblur'  =>'
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
                    </div>
                </div>
            </div>
			<div class="col-md-12">

                <div class="col-md-6">

                    &nbsp;
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dikeluarkan</label>
                        <div class="col-md-8">
                             <?php 
                                if ($model->isNewRecord){
                                    echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]) ;
                                }else{
                                    echo $form->field($model, 'dikeluarkan'); 
                                } 
                                ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="col-md-6">

                    &nbsp;
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Surat</label>
                        <div class="col-md-4"  id="tgl_dikeluarkan">
                            <?=
							 $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
								'type' => DateControl::FORMAT_DATE,
								'ajaxConversion' => false,
								'options' => [
									'options' => [
										'placeholder' => 'Tgl Surat',//dikeluarkan jadi surat
										'style'=>'width:75%',
										'placeholder'=>'DD-MM-YYYY'
									],
									'pluginOptions' => [
										'autoclose' => true,
										'endDate' => date('d-m-Y')
									]
								]
							]);
                           
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	
	 <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::PenetapanBarbuk, 'id_table' => $model->id_sita]) ?>
		
	<div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
		<?php if(!$model->isNewRecord){ ?>
			<!--<a class="btn btn-warning" href="<?php //echo  \yii\helpers\Url::to(['pdm-penetapan-barbuk/cetak?id='.$model->id_sita] ) ?>">Cetak</a>-->
		<?php } ?>
    </div>
    <?php ActiveForm::end(); ?>

	</div>
</section>





<?php
Modal::begin([
    'id' => '_spdp',
    'header' => 'Data SPDP',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('//pdm-penetapan-barbuk/_spdp', [
    'searchSPDP' => $searchSPDP,
    'dataSPDP' => $dataSPDP,
])
?>

<?php
Modal::end();
?>  

<?php
    $sqlOpt = "select nama from pidum.pdm_ms_satuan order by nama";
            $option='';
                                                $resOpt = PdmMsSatuan::findBySql($sqlOpt)->asArray()->all();
                                                foreach($resOpt as $dOpt){
                                                    // if($dOpt['nama']=='$'){
                                                    //     $dOpt['nama'] = 'Dollar';
                                                    // }
                                                    $option .= '<option value="'.$dOpt['nama'] .'">'.$dOpt['nama'].'</option>';
                                                }

?>
<?php
$script = <<< JS
    /*var valid = $('txt_nomor_surat').val();
    if(valid==''){
        alert('SP PENYISIHAN ')
    }   */

        
        
     $(".date-picker").kvDatepicker({
			format:'dd-mm-yyyy',
			autoclose: true
		});
		
	//$('.help-block').remove();
	
	
	var id=1;
	$('.tambah_memperhatikan').on('click', function() {
		$("#table_grid_surat > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check[]' class='hapusSuratCheck'></td><td><input type='text' class='form-control' name='txt_nama_surat[]' /></td><td><input type='text' name='txt_nomor_surat[]' style='width:80%' class='form-control' /></td><td><input type='text' placeholder='DD-MM-YYYY' style='width:22%' class='form-control date-picker' name='txt_tgl_surat[]'/></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
	
	$('.hapusSurat').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
	
	var kode_ip = $('#InstansiPenyidik').val();
	$.ajax({
		type: "POST",
		url: '/pidum/spdp/penyidik',
		data: 'kode_ip='+kode_ip,
		success:function(data){
			console.log(data);
			$('#pdmpenetapanbarbuk-id_inst_penyidik_pelaksana').html(data);
            $('#pdmpenetapanbarbuk-id_inst_penyidik_pelaksana option[value=$model->id_inst_penyidik_pelaksana]').attr('selected','selected');

		}
	});

    
	
	$('#InstansiPenyidik').change(function(){
            var kode_ip = $(this).val();
            $.ajax({
                type: "POST",
                url: '/pidum/spdp/penyidik',
                data: 'kode_ip='+kode_ip,
                success:function(data){
                    console.log(data);
                    $('#pdmpenetapanbarbuk-id_inst_penyidik_pelaksana').html(data);
                }
            });
        });


        $(document).ready(function(){
  
   

            $('.tambah_data_barbuk').on('click',function(){
                var no = $("#tbody_data_barbuk").find("tr").length + 1;
                var a =   '<tr>'+
                         '<td><input type="checkbox" name="new_check[]" class="hapusTembusanCheck" value=""></td>'+
                         '<td><input readonly="true" type="text" name="barbuk_pratut[nobarbuk][]" class="form-control" value="'+no+'"></td>'+
                         '<td><input type="text" name="barbuk_pratut[namabarbuk][]" class="form-control" value=""></td>'+
                         '<td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" name="barbuk_pratut[jumlahbarbuk][]" class="form-control" value=""></td>'+
                         '<td><select id="satuan" name="barbuk_pratut[satuanbarbuk][]" class="select2" style="width:100%;">'+
                                            '<option value=""></option>$option</select></td>'+


                         '<td><input type="text" name="barbuk_pratut[pemilikbarbuk][]" class="form-control" value=""></td>'+
                         /*'<td><input type="text" name="barbuk_pratut[penyimpananbarbuk][]" class="form-control" value=""></td>'+*/
                         '<td><button type="button" class="btn btn-primary btn-lg" data-toggle="modal"'+ 
                         'data-target="#myModal'+no+'">Detail</button></td>'+
                         '</tr> ';
             $('#tbody_data_barbuk').append(a);
             lol(no);
            
            });
            $('#table_grid_barbuk').on('click','.btn-lg',function(){
                var hasil = $(this).parent().parent().find('td:eq(2) input').val();
                $('h4.modal-title').text('Status Barbuk '+hasil);
            });
    function lol(no){
        //var no = $("#tbody_data_barbuk").find("tr").length + 1;   
         var m ='<div class="modal fade" id="myModal'+no+'" tabindex="1" role="dialog" aria-labelledby="myModalLabel">'+
                  '<div class="modal-dialog" role="document">'+
                    '<div class="modal-content">'+
                      '<div class="modal-header">'+                    
                        '<h4 class="modal-title" id="myModalLabel">Status Barbuk</h4>'+
                      '</div>'+
                      '<div class="modal-body">'+
                      '</div>'+
                        '<table id="table_grid_barbuk" class="table table-bordered table-striped">'+
                        '<thead>'+
                            '<tr>'+
                                '<th style="width:40%;">Penyisihan dan Pemusnahan Barang Bukti</th>'+
                                '<th align="center">Jumlah</th>'+
                                '<th align="center">Satuan</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '<tr>'+
                                '<td> Kepentingan Pembuktian Perkara </td>'+
                                '<td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_pembuktian][]"/></td>'+
                                '<td>'+
                                    '<select name="pdm_kepentingan_barbuk[satuan_pembuktian][]" class="select2" style="width:100%;" ">'+
                                            '<option value=""></option>$option</select>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td> Kepentingan Pengembangan Ilmu Pengetahuan </td>'+
                                '<td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_iptek][]"/>'+
                                '</td>'+
                                '<td>'+
                                    '<select name="pdm_kepentingan_barbuk[satuan_iptek][]" class="select2" '+
                                    'style="width:100%;" ">'+
                                            '<option value=""></option>$option</select>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td> Kepentingan Pendidikan dan Pelatihan </td>'+
                                '<td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_diklat][]"/></td>'+
                                '<td>'+
                                    '<select name="pdm_kepentingan_barbuk[satuan_diklat][]" class="select2" style="width:100%;" ">'+
                                            '<option value=""></option>$option</select>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td> Dimusnahkan </td>'+
                                '<td><input type="number"  pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" style="width:100%" name="pdm_kepentingan_barbuk[jumlah_dimusnahkan][]"/></td>'+
                                '<td>'+
                                    '<select name="pdm_kepentingan_barbuk[satuan_dimusnahkan][]" class="select2" style="width:100%;" ">'+
                                            '<option value=""></option>$option</select>'+
                                '</td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table>'+
                      '<div class="modal-footer">'+
                        '<button type="button" class="btn btn-default" data-dismiss="modal">Simpan</button>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';

                               
        $('form').append(m);
        }
    });
JS;
$this->registerJs($script);
?>

<script type="text/javascript">

        
</script>
<!-- 
$.ajax({
        type: "POST",
        url: '/pidum/pdm-penetapan-barbuk/satuan',
        data: 'kode_ip='+kode_ip,
        success:function(data){
           
        }
    }); -->