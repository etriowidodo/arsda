<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use kartik\widgets\TimePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
use app\modules\pengawasan\models\Was12Search;
use app\modules\pengawasan\components\FungsiComponent;
/* @var $this yii\web\View */
/* @var $model app\models\Was2 */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="was-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'was10form',
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
    <div class="box box-primary" style="padding:20px;">
        <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">No. Surat</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_surat')->textInput()?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tanggal_was12',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                       'startDate' => date('d-m-Y',strtotime($modelWas10['was10_tanggal'])),
                                    ]
                                ],
                            ]); 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-5">Sifat Surat</label>
                        <div class="col-md-7">
                            <?= $form->field($model, 'sifat_surat')->dropDownList(['1' => 'Biasa', '2' => 'Segera','3' =>'Rahasia'], ['prompt' => '--Pilih--']) ?>
                        </div>
                    </div>
                </div>
            </div>
              
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" >Perihal</label>
                        <div class="col-md-8">
                            <?
                            if($model->isNewRecord){
                            $model->perihal_was12="Bantuan Untuk Melakukan Pemanggilan Terhadap Terlapor";
                            }
                            ?>

                            <?= $form->field($model, 'perihal_was12')->textArea(['row' => 3])?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Lampiran</label>
                        <div class="col-md-8" style="right:8%">
                            <?= $form->field($model, 'lampiran_was12')->textInput()?>
                        </div>
                    </div>
                </div>
            </div>
              
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Kepada</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'kepada_was12')->textInput()?>
                        </div>
                    </div>
                </div>
               <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Di</label>
                        <div class="col-md-8" style="right:8%">
                            <?= $form->field($model, 'di_was12')->textInput()?>
                        </div>
                    </div>
                </div>
            </div>
    <div class="col-md-12" style="padding:0px;">
    <div class="panel panel-primary">
        <div class="panel-heading">Terlapor</div>
            <div class="panel-body">
                <div class="btn-toolbar" style="margin-bottom:10px">
                  <a class="btn btn-primary btn-sm pull-right" id="hapus_terlapor"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
                  <a class="btn btn-primary btn-sm pull-right" id="Tambah_terlapor"><i class="glyphicon glyphicon-plus"> Tambah</i></a>
                </div>
            
        <table class="table table-bordered">
            <thead>
                <tr>
                   <th width="4%" style="text-align:center">No</th>
                      <th style="text-align:center">NIP/NRP</th>
                      <th width="20%" style="text-align:center">Nama</th>
                      <th style="text-align:center">Jabatan</th>
                      <th style="text-align:center">Pangkat</th>
                      <th width="2%" rowspan="2" style="text-align:center"><input class="" type="checkbox" name="hapus_all" id="hapus_all"></th>
                </tr>
            </thead>
            <tbody class="bd_terlapor_tmp">
                <?php 
                 if(!$model->isNewRecord){
                    $no_1=1;
                    foreach ($modelTerlapor as $value_terlapor) { ?>
                        <tr class="trterlpaor<?php echo $value_terlapor['id_terlapor']; ?>">
                        <td style="text-align:center"><?= $no_1 ?></td>
                        <td><?= $value_terlapor['nip_pegawai_terlapor']?></td>
                        <td><?= $value_terlapor['nama_pegawai_terlapor']?></td>
                        <td><?= $value_terlapor['jabatan_pegawai_terlapor']?></td>
                        <td><?= $value_terlapor['pangkat_pegawai_terlapor']?></td>
                        <?php
                        echo "<td class='ck_bok' width='2%' style='text-align:center'><input class='td_terlapor' type='checkbox' name='ck_pr_ubah' rel='trterlpaor".$value_terlapor['id_terlapor']."' value='".$value_terlapor['id_terlapor']."'enama='".$value_terlapor['nama_pegawai_terlapor']. "'epangkat='".$value_terlapor['pangkat_pegawai_terlapor']."'enip='".$value_terlapor['nip']."'ejabatan='".$value_terlapor['jabatan_pegawai_terlapor']."'egolongan='".$value_terlapor['golongan_pegawai_terlapor']."'enrp='".$value_terlapor['nrp_pegawai_terlapor']."'></td>";
                          ?>
                        <input type="hidden" name="id_was10[]" value="<?= $value_terlapor['id_was_10']?>">
                        <input type="hidden" name="nip_pegawai_terlapor[]" class="nip_pegawai_terlapor" value="<?= $value_terlapor['nip_pegawai_terlapor']?>">
                        <input type="hidden" name="nama_pegawai_terlapor[]" class="nama_pegawai_terlapor" value="<?= $value_terlapor['nama_pegawai_terlapor']?>">
                        <input type="hidden" name="jabatan_pegawai_terlapor[]" class="jabatan_pegawai_terlapor" value="<?= $value_terlapor['jabatan_pegawai_terlapor'] ?>">
                        <input type="hidden" name="pangkat_pegawai_terlapor[]" class="pangkat_pegawai_terlapor" value="<?= $value_terlapor['pangkat_pegawai_terlapor']?>">
                        <input type="hidden" name="nrp_pegawai_terlapor[]" class="nrp_pegawai_terlapor" value="<?= $value_terlapor['nrp_pegawai_terlapor'] ?>">
                        <input type="hidden" name="golongan_pegawai_terlapor[]" class="golongan_pegawai_terlapor" value="<?= $value_terlapor['golongan_pegawai_terlapor']?>">
                      </tr>
                    <?php 
                    $no_1++;
                        }
                  }   
              ?>
            </tbody>
        </table>
        </div>
        <br>
    </div>    
    </div> 
     <?php 
     /*simpan data terlapor pada local storage*/
         if(!$model->isNewRecord){
            $fungsi=new FungsiComponent();
            $where=$fungsi->static_where();
            $connection = \Yii::$app->db;
                $sql = "select string_agg(nip_pegawai_terlapor,',') as nip_pegawai_terlapor from was.was_12_detail where no_register='".$_SESSION['was_register']."'and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_was_12='".$_GET['id']."' $where";
            $SES_nip = $connection->createCommand($sql)->queryOne();
         }
    ?>
    <div class="col-md-12" style="padding:0px;">
    <div class="panel panel-primary">
        <div class="panel-heading">Penandatangan</div>
            <div class="panel-body">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nip</label>
                        <div class="col-md-10">
                          <?php
                            echo $form->field($model, 'nip_penandatangan',['addon' => ['append' => ['content'=>Html::button('Cari', ['class'=>'btn btn-primary cari_ttd','id'=>'pilih_pegawai','data-toggle'=>'modal','data-target'=>'#penandatangan',"data-backdrop"=>"static", "data-keyboard"=>false]), 
            'asButton' => true]]])->textInput(['readonly'=>'readonly']);
                           ?>
                        </div>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                          <?php
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                           ?>
                        </div>
                    </div>  
                </div>
                <!-- sebenarnya ada penandatangan default tpi daskrimti belum tau defaultnya apa -->
                <div class="col-md-4">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-3">Jabatan</label>
                        <div class="col-md-9">
                          <?php
                              echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                              ?>
                          <?php
                           echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                              ?>

                             <?php
                               echo $form->field($model, 'pangkat_penandatangan')->hiddenInput();
                           ?>
                           <?php
                                echo $form->field($model, 'jbtn_penandatangan')->hiddenInput();
                           ?>
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
        <div class="form-group" style="padding:10px 40px 10px 40px;">
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
    <?php if(!$model->isNewRecord){ ?>
    <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
        <label>Unggah Berkas WAS-12 : 
             <?php if (substr($model->was12_file,-3)!='pdf'){?>
                <?= ($model['was12_file']!='' ? '<a href="viewpdf?id='.$model['id_was_12'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
            <?php } else{?>
                <?= ($model['was12_file']!='' ? '<a href="viewpdf?id='.$model['id_was_12'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
            <?php } ?>
        </label>
        <!-- <input type="file" name="was12_file" /> -->
        <div class="fileupload fileupload-new" data-provides="fileupload">
        <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Upload File </span>
        <span class="fileupload-exists "> Ubah File</span>         <input type="file" name="was12_file" id="was12_file" /></span>
        <span class="fileupload-preview"></span>
        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
    </div>
    </div>
    <?php
    }
    ?>

            
            
        <hr style="border-color: #c7c7c7;margin: 10px 0;">  
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
        <input type="hidden" name="print" value="0" id="print"/>
		<a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was12/cetakdocx?no_register='.$model->no_register.'&id='. $model['id_was_12'].'&id_tingkat='. $model['id_tingkat'].'&id_kejati='. $model['id_kejati'].'&id_kejari='. $model['id_kejari'].'&id_cabjari='. $model['id_cabjari']])?>"><i class="fa fa-print"></i> Cetak</a>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was12/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
        <!-- <i class="fa fa-print"><input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" /></i> -->
        </div>
    </div>
<?php ActiveForm::end(); ?>
    </div> 


<div id="terlaporWa10" class="modal fade" role="dialog">
  <div class="modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Daftar Terlapor</h4>
      </div>
      <div class="modal-body">
        <div class="box box-primary" style="padding: 15px 0px;">
           <?php $form = ActiveForm::begin([
                      // 'action' => ['create'],
                      'method' => 'get',
                      'id'=>'searchFormTerlapor', 
                      'options'=>['name'=>'searchFormTerlapor'],
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
                      <input type="text" name="cari" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Terlapor"><i class="fa fa-search"> Cari </i></button>
                    </span>
                  </div>
              </div>
            </div>
          </div>
          <?php ActiveForm::end(); ?>
          <div class="col-md-12">
            <?php
            $searchModel = new Was12Search();
            $dataProvider = $searchModel->searchTerlaporWas10(Yii::$app->request->queryParams);
            ?>
            <?php Pjax::begin(['id' => 'Mpemeriksa-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
            <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'Nip',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nip',    
                ],

                
                ['label'=>'Nama',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama_pegawai_terlapor',
                ],

                ['label'=>'Golongan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'golongan_pegawai_terlapor',
                ],

                ['label'=>'Pangkat',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'pangkat_pegawai_terlapor',
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan_pegawai_terlapor',
                ],   

                ['class' => 'yii\grid\CheckboxColumn',
                   'checkboxOptions' => function ($data) {
                    $result=json_encode($data);
                    return ['value' => $data['nip'],'class'=>'Mselection_one','json'=>$result];
                    },
                ],
                
             ],   

        ]); ?>
        <?php Pjax::end(); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="Mtambah_terlapor">Tambah</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
</div>

<div class="modal fade" id="penandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Terlapor</h4>
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
                            $searchModelWas12 = new Was12Search();
                            $dataProviderPenandatangan = $searchModelWas12->searchPenandatangan(Yii::$app->request->queryParams);
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
                                            return ['value' => $data['id_surat'],'class'=>'MPenandatangan_selection_one','json'=>$result];
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

fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
#was12-tanggal_was12-disp{
    padding: 4px;
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
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/
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
/*part localstorage*/
localStorage.removeItem("Wa12nip_terlapor");
/*ambil dari database*/
var nip_OnDB="<?=$SES_nip['nip_pegawai_terlapor']?>";
localStorage.removeItem("Wa12nip_terlapor_OnDB");
localStorage.setItem("Wa12nip_terlapor_OnDB", JSON.stringify([nip_OnDB]));

$(document).on('click','#Tambah_terlapor',function(){
    $('#terlaporWa10').modal({backdrop: 'static', keyboard: false});
});

$(document).on('click','#Mtambah_terlapor',function(){
var checkValues = $('.Mselection_one:checked').map(function()
                        {
                            return $(this).attr("json");
                        }).get();



var jml=$('.Mselection_one:checked').length;
var names=[];
var cek = JSON.parse(localStorage.getItem("Wa12nip_terlapor"));
var cek_OnDB = JSON.parse(localStorage.getItem("Wa12nip_terlapor_OnDB"));
// var data=JSON.parse($('.Mselection_one:checked').attr('json'));
for (var i = 0; i < jml; i++) {
    var trans=JSON.parse(checkValues[i]);
if(jQuery.inArray(trans.nip,cek)==-1 && jQuery.inArray(trans.nip,cek_OnDB)==-1){/*jika kondisi tidak sama maka tambahkan data*/
    $('.bd_terlapor_tmp').append('<tr>'+
            '<td></td>'+
            '<td>'+trans.nip+'</td>'+
            '<td>'+trans.nama_pegawai_terlapor+'</td>'+
            '<td>'+trans.jabatan_pegawai_terlapor+'</td>'+
            '<td>'+trans.pangkat_pegawai_terlapor+'</td>'+
            '<td><input class="selection_one" name="selection[]" value="'+trans.nip+'"  type="checkbox">'+
            '<input type="hidden" name="nip_pegawai_terlapor[]" value="'+trans.nip+'">'+
            '<input type="hidden" name="id_was10[]" value="'+trans.id_surat_was10+'">'+
            '<input type="hidden" name="golongan_pegawai_terlapor[]" value="'+trans.golongan_pegawai_terlapor+'">'+
            '<input type="hidden" name="pangkat_pegawai_terlapor[]" value="'+trans.pangkat_pegawai_terlapor+'">'+
            '<input type="hidden" name="jabatan_pegawai_terlapor[]" value="'+trans.jabatan_pegawai_terlapor+'">'+
            '</td>'+
            '</tr>');
    // names.push(trans.nip,arrnip);
}
};
var arrnip = $('.selection_one').map(function()
                                {
                                    return $(this).val();
                                }).get();
    localStorage.setItem("Wa12nip_terlapor", JSON.stringify(arrnip));

    $('#terlaporWa10').modal('hide');
}); 

$(document).on('hidden.bs.modal','#terlaporWa10', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

$(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".MPenandatangan_selection_one:checked").attr("json"));
    var jml=$(".MPenandatangan_selection_one:checked").length;
    if(jml=>1 && jml<2){
       $('#was12-nip_penandatangan').val(data.nip);
       $('#was12-nama_penandatangan').val(data.nama);
       $('#was12-jabatan_penandatangan').val(data.nama_jabatan);
       $('#was12-golongan_penandatangan').val(data.gol_kd);
       $('#was12-pangkat_penandatangan').val(data.gol_pangkat2);
        $('#was12-jbtn_penandatangan').val(data.jabtan_asli);
        
       // $('#was12-nip_penandatangan').val(data.nip);
       // $('#was12-nama_penandatangan').val(data.nama);
       // $('#was12-jabatan_penandatangan').val(data.nama_jabatan);
       $('#penandatangan').modal('hide');
    }
                                
    });

 $('#hapus_terlapor').click(function(){
        var cek = $('.selection_one:checked').length;
        $('.selection_one:checked').closest('tr').remove();
        
    }); $

/*////////////////PENANDATANGAN SURAT GRID LOADING////////////////////*/
    $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
          $('#grid-penandatangan_surat').addClass('loading');
        }).on('pjax:success', function(){
          $('#grid-penandatangan_surat').removeClass('loading');
        });

    $(document).on('click','.cari_ttd',function() { 
        $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/was12/getttd",function(responseText, statusText, xhr)
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