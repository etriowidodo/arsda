<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmMsUu;
use app\modules\pdsold\models\PdmMsRentut;
use app\modules\pdsold\models\VwPenandatangan;
use app\modules\pdsold\models\PdmPidanaPengawasan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\modules\pdsold\models\PdmP41Terdakwa;
use app\modules\pdsold\models\PdmUuPasalTahap2;

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

        <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=> '_p41']) ?>
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
                                lel <?php echo $keyx ?>

                                <div class="panel with-nav-tabs panel-default">
                                    <div class="panel-heading single-project-nav">
                                            <ul class="nav nav-tabs">
                                            <?php foreach ($tersangka as $kunci => $nilai) { ?>
                                            <li <?php echo ($kunci ==0)?'class="active"':'';?>>
                                            <a href="#tab-<?php echo $nilai->no_reg_tahanan.$valuex->id;?>" data-toggle="tab"><?php echo $nilai->nama;?></a></li>
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
                                            <div <?php echo ($kunci ==0)?'class="tab-pane fade in active"':'class="tab-pane fade"';?> id="tab-<?php echo $nilai->no_reg_tahanan.$valuex->id;?>">
                                            lol <?php echo $keyx.'-'.$nilai->no_reg_tahanan; ?>

                                            <!-- MULAI -->

                                            
                                            <div class="col-md-12">
                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Tanggal Baca JPU</label>
                                                        <div class="col-md-3">
                                                            <?php 
                                                                echo DateControl::widget([
                                                                    'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][tgl_baca_rentut][]', 
                                                                    'value'=>$modelTerdakwa->tgl_baca_rentut,
                                                                    'type'=> DateControl::FORMAT_DATE,
                                                                    'ajaxConversion' => false,
                                                                    'options' => [
                                                                        'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        ]
                                                                    ]
                                                                ]);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2">Pasal Dibuktikan</label>
                                                        <div class="col-md-6">
                                                            <table id="table_pasal" class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="35%" style="text-align: center;vertical-align: middle;">Undang-undang</th>
                                                                        <th width="35%" style="text-align: center;vertical-align: middle;">Pasal</th>
                                                                        <th width="4%" style="text-align: center;vertical-align: middle;">Dibuktikan</th>
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
                                                echo '<td style="text-align: left; "><input type="checkbox" name="UuTahap2['.$valuex->id.']['.$nilai->no_reg_tahanan.'][pasal][]" "'.$check.'" value="'.$listPasal['id_pasal'].'" style="width:100%"></td>';
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
                                                        <div class="col-md-4">
                                                            <textarea class="form-control" name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_reg_tahanan ?>][memberatkan][]" ><?= $modelTerdakwa->memberatkan ?></textarea>
                                                        </div>
                                                    </div>
                                
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Yang Meringankan</label>
                                                        <div class="col-md-4">
                                                            <textarea class="form-control" name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_reg_tahanan ?>][meringankan][]"> <?= $modelTerdakwa->meringankan ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Tolak Ukur</label>
                                                        <div class="col-md-4">
                                                            <textarea class="form-control" name="PdmP41Terdakwa[<?= $valuex->id ?>][<?= $nilai->no_reg_tahanan ?>][tolak_ukur][]"><?= $modelTerdakwa->tolak_ukur ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Rencana Tuntutan</label>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <div class="col-md-12 input_rentut">
                                                                    <select class="form-control selectRentut"  id="input_rentut_<?= $valuex->id.'_'.$nilai->no_reg_tahanan ?>" kode="<?= '_'.$valuex->id.'_'.$nilai->no_reg_tahanan ?>" name="PdmP41Terdakwa[<?= $valuex->id.']['.$nilai->no_reg_tahanan ?>][id_ms_rentut][]">
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
                                                
                                                   <div  class="pidana_kurungan_denda" id="pidana_kurungan_denda_<?= $valuex->id.'_'.$nilai->no_reg_tahanan ?>" >
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Kurungan</label>
                                                          <div class="col-md-2" style="width:17%">
                                                              <?= $form->field($modelTerdakwa, 'kurungan_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][kurungan_bulan][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-20px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:17%;">
                                                              <?= $form->field($modelTerdakwa, 'kurungan_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][kurungan_hari][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-20px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_reg_tahanan?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Masa Percobaan</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'masa_percobaan_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][masa_percobaan_tahun][]' ]); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'masa_percobaan_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][masa_percobaan_bulan][]' ]); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'masa_percobaan_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][masa_percobaan_hari][]' ]); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_reg_tahanan?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Pidana Badan</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'pidana_badan_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][pidana_badan_tahun][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'pidana_badan_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][pidana_badan_bulan][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'pidana_badan_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][pidana_badan_hari][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div id="denda_<?= $valuex->id.'_'.$nilai->no_reg_tahanan ?>" class="denda">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Denda</label>
                                                          <div class="col-md-5">
                                                              <div class="input-group">
                                                                  <div class="input-group-addon">Rp</div>
                                                                  <?= MaskedInput::widget([
                                                                          'name' => 'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][denda][]',
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

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_reg_tahanan?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">SubSidair</label>
                                                          <div class="col-md-2" style="width:11%">
                                                              <?= $form->field($modelTerdakwa, 'subsidair_tahun')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][subsidair_tahun][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Tahun</label>
                                                          <div class="col-md-2" style="width:10%;margin-left:-30px;">
                                                              <?= $form->field($modelTerdakwa, 'subsidair_bulan')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][subsidair_bulan][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Bulan</label>
                                                          <div class="col-md-2" style="margin-left:-30px;width:11%;">
                                                              <?= $form->field($modelTerdakwa, 'subsidair_hari')->textInput(['type' => 'number', 'min' => 0, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][subsidair_hari][]']); ?>
                                                          </div>
                                                          <label class="control-label col-md-1" style="margin-left:-24px;">Hari</label>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_reg_tahanan?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Biaya Perkara</label>
                                                          <div class="col-md-5">
                                                              <div class="input-group">
                                                                  <div class="input-group-addon">Rp</div>
                                                                  <?= MaskedInput::widget([
                                                                          'name' => 'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][biaya_perkara][]',
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

                                                   <div id="pidana_tambahan_<?= $valuex->id.'_'.$nilai->no_reg_tahanan ?>" class="pidana_tambahan">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Pidana Tambahan</label>
                                                          <div class="col-md-5">
                                                              <?= $form->field($modelTerdakwa, 'pidana_tambahan')->textArea(['rows' => 2, 'name'=>'PdmP41Terdakwa['.$valuex->id.']['.$nilai->no_reg_tahanan.'][pidana_tambahan][]']); ?>
                                                          </div>
                                                      </div>
                                                   </div>

                                                   <div class="pidana_penjara_<?= $valuex->id.'_'.$nilai->no_reg_tahanan?>">
                                                      <div class="form-group">
                                                          <label class="control-label col-md-2">Pidana Pengawasan</label>
                                                          <div class="col-md-5">
                                                              <div class="form-group">
                                                                  <div class="col-md-12">
                                                                      <select class="form-control" id="input_pidanapengawasan" name="PdmP41Terdakwa[<?= $valuex->id.']['.$nilai->no_reg_tahanan ?>][id_ms_pidana_pengawasan][]">
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
                                            
                                            
                                            <!-- USUL JAKSA -->
                                            
                                            <!-- END USUL JAKSA -->
                                          

                                            <!-- END PERULANGAN TERSANGKA-->
                                            </div>
                                        <?php
                                        $rentutUpdate = $modelTerdakwa->id_ms_rentut ;
                                        $kodeRentutUpdate = '_'.$valuex->id.'_'.$nilai->no_reg_tahanan;

                                           $jsresult  .= "$(document).ready(function(){
                                                                     var id = '$rentutUpdate';
                                                                     var kode = '$kodeRentutUpdate';

                                                                     console.log(kode);
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
                      <?= MaskedInput::widget([
                              'name' => 'PdmP41[akibat_lain]',
                              'value' => $model->akibat_lain,
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

         <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P41, 'id_table' => $model->no_surat_p41]) ?>
        
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => 'btn btn-warning']) ?>
            <?php  if(!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-p41/cetak?id=' . $model->no_surat_p41]) ?>">Cetak</a>
            <?php endif ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>

<?php
$script = <<< JS
       

        $(".selectRentut").on("change", function() {
            var kode = $(this).attr('kode');
            var id = $(this).val();
            console.log(kode);
            console.log(id);
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
                    }else if (id==6){
                        $('.pidana_penjara'+kode).hide();
                        $('#pidana_tambahan'+kode).hide();
                        $('#pidana_kurungan_denda'+kode).hide();
                        $('#denda'+kode).show();
                    }else {
                        $('.pidana_penjara'+kode).hide();
                        $('#pidana_tambahan'+kode).hide();
                        $('#pidana_kurungan_denda'+kode).hide();
                        $('#denda'+kode).hide();
                    }
        });

       


JS;
$this->registerJs($script);
?>