<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use app\modules\pengawasan\models\PegawaiTerlaporWas10Inspeksi;
use app\modules\pengawasan\models\PemeriksaSpwas2;
use app\modules\pengawasan\models\Was10InspeksiSearch;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was10-form">


<?php $form = ActiveForm::begin([
                    'options'=>['enctype'=>'multipart/form-data'] ,
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
                ]); ?>
    <div class="box box-primary">
        <div class="box-body" style="padding:15px;">
             <?php
                if($result_expire=='0'){
                ?>
                <div class="alert alert-warning" style="margin:0 15px 15px 15px;">
                    <strong>Peringatan!</strong> . Batas Tanggal Sp-Was-2 Sudah Kadaluarsa
                </div>
                <?php
                  }
                ?>
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nomor</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'no_surat')->textInput(['readonly'=>'readonly'])->label(false);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'was10_tanggal',['addon' => ['prepend' => ['content'=>'<i class="fa fa-calendar" id="tgl_was10"></i>']]])->textInput()->label(false);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Sifat Surat</label>
                        <div class="col-md-8">
                            <?php 
                                $list = [0 => 'Pilih',
                                     1 => 'Biasa', 
                                     2 => 'Segera',
                                     3 => 'Rahasia',
                                     ];
                                     echo $form->field($model, 'sifat_surat')->dropDownList($list)->label(false);
                            ?> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-3">Perihal</label>
                        <div class="col-md-9">
                            <!-- <textarea class="form-control"></textarea> -->
                             <?= $form->field($model, 'was10_perihal')->textArea()->label(false);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-3">Lampiran</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'was10_lampiran')->textInput()->label(false);?>
                        </div>
                    </div>
                </div>
            </div><br/>

            <div class="col-md-12" style="padding:0px;">
            <div class="panel panel-primary">
                <div class="panel-heading">Terlapor</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding-top: 10px;padding-right: 0px;padding-left: 0px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kepada</label>
                            <div class="col-md-9">
                                <?php
                                $loadNip=PegawaiTerlaporWas10Inspeksi::findOne(['nip_pegawai_terlapor'=>$_GET['nip']]);
                                $model->nip_pegawai_terlapor=$loadNip['nip_pegawai_terlapor'];
                                echo '<input id="was10-nip_pegawai_terlapor" class="form-control" value="'.$loadNip['nama_pegawai_terlapor'].'" name="nama_terlpor" readonly="readonly" type="text">';
                                echo $form->field($model, 'nip_pegawai_terlapor')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Bertemu</label>
                            <div class="col-md-9">
                                <?///= $form->field($model, 'nip_pemeriksa')->textInput()->label(false);?>
                                <?php
                                echo $form->field($model, 'nip_pemeriksa')->dropDownList(
                                    ArrayHelper::map(PemeriksaSpwas2::find()->where(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                              'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                              'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                              'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->all(), 'nip_pemeriksa', 'nama_pemeriksa'), ['prompt' => 'Pilih Pemeriksa'],['width'=>'40%']
                                    )->label(false);       
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="padding-top: 10px;padding-right: 0px;padding-left: 0px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Di</label>
                            <div class="col-md-9">
                                <?php
                                echo $form->field($model, 'di_was10')->textInput()->label(false);       
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>

            <div class="col-md-12" style="padding:0px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Jadwal Kehadiran</div>
                        <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Hari</label>
                            <div class="col-md-9">
                                <?= $form->field($model, 'hari_pemeriksaan_was10')->textInput(['readonly'=>true])->label(false);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-9">
                                <?= $form->field($model, 'tanggal_pemeriksaan_was10',['addon' => ['prepend' => ['content'=>'<i class="fa fa-calendar" id="tgl_bertemu"></i>']]])->textInput()->label(false);?>
                            </div>
                        </div>
                   <!--  </div>
                    <div class="col-md-4"> -->
                        <div class="form-group">
                            <label class="control-label col-md-3">Jam</label>
                            <div class="col-md-6">
                                <?= TimePicker::widget([
                                        'name' => 'jam_pemeriksaan_was10',
                                        'pluginOptions' => [
                                            'showSeconds' => false,
                                            'showMeridian' => false,
                                            'minuteStep' => 1,
                                            'secondStep' => 5,
                                        ]
                                    ]);
                                ?>
                            </div>
                            <div class="col-md-3">
                               <?php echo $form->field($model, 'zona_waktu')->dropDownList(['WIB','WIT','WITA'])?>                             
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-9">
                                <?= $form->field($model, 'tanggal_pemeriksaan_was10',['addon' => ['prepend' => ['content'=>'<i class="fa fa-calendar" id="tgl_bertemu"></i>']]])->textInput()->label(false);?>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tempat</label>
                            <div class="col-md-9">
                                <!-- <textarea class="form-control" style="width: 500px;"></textarea> -->
                                 <?= $form->field($model, 'tempat_pemeriksaan_was10')->textArea()->label(false);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-12" style="padding:0px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Penandatangan</div>
                        <div class="panel-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">NIP</label>
                            <div class="col-md-9">
                                    <?= $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan","data-backdrop"=>"static","data-keyboard"=>"false"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly'])->label(false);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama</label>
                            <div class="col-md-9">
                                <!-- <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text"> -->
                                <?= $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">Jabatan</label>
                            <div class="col-md-9">
                                <?= $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);?>
                                <?php
                                    echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                  ?>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding:0px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Tembusan</div>
                        <div class="panel-body">
                    <div class="form-group"style="margin:10px">
                        <a class="btn btn-primary" id="hapus_tembusan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
                        <a class="btn btn-primary"  id="addtembusan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Tembusan</a><br>  
                    </div>
                    <div class="for_tembusan">
                                <?php 
                    if(!$model->isNewRecord){
                      
                        $no=1;
                        foreach ($modelTembusan as $key) {
                    ?>
                    <div class="col-md-7 <?php echo"tembusan".$key['id_tembusan_was']; ?>" style="margin-bottom: 15px" id="<?= $key['id_tembusan_was']?>">
                        <div class="col-sm-1" style="text-align:center">
                           <input type="checkbox" value="<?= $key['id_tembusan_was']?>" id="cekbok" class="cekbok">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly style="text-align:center;">
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="pejabat" name="pejabat[]" value="<?php echo $key['tembusan']?>">
                        </div>
                    </div>
                    <?php 
                    $no++;
                            }
                        }else{ 

                            $no_2=1;
                            foreach ($modelTembusanMaster as $valueTembusanAwal) {   
                          ?>

                      <div class="col-md-7 <?php echo"tembusan".$valueTembusanAwal['id_tembusan']; ?>" style="margin-bottom: 15px" id="<?= $valueTembusanAwal['id_tembusan']?>">
                          <div class="col-sm-1" style="text-align:center">
                             <input type="checkbox" value="<?= $valueTembusanAwal['id_tembusan']?>" id="cekbok" class="cekbok">
                          </div>
                          <div class="col-sm-2">
                              <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly style="text-align:center;">
                          </div>
                          <div class="col-sm-9">
                              <input type="text" class="form-control" id="pejabat" name="pejabat[]" value="<?php echo $valueTembusanAwal['nama_tembusan']?>">
                          </div>
                      </div>
                      <?php
                       $no_2++;
                          }
                        }
                      ?>
                  </div>
                </div>
            </div>
        </div>

        <?php if(!$model->isNewRecord) { ?>
        <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas WAS-10 :
                    <?php if (substr($model->was10_file,-3)!='pdf'){?>
                        <?= ($model['was10_file']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_was10='.$model['id_surat_was10'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['was10_file']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_was10='.$model['id_surat_was10'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                    <?php } ?>
                </label>
                <!-- <input type="file" name="was10_file" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="was10_file" id="was10_file" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
        <?php
        }
        ?>
        </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">

    <div class="box-footer" style="margin:10px;padding:10px;background:none;">
      <?php

      if ($model->isNewRecord){
         if($result_expire=='1'){
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
          }
       }else{
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
       }
       ?>
      <?php
      if (!$model->isNewRecord){
        echo Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/was10-inspeksi/cetakdocx', 'id' => $model->id_surat_was10], ['class' => 'btn btn-primary']);
       }
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal', ['/pengawasan/was10-inspeksi/index'], ['id' => 'KembaliSpWas1', 'class' => 'btn btn-primary']);
     ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>




<div class="modal fade" id="penandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Penandatangan</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPenandatangan', 
                                      'options'=>['name'=>'searchFormPenandatangan'],
                                      'fieldConfig' => [
                                                  'options' => [
                                                      'tag' => false,
                                                      ],
                                                  ],
                                  ]); ?>
                          <div class="col-md-12">
                             <div class="form-group">
                                <label class="control-label col-md-2">Cari</label>
                                  <div class="col-md-8 kejaksaan">
                                    <div class="form-group input-group">       
                                      <input type="text" name="cari_penandatangan" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas10 = new Was10InspeksiSearch();
                            $dataProviderPenandatangan = $searchModelWas10->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatangan,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_jabatan',
                                    ],

                                    ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabtan_asli',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?>
                        </div>
                           <div class="modal-loading-new"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_penandatangan">Tambah</button>
                </div>
            </div>
        </div>
