<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmMsUu;
use app\modules\pidum\models\PdmMsRentut;
use app\modules\pidum\models\VwPenandatangan;
use app\modules\pidum\models\PdmPidanaPengawasan;
use app\modules\pidum\models\PdmMsBarbukEksekusi;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\grid\GridView;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\modules\pidum\models\PdmP41Terdakwa;
use app\modules\pidum\models\PdmUuPasalTahap2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php

        //echo '<pre>';print_r($statp41);exit;
        $form = ActiveForm::begin(
                        [
                            'id' => 'p41-form',
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

        <?= $this->render('//pdm-p41/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=> '_p41']) ?>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="form-group">
                <label class="control-label col-sm-2">Tanggal Baca JPU</label>
                <div class="col-md-3">
                <?=
                    $form->field($model, 'tgl_baca')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'options' => [
                                'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                //'startDate' => $MinTgl,
                                //'endDate'   => $MaxTgl,
                                //'endDate' => date('d-m-Y'),
                            ]
                        ]
                    ]);
                ?>
                </div>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            
            <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                        <?php foreach ($statp41 as $keyx => $valuex) { ?>
                            <li <?php echo ($keyx ==0)?'class="active"':'';?>>
                            <a href="#tab-<?php echo $valuex->id;?>" data-toggle="tab"><?php echo $valuex->nama;?></a></li>
                       <?php }
                        ?>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                        <?php foreach ($statp41 as $keyx => $valuex) { ?>
                            <div <?php echo ($keyx ==0)?'class="tab-pane fade in active"':'class="tab-pane fade"';?> id="tab-<?php echo $valuex->id;?>">
                                <!-- lel <?php //echo $keyx ?> -->

                                <div class="panel with-nav-tabs panel-default">
                                    <div class="panel-heading single-project-nav">
                                            <ul class="nav nav-tabs">
                                            <?php foreach ($tersangka as $kunci => $nilai) { ?>
                                            <li <?php echo ($kunci ==0)?'class="active"':'';?>>
                                            <a href="#tab-tersangka<?php echo $nilai->no_urut_tersangka.'-'.$valuex->id;?>" data-toggle="tab"><?php echo $nilai->nama;?></a></li>
                                            <?php } ?>
                                            </ul>
                                        </div> 
                                <!-- Isi Nav -->
                                    <div class="panel-body">
                                        <div class="tab-content">

                                        <?php ?>
                                        <?php   foreach ($tersangka as $kunci => $nilai) { 
                                             // $js = ""; 
                                        if (!$model->isNewRecord) {
                                          $modelTerdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$model->no_register_perkara, 'no_surat_p41'=>$model->no_surat_p41, 'no_reg_tahanan'=>$nilai->no_reg_tahanan, 'status_rentut'=> $valuex->id]);
                                        }
                                          ?>
                                        <div <?php echo ($kunci ==0)?'class="tab-pane fade in active"':'class="tab-pane fade"';?> id="tab-tersangka<?php echo $nilai->no_urut_tersangka.'-'.$valuex->id;?>">
                                            <!-- lol <?php //echo $keyx.'-'.$nilai->no_reg_tahanan; ?> -->

                                            <!-- MULAI -->

                                            <div id="div-copy" class="form-group col-md-12">
                                               
                                                
                                                <?php if($valuex->id>1){ ?>
                                                <div class="col-md-2">
                                                    <a dari="<?= $valuex->id.'^'.$nilai->no_urut_tersangka ?>" class='btn btn-warning copy'>Copy Pendapat <? echo $valuex->id=='2' ? 'Jaksa' : 'Kasi' ?></a>
                                                </div>
                                                <?php } ?>
                                                    
                                                
                                            </div>


                                            <div id="isi_<?=$valuex->id.'_'.$nilai->no_urut_tersangka?>" class="col-md-12">
                                                <div class="col-md-12">

                                                    

                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2">Pasal Yang di Dakwaan</label>
                                                        <div class="col-md-6">
                                                            <table id="table_pasal" class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="35%" style="text-align: center;vertical-align: middle;">Undang-undang</th>
                                                                        <th width="35%" style="text-align: center;vertical-align: middle;">Pasal</th>
                                                                        <th width="30%" style="text-align: center;vertical-align: middle;">Pasal dakwaan yang dapat dibuktikan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbody_pasal">
                                                                    <?php
                                                                        
                                                                      $pasal = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register_perkara]);

                                                                        if (!$model->isNewRecord) {
                                                                            $dec = json_decode($modelTerdakwa->undang_undang);
                                                                            $arr = $dec->undang;
                                                                            $jum_undang= count($arr);
                                                                        }
                                                                        
                                                                        $ix = 0;
                                                                        foreach ($pasal as $listPasal):

                                                                            $check='';
                                                                        if (!$model->isNewRecord) {
                                                                            for ($i=0; $i < $jum_undang; $i++) { 
                                                                                if($listPasal['id_pasal'] == $arr[$i]){
                                                                                    $check=' checked "true" '.$listPasal['id_pasal'];
                                                                                }
                                                                            }
                                                                        }
                                                                            
                                                                            
                                                                        
                                                                  
                                                echo '<tr id="row-'.$listPasal['undang'].'-'.$listPasal['pasal'].'">';
                                                echo '<td style="text-align: center"><input type="text" style="width:100%" readonly="true"  value="'.$listPasal['undang'].'"></td>';
                                                echo '<td style="text-align: center"><input type="text" style="width:100%" readonly="true"  value="'.$listPasal['pasal'].'"></td>';
                                                echo '<td style="text-align: left; "><input type="checkbox" name="UuTahap2['.$valuex->id.']['.$nilai->no_urut_tersangka.'][pasal][]" "'.$check.'" value="'.$listPasal['id_pasal'].'" style="width:100%"></td>';
                                                                           echo '</tr>';
                                                                            $ix++;
                                                                        endforeach;//exit;
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Yang Memberatkan</label>

                                                        <div class="col-md-6">
                                                            <div class="box-header with-border">
                                                                <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                                    <h3 class="box-title">
                                                                        <a class='btn btn-danger delete hapus hapusBerat' param="<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>"></a>
                                                                        &nbsp;
                                                                        <a class="btn btn-primary tambah_memberatkan" param="<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>">+ Memberatkan</a>
                                                                    </h3>
                                                                </div>
                                                                <table id="table_grid_berat_<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <th style="width: 3%"></th>
                                                                        <th style="width: 10%"></th>
                                                                        <th style="width: 87%"></th>
                                                                    </thead>
                                                                    <tbody id="tbody_grid_berat_<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>">
                                                                        <?php if(!$model->isNewRecord){ ?>
                                                                            <?php $memberatkan = json_decode($modelTerdakwa->memberatkan); 
                                                                            //echo '<pre>';print_r($memberatkan->no_urut);exit; ?>
                                                                            <?php for($i=0; $i < count($memberatkan->no_urut);$i++){ $no=$i+1; ?>
                                                                        <tr id="<?=$no?>tr-<?= $valuex->id.$nilai->no_urut_tersangka?>">
                                                                            <td width="3%"><input type='checkbox' name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][memberatkan][new_check_berat]"  class='hapusBeratCheck'></td>
                                                                            <td width="10%"><input name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][memberatkan][no_urut][]" style="padding: 0px" value="<?= $memberatkan->no_urut[$i]?>" readonly="true" type="text" class="form-control"></td>
                                                                            <td width="87%"><textarea name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][memberatkan][isi][]"  type='textarea' class='form-control'><?= $memberatkan->isi[$i]?></textarea></td>
                                                                            </tr>
                                                                            <?php $no++; }?>
                                                                        <?php }else{ ?>
                                                                        <tr id="1tr-<?= $valuex->id.$nilai->no_urut_tersangka?>">
                                                                            <td width="3%"><input type='checkbox' name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][memberatkan][new_check_berat]"  class='hapusBeratCheck'></td>
                                                                            <td width="10%"><input name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][memberatkan][no_urut][]" style="padding: 0px" value="1" readonly="true" type="text" class='form-control'></td>
                                                                            <td width="87%"><textarea name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][memberatkan][isi][]"  type='textarea' class='form-control'></textarea></td>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Yang Meringankan</label>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="box-header with-border">
                                                                <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                                    <h3 class="box-title">
                                                                        <a class='btn btn-danger delete hapus hapusRingan' param="<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>"></a>
                                                                        &nbsp;
                                                                        <a class="btn btn-primary tambah_meringankan" param="<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>">+ Meringankan</a>
                                                                    </h3>
                                                                </div>
                                                                <table id="table_grid_ringan_<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <th style="width: 3%"></th>
                                                                        <th style="width: 10%"></th>
                                                                        <th style="width: 87%"></th>
                                                                    </thead>
                                                                    <tbody id="tbody_grid_ringan_<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>">
                                                                        <?php if(!$model->isNewRecord){ ?>
                                                                            <?php $meringankan = json_decode($modelTerdakwa->meringankan); ?>
                                                                            <?php for($i=0; $i < count($meringankan->no_urut);$i++){ $no=$i+1; ?>
                                                                        <tr id="<?=$no?>tr-<?= $valuex->id.$nilai->no_urut_tersangka?>">
                                                                            <td width="3%"><input type='checkbox' name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][meringankan][new_check_ringan]"  class='hapusRinganCheck'></td>
                                                                            <td width="10%"><input name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][meringankan][no_urut][]" style="padding: 0px" value="<?= $meringankan->no_urut[$i]?>" readonly="true" type="text" class="form-control"></td>
                                                                            <td width="87%"><textarea name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][meringankan][isi][]"  type='textarea' class='form-control'><?= $meringankan->isi[$i]?></textarea></td>
                                                                            </tr>
                                                                            <?php $no++; }?>
                                                                        <?php }else{ ?>
                                                                        <tr id="1tr-<?= $valuex->id.$nilai->no_urut_tersangka?>">
                                                                            <td width="3%"><input type='checkbox' name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][new_check_ringan]"  class='hapusRinganCheck'></td>
                                                                            <td width="10%"><input name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][meringankan][no_urut][]" style="padding: 0px" value="1" readonly="true" type="text" class="form-control"></td>
                                                                            <td width="87%"><textarea name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][meringankan][isi][]"  type='textarea' class='form-control'></textarea></td>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Tolak Ukur</label>
                                                        <div class="col-md-4">
                                                            <textarea class="form-control" name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_urut_tersangka ?>][tolak_ukur][]"><?= $modelTerdakwa->tolak_ukur ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Rencana Tuntutan</label>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <div class="col-md-12 input_rentut">
                                                                    <select class="form-control selectRentut"  id="input_rentut_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>" kode="<?= '_'.$valuex->id.'_'.$nilai->no_urut_tersangka ?>" name="PdmP41Terdakwa[<?= $valuex->id.']['.$nilai->no_urut_tersangka ?>][id_ms_rentut][]">
                                                                        <option value="">Pilih Rencana Tuntutan</option>
                                                                        <?php foreach (PdmMsRentut::find()->orderBy('id asc')->all() as $key => $value): ?>
                                                                            <option value="<?php echo $value->id ?>" <?php echo $value->id == $modelTerdakwa->id_ms_rentut ? "selected" : "" ; ?>>
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
                                                
                                                   <div  class="pidana_kurungan_denda" id="pidana_kurungan_denda_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>" >
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Kurungan</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'kurungan_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][kurungan_tahun][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'kurungan_bulan')->textInput(['type' => 'number','max'=>12, 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][kurungan_bulan][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'kurungan_hari')->textInput(['type' => 'number','max'=>255, 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][kurungan_hari][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Masa Percobaan</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'masa_percobaan_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][masa_percobaan_tahun][]' ]); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'masa_percobaan_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][masa_percobaan_bulan][]' ]); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'masa_percobaan_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][masa_percobaan_hari][]' ]); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Pidana Badan</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'pidana_badan_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][pidana_badan_tahun][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'pidana_badan_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][pidana_badan_bulan][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'pidana_badan_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][pidana_badan_hari][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div id="denda_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>" class="denda">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Denda</label>
                                                          <div class="col-md-5">
                                                              <div class="input-group">
                                                                  <div class="input-group-addon">Rp</div>
                                                                  <?= MaskedInput::widget([
                                                                          'name' => 'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][denda][]',
                                                                          'value' => $modelTerdakwa->denda,
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

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">SubSidair</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'subsidair_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][subsidair_tahun][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'subsidair_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][subsidair_bulan][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'subsidair_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][subsidair_hari][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>



                                                   <div class="biaya_perkara_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Biaya Perkara</label>
                                                          <div class="col-md-5">
                                                              <div class="input-group">
                                                                  <div class="input-group-addon">Rp</div>
                                                                  <?= MaskedInput::widget([
                                                                          'name' => 'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][biaya_perkara][]',
                                                                          'value' => $modelTerdakwa->biaya_perkara,
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

                                                   <div id="pidana_tambahan_<?= $valuex->id.'_'.$nilai->no_urut_tersangka ?>" class="pidana_tambahan">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Pidana Tambahan</label>
                                                          <div class="col-md-5">
                                                              <?= $form->field($modelTerdakwa, 'pidana_tambahan')->textArea(['rows' => 2, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_urut_tersangka.'][pidana_tambahan][]']); ?>
                                                          </div>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_urut_tersangka?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Pidana Pengawasan</label>
                                                          <div class="col-md-5">
                                                              <div class="form-group">
                                                                  <div class="col-md-12">
                                                                      <select class="form-control" id="input_pidanapengawasan" name="PdmP41Terdakwa[<?= $valuex->id.']['.$nilai->no_urut_tersangka ?>][id_ms_pidana_pengawasan][]">
                                                                          <option value="">Pilih Pengawasan</option>
                                                                          <?php foreach (PdmPidanaPengawasan::find()->all() as $keyyy => $valueyy): ?>
                                                                              <option value="<?php echo $valueyy->id ?>" <?php echo $valueyy->id == $modelTerdakwa->id_ms_pidana_pengawasan ? 'selected' : '' ; ?>>
                                                                                  <?php echo $valueyy->nama ?>
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

                                            
                                            <!-- USUL JAKSA -->
                                            
                                            <!-- END USUL JAKSA -->
                                          

                                            <!-- END PERULANGAN TERSANGKA-->
                                            </div>
                                        <?php
                                        $rentutUpdate = $modelTerdakwa->id_ms_rentut ;
                                        $kodeRentutUpdate = '_'.$valuex->id.'_'.$nilai->no_urut_tersangka;

                                           $jsresult  .= "$(document).ready(function(){
                                                                     var id = '$rentutUpdate';
                                                                     var kode = '$kodeRentutUpdate';

                                                                     //console.log(kode);
                                                                                $('#biaya_perkara'+kode).show();
                                                                                if (id == 4) { // pidana kurungan denda
                                                                                    $('.pidana_penjara'+kode).hide();
                                                                                    $('#pidana_tambahan'+kode).hide();
                                                                                    $('#pidana_kurungan_denda'+kode).show();
                                                                                    $('#denda'+kode).show();
                                                                                }else if (id == 3){
                                                                                    $('.pidana_penjara'+kode).show();
                                                                                    $('#pidana_tambahan'+kode).show();
                                                                                    $('#pidana_kurungan_denda'+kode).hide();
                                                                                    $('#denda'+kode).show();
                                                                                }else {
                                                                                    $('.pidana_penjara'+kode).hide();
                                                                                    $('#pidana_tambahan'+kode).hide();
                                                                                    $('#pidana_kurungan_denda'+kode).hide();
                                                                                    $('#denda'+kode).hide();
                                                                                    
                                                                                }
                                                            });";
                                         } ?>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                       // $this->registerJs($jsresult);

                        }  $this->registerJs($jsresult); ?>
                        </div>
                    </div>
            </div>
        </div>


        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <h3 class="box-title">
                    Akibat yang ditimbulkan
                </h3>
          <div class="col-md-12">
              <div class="form-group">
                  <label class="control-label col-md-2">Kerugian Negara</label>
                  <div class="col-md-4">
                      <div class="input-group">
                          <div class="input-group-addon">Rp</div>
                          <?= MaskedInput::widget([
                                  'name' => 'PdmP41[kerugian_negara]',
                                  'value' => $model->kerugian_negara,
                                  'mask' => '9',
                                  'clientOptions' => [
                                      'repeat' => 10, 
                                      'greedy' => false,
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

              <div class="form-group">
                  <label class="control-label col-md-2">Mati</label>
                  <div class="col-md-4">
                      <?= MaskedInput::widget([
                              'name' => 'PdmP41[mati]',
                              'value' => $model->mati,
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

              <div class="form-group">
                  <label class="control-label col-md-2">Luka</label>
                  <div class="col-md-4">
                      <?= MaskedInput::widget([
                              'name' => 'PdmP41[luka]',
                              'value' => $model->luka,
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
              
              <div class="form-group">
                  <label class="control-label col-md-2">Akibat Lain</label>
                  <div class="col-md-4">
                      <?= $form->field($model, 'akibat_lain')->textArea(['rows' => 2]); ?>
                  </div>
                  <div class="col-sm-12"></div>
                  <div class="col-sm-12">
                      <div class="help-block"></div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-2">Usul Kejari</label>
                  <div class="col-md-4">
                      <?= $form->field($model, 'usul')->textArea(['rows' => 2]); ?>
                  </div>
                  <div class="col-sm-12"></div>
                  <div class="col-sm-12">
                      <div class="help-block"></div>
                  </div>
              </div>

          </div>
        </div>


        



        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <h3 class="box-title">
                    Barang Bukti
                </h3>
            <div class="col-md-12">
                <div class="form-group">
                        <table id="table_barbuk" class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="4%"
                                    style="text-align: center;">No</th>
                                <th width="15%" style="text-align: center;vertical-align: middle;">Nama</th>
                                <th width="8%" style="text-align: center;vertical-align: middle;">Jumlah [decimal]</th>
                                <th width="8%" style="text-align: center;vertical-align: middle;">Satuan</th>
                                <th width="10%" style="text-align: center;vertical-align: middle;">Disita dari</th>
                                <th width="10%" style="text-align: center;vertical-align: middle;">Tempat Simpan</th>
                                <th width="10%" style="text-align: center;vertical-align: middle;">Kondisi</th>
                                <th width="35%" style="text-align: center;vertical-align: middle;">Putusan</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_barbuk">

                            <?php
                           
                                foreach ($modelBarbuk as $barbuk){
                            ?>
                                <tr >
                                    <td style="text-align: center">
                                        <input type="text" class="form-control" name="pdmBarbukNo[]" readonly="true" value="<?= $barbuk['no_urut_bb'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="<?= $barbuk['nama'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="<?= $barbuk['jumlah'] ?>">
                                    </td>
                                    <td>
                                        <input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="<?= $barbuk['id_satuan'] ?>">
                                        <input type="text" class="form-control" name="txtBarbukSatuan[]" readonly="true" value="<?= \app\modules\pidum\models\PdmMsSatuan::findOne($barbuk['id_satuan'])->nama ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="<?= $barbuk['sita_dari'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="<?= $barbuk['tindakan'] ?>">
                                    </td>
                                    <td>
                                        <input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="<?= $barbuk['id_stat_kondisi'] ?>">
                                        <input type="text" class="form-control" name="txtBarbukKondisi[]" readonly="true" value="<?= \app\modules\pidum\models\PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => \app\components\ConstDataComponent::KondisiBarang])->nama ?>">
                                    </td>
                                    <td>
                                        <div class="col-md-12">
                                            <select class="form-control selectBarbukEksekusi" id="selectBarbukEksekusi_<?= $barbuk['no_urut_bb']?>" kode="<?= $barbuk['no_urut_bb']?>" name="PdmMsBarbukEksekusi[]">
                                                <option value="">Pilih</option>
                                                    <?php foreach (PdmMsBarbukEksekusi::find()->all() as $key => $value): ?>
                                                <option value="<?php echo $value->id ?>" <?php echo $value->id == $barbuk['id_ms_barbuk_eksekusi'] ? 'selected' : '' ; ?>>
                                                    <?php echo $value->nama ?>
                                                    
                                                </option>
                                                    <?php 


                                                    endforeach; ?>
                                            </select>
                                            <div class="div_pindah" id="div_pindah_<?= $barbuk['no_urut_bb']?>">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input  id="row_<?= $barbuk['no_urut_bb']?>" type="text" class="form-control" name="pdmBarbukPindah[]" readonly="true" value="<?= $barbuk['pindah'] ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <a data-toggle="modal" data-target="#_berkas"  class="btn btn-primary cari_berkas">Pilih Berkas</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            $id_ms_bb = $value->id;
                            $no_urut  = $barbuk['no_urut_bb'];

                               $jsnew  .= "$(document).ready(function(){
                                                         var no_bb = '$no_urut';
                                                         var id_ms_bb = $('#selectBarbukEksekusi_'+no_bb).val();
                                                         
                                                         //console.log(id_ms_bb);
                                                         //console.log(no_bb);
                                                            if (id_ms_bb == 4) { // Digunakan dalam Perkara Lain 
                                                                $('#div_pindah_'+no_bb).show();
                                                            }else{
                                                                $('#div_pindah_'+no_bb).hide();
                                                            }
                                                });";

                                }//end foreach
                            
                            $this->registerJs($jsnew);
                            ?>

                            </tbody>
                        </table>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Upload File</label>
                            <div class="col-md-6">
                                <?php
                                $preview = "";
                                if($model->file_upload!=""){
                                    /*$preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                                 ];*/
                                    echo '<object width="160px" id="print" height="160px" data="'.$model->file_upload.'"></object>';
                                }
                                echo FileInput::widget([
                                    'name' => 'attachment_3',
                                    'id'   =>  'filePicker',
                                    'pluginOptions' => [
                                        'showPreview' => true,
                                        'showCaption' => true,
                                        'showRemove' => true,
                                        'showUpload' => false,
                                        'initialPreview' =>  $preview
                                    ],
                                ]);
                                ?>
                                
                                
                                <?= $form->field($model, 'file_upload')->hiddenInput()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!--  <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Usul / Pendapat Kajari</label>
                        <div class="col-md-7">
                            <?php /*$form->field($model, 'usul_kajari')->textArea(['rows'=>3]);*/ ?>                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Usul / Pendapat Kajati</label>
                        <div class="col-md-7">
                            <?php /*$form->field($model, 'usul_kajati')->textArea(['rows'=>3]);*/ ?>                           
                        </div>
                    </div>
                </div>
            </div>
          
        </div> -->

         <?php //echo $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P41, 'id_table' => $model->no_surat_p41]) ?>
        

        <div class="panel box box-warning">
                <div class="box-body">
                    <div class="col-md-7 pull-right">

                        <label class="control-label col-md-2" style="padding-right:0;margin-left:7%">Penanda Tangan</label>
                        <div class="col-md-9 pull-right">
                            


                <?php $penandatangan=(new \yii\db\Query())
                    ->select('peg_nik,peg_nip_baru,nama')
                    ->from('pidum.vw_penandatangan')
                    ->where(['is_active' =>'1'])
                    ->all();

                $list = ArrayHelper::map($penandatangan,'peg_nip_baru','nama');
                echo $form->field($model, 'id_penandatangan')->dropDownList($list,
                    ['prompt' => '---Pilih---'],
                    ['label'=>'']);
                ?>
                


                        </div>
                    </div>
                </div>
                <div class="box-body">   
                
                    <div class="col-md-8 pull-left">   
                        <?= Yii::$app->globalfunc->getTembusan($form,'P-41',$this,$model->no_surat_p41, '') ?>
                    </div>
                </div>
            
        </div>


        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => 'btn btn-warning']) ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-p41/cetak?id=' . $model->no_surat_p41]) ?>">Cetak Draft</a>
            <?php  if(!$model->isNewRecord): ?>
                <!-- <a class="btn btn-warning" href="<?= Url::to(['pdm-p41/cetak?id=' . $model->no_surat_p41]) ?>">Cetak</a> -->
                <a class="btn btn-warning" id="ctx">Cetak</a>
            <?php endif ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>



<?php
Modal::begin([
    'id' => '_berkas',
    'header' => 'Data Berkas',
    'options' => [
        'data-url' => '',
    ],
]);
/*echo '<pre>';print_r($dataProvidert);exit;*/
?> 



<div class="modalContent">

<?php 

echo GridView::widget([
        'dataProvider' => $dataProviderBerkas,
        'filterModel' => $searchmodelBerkas,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_register_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'no_register_perkara',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    //return $model['nomor'].'<br>  Tanggal '.$model['tgl'];
                    return $model['no_register_perkara'];
                },
            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => $model['no_register_perkara'], "class" => "btn btn-warning pilihBerkas"]);
                    }
                        ],
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ]
    ]); ?>
    
