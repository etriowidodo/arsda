<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\Pdmtahapdua;
use yii\helpers\ArrayHelper;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmBa4;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\web\View;
use kartik\builder\Form;
use kartik\grid\GridView;
use yii\web\Session;
use app\modules\pidum\models\MsJenisPidana;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use app\models\MsWarganegara;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTahapDua */
/* @var $form yii\widgets\ActiveForm */
$actual_linkx = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_linkx = explode('/', $actual_linkx);
$actual_linkxx = explode('?', $actual_linkx[5]);

?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <div class="box box-primary" style="border-color: #f39c12;padding-bottom: 20px;overflow: hidden;">
        <div class="box-header"></div>

<?php if($actual_linkxx[0]!=='update'){ ?>
    <div id="divTambah" class="col-md-10">
         <a data-toggle="modal" data-target="#_berkas" class="btn btn-primary cari_spdp">Tambah</a>
 </div>
<?php } ?>
<?php
        

$form = ActiveForm::begin(
    [
        'id' => 'tahap-dua-form',
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
<div id="pengantar">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Asal Surat</label>
                        <div class="col-md-4">
                            <input class="form-control" value="<?= $modelSpdp->idAsalsurat->nama ?>" readOnly="true">
                        </div>
                        <label type="text" class="control-label col-md-2">Penyidik</label>
                        <div class="col-md-4">
                            <input class="form-control" value="<?= MsInstPelakPenyidikan::findOne(['kode_ip'=>$modelSpdp->id_asalsurat,'kode_ipp'=>$modelSpdp->id_penyidik])->nama ?>" readOnly="true">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group"></div>
        </div>


        

            
        <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-2">No. Pengiriman Berkas</label>
                <div class="col-md-4">
                 <?= $form->field($model, 'no_pengiriman')->textInput(['maxlength' => true]) ?>
                    </div>
                 <label class="control-label col-md-2">Tanggal</label>
                <div class="col-md-3">
                    <?= $form->field($model, 'tgl_pengiriman')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ],
                        'options' => [
                            'placeholder' => 'Tanggal Pengiriman'
                        ]
                    ]
                ]); ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
                <div class="form-group">
                <label class="control-label col-md-2">Diterima Diwilayah Kerja</label>
                        <div class="col-md-4">
                            <input class="form-control" value="<?= $modelSpdp->idAsalsurat->nama ?>" readOnly="true">
                        </div>

                <label class="control-label col-md-2">Tanggal Terima</label>
                <?php /*
                <label class="control-label col-md-2">Wilayah Kerja</label>
                <div class="col-md-3">
                    <input type="text" readonly="true" class="form-control" id="satker_nama" value="<?php echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                    <input type="hidden" id="satker_tujuan" name="id_satker_tujuan" value="<?= !empty($modelSpdp->id_satker_tujuan) ? $modelSpdp->id_satker_tujuan : '' ; ?>">
                </div>
                <div class="col-md-1" style="margin-left:-29px;">
                    <button id="cari_satker" class="btn btn-warning" type="button" data-satkerkode="<?php echo \Yii::$app->globalfunc->getSatker()->inst_satkerkd ?>">Cari</button>
                </div>
                */ ?>

                <div class="col-md-3">
                        <?= $form->field($model, 'tgl_terima')->widget(DateControl::className(),[
                        'type'=>DateControl::FORMAT_DATE,
                        'ajaxConversion'=>false,
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true
                            ],
                            'options' => [
                                'placeholder' => 'Tanggal Terima'
                            ]
                        ]
                    ]); ?> 
                </div>
            </div>
        </div>

        <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-2">Uraian Singkat Perkara</label>
                <div class="col-md-8">

               <?= $form->field($model, 'kasus_posisi')->textArea(['rows' => 3, 'value' => $model->isNewRecord ? $modelSpdp->ket_kasus : $model->kasus_posisi ]) ?>
                </div>
            </div>
        </div>
    <?php
        if(!$model->isNewRecord){
            $ba4 = PdmBa4::findOne(['no_register_perkara'=>$model->no_register_perkara])->no_register_perkara;
            if($ba4==NULL){
                $hide = 'hide';
                $val  = $model->no_register_perkara; 
            }else{
                $hide = '';
                $val  = '';
                if(substr($model->no_register_perkara,(strlen($model->no_register_perkara)-1),1)!=='^'){
                    $val = $model->no_register_perkara;
                }
            }
        }else{
            $hide = 'hide';
            $val = uniqid().'^';
        }
    ?>
    <div class="box box-primary <?= $hide ?>" style="border-color: #f39c12;padding-bottom: 20px;overflow: hidden;">
        <div class="box-header with-no-border"></div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2"><strong>Nomor Register Perkara</strong></label>
                        <div class="col-md-4">
                        <?= $form->field($model, 'no_register_perkara')->textInput(['maxlength' => "30", 'value' => $val ]); 
                        ?>    
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-group"></div>
        </div>
    </div>
        
        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-10">
                    <div class="form-group">
                        <a class="btn btn-danger delete hapus" id="hapus_saksi"></a>
                        <a class="btn btn-primary add_saksi" param="saksi" id="add_saksi">
                            <i class="glyphicon glyphicon-plus"></i>Saksi 
                        </a>
                    </div>
                </div>
            </div>

                <div class="box-header with-border">
                    <table id="table_saksi" class="table table-bordered">
                        <tbody id="tbody_saksi">
                            <div id="divHapus">
                            </div>
                            <?php
                            //echo '<pre>';print_r($modelSaksi);exit;
                            if ($modelSaksi != null) {
                                $i =0;
                                foreach ($modelSaksi as $key => $value) { $wnx = MsWarganegara::findOne($value->warganegara)->nama; ?>
                                    <tr id="tr_id<?=$value['id_saksi']?>">
                                        <td width="20px"><input type="checkbox" name="saksi[]" class="hapussaksi" value="<?=$value['id_saksi']?>"></td>
                                        <td><a href="javascript:void(0);" onclick="edit_saksi('<?=$value['id_saksi'];?>','saksi')"><?=$value['no_urut']?>. <?=$value['nama']?> </a>
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][id_saksi][]" value="<?=$value['id_saksi']?>" class="form-control">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][nama][]" value="<?=$value->nama?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][tmpt_lahir][]" value="<?=$value['tmpt_lahir']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][tgl_lahir][]" value="<?= date("Y-m-d", strtotime($value['tgl_lahir']))?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][umur][]" value="<?=$value['umur']?>" class="form-control saksi<?=$value['id_saksi']?>">                  
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][id_jkl][]" value="<?=$value['id_jkl']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][alamat][]" value="<?=$value['alamat']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][id_identitas][]" value="<?=$value['id_identitas']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][no_identitas][]" value="<?=$value['no_identitas']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][no_hp][]" value="<?=$value['no_hp']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][id_agama][]" value="<?=$value['id_agama']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][warganegara][]" attr-id="<?=$wnx?>" value="<?=$value['warganegara']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][pekerjaan][]" value="<?=$value['pekerjaan']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][suku][]" value="<?=$value['suku']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][id_pendidikan][]" value="<?=$value['id_pendidikan']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][unix][]" value="" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[saksi][<?=$value['id_saksi']?>][no_urut][]" value="<?=$value['no_urut']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            </td>
                                        </td>
                                    </tr>
                                    
                            <?php   }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
        </div>
        
        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-10">
                    <div class="form-group">
                        <a class="btn btn-danger delete hapus" id="hapus_ahli"></a>
                        <a class="btn btn-primary add_saksi" param="ahli" id="add_ahli">
                            <i class="glyphicon glyphicon-plus"></i>Ahli 
                        </a>
                    </div>
                </div>
            </div>


            <div class="box-header with-border">
                <table id="table_ahli" class="table table-bordered">
                    <tbody id="tbody_ahli">
                        <div id="divHapus">
                        </div>
                        <?php
                            //echo '<pre>';print_r($modelSaksi);exit;
                            if ($modelAhli != null) {
                                $i =0;
                                foreach ($modelAhli as $key => $value) { $wnx = MsWarganegara::findOne($value->warganegara)->nama; ?>
                                    <tr id="tr_id<?=$value['id_saksi']?>">
                                        <td width="20px"><input type="checkbox" name="saksi[]" class="hapussaksi" value="<?=$value['id_saksi']?>"></td>
                                        <td><a href="javascript:void(0);" onclick="edit_saksi('<?=$value['id_saksi'];?>','ahli')"><?=$value['no_urut']?>. <?=$value['nama']?> </a>
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][id_saksi][]" value="<?=$value['id_saksi']?>" class="form-control">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][nama][]" value="<?=$value->nama?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][tmpt_lahir][]" value="<?=$value['tmpt_lahir']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][tgl_lahir][]" value="<?= date("Y-m-d", strtotime($value['tgl_lahir']))?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][umur][]" value="<?=$value['umur']?>" class="form-control saksi<?=$value['id_saksi']?>">                  
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][id_jkl][]" value="<?=$value['id_jkl']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][alamat][]" value="<?=$value['alamat']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][id_identitas][]" value="<?=$value['id_identitas']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][no_identitas][]" value="<?=$value['no_identitas']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][no_hp][]" value="<?=$value['no_hp']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][id_agama][]" value="<?=$value['id_agama']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][warganegara][]" attr-id="<?=$wnx?>" value="<?=$value['warganegara']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][pekerjaan][]" value="<?=$value['pekerjaan']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][suku][]" value="<?=$value['suku']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][id_pendidikan][]" value="<?=$value['id_pendidikan']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][unix][]" value="" class="form-control saksi<?=$value['id_saksi']?>">
                                            <input type="hidden" name="MssaksiBaru[ahli][<?=$value['id_saksi']?>][no_urut][]" value="<?=$value['no_urut']?>" class="form-control saksi<?=$value['id_saksi']?>">
                                            </td>
                                        </td>
                                    </tr>
                                    
                            <?php   }
                            }
                            ?>

                    </tbody>
                </table>
            </div>


        </div>
        
                        <?php if(!empty($modeluu)){ ?>
                            <div class="col-md-12">
                                <div id="pengantar">
                                    <div class="box box-primary "  style="border-color: #f39c12;">
                                        <div class="box-header with-border">
                                            <div class="col-md-6">
                                                <h5 class="box-title"> Undang-Undang & Pasal </h5>&nbsp;
                                            </div>
                                        </div>
                                        <?php //echo '<pre>';print_r($modeluu);exit;   ?>
                                        <div class="body-undang-undang">
                                        <?php  foreach ($modeluu as $key => $value) { ?>
                                            <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
                                                <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
                                                    <div class="form-group">
                                                        <div class="col-md-12 " style="padding-right:0px">
                                                             <div class="form-group field-mspedoman-uu">
                                                                 <div class="col-sm-8">
                                                                     <div class="form-group">
                                                                        <label class="control-label col-md-2" >Undang Undang</label>
                                                                        <div class="input-group col-md-8" >
                                                                            <input type="text" readOnly placeholder="Undang-Undang" class="form-control undang-undang" value="<?= $value['undang'] ?>" name="MsUndang[undang][]">
                                                                            <input type="hidden" readOnly class="form-control tentang-undang-undang" value="<?= $value['tentang']?>" name="MsUndang[tentang][]">
                                                                            <div class="input-group-btn">
                                                                                <a class="btn btn-warning pilih-undang" href="/pidum/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                                                            </div>
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                         <label class="control-label col-md-2" >Pasal</label>
                                                                         <div class="input-group col-md-8" >
                                                                             <input type="text" readOnly placeholder="Pasal Undang-Undang" class="form-control pasal-undang-undang" value="<?= $value['pasal'] ?>" attr-id='' name="MsUndang[pasal][]">
                                                                             <div class="input-group-btn">
                                                                                 <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                         <label class="control-label col-md-2" >Dakwaan</label>
                                                                         <div class="input-group col-md-4">
                                                                             <select name="MsUndang[dakwaan][]" class="form-control select-dakwaan" " >
                                                                                 <option value="0">-- Pilih --</option>
                                                                                 <option <?php if($value['dakwaan']==1){echo "selected='selected'";} ?> value="1">-- Juncto --</option>
                                                                                 <option <?php if($value['dakwaan']==2){echo "selected='selected'";} ?>  value="2">-- Dan --</option>
                                                                                 <option <?php if($value['dakwaan']==3){echo "selected='selected'";} ?>  value="3">-- Atau --</option>
                                                                                 <option <?php if($value['dakwaan']==4){echo "selected='selected'";} ?>  value="4">-- Subsider --</option>
                                                                             </select>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                                 <?php if($key>0){ ?>
                                                                     <div class="col-sm-2">
                                                                         <div class="input-group col-md-2" >
                                                                             <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                                                                 <i class="fa fa-trash-o"></i> Hapus
                                                                             </a>      
                                                                         </div>
                                                                     </div>
                                                                 <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>                          
                                                </div>                                      
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>



</div>
    <div class="box-footer" style="text-align: center;">
    <div class="col-md-12">
    <?php


     if($actual_linkx[5]!=='create'){
        ?>
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?= Html::a('Batal', ['/pidum/pdm-tahap-dua/index'], ['class' => 'btn btn-danger']) ?>
        <?php } ?>
        </div>
        </div>

    
</div>
</div>

<?php ActiveForm::end(); ?>

<div  id='clone_div' class="hide">
    <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
        <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
            <div class="form-group">
                <div class="col-md-12 " style="padding-right:0px">
                    <div class="form-group field-mspedoman-uu">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label col-md-2" >Undang Undang</label>
                                <div class="input-group col-md-8" >
                                    <input type="text" readOnly placeholder="Undang-Undang" class="form-control undang-undang" value="" name="MsUndang[undang][]">
                                    <input type="hidden" readOnly class="form-control tentang-undang-undang" value="" name="MsUndang[tentang][]">
                                    <div class="input-group-btn">
                                        <a class="btn btn-warning pilih-undang" href="/pidum/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" >Pasal</label>
                                <div class="input-group col-md-8" >
                                    <input type="text" readOnly placeholder="Pasal Undang-Undang" class="form-control pasal-undang-undang" value="" attr-id='' name="MsUndang[pasal][]">
                                    <div class="input-group-btn">
                                        <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <label class="control-label col-md-2" >Dakwaan</label>
                            <div class="form-group">
                                <div class="input-group col-md-4">
                                    <select name="MsUndang[dakwaan][]" class="form-control select-dakwaan" >
                                        <option value="0">-- Pilih --</option>
                                        <option value="1">-- Juncto --</option>
                                        <option value="2">-- Dan --</option>
                                        <option value="3">-- Atau --</option>
                                        <option value="4">-- Subsider --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group col-md-2" >
                                <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                    <i class="fa fa-trash-o"></i> Hapus
                                </a>                   
                                <div class="input-group col-md-2" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<br>

<script>
   


</script>


<?php
Modal::begin([
    'id' => 'm_saksi',
    'header' => '<h7>Tambah Saksi</h7>'
]);
Modal::end();



Modal::begin([
    'id' => 'm_satker',
    'header' => '<h7>Cari Wilayah Kerja</h7>'
]);
Modal::end();
?>



<?php
    $script = <<< JS
    $(function(){
        localStorage.clear();
    });

    $('.add_saksi').click(function(e){
        localStorage.clear();
        var jenis = $(this).attr('param');
        localStorage.jenis = jenis;

        console.log(localStorage.jenis);


        if($('#tbody_'+localStorage.jenis+' tr').length==0)
        {
          localStorage.no_urut_saksi = 1;
          //console.log(localStorage.no_urut);
        }else{
            var len = $('#tbody_'+localStorage.jenis+' tr').length;
            localStorage.no_urut_saksi = len+1;
            console.log(localStorage.no_urut_saksi);

           /* var count_saksi =  [];

            $('input[name="MssaksiBaru[no_urut][]"]').each(function(i,x){
                count_saksi.push(parseInt(this.value));
            });
            $('#tbody_saksi a.add_saksi').each(function(i,x){
                count_saksi.push(parseInt(this.text));
            });

            var a = Math.max.apply(null,count_saksi);

            if($(this).parent().prop("tagName")=='H3'){
               localStorage.no_urut_saksi = a+1;
            }*/
        }

        var href = $(this).attr('href');
        if(href != null){
            var id_saksi = href.substring(1, href.length);
        }else{
            var id_saksi = '';
        }

        if($('#tr_id'+id_saksi+' td input[type=hidden]').length!=0){
            edit_saksi(id_saksi,jenis);
        }else{

            if(id_saksi ==''){
                $('#m_saksi').html('');
                $('#m_saksi').load('/pidum/pdm-tahap-dua/show-saksi');
                $('#m_saksi').modal('show');
            }else{
                $('#m_saksi').html('');
                $('#m_saksi').load('/pidum/pdm-tahap-dua/show-saksi?id_saksi='+'$model->no_register_perkara|'+id_saksi);
                $('#m_saksi').modal('show');
            }

        }
    });
    
    

    

        $('#cari_satker').click(function(){
            var kode = $(this).attr("data-satkerkode");
            $('#m_satker').html('');
            $('#m_satker').load('/pidum/pdm-tahap-dua/satker?kd='+kode);
            $('#m_satker').modal('show');
        });





        $('body').on('click','.pilih-pasal',function(e){
           var index = $(this).index('.pilih-pasal');
           localStorage.indexPasal = index;
           var value = $('.undang-undang:eq('+index+')').attr('attr-id');
           console.log(value);
           if(value=='')
           {
                 bootbox.dialog({
                        message: "Silahkan Pilih Undang-Undang Dahulu",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",

                            }
                        }
                    });
           }
           else
           {
            console.log(value);
                $('#m_pasal').html('');
                $('#m_pasal').load('/pidum/pdm-tahap-dua/show-pasal?uu='+encodeURI(value));
                $('#m_pasal').modal('show');
           }
        });

        $('body').on('click','a.pilih-undang',function(){
           var index = $(this).index('.pilih-undang');

           localStorage.indexUndang = index;
        });

        $('#_undang div div div button.close').hide();


        function pilihPasal(pasal)
        {
            $('input.pasal-undang-undang:eq('+localStorage.indexPasal+')').val(pasal);
            $('#m_pasal').modal('hide');
        }


        $('body').off('change').on('change','#pengantar .body-undang-undang .select-dakwaan',function(e){
          var add_clone  =  $('#pengantar .body-undang-undang .select-dakwaan option[value=0]:selected').length;
          var add_clone2 =   $('#clone_div .select-dakwaan option[value=0]:selected').length;
          var index     =  $(this).index('.select-dakwaan');
          var value     =  $(this).val();

          var valueUU   =  $('#pengantar  .body-undang-undang input.undang-undang:eq('+index+')').val();
          var valuePsl  =  $('#pengantar  .body-undang-undang input.pasal-undang-undang:eq('+index+')').val();
           //alert(index);

                        var count_uu2 =0;
                        $('#pengantar .box-primary  input.undang-undang').each(function(x){
                           if($(this).val()=='')
                           {
                            count_uu2 +=1;
                           }
                        });

                         var count_uu3 =0;
                        $('#pengantar .box-primary  input.pasal-undang-undang').each(function(x){
                         if($(this).val()=='')
                         {
                          count_uu3 +=1;
                         }
                      });

          if( (add_clone+add_clone2) == 1)
          {

            console.log(valueUU);
            console.log(valuePsl);
            if(valueUU==''||valuePsl=='')
            {
                bootbox.dialog({
                        message: "<center>Silahkan Isi Undang-Undang dan Pasal Dahulu</center>",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",
                                callback: function(){
                                $('.body-undang-undang .select-dakwaan:eq('+index+') option[value='+0+']').prop("selected","true"); 
                                $("#tahap-dua-form").css('overflow-y','scroll');
                                }

                            }
                        }
                    });
            }
            else
            {
                 if(count_uu2==0&&count_uu3==0)
                   {
                     $('.select-dakwaan:eq('+index+') option[value='+value+']').attr("selected","selected");
                        var a =  $('#clone_div').clone().html();
                        $('#pengantar .body-undang-undang').append(a);
                   }
                   else
                   {
                     bootbox.dialog({
                            message: "<center>Silahkan Isi Undang-Undang dan Pasal Dahulu</center>",
                            buttons:{
                                ya : {
                                    label: "OK",
                                    className: "btn-warning",
                                    callback: function(){
                                    $('.body-undang-undang .select-dakwaan:eq('+index+') option[value='+0+']').prop("selected","true"); 
                                    $("#tahap-dua-form").css('overflow-y','scroll');
                                    }

                                }
                            }
                        });
                   } 
            }
           
          }
           

          if(index !=0)
          {
            if($(this).val()==0)
            {
                $(this).parent().parent().parent().parent().parent().parent().next().remove();
            }
          }

          $('.select-dakwaan:eq('+index+') option').removeAttr("selected");
          $('.select-dakwaan:eq('+index+') option[value='+value+']').attr("selected","selected");
          $('.select-dakwaan:eq('+index+') option[value='+value+']').prop("selected","true");
        });



        $('select[name=kode_pidana]').on('change',function(){
                var kode_pidana=$('select[name=kode_pidana]').val();
                $.ajax({
                    type: "POST",
                    url: '/pidum/pdm-tahap-dua/refer-undang',
                    data: 'kode_pidana='+kode_pidana,
                    success:function(data){
                        console.log(data);
                        $('#_undang .modal-body').html(data).show();
                    }
                });
            });

        $('body').on('click','a.pilih-undang',function(){
           var index = $(this).index('.pilih-undang');
           localStorage.indexUndang = index;
           console.log(index);
        });
        $('body').on('click','.pilih-pasal',function(e){
           var index = $(this).index('.pilih-pasal');
           localStorage.indexPasal = index;
           var value = $('.undang-undang:eq('+index+')').attr('attr-id');
           console.log(value);
           if(value=='')
           {
                 bootbox.dialog({
                        message: "Silahkan Pilih Undang-Undang Dahulu",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",

                            }
                        }
                    });
           }
           else
           {
            console.log(value);
                $('#m_pasal').html('');
                $('#m_pasal').load('/pidum/pdm-berkas-tahap1/show-pasal?uu='+encodeURI(value));
                $('#m_pasal').modal('show');
           }
        });


        $('#pengantar').off('click').on('click','.delete-undang-undang',function(e){
            var index  = $(this).index('.delete-undang-undang');
            var parent = $(this).prev().html();
            var value  = $(parent).find('input[type=hidden]').val();

           if(typeof(localStorage.data_db)!='undefined')
           {
           
                 if(typeof(value)!='undefined')
                 {
                  var lcl = 'hapusTersangka'+localStorage.data_db;
                    $('#trHpsTersangka').append(
                      '<input class="'+lcl+'" type="hidden" name="hapusUndang[]" value='+value+'>'
                      );
                 }
                $(this).parent().parent().parent().parent().remove();
           }
           else
          {
             if(index !=0)
            {
                 if(typeof(value)!='undefined')
               {
                var lcl = 'hapusTersangka'+localStorage.data_db;
                  $('#trHpsTersangka').append(
                    '<input class="'+lcl+'" type="hidden" name="hapusUndang[]" value='+value+'>'
                    );
               }
                $(this).parent().parent().parent().parent().remove();
            }else{
                $(this).parent().parent().parent().parent().remove();
            }
          }
            
        });


