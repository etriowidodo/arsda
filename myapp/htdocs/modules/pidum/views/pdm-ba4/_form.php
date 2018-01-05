<?php

use app\modules\pidum\models\PdmP16;
use app\models\MsWarganegara;
use app\modules\pidum\models\PdmPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use app\modules\pidum\models\MsLoktahanan;

/* @var $this View */
/* @var $model ActiveForm2 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin([
                    'id' => 'ba4-form',
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
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal BA</label>
                        <div class="col-md-8">
                           <?php 
                           
                               echo DateControl::widget([
                                   'name'=>'PdmBa4[tgl_ba4]', 
                                   'value'=>$rp9->tgl_terima,
                                   'type'=> DateControl::FORMAT_DATE,
                                   'readonly'=>true,
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
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jaksa Penuntut Umum</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'nama_ttd', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if(!$model->isNewRecord){
                    if(substr($model->no_reg_tahanan,(strlen($model->no_reg_tahanan)-1),1)=='^'){
                        $val='';
                    }
                }
            ?>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No Reg Tahanan Penyidik</label>
                        <div class="col-md-8">
                           <?= $form->field($model, 'no_reg_tahanan')->input('text',
                                ['oninput'  =>'
                                        var number =  /^[A-Za-z0-9-./]+$/;
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
                                        ', 
                                'value'=>$val]);   ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
             <div class="col-md-9">

           <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">No Urut Tersangka</label>
                        <div class="col-md-1">
                            <?php echo $form->field($model, 'no_urut_tersangka'); ?>
                        </div>
                        <label class="control-label col-md-1">Nama</label>
                        <div class="col-md-7">
                            <?php
                            echo $form->field($model, 'nama', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', 'javascript:void(0)', ['id'=>'show_tersangka','class' => 'btn btn-warning']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <!-- CMS_PIDUM003_28|jaka|03-06-2016|ganti label TTL menjadi tempat lahir -->
                        <label class="control-label col-md-4">Tempat Lahir</label>
                        <div class="col-md-8">
                            <?php echo $form->field($model, 'tmpt_lahir'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Lahir</label><!-- jaka|03-06-2016|tambah label tanggal lahir -->
                        <div class="col-md-2" style="width:27%">
                            <?php
                            echo $form->field($model, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => [
                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'startDate' => '-101y',
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) {
                                           
                                            
                                        }",
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <label class="control-label col-md-1" style="width:15%;padding-left:30px;">Umur</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label Umur -->
                         <div class="col-md-2 control-label-inline" style="width:22%">
                         <!-- BEGIN CMS_PIDUM001_03 ETRIO WIDODO -->
                             <?php echo $form->field($model, 'umur')->Input('number',
                        ['max'      =>99,
                         'min'      =>0,
                         'maxlength'=>2,
                         'oninput'  =>'
                                        var number =  /^[0-9]+$/;
                                        if(this.value.length>2)
                                        {
                                          this.value = this.value.substr(0,2);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        if(!this.value.match(number))
                                        {
                                            this.value =null
                                        }
                                        ',
                        'onchange'=>'maxpendidikan()'
                                        ]); ?>
                       <!-- END CMS_PIDUM001_03 ETRIO WIDODO -->
                    </div>

                    <label class="control-label label-inline col-md-1" style="padding-left:0px;">Tahun</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label tahun untuk usia-->
                </div>
            </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">
                        
                    <div class="input-group">
                        <input type="text" value="<?= MsWarganegara::findOne($model->warganegara)->nama ?>" id="pdmba4-warganegara-text" class="form-control" ><div class="input-group-btn"><a id='showWn' class="btn btn-warning" type="button">Pilih</a></div></div>
                 
                        </div>
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Suku</label>
                        <div class="col-md-9">
                            <?php echo $form->field($model, 'suku') ?>
                        </div>
                    </div>
                </div> 

            </div>
             <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Identitas</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'id_identitas')->dropDownList(
                                    $identitas,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            )
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                    <!-- jaka | tambahan label dan filter number-->
                    <label class="control-label col-md-3" style="">No Identitas</label>
                        <div class="col-md-9">
                            <?php echo $form->field($model, 'no_identitas')->input('text',
                                [
                                'maxlength'=> '24',
                                'oninput'  =>'
                                        var onchange = document.getElementById("pdmba4-id_identitas").value;
                                        var number =  /^[0-9-]+$/;
                                        if(onchange != 3)
                                        {
                                           if(this.value.length>24)
                                            {
                                              this.value = this.value.substr(0,24);
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
                                        }
                                       
                                        
                                        ']) ?>
                        <!-- END -->
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                                    <label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                        <!--
                        <div class="btn-group" data-toggle="button-radio">
                            <button type="button" class="btn btn-primary">Laki</button>
                            <button type="button" class="btn btn-primary">Perempuan</button>
                        </div>
                        <!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->
         
                                
                           
                                <?php
                            
                                echo $form->field($model, 'id_jkl')->radioList($JenisKelamin);
                                
                                //echo $form->field($modelTersangka, 'id_jkl')->inline()->radioList($JnsKelamin);
                                //echo $form->field($modelTersangka, 'id_jkl');
                              //echo $form->radioButtonList($modelTersangka,'id_jkl',(1=>'Laki-laki',2=>'Perempuan'),array('separator'=>'&nbsp;','labelOptions'=>array('style'=>'display:inline'),));
                                //echo $form->error($modelTersangka,'id_jkl');
                                //echo  $form->radioButtonList($model,'radio',array('m'=>'male','f'=>'female'),array('separator'=>'', 'labelOptions'=>array('style'=>'display:inline')));
                                                    // ->dropDownList($JnsKelamin,
                                                    // ['prompt' => '---Pilih---'],
                                                    // ['label'=>'']) ?>
                            <!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->
                        
                        </div>
                  </div>
               </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">Agama</label>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'id_agama')->dropDownList( $agama,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
                            ?>
                        </div>
                    </div>
                </div>

            </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Alamat</label>
                        <div class="col-md-8">
                            <?php echo $form->field($model, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">No HP</label>
                        <div class="col-md-9">
                            <?php echo $form->field($model, 'no_hp')->input('text',
                                ['oninput'  =>'var number =  /^[0-9]+$/;
                                        if(this.value.length>24)
                                        {
                                          this.value = this.value.substr(0,24);
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
                                        ']) ?>
                        </div>
                    </div>
                </div>
            </div>
              <div class="row">
                

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                            <?php
                            
                            echo $form->field($model, 'id_pendidikan')->dropDownList( $pendidikan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''],
                                                    ['data-id'=>'a']
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">Pekerjaan</label>
                        <div class="col-md-9">
                            <?php echo $form->field($model, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>

            </div>
            </div>
             <div class="col-md-3">
             <center class='col-md-12' style="padding-bottom: 10px">
             <button id="run_camera"  onclick="setup(); $(this).hide().next().show();"  type="button" class="btn btn-warning center"><i class="fa fa-camera" aria-hidden="true"></i> <span class="sr-only">Nyalakan Kamera</span>Hidupkan Kamera</button>
             <button id="take_snap" style="display:none" onclick="take_snapshot()"  type="button" class="btn btn-warning center"><i class="fa fa-camera" aria-hidden="true"></i> <span class="sr-only">Nyalakan Kamera</span>Ambil Foto</button>
             <br>
             <div class="form-group" style="padding-top: 10px">
                           <!--  <label class="control-label col-md-4">Upload File</label> -->
                             <div class="col-md-12">
                                     <?php 
                                // echo '<label class="control-label col-md-4">Upload Document</label>';
                                     $preview = "";
                                     // if($model->upload_file!="")
                                     // {
                                     //    $preview =  [
                                     //                "<a href='".$model->upload_file."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                     //                 ];
                                     // }
                                     

                                        echo FileInput::widget([
                                            'name' => 'attachment_3',
                                            'id'   =>  'filePicker',
                                            'pluginOptions' => [
                                                    'showPreview' => false,
                                                    'showCaption' => true,
                                                    'showRemove' => true,
                                                    'showUpload' => false,
                                                     'initialPreview' =>  $preview
                                                    
                                                ],
                                            
                                        ]);
                                        ?>
                                    <!-- <a href="<?= $model->upload_file?>">Lihat File</a>
                                    <input id="filePicker" type="file" /> -->
                                </div>
                        </div>
             </center>
             <br>
                <div id="my_camera"></div>
                <img src="<?= $model->foto?>"/>
             </div>
        </div>
        
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border hide">
                <span class="pull-right"><a class="btn btn-warning" id="btn_tambah_pertanyaan">Tambah</a></span>
                <h3 class="box-title">
                    Pertanyaan dan Jawaban
                </h3>
            </div>
            <table id="table_pertanyaan" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="50%">Pertanyaan</th>
                        <th width="47%">Jawaban</th>
                        <th width="3%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tbody_pertanyaan">
                    <?php
                    //echo '<pre>';print_r($tanyaJawab);exit;
                    if (count($tanyaJawab) > 0) {
                       foreach ($tanyaJawab as $rowTanyaJawab) {
                            ?>
                            <tr id="trtanyajawab">
                                <td><input type="text" class="form-control" name="pertanyaan[]" value="<?php echo $rowTanyaJawab['pertanyaan']; ?>" > </td>
                                <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                                <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                            </tr>
                            <?php
                        }
                    }else{
                    ?>
                        <tr id="trtanyajawab">
                            <td><input type="text" class="form-control" name="pertanyaan[]" value="Apa sebab Saudara dihadapkan di Kejaksaan?" > </td>
                            <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                        <tr id="trtanyajawab">
                            <td><input type="text" class="form-control" name="pertanyaan[]" value="Apakah untuk Perkara ini Saudara ditahan?" > </td>
                            <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                        <tr id="trtanyajawab">
                            <td><input type="text" class="form-control" name="pertanyaan[]" value="Kalau ditahan sejak kapan?" > </td>
                            <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                        <tr id="trtanyajawab">
                            <td><input type="text" style="font-size:13px;" class="form-control" name="pertanyaan[]" value="Benarkah sangkaan terhadap Saudara seperti tersebut dalam berkas perkara ini?" > </td>
                            <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                        <tr id="trtanyajawab">
                            <td><input type="text" class="form-control" name="pertanyaan[]" value="Apakah Saudara pernah dihukum?" > </td>
                            <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                        <tr id="trtanyajawab">
                            <td><input type="text" class="form-control" name="pertanyaan[]" value="Apakah ada hal-hal lain yang akan Saudara jelaskan?" > </td>
                            <td><input type="text" class="form-control" name="jawaban[]" value="<?php echo $rowTanyaJawab['jawaban']; ?>" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
<!--         <h3 class="box-title">
                    Kesesuaian Keterangan
                </h3>-->
            <table id="table_pertanyaan" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="50%">Kesesuaian Keterangan</th>
                        <th width="10%">Jawaban</th>
                        <th width="40%">Alasan</th>
                    </tr>
                </thead>
                <tbody id="tbody_pertanyaan">
                                  
                        <tr id="trtanyajawab">
                            <td> <textarea readonly="true" class="form-control" >Apakah keterangan tersangka sesuai dengan Berita Acara yang dibuat oleh penyidik ?</textarea>
                            <td>
                                 <input <?php echo (trim($model['alasan'])=="")?"checked":""; ?>  type='radio' value='1' name='tanya_alasan'/> Ya
                                 <input <?php echo (trim($model['alasan'])!="")?"checked":""; ?> type='radio' value='2' name='tanya_alasan'/> Tidak
                            </td>
                            <td>
                                <div class="form-group">                                    
                                    <div class="col-md-12 kejaksaan">
                                    <?php $style = (trim($model['alasan'])=="")?"display:none;":""; ?>
                                        <?= $form->field($model, 'alasan')->textarea(['rows' => 4,'style'=>$style]) ?>
                                    </div>      
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <div class="box box-primary" id="div_riwayat_tahanan_div" style="border-color: #f39c12;" >
           
           
            <div class="box-header with-border">
<!--            <h3 class="box-title">
                    Riwayat Penahanan
                </h3>-->

            <table id="table_pertanyaan" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="30%">Riwayat Penahanan</th>
                        <th  width="40%">Jawaban</th>
                        <th width="30%"><!-- Keterangan --></th>
                    </tr>
                </thead>
                <tbody id="tbody_pertanyaan">
                                  
                        <tr id="trtanyajawab">
                            <td> 
                            <textarea readonly="true"  class="form-control" >Apakah Tersangka Ditahan oleh Penyidik</textarea>
                            </td>

                            <td colspan="2">
                                <?php if($model->isNewRecord){ ?>
                                    <input  type='radio' value='1' name='tanya_tahan'/> Ya
                                    <input   type='radio' value='2' name='tanya_tahan' checked="checked" /> Tidak
                                <?php }else{ ?>
                                    <input <?php echo (trim($model['no_sp_penyidik'])!="")?'checked="checked"':"";  ?>   type='radio' value='1' name='tanya_tahan'/> Ya
                                    <input <?php echo (trim($model['no_sp_penyidik'])=="")?'checked="checked"':"";  ?>  type='radio' value='2' name='tanya_tahan'/> Tidak
                                <?php } ?>
                                 
                            </td>
                        </tr>
                        <tr>
                            <td id="body_riwayat_tahanan" colspan="3" <?php $no_sp_penyidik = (trim($model['no_sp_penyidik'])=="")?'style="display:none"':""; echo $no_sp_penyidik; ?>>
                                 <div class="col-md-12 text-center" >
                                                <div class="col-md-12">
                                                            <div class="form-group">
                                                            <label class="control-label col-md-2" ></label>
                                                            <label class="control-label col-md-2 " style="margin-right: -10px; padding-right: 0px">No Surat Perintah Penahanan</label>
                                                            <label class="control-label col-md-2 "  style="margin-right: -10px; padding-right: 0px;width: 10%;">Tanggal Surat Perintah Penahanan</label>
                                                            <label class="control-label col-md-2 " style="margin-right: -10px; padding-right: 0px; width: 10%;">Jenis Penahanan</label>
                                                            <label class="control-label col-md-2 " style="margin-right: -10px; padding-right: 0px;width: 10%;">Lokasi</label>
                                                            <label class="control-label col-md-2 " style="margin-right: -10px; padding-right: 0px;width: 10%;">Tanggal Awal</label>
                                                            <label class="control-label col-md-2 " >Tanggal Akhir</label>
                                                            
                                                            </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" >
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Ditahan Oleh Penyidik</label>
                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px">
                                                        <?php echo $form->field($model, 'no_sp_penyidik')->input('text',
                                                            [
                                                            'maxlength'=> '40',]) ?>
                                                        </div>
                                                        <div class="col-md-2"  style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                            <?php
                                                            echo $form->field($model, 'tgl_sp_penyidik')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                                    <?=
                                                                    $form->field($model, 'jns_penahanan_penyidik')->dropDownList(
                                                                            ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama'), ['prompt' => 'Pilih Jenis Tahanan',
                                                                            ]
                                                                    )
                                                                    ?>
                                                         </div>
                                                        
                                                        <div class="col-md-2"  style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                        <?php echo $form->field($model, 'lokasi_penyidik')->input('text',
                                                            [
                                                            'maxlength'=> '40',]) ?>
                                                        </div>

                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                            <?php
                                                            echo $form->field($model, 'tgl_awal_penyidik')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?php
                                                            echo $form->field($model, 'tgl_akhir_penyidik')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                         
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Diperpanjang Oleh Kejaksaan</label>
                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px">
                                                        <?php echo $form->field($model, 'no_sp_jaksa')->input('text',
                                                            [
                                                            'maxlength'=> '40',]) ?>
                                                        </div>
                                                        <div class="col-md-2"  style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                            <?php
                                                            echo $form->field($model, 'tgl_sp_jaksa')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                                    <?=
                                                                    $form->field($model, 'jns_penahanan_jaksa')->dropDownList(
                                                                            ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama'), ['prompt' => 'Pilih Jenis Tahanan',
                                                                            ]
                                                                    )
                                                                    ?>
                                                         </div>

                                                          <div class="col-md-2"  style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                         <?php echo $form->field($model, 'lokasi_jaksa')->input('text',
                                                             [
                                                             'maxlength'=> '40',]) ?>
                                                         </div>

                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                            <?php
                                                            echo $form->field($model, 'tgl_awal_kejaksaan')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>

                                                        <div class="col-md-2" >
                                                            <?php
                                                            echo $form->field($model, 'tgl_akhir_kejaksaan')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                         
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Diperpanjang Oleh PN</label>
                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px">
                                                        <?php echo $form->field($model, 'no_sp_pn')->input('text',
                                                            [
                                                            'maxlength'=> '40',]) ?>
                                                        </div>
                                                        <div class="col-md-2"  style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                            <?php
                                                            echo $form->field($model, 'tgl_sp_pn')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                                    <?=
                                                                    $form->field($model, 'jns_penahanan_pn')->dropDownList(
                                                                            ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama'), ['prompt' => 'Pilih Jenis Tahanan',
                                                                            ]
                                                                    )
                                                                    ?>
                                                         </div>

                                                        <div class="col-md-2"  style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                        <?php echo $form->field($model, 'lokasi_pn')->input('text',
                                                            [
                                                            'maxlength'=> '40',]) ?>
                                                        </div>

                                                        <div class="col-md-2" style="margin-right: -10px; padding-right: 0px;width: 10%;">
                                                            <?php
                                                            echo $form->field($model, 'tgl_awal_pn')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>

                                                        <div class="col-md-2" >
                                                            <?php
                                                            echo $form->field($model, 'tgl_akhir_pn')->widget(DateControl::className(), [
                                                                'type' => DateControl::FORMAT_DATE,
                                                                'ajaxConversion' => false,
                                                                'options' => [
                                                                    'options' => [
                                                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                                                    ],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'startDate' => '-101y',
                                                                    ],
                                                                    'pluginEvents' => [
                                                                        "changeDate" => "function(e) {
                                                                           
                                                                            
                                                                        }",
                                                                    ],
                                                                ],
                                                            ]);
                                                            ?>
                                                        </div>
                                                         
                                                    </div>
                                                </div>

                                            </div>
                            </td>
                        </tr>
                </tbody>
            </table>
           

            </div>
        </div>






        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-12">
                    
                </div>
            </div>
         <!--   <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Penanda Tangan</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'id_penandatangan')->dropDownList(
                                    ArrayHelper::map(PdmPenandatangan::find()->where(['is_active' => '1'])->all(), 'peg_nik', 'nama'), ['prompt' => 'Pilih Penanda Tangan',
                                'id' => 'cbPenandaTangan',
                                    ]
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div> -->
            <div class="col-md-12 ">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Upload File</label>

                        <div class="col-md-6">
                             <?php 
                        // echo '<label class="control-label col-md-4">Upload Document</label>';
                             $preview = "";
                             if($model->upload_file!="")
                             {
                                /*$preview =  ["<a href='".$model->upload_file."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"];*/
                                echo '<object width="160px" id="print" height="160px" data="'.$model->upload_file.'"></object>';
                             }
                             

                                echo FileInput::widget([
                                    'name' => 'attachment_3',
                                    'id'   =>  'filePicker1',
                                    'pluginOptions' => [
                                            'showPreview' => true,
                                            'showCaption' => true,
                                            'showRemove' => true,
                                            'showUpload' => false,
                                             'initialPreview' =>  $preview
                                            
                                        ],
                                    
                                ]);
                                ?>
                            <!-- <a href="<?= $model->upload_file?>">Lihat File</a>
                            <input id="filePicker" type="file" /> -->
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                <?= $form->field($model, 'warganegara')->hiddenInput() ?>
                <?= $form->field($model, 'id_penandatangan')->hiddenInput() ?>
                <?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>
                <?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>
                <?= $form->field($model, 'foto')->hiddenInput()?>
                <?= $form->field($model, 'upload_file')->hiddenInput()?>
                </div>
            </div>
        </div>
    </div>




    <div class="box-footer" style="text-align: center;">
        <?php
        // echo $form->field($modeljaksi, 'nip')->hiddenInput();
        // echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
        // echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
        // echo Html::textInput('perkara', $id, ['id' => 'perkara', 'type' => 'hidden']);
        // echo Html::textInput('ba_15', $model->id_ba15, ['id' => 'ba_15', 'type' => 'hidden']);
        ?>
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php
        if (!$model->isNewRecord) { 
            /*echo Html::a('Cetak', ['cetak', 'no_register_perkara' => $model->no_register_perkara,'tgl_ba4'=>$model->tgl_ba4,'no_urut_tersangka'=>$model->no_urut_tersangka], ['class' => 'btn btn-warning']);*/
            ?>
            <a class="btn btn-warning" id="ctx" target="_blank">Cetak</a>
        <?php }
        ?>

        <?php ActiveForm::end(); ?>

    </div>