</div>

<?php
Modal::end();
?>
<script>


</script>


<?php
$script = <<< JS
        $('#ctx').on('click', function(){
            var file = '$model->file_upload';
            if(file==''){
                alert('Belum Upload File!');
                return false;
            }
            download(file, 'P-41.pdf', 'text/pdf');
        });



        //$('.div_pindah').hide();
        $('body').on('click', '.tambah_memberatkan', function() {
            var ckode = $(this).attr('param');
            console.log(ckode);
            var len = $('#table_grid_berat_'+ckode+' tr').length;
            //var urut = len+1;
            var jaksa = ckode.split('_')[0];
            var tersangka = ckode.split('_')[1];
            console.log(jaksa);
            console.log(tersangka);
            var row =   '<tr id='+len+'tr-'+ckode+'>'+
                            '<td width="3%"><input type="checkbox" name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][memberatkan][new_check_berat]"  class="hapusSuratCheck1"></td>'+
                            '<td width="10%"><input name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][memberatkan][no_urut][]" style="padding: 0px" readonly="true" type="text" class="form-control" value='+len+'></td>'+
                            '<td width="87%"><textarea name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][memberatkan][isi][]"  type="textarea" class="form-control"></textarea></td>'+
                        '</tr>';
            $('#tbody_grid_berat_'+ckode).append(row);
        });

        $('body').on('click', '.hapusBerat' , function(){
                var ckode = $(this).attr('param');
                var jaksa = ckode.split('_')[0];
                var tersangka = ckode.split('_')[1];
                //console.log(ckode);
                 $.each($('input[type="checkbox"][name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][memberatkan][new_check_berat]"]'),function(x)
                    {
                        var input = $(this);
                        if(input.prop('checked')==true)
                        {   var id = input.parent().parent();
                            console.log(id);
                            id.remove();
                        }
                    }
                 )
            });


        $('body').on('click', '.tambah_meringankan', function() {
                    var ckode = $(this).attr('param');
                    var len = $('#table_grid_ringan_'+ckode+' tr').length;
                    var jaksa = ckode.split('_')[0];
                    var tersangka = ckode.split('_')[1];
                    var row =   '<tr id='+len+'tr-'+ckode+'>'+
                                    '<td width="3%"><input type="checkbox" name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][meringankan][new_check_ringan]"  class="hapusSuratCheck1"></td>'+
                                    '<td width="10%"><input name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][meringankan][no_urut][]" style="padding: 0px" readonly="true" type="text" class="form-control" value='+len+'></td>'+
                                    '<td width="87%"><textarea name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][meringankan][isi][]"  type="textarea" class="form-control"></textarea></td>'+
                                '</tr>';
                    $('#tbody_grid_ringan_'+ckode).append(row);
                });

        $('body').on('click', '.hapusRingan' , function(){
                    var ckode = $(this).attr('param');
                    var jaksa = ckode.split('_')[0];
                    var tersangka = ckode.split('_')[1];
                   
                    $.each($('input[type="checkbox"][name="PdmP41Terdakwa['+jaksa+']['+tersangka+'][meringankan][new_check_ringan]"]'),function(x){
                            var input = $(this);
                            if(input.prop('checked')==true){   
                                var id = input.parent().parent();
                                //console.log(id);
                                id.remove();
                            }
                        })
                    });


        $("body").on("change", '.selectRentut', function() {
            var kode = $(this).attr('kode');
            var id = $(this).val();
            /*console.log(kode);
            console.log(id);*/
                    if(kode!==''){
                        $('#biaya_perkara'+kode).show();
                    }else{
                        $('#biaya_perkara'+kode).hide();
                    }
                    if (id == 4) { // pidana kurungan denda
                        $('.pidana_penjara'+kode).hide();
                        $('#pidana_tambahan'+kode).hide();
                        $('#pidana_kurungan_denda'+kode).show();
                        $('#denda'+kode).show();
                    }else if (id == 3){
                        $('.pidana_penjara'+kode).show();
                        $('#pidana_tambahan'+kode).show();
                        $('#pidana_kurungan_denda'+kode).hide();
                        $('#denda'+kode).show();
                    }else {
                        $('.pidana_penjara'+kode).hide();
                        $('#pidana_tambahan'+kode).hide();
                        $('#pidana_kurungan_denda'+kode).hide();
                        $('#denda'+kode).hide();
                    }
        });

        $(".selectBarbukEksekusi").on("change", function() {
           var kodex = $(this).attr('kode');
            var idx = $(this).val();
            /*console.log(kodex);
            console.log(idx);*/
            if(idx==4){
                $('#div_pindah_'+kodex).show();
            }else{
                $('#div_pindah_'+kodex).hide();
            }
        });

        $(".cari_berkas").on("click", function() {
            var parent = $(this).parent().parent();
            var id = parent.find('input').attr('id');
            //console.log(parent);
            localStorage.idrow = id;
           
        });

        function pilihBerkas($id){
            $('#'+coba+' pdmBarbukPindah').val(id);
        }

        $('.pilihBerkas').on('click',function(){
            var coba = $(this).closest('tr').attr('data-id');
            //console.log(localStorage.idrow);
            $('#'+localStorage.idrow).val(coba);
            $('#_berkas').modal('hide');
        });

        $('.copy').on('click',function(){
            var kodey = $(this).attr('dari').split('^');
            var kode = kodey[0]-1;

            var newId = kodey[0]+'_'+kodey[1];
            var oldId = kode+'_'+kodey[1];

            // console.log(newId);

            
            var xxx = $('#isi_'+oldId).clone();

            //console.log(newName);

            $('body #isi_'+newId).html('');
            $('body #isi_'+newId).append(xxx);

            var xxx = $('body #isi_'+newId).find('input, select, textarea, table, tbody, a, div, checkbox').each(function(index) {
            //var xxx = $('body #isi_'+newId).find('select').each(function(index) {
                var tipe            = $(this).attr('type');
                var fieldNameOld    = $(this).attr('name');
                var fieldIdOld      = $(this).attr('id');
                var fieldParamOld   = $(this).attr('param');
                var fieldClassOld   = $(this).attr('class');
                var fieldKodeOld    = $(this).attr('kode');

                //console.log(fieldIdOld);

                if(tipe !== undefined && tipe =='checkbox'){
                    var newName = 'UuTahap2['+kodey[0]+']['+kodey[1]+']';
                    var oldName = 'UuTahap2['+kode+']['+kodey[1]+']';
                }else{
                    var newName = 'PdmP41Terdakwa['+kodey[0]+']['+kodey[1]+']';
                    var oldName = 'PdmP41Terdakwa['+kode+']['+kodey[1]+']';
                }

                
                //ID
                if(fieldClassOld !== undefined){
                    var fieldClassNew   = fieldClassOld.replace(oldId, newId);
                    $(this).attr('class',  fieldClassNew);
                }

                if(fieldNameOld !== undefined ){
                    var fieldNameNew      = fieldNameOld.replace(oldName, newName);
                    $(this).attr('name', fieldNameNew);
                }

                if(fieldIdOld !== undefined ){
                    var fieldIdNew      = fieldIdOld.replace(oldId, newId);
                    //console.log(fieldIdOld+' BARUUU '+fieldIdNew);    
                    $(this).attr('id', fieldIdNew);
                }

                if(fieldParamOld !== undefined){
                    var fieldParamNew   = fieldParamOld.replace(oldId, newId);
                    $(this).attr('param',  fieldParamNew);
                }

                if(fieldKodeOld !== undefined){
                    var fieldKodeNew   = fieldKodeOld.replace(oldId, newId);
                    $(this).attr('kode',  fieldKodeNew);
                }

                if(fieldIdOld =='input_rentut_'+oldId){
                    console.log(oldId);
                    ceked = $('#input_rentut_'+oldId).val();
                    console.log(ceked);
                    $('#input_rentut_'+newId).val(ceked);
                }
            
            });

            var xxx='';
        });


        var handleFileSelect = function(evt) {
             var files = evt.target.files;
             var file = files[0];

             if (files && file) {
                 var reader = new FileReader();
                 // console.log(file);
                 reader.onload = function(readerEvt) {
                     var binaryString = readerEvt.target.result;
                     var mime = 'data:'+file.type+';base64,';
                     console.log(mime);
                     document.getElementById('pdmp41-file_upload').value = mime+btoa(binaryString);
                     // window.open(mime+btoa(binaryString));
                 };
                 reader.readAsBinaryString(file);
             }
         };

         if (window.File && window.FileReader && window.FileList && window.Blob) {
             document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
         } else {
             alert('The File APIs are not fully supported in this browser.');
         }


JS;


$this->registerJs($script);
?>