$('#hapus_ahli').click(function(){
    $('#table_ahli').find('input[type="checkbox"]:checked').each(function () {
        jQuery('input:checkbox:checked').parents('tr').remove();
    });
});

$('#hapus_saksi').click(function(){
    $('#table_saksi').find('input[type="checkbox"]:checked').each(function () {
        jQuery('input:checkbox:checked').parents('tr').remove();
    });
})


JS;
$this->registerJs($script);
?>


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

<?php echo GridView::widget([
        'dataProvider' => $dataProvidert,
        'filterModel' => $searchmodelt,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_berkas',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    //return $model['nomor'].'<br>  Tanggal '.$model['tgl'];
                    return $model['nomor'].'<br>  Tanggal '.$model['tgl'];
                },
            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => $model['id_perkara'],"berkas" => $model['id_berkas'], "class" => "btn btn-warning",
                                    "no_surat" => $model['nomor'],
                                    "tgl_spdp" => $model['tgl'],
                                    "onClick" => "pilihBerkas($(this).attr('id'),$(this).attr('berkas'))"]);
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

<?php
Modal::begin([
    'id'            => '_undang',
    'header'        => 'Data Undang-Undang
                        <div class="navbar-right" style="width: 180px; color: Black; ">
                        <h5>'.
                        Html::dropDownList('kode_pidana', null,
                        ArrayHelper::map(MsJenisPidana::find()->all(), 'kode_pidana', 'akronim'),
                        ['prompt'=>' -- Pilih Jenis Pidana --']        
                                ).'
                        </h5>
                        </div>',
    'options'       => [
        'data-url'  => '',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
?> 

<?=
$this->render('//ms-pasal/_undang', [
    'model' => $model,
    'searchUU' => $searchUU,
    'dataUU' => $dataUU,
])
?>

<?php
Modal::end();
?>


<?php
//Modal::end();
?>


<?php
Modal::begin([
    'id' => 'm_pasal',
    'header' => '<h7>Daftar Pasal</h7>',
    'options' => [
        'width' => '50%',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();
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


<script>
    function pilihBerkas(id,berkas) {

       
        $('#_spdp').modal('hide');

        
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-tahap-dua/create2?id="+id+"&berkas="+berkas;
        $(location).attr('href',url);
    }
    


function edit_saksi(id,jenis){
        var id = id;
            //console.log($("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq()["));
            
           localStorage.unix_saksi       =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(0)").val();
           localStorage.nama_saksi       =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(2)").val();
             
           localStorage.tmpt_lahir_saksi =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(3)").val();
           localStorage.tgl_lahir_saksi  =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(4)").val();
           localStorage.umur_saksi       =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(5)").val();
           localStorage.jk_saksi         =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(6)").val();
           localStorage.alamat_saksi     =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(7)").val();
           localStorage.id_saksi         =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(8)").val();
           localStorage.no_id_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(9)").val();
           localStorage.no_hp_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(10)").val();
           localStorage.agama_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(11)").val();
           localStorage.id_wn_saksi      =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(12)").val();
           localStorage.nm_wn_saksi      =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(12)").attr('attr-id');
           localStorage.kerja_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(13)").val();
           localStorage.suku_saksi       =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(14)").val();
           localStorage.pendidikan_saksi =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(15)").val();
           localStorage.tr_saksi         = id;
           localStorage.no_urut              =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(17)").val();
            var href = $(this).attr('href');
            if(href != null){
                var id_saksi = href.substring(1, href.length);
            }else{
                var id_saksi = '';
            }

            console.log(localStorage);
            $('#m_saksi').html('');
            $('#m_saksi').load('/pidum/pdm-tahap-dua/show-saksi?id_saksi='+id_saksi);
            $('#m_saksi').modal('show');
        }
</script>