</section>
<?php
Modal::begin([
    'id'     => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Kewarganegaraan<button type="button" id="contoh">klik</button></h7>'

]);
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data JPU',
    'options' => [
        'data-url' => '',
    ],
]);



?> 

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataProviderJPU' => $dataProviderJPU,
])
?>

<?php
Modal::end();
?>  
<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Data Tersangka</h7>'
]);
?> 

<?php
Modal::end();
?> 
<?php 
$usia = date('Y,m,d');
$maxpendidikan = json_encode($maxPendidikan);
?>
<script type="text/javascript">


    function setup() {
            Webcam.reset();
            Webcam.attach( '#my_camera' );
        }
        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                document.getElementById('my_camera').innerHTML = '<img src="'+data_uri+'"/>';
                $('#pdmba4-foto').val(data_uri);
                $("#take_snap").hide();
                $('#run_camera').show();
            } );
        }
        var handleFileSelect1 = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);
                    document.getElementById("pdmba4-upload_file").value = mime+btoa(binaryString);
                    // window.open(mime+btoa(binaryString));
                };

                reader.readAsBinaryString(file);
            }
        };

        if (window.File && window.FileReader && window.FileList && window.Blob) {

            document.getElementById('filePicker1').addEventListener('change', handleFileSelect1, false);

        } else {
            alert('The File APIs are not fully supported in this browser.');
        }
    window.onload = function () {
        $('#ctx').on('click', function(){
            var file = '<?php echo $model->upload_file ?>';
            if(file==''){
                alert('Belum Upload File!');
                return false;
            }
            download(file, 'BA-4.pdf', 'text/pdf');
        });
        
            
        var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);

                    document.getElementById('my_camera').innerHTML = '<img src="'+mime+btoa(binaryString)+'"/>';
                    // $('#pdmba4-foto').val(data_uri);
                    document.getElementById("pdmba4-foto").value = mime+btoa(binaryString);
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


        $('.radio').css('display','inline-block');
        $(document).on('click', 'a#btn_hapus_pertanyaan', function () {
            $(this).parent().parent().remove();
            return false;
        });

            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });

        $('#btn_tambah_pertanyaan').click(function () {
            $('#tbody_pertanyaan').append(
                    '<tr>' +
                    '<td><input type="text" class="form-control" name="pertanyaan[]" > </td>' +
                    '<td><input type="text" class="form-control" name="jawaban[]" > </td>' +
                    '<td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>' +
                    '</tr>'
                    );

        });

            $('#showWn').click(function(){        
                $('#m_kewarganegaraan').html('');
                $('#m_kewarganegaraan').load('/pidum/pdm-ba4/wn');
                $('#m_kewarganegaraan').modal('show');
            });
        $(document).on('click', 'a#btn_ubah_tersangka', function () {
            $('#m_update_tersangka').modal('show');
            var data = $(this).attr('tersangka').split("#");

            $("#update_id_tersangka").val(data[0]);
            $("#update_id_perkara").val(data[1]);
            $("#update_jenis_identitas").val(data[12]);
            $("#update_no_identitas").val(data[5]);
            $("#update_nama").val(data[10]);
            $("#update_jkl > [value='" + data[11] + "']").attr("selected", "true");
            $("#update_tempat_lahir").val(data[2]);
            $("#update_tgl_lahir").val(data[3]);
            $("#update_alamat").val(data[4]);
            $("#update_warganegara").val(data[7]);
            $("#update_suku").val(data[9]);
            $("#update_pendidikan > [value='" + data[14] + "']").attr("selected", "true");
            $("#update_agama > [value='" + data[13] + "']").attr("selected", "true");
            $("#update_pekerjaan").val(data[8]);

        });


        $(document).on('click', 'a#btn_hapus_tersangka', function () {
            $(this).parent().parent().remove();
            return false;
        });

        $('#pilih-tersangka').click(function () {

            $('input:checkbox:checked').each(function (index) {
                var value = $(this).val();
                var data = value.split('#');

                $('#tbody_tersangka').append(
                        '<tr id="trtersangka' + data[0] + '">' +
                        '<td><input type="hidden" class="form-control" name="id_tersangka[]" readonly="true" value="' + data[0] + '"><input type="text" class="form-control" name="nama[]" readonly="true" value="' + data[1] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="alamat[]" readonly="true" value="' + data[2] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="pekerjaan[]" readonly="true" value="' + data[3] + '"> </td>' +
                        '<td><a class="btn btn-warning" id="btn_hapus_tersangka">Hapus</a></td>' +
                        '</tr>'
                        );
            });
            $('#m_tersangka').modal('hide');

        });
         $('#show_tersangka').click(function(){
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidum/pdm-ba4/refer-tersangka');
            $('#m_tersangka').modal('show');
                    
            });

         $('#pdmba4-tgl_lahir-disp').on('change',function(){
                var tgl = $('#pdmba4-tgl_lahir-disp').val();
                if(tgl != ''){
                    var str = tgl.split('-');
                    var firstdate=new Date(str[2],str[1],str[0]);
                    var tglKejadian =$('#pdmba4-tgl_ba4').val();
                                                        
                    var start = tglKejadian.split('-');
                    var Endate=new Date(<?php $usia ?>);
                    var today = new Date(Endate);
                    var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
                    var age = parseInt(dayDiff);
                    $('#pdmba4-umur').val(age);
                    maxpendidikan();
                }
             });    
         
         // console.log(jsonMaxUsia);
              function maxpendidikan()
              {
                var compare     = $('#pdmba4-umur').val(); 
                var jsonMaxUsia = <?php echo $maxpendidikan ?>;
                $('#pdmba4-id_pendidikan option:eq(0)').prop('disabled','true'); 
                $.each(jsonMaxUsia,function(x,y){
                    if(compare<y)
                    {
                      $('#pdmba4-id_pendidikan option:eq('+(x)+')').prop('disabled','true');  
                      $('#pdmba4-id_pendidikan option:eq('+(x)+')').css('color','red');
                    }
                    else
                    {
                      $('#pdmba4-id_pendidikan option:eq('+(x)+')').removeAttr('disabled');
                      $('#pdmba4-id_pendidikan option:eq('+(x)+')').css('color','black');
                    }
                    
                });
              }

              $('input[name="tanya_alasan"]').click(function(){
                value = $(this).val();
                if(value==2)
                    {
                        $('#pdmba4-alasan').show();
                    }
                    else
                    {
                        $('#pdmba4-alasan').hide();
                        $('#pdmba4-alasan').val("");
                    }
              });


              $('input[name="tanya_tahan"]').click(function(){
                value = $(this).val();
                if(value==1)
                    {
                        $('#body_riwayat_tahanan').show();
                    }
                    else
                    {
                        $('#body_riwayat_tahanan').hide();
                        $('#body_riwayat_tahanan input').val("");
                        $('#body_riwayat_tahanan option[value=""]').prop("selected",true);
                    }
              });

              

        $('#pdmba15-id_tersangka').change(function () {
            //alert("test");
            $.ajax({
                type: "POST",
                url: "<?= Url::to(['/pidum/pdm-ba15/tersangka']) ?>",
                data: "id=" + $(this).val() + "&id_ba15=" + $('#ba_15').val() + "&perkara=" + $('#perkara').val(),
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data == 1) {
                        bootbox.dialog({
                            message: "Data surat untuk tersangka yang Anda pilih sudah ada!",
                            title: "Peringatan",
                            buttons: {
                                success: {
                                    label: "Oke!",
                                    className: "btn-warning",
                                    callback: function () {
                                    }
                                }
                            }
                        });
                    } else {
                        $('#mstersangka-nama').val(data.nama);
                        $('#mstersangka-tmpt_lahir').val(data.tempat_lahir);
                        $('#mstersangka-tgl_lahir-disp').val(data.tanggal_lahir);
                        $('#mstersangka-id_jkl').val(data.jenis_kelamin);
                        $('#mstersangka-warganegara').val(data.warga_negara);
                        $('#mstersangka-alamat').val(data.tempat_tinggal);
                        $('#mstersangka-id_agama').val(data.agama);
                        $('#mstersangka-pekerjaan').val(data.pekerjaan);
                        $('#mstersangka-id_pendidikan').val(data.pendidikan);
                        $('#pdmperpanjangantahanan-no_surat').val(data.no_panjang);
                        $('#pdmperpanjangantahanan-tgl_surat').val(data.tgl_panjang);
                        // $('#pdmp16a-id_tersangka').val(data.id);
                    }
                }
            });
        });

    };
</script>
