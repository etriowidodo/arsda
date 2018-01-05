<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\typeahead\TypeaheadAsset;
use kartik\select2\Select2Asset;
use app\modules\pidum\models\PdmMsUu;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\modules\pidum\models\PdmMsRentut;
use app\modules\pidum\models\PdmPidanaPengawasan;
use app\modules\pidum\models\PdmBa4;
use app\modules\pidum\models\PdmT7;
use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);
use app\modules\pidum\models\MsJenisPidana;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP29 */
/* @var $form yii\widgets\ActiveForm */
// TypeaheadAsset::register($this);
// Select2Asset::register($this);
?>

<div class="box-header"></div>


<?php
$form = ActiveForm::begin(
[
    'id' => 'p30-form',
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

<div class="content-wrapper-1">
    <div class="pdm-p30-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No. Register Perkara</label>
                                        <div class="col-md-6">
                                            <?php 
                                            if(!$model->isNewRecord){ ?>
                                            <?= $form->field($model, 'no_register_perkara')->textInput(['readonly'=>true]);?>
                                            <?php }else{ ?>
                                            <?= $form->field($model, 'no_register_perkara')->textInput(['readonly'=>true, 'value'=>$no_register]);?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <h4>Terdakwa</h4>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table id="table_terdakwa" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="4%" style="text-align: center;">No</th>
                                                    <th width="96%" style="text-align: center;vertical-align: middle;">Nama</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_terdakwa">
                                                <?php
                                                    $i = 1;
                                                    foreach ($ba4tsk as $barbuk){
                                                ?>
                                                    <tr>
                                                        <td style="text-align: center">
                                                            <input type="text" class="form-control" name="pdmBarbukNo[]" readonly="true" value="<?= $i ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="<?= $barbuk['nama'] ?>">
                                                        </td>
                                                        
                                                    </tr>
                                                
                                                <?php
                                                 $i++;   }//end foreach
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. Dikeluarkan</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl. Dikeluarkan'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'startDate' => '-1m',
                                                        'endDate' => '+4m'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Bertempat di</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'dikeluarkan')->textInput(['placeholder' => 'Bertempat di','value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                    <?php foreach ($ba4tsk as $rowmodeltsk) { ?> 
                         <li <?php echo ($rowmodeltsk['no_urut_tersangka'] == 1)?'class="active"':'';?>>
                         <a href="#tab-<?php echo Yii::$app->globalfunc->clean($rowmodeltsk['no_reg_tahanan']);?>" data-toggle="tab"><?php echo $rowmodeltsk['nama'];?></a></li>
                    <?php } ?>     
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">

                    <?php foreach ($ba4tsk as $rowmodeltsk) { ?>
                        <div <?php echo ($rowmodeltsk['no_urut_tersangka'] == 1)?'class="tab-pane fade in active"':'class="tab-pane fade"';?> id="tab-<?php echo Yii::$app->globalfunc->clean($rowmodeltsk['no_reg_tahanan']);?>"  >
                            <?php //if ($model->isNewRecord){?>
                        <?php 

                        $lalu = PdmBa4::findOne(['no_register_perkara'=>$rowmodeltsk['no_register_perkara'], 'no_reg_tahanan'=>$rowmodeltsk['no_reg_tahanan'] ]);
                        $lalu_t7 = PdmT7::findOne(['no_register_perkara'=>$rowmodeltsk['no_register_perkara'], 'no_urut_tersangka'=>$rowmodeltsk['no_urut_tersangka'] ]);  
                        if(!$model->isNewRecord){
                            $lalu = $riwayat[0]->$rowmodeltsk['no_reg_tahanan'];
                            $lalu_t7 = $lalu;
                            /*echo '<pre>';print_r($lalu->$rowmodeltsk['no_reg_tahanan']);exit;
                            foreach ($lalu->$rowmodeltsk['no_reg_tahanan'] as $rowdet) {
                                echo '<pre>';print_r($rowdet);
                            }
                            exit;*/
                            //echo '<pre>';print_r(COUNT($riwayat));exit;
                        }
                        ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                <h4 class="box-title">
                                                    Riwayat Penahanan Terdakwa <?=$rowmodeltsk[nama]?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" ></label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label" >No Surat Perintah Penahanan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label">Tanggal Surat Perintah Penahanan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label">Jenis Penahanan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label">Tanggal Awal</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label">Tanggal Akhir</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="control-label">Lokasi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 12px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" >Ditahan Oleh Penyidik</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][no_sp_penyidik]" value="<?=$lalu->no_sp_penyidik ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                        $tgl_sp_penyidik ='';

                                                        //echo '<pre>';print_r(gettype($lalu->tgl_sp_sidik));exit;
                                                        if(!empty($lalu->tgl_sp_penyidik)){
                                                            $dt = date_create($lalu->tgl_sp_penyidik);
                                                            $tgl_sp_penyidik = date_format($dt,"d-m-Y");    
                                                        }
                                                        
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_sp_penyidik]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_sp_penyidik, 
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="selectpicker form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][jns_penahanan_penyidik]">
                                                    <?php $lok_tahanan = \app\modules\pidum\models\MsLoktahanan::find()->all(); 
                                                         foreach ($lok_tahanan as $row_lok_tahanan){?>
                                                        <option value="<?= $row_lok_tahanan['nama'] ?>"
                                                        <?php echo $row_lok_tahanan['id_loktahanan'] == $lalu->jns_penahanan_penyidik ? "selected" : "" ; ?>><?= $row_lok_tahanan['nama'] ?></option>
                                                    <?php
                                                         }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_awal_penyidik ='';
                                                    if(!empty($lalu->tgl_awal_penyidik)){
                                                        //echo '<pre>';print_r('cuakakak');exit;
                                                        $dt = date_create($lalu->tgl_awal_penyidik);
                                                        $tgl_awal_penyidik = date_format($dt,"d-m-Y");    
                                                    }
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_awal_penyidik]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_awal_penyidik,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_akhir_penyidik ='';
                                                    if(!empty($lalu->tgl_akhir_penyidik)){
                                                        $dt = date_create($lalu->tgl_akhir_penyidik);
                                                        $tgl_akhir_penyidik = date_format($dt,"d-m-Y");    
                                                    }
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_akhir_penyidik]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_akhir_penyidik,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][lokasi_penyidik]" value="<?= $lalu->lokasi_penyidik ?> ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 12px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" >Diperpanjang Oleh Kejaksaan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][no_sp_jaksa]" value="<?= $lalu->no_sp_jaksa ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_sp_jaksa ='';
                                                    if(!empty($lalu->tgl_sp_jaksa)){
                                                        $dt = date_create($lalu->tgl_sp_jaksa);
                                                        $tgl_sp_jaksa = date_format($dt,"d-m-Y");    
                                                    } 
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_sp_jaksa]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_sp_jaksa,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="selectpicker form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][jns_penahanan_jaksa]">
                                                    <?php $lok_tahanan = \app\modules\pidum\models\MsLoktahanan::find()->all(); 
                                                         foreach ($lok_tahanan as $row_lok_tahanan){?>
                                                        <option value="<?= $row_lok_tahanan['nama'] ?>"
                                                        <?php echo $row_lok_tahanan['id_loktahanan'] == $lalu->jns_penahanan_jaksa ? "selected" : "" ; ?>><?= $row_lok_tahanan['nama'] ?></option>
                                                    <?php
                                                         }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                        $tgl_awal_kejaksaan ='';
                                                        if(!empty($lalu->tgl_awal_kejaksaan)){
                                                            $dt = date_create($lalu->tgl_awal_kejaksaan);
                                                            $tgl_awal_kejaksaan = date_format($dt,"d-m-Y");    
                                                        }

                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_awal_kejaksaan]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_awal_kejaksaan,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_akhir_kejaksaan ='';
                                                    if(!empty($lalu->tgl_akhir_kejaksaan)){
                                                        $dt = date_create($lalu->tgl_akhir_kejaksaan);
                                                        $tgl_akhir_kejaksaan = date_format($dt,"d-m-Y");    
                                                    } 
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_akhir_kejaksaan]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_akhir_kejaksaan,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][lokasi_jaksa]" value="<?= $lalu->lokasi_jaksa ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 12px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" >Diperpanjang Oleh PN</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][no_sp_pn]" value="<?= $lalu->no_sp_pn ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_sp_pn ='';
                                                    if(!empty($lalu->tgl_sp_pn)){
                                                        $dt = date_create($lalu->tgl_sp_pn);
                                                        $tgl_sp_pn = date_format($dt,"d-m-Y");    
                                                    }  
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_sp_pn]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_sp_pn,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="selectpicker form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][jns_penahanan_pn]">
                                                    <?php $lok_tahanan = \app\modules\pidum\models\MsLoktahanan::find()->all(); 
                                                         foreach ($lok_tahanan as $row_lok_tahanan){?>
                                                        <option value="<?= $row_lok_tahanan['nama'] ?>"
                                                        <?php echo $row_lok_tahanan['id_loktahanan'] == $lalu->jns_penahanan_pn ? "selected" : "" ; ?>><?= $row_lok_tahanan['nama'] ?></option>
                                                    <?php
                                                         }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_awal_pn ='';
                                                    if(!empty($lalu->tgl_awal_pn)){
                                                        $dt = date_create($lalu->tgl_awal_pn);
                                                        $tgl_awal_pn = date_format($dt,"d-m-Y");    
                                                    }  
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_awal_pn]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_awal_pn,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_akhir_pn ='';
                                                    if(!empty($lalu->tgl_akhir_pn)){
                                                        $dt = date_create($lalu->tgl_akhir_pn);
                                                        $tgl_akhir_pn = date_format($dt,"d-m-Y");
                                                     } 
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_akhir_pn]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_akhir_pn,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][lokasi_pn]" value="<?= $lalu->lokasi_pn ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 12px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" >Penahanan Oleh JPU Sejak</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][no_surat_t7]" value="<?= $lalu_t7->no_surat_t7 ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_dikeluarkan ='';
                                                    // /echo '<pre>';print_r($lalu_t7);exit;
                                                    if(!empty($lalu_t7->tgl_dikeluarkan)){
                                                        $dt = date_create($lalu_t7->tgl_dikeluarkan);
                                                        $tgl_dikeluarkan = date_format($dt,"d-m-Y");
                                                     }

                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_dikeluarkan]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_dikeluarkan,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="selectpicker form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][id_ms_loktahanan]">
                                                    <?php $lok_tahanan = \app\modules\pidum\models\MsLoktahanan::find()->all(); 
                                                         foreach ($lok_tahanan as $row_lok_tahanan){?>
                                                        <option value="<?= $row_lok_tahanan['nama'] ?>"
                                                        <?php echo $row_lok_tahanan['id_loktahanan'] == $lalu_t7->id_ms_loktahanan ? "selected" : "" ; ?>><?= $row_lok_tahanan['nama'] ?></option>
                                                    <?php
                                                         }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_mulai = '';
                                                    if(!empty($lalu_t7->tgl_mulai)){
                                                        $dt = date_create($lalu_t7->tgl_mulai);
                                                        $tgl_mulai = date_format($dt,"d-m-Y");
                                                     }
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_mulai]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_mulai,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_selesai = '';
                                                    if(!empty($lalu_t7->tgl_selesai)){
                                                        $dt = date_create($lalu_t7->tgl_selesai);
                                                        $tgl_selesai = date_format($dt,"d-m-Y");
                                                     } 
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_selesai]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_selesai,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][lokasi_tahanan]" value="<?= $lalu_t7->lokasi_tahanan ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 12px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" >Diperpanjang Oleh Majelis Hakim</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][no_surat_mh]" value="<?= isset($lalu->no_surat_mh) ? $lalu->no_surat_mh : '' ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_surat_mh ='';
                                                    if(!empty($lalu->tgl_surat_mh)){
                                                        $dt = date_create($lalu->tgl_surat_mh);
                                                        $tgl_surat_mh = date_format($dt,"d-m-Y");
                                                     }  
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_surat_mh]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_surat_mh,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="selectpicker form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][jenis_mh]">
                                                    <?php $lok_tahanan = \app\modules\pidum\models\MsLoktahanan::find()->all(); 
                                                    foreach ($lok_tahanan as $row_lok_tahanan){?>
                                                    <option value="<?= $row_lok_tahanan['nama'] ?>"
                                                    <?php if(isset($lalu->jenis_mh)){
                                                      echo $row_lok_tahanan['nama'] == $lalu->jenis_mh ? "selected" : "" ; } ?>  >
                                                        <?= $row_lok_tahanan['nama'] ?>
                                                    </option>    

                                                    <?php
                                                         }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_awal_mh ='';
                                                    if(!empty($lalu->tgl_awal_mh)){
                                                        $dt = date_create($lalu->tgl_awal_mh);
                                                        $tgl_awal_mh = date_format($dt,"d-m-Y");
                                                     } 
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_awal_mh]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_awal_mh,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    $tgl_akhir_mh ='';
                                                    if(!empty($lalu->tgl_akhir_mh)){
                                                        $dt = date_create($lalu->tgl_akhir_mh);
                                                        $tgl_akhir_mh = date_format($dt,"d-m-Y");
                                                     } 
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_akhir_mh]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_akhir_mh,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][lokasi_mh]" value="<?= isset($lalu->lokasi_mh) ? $lalu->lokasi_mh : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 12px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <label class="control-label" >Diperpanjang Oleh Ketua PN</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][no_surat_ket_pn]" value="<?= isset($lalu->no_surat_ket_pn) ? $lalu->no_surat_ket_pn : ''; ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_surat_ket_pn = '';
                                                    if(!empty($lalu->tgl_surat_ket_pn)){
                                                        $dt = date_create($lalu->tgl_surat_ket_pn);
                                                        $tgl_surat_ket_pn = date_format($dt,"d-m-Y");
                                                     } 

                                                     //echo '<pre>';print_r($tgl_surat_ket_pn);exit;
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_surat_ket_pn]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_surat_ket_pn,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="selectpicker form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][jenis_ket_pn]">
                                                    <?php $lok_tahanan = \app\modules\pidum\models\MsLoktahanan::find()->all(); 
                                                         foreach ($lok_tahanan as $row_lok_tahanan){?>
                                                        <option value="<?= $row_lok_tahanan['nama'] ?>"
                                                        <?php if(isset($lalu->jenis_ket_pn)){
                                                      echo $row_lok_tahanan['nama'] == $lalu->jenis_ket_pn ? "selected" : "" ; } ?>  >
                                                        <?= $row_lok_tahanan['nama'] ?>                                                          
                                                        </option>
                                                    <?php
                                                         }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_awal_ket_pn = '';
                                                    if(!empty($lalu->tgl_awal_ket_pn)){
                                                        $dt = date_create($lalu->tgl_awal_ket_pn);
                                                        $tgl_awal_ket_pn = date_format($dt,"d-m-Y");
                                                     }
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_awal_ket_pn]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_awal_ket_pn,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php 
                                                    $tgl_akhir_ket_pn = '';

                                                    if(!empty($lalu->tgl_akhir_ket_pn)){
                                                        $dt = date_create($lalu->tgl_akhir_ket_pn);
                                                        $tgl_akhir_ket_pn = date_format($dt,"d-m-Y");
                                                     }
                                                        echo DatePicker::widget([
                                                            'name' => 'pdmPenahanan['.$rowmodeltsk[no_reg_tahanan].'][tgl_akhir_ket_pn]',
                                                            'type' => DatePicker::TYPE_INPUT,
                                                            'value' => $tgl_akhir_ket_pn,
                                                            'pluginOptions' => [
                                                                'autoclose'=>true,
                                                                'format' => 'dd-mm-yyyy'
                                                            ]
                                                        ]);
                                                    ?>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" class="form-control" name="pdmPenahanan[<?= $rowmodeltsk['no_reg_tahanan'] ?>][lokasi_ket_pn]" value="<?= isset($lalu->lokasi_ket_pn) ? $lalu->lokasi_ket_pn : ''  ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <hr>
                                    <br/>
                                    <?php //} ?>
                                    <?php //} else { ?>
                                      



                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>



                <!-- <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12"> -->
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
                                                                            <input type="hidden" readOnly class="form-control tentang-undang-undang" value="<?= $value['tentang'] ?>" attr-id='' name="MsUndang[tentang][]">
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
                            <!-- </div>
                        </div>
                    </div>
                </div> -->
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Catatan</label>
                                        <div class="col-md-10">
                                            <?= $form->field($model, 'catatan')->textarea(['placeholder' => 'Catatan','class'=>'ckeditor']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Jaksa</label>
                                        <div class="col-md-6">
                                            <?php
                                                if ($model->isNewRecord) {?>
                                                <div class="form-group field-pdmjaksasaksi-nama required">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12"></div>
                                                    <div class="col-sm-12">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            <?php
                                                } else {
                                            ?>
                                                <div class="form-group field-pdmjaksasaksi-nama required">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input value ="<?= $model->nama?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        
//                                                        echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'nip')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-12"></div>
                                                    <div class="col-sm-12">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord): 
//            echo Html::a('Cetak', ['cetak', 'id' => rawurlencode($model->no_surat_p26)], ['class' => 'btn btn-warning']);?>
            <a class="btn btn-warning" href="<? echo Url::to(["pdm-p30/cetak?id=".$model->no_register_perkara]) ?>">Cetak</a>
        <?php endif ?>	
        <?php  //} else {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                    ?>
        <?php
//        if (!$model->isNewRecord) {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
//        } else {
            echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', $model->no_register_perkara, ['id' => 'pdmjaksasaksi-no_register_perkara']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_surat_p16a]', null, ['id' => 'pdmjaksasaksi-no_surat_p16a']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_urut]', null, ['id' => 'pdmjaksasaksi-no_urut']);
            echo Html::hiddenInput('PdmJaksaSaksi[nip]', $model->id_penandatangan, ['id' => 'pdmjaksasaksi-nip']);
            echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', $model->jabatan, ['id' => 'pdmjaksasaksi-jabatan']);
            echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', $model->pangkat, ['id' => 'pdmjaksasaksi-pangkat']);
        ?>
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
                                    <input type="hidden" readOnly class="form-control tentang-undang-undang" value="<?= $value['tentang'] ?>" attr-id='' name="MsUndang[tentang][]">
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

<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>

<?php
    $script = <<< JS
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
                        $("#pengantar").css('overflow-y','scroll');
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
                            $("#pengantar").css('overflow-y','scroll');
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
            
JS;
$this->registerJs($script);
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