</div>

<style type="text/css">
#grid-penandatangan_surat.loading {overflow: hidden;}
#grid-penandatangan_surat.loading .modal-loading-new {display: block;}

    fieldset.scheduler-border {
        border: 1px solid #ddd;
        margin: 0;
        padding: 10px;
    }
    legend.scheduler-border {
        border-bottom: none;
        width: inherit;
        margin: 0;
        padding: 0px 5px;
        font-size: 14px;
        font-weight: bold;
    }
    #field {
        margin-bottom:-5px;
        margin-top: 15px;
    }
    #field .input{
        height: 34px;
        border: 1px solid #ccc;
        /*width: 800px;*/
    }
    #field .btn-flat{
        border: 1px solid #ccc;
        margin-top: -3px;
    }


  /*upload file css*/
.clearfix{*zoom:1;}.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0;}
.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.btn-file{overflow:hidden;position:relative;vertical-align:middle;}.btn-file>input{position:absolute;top:0;right:0;margin:0;opacity:0;filter:alpha(opacity=0);transform:translate(-300px, 0) scale(4);font-size:23px;direction:ltr;cursor:pointer;}
.fileupload{margin-bottom:9px;}.fileupload .uneditable-input{display:inline-block;margin-bottom:0px;vertical-align:middle;cursor:text;}
.fileupload .thumbnail{overflow:hidden;display:inline-block;margin-bottom:5px;vertical-align:middle;text-align:center;}.fileupload .thumbnail>img{display:inline-block;vertical-align:middle;max-height:100%;}
.fileupload .btn{vertical-align:middle;}
.fileupload-exists .fileupload-new,.fileupload-new .fileupload-exists{display:none;}
.fileupload-inline .fileupload-controls{display:inline;}
.fileupload-new .input-append .btn-file{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
.thumbnail-borderless .thumbnail{border:none;padding:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;}
.fileupload-new.thumbnail-borderless .thumbnail{border:1px solid #ddd;}
.control-group.warning .fileupload .uneditable-input{color:#a47e3c;border-color:#a47e3c;}
.control-group.warning .fileupload .fileupload-preview{color:#a47e3c;}
.control-group.warning .fileupload .thumbnail{border-color:#a47e3c;}
.control-group.error .fileupload .uneditable-input{color:#b94a48;border-color:#b94a48;}
.control-group.error .fileupload .fileupload-preview{color:#b94a48;}
.control-group.error .fileupload .thumbnail{border-color:#b94a48;}
.control-group.success .fileupload .uneditable-input{color:#468847;border-color:#468847;}
.control-group.success .fileupload .fileupload-preview{color:#468847;}
.control-group.success .fileupload .thumbnail{border-color:#468847;}
</style>

<script type="text/javascript">
$(document).ready(function(){
// $("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
//        $('#grid-penandatangan_surat').addClass('loading');
//      }).on('pjax:success', function(){
//        $('#grid-penandatangan_surat').removeClass('loading');
//      });

/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

$('#was10inspeksi-was10_tanggal').datepicker({ 
    minDate: new Date("<?=$spWas2['tanggal_mulai_sp_was2']?>"),
    maxDate: new Date("<?=$spWas2['tanggal_akhir_sp_was2']?>")
    });
$('#was10inspeksi-tanggal_pemeriksaan_was10').datepicker({
        onSelect: function(dateText, inst) {
        var weekday=new Array(7);
        weekday[0]="Senin";
        weekday[1]="Selasa";
        weekday[2]="Rabu";
        weekday[3]="Kamis";
        weekday[4]="Jumat";
        weekday[5]="Sabtu";
        weekday[6]="Minggu";
           var date = $(this).datepicker('getDate');
           var dayOfWeek = weekday[date.getUTCDay()];
           $('#was10inspeksi-hari_pemeriksaan_was10').val(dayOfWeek);
    },
    // new Date('".$spWas1['tanggal_mulai_sp_was1']."'),
      // maxDate: new Date('".$spWas1['tanggal_akhir_sp_was1']."'),
    minDate: new Date("<?=$spWas2['tanggal_mulai_sp_was2']?>"),
    maxDate: new Date("<?=$spWas2['tanggal_akhir_sp_was2']?>")
    });
/*trigger*/
$('#tgl_bertemu').click(function(){
    $("#was10inspeksi-tanggal_pemeriksaan_was10").datepicker().focus();
});
$('#tgl_was10').click(function(){
    $("#was10inspeksi-was10_tanggal").datepicker().focus();
});

    $('#tambah-tembusan').click(function(){
        var tabel   = $('#table_tembusan > tbody').find('tr:last');         
        var newId   = (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
        $('#table_tembusan').append(
            '<tr data-id="'+newId+'">' +
            '<td class="text-center"><input type="checkbox" name="" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
            '<td><input type="text" name="" class="form-control input-sm" /></td>' +
            '<td><input type="text" name="pejabat[]" class="form-control input-sm" /> </td>' +
            '</tr>'
        );
        $("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
        $('#table_tembusan').find("input[name='']").each(function(i,v){$(v).val(i+1);});               
    });
 
});

window.onload=function(){

$(document).on('click','#addtembusan',function() {
    $('.for_tembusan').append('<div class=\"col-sm-7\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\" style=\"text-align: center\"><input type=\"checkbox\" value=\"0\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\" class=\"no_urut\" readonly></div><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"pejabat\" name=\"pejabat[]\"></div></div>');
        i = 0;
    $('.for_tembusan').find('.col-sm-7').each(function () {

        i++;
        $(this).addClass('tembusan'+i);
        $(this).find('.cekbok').val(i);
    });
    });

$(document).on('click','#hapus_tembusan',function() {
     // $('#hapus_tembusan').click(function(){
        var cek = $('.cekbok:checked').length;
         var checkValues = $('.cekbok:checked').map(function()
            {
                return $(this).val();
            }).get();
                for (var i = 0; i < cek; i++) {
                    $('.tembusan'+checkValues[i]).remove();
                };
                                
    });
$(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".selection_one:checked").attr("json"));
       $('#was10inspeksi-nip_penandatangan').val(data.nip);
       $('#was10inspeksi-nama_penandatangan').val(data.nama);
       $('#was10inspeksi-jabatan_penandatangan').val(data.nama_jabatan);
       $('#was10inspeksi-jabtan_asli').val(data.jabtan_asli);
       $('#penandatangan').modal('hide');
                                
    });

$(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat').removeClass('loading');
    });
$(document).on('click','.cari_ttd',function() { 
    $('#grid-penandatangan_surat').addClass('loading');
    $("#grid-penandatangan_surat").load("/pengawasan/was10-inspeksi/getttd",function(responseText, statusText, xhr)
        {
            if(statusText == "success")
                     $('#grid-penandatangan_surat').removeClass('loading');
            if(statusText == "error")
                    alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
        });
  });

$(document).on('hidden.bs.modal','#penandatangan', function (e) {
  $(this)
    .find("input[name=cari_penandatangan]")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

}
</script>