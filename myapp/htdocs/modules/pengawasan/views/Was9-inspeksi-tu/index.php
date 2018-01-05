<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was9_InspeksiTuSearch;
use yii\widgets\Pjax;
use app\modules\pengawasan\components\FungsiComponent; 
use app\modules\pengawasan\models\SaksiEksternal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was9-Inspeksi';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="was9-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_was9_internal"><i class="glyphicon glyphicon-plus"> </i> Tambah Nomor</a>
        </div>
    </p>
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading single-project-nav">
            <ul class="nav nav-tabs"> 
                <li class="active">
                    <a href="#saksi_internal" data-toggle="tab" id="Msaksi_internal">Saksi Internal</a>
                </li>
                <li>
                    <a href="#kepegawaian" data-toggle="tab" id="Msaksi_eksternal">Saksi Eksternal</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
<!-- /////////////////////SAKSI INTERNAL FORM INDEX//////////////////////////////// -->
                 <div class="tab-pane fade in active" id="saksi_internal">
                    <?php 
                    $searchModel = new Was9_InspeksiTuSearch();
                    $dataProviderSaskiInternal = $searchModel->searchSaksiInternal(Yii::$app->request->queryParams);
                    ?>
                    <div id="w0" class="grid-view">
                        <?php Pjax::begin(['id' => 'MSaksi-internal-grid', 'timeout' => false,'formSelector' => '#searchFormSaksiInternal','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                    'dataProvider'=> $dataProviderSaskiInternal,                          
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'internal'],
                                    'columns' => [
                                     ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],
                                        
                                        ['label'=>'No Surat',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nomor_surat_was9',
                                            'value' => function ($data) {
                                             return $data['nomor_surat_was9']; 
                                          },    
                                        ], 

                                        ['label'=>'Nip',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nip',
                                            'value' => function ($data) {
                                             return $data['nip']; 
                                          },    
                                        ],

                                        
                                        ['label'=>'Nama',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nama_saksi_internal',
                                            'value' => function ($data) {
                                             return $data['nama_saksi_internal']; 
                                          },
                                        ],

                                        ['label'=>'Jabatan',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'jabatan_saksi_internal',
                                            'value' => function ($data) {
                                             return $data['jabatan_saksi_internal']; 
                                           },
                                        ], 

                                        ['label'=>'Gol/Pangkat',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'golongan_saksi_internal',
                                            'value' => function ($data) {
                                             return $data['golongan_saksi_internal'].'/'.$data['pangkat_saksi_internal']; 
                                           },
                                        ],   

                                        ['label'=>'Nama Pemeriksa',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nama_pemeriksa',
                                             'value' => function ($data) {
                                             return $data['nama_pemeriksa']; 
                                           },
                                        ],   

                                       ['class' => 'yii\grid\CheckboxColumn',
                                        'headerOptions'=>['style'=>'text-align:center'],
                                        'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $result=json_encode($data);
                                                    $jns_saksi='Internal';
                                                    $FungsiWas      =new FungsiComponent();
                                                    $getPanggilan   =$FungsiWas->FunctPanggilan_saksiInt_ins($jns_saksi,$data['id_saksi_internal'],$data['no_register']);
                                                    return [ 'value'=>$data['pieg_nip_baru'],'json'=>$result,'class'=>'MselectionSI_one','panggilan'=>$getPanggilan.'#'.$data['id_saksi_internal'].'#'.$data['nip'].'#'.$data['nama_saksi_internal']];
                                                    },
                                            ],
                                         ],   

                                ]); ?>
                                <?php Pjax::end(); ?>
                    
                    </div>
                </div>
<!-- ///////////////////////////////////// SAKSI EKSTERNAL FORM INDEX//////////////////////////////////////////////// -->
                <div class="tab-pane fade" id="kepegawaian">
                    <?php 
                    $searchModel = new Was9_InspeksiTuSearch();
                    $dataProviderSaskiEksternal = $searchModel->searchSaksiEksternal(Yii::$app->request->queryParams);
                    ?>
                    <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'MSaksi-eksternal-grid', 'timeout' => false,'formSelector' => '#searchFormSaksiInternal','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                    'dataProvider'=> $dataProviderSaskiEksternal,
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'eksternal'],
                                    'columns' => [
                                        ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],

                                         ['label'=>'No Surat',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nomor_surat_was9',
                                            'value' => function ($data) {
                                             return $data['nomor_surat_was9']; 
                                          },    
                                        ], 
                                        
                                        ['label'=>'Nama Saksi',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['nama_saksi_eksternal']; 
                                          },    
                                        ],

                                        
                                        ['label'=>'Alamat',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['alamat_saksi_eksternal']; 
                                          },
                                        ],

                                        ['label'=>'Kota',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['nama_kota_saksi_eksternal']; 
                                           },
                                        ], 

                                        ['label'=>'Nama Pemeriksa',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nama_pemeriksa',
                                             'value' => function ($data) {
                                             return $data['nama_pemeriksa']; 
                                           },
                                        ], 

                                      /*  ['label'=>'Panggilan Ke-',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['golongan_saksi_internal'].'/'.$data['pangkat_saksi_internal']; 
                                           },
                                        ],   */

                                       ['class' => 'yii\grid\CheckboxColumn',
                                        'headerOptions'=>['style'=>'text-align:center'],
                                        'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $result=json_encode($data);
                                                    return [ 'value'=>$data['pieg_nip_baru'],'json'=>$result,'class'=>'MselectionSI_one'];
                                                    },
                                            ],
                                         ],   

                                ]); ?>
                                <?php Pjax::end(); ?>
                    
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Undang Saksi Internal -->
<!-- modal saksi internal -->
                 <?php
                  $form = ActiveForm::begin([
                                      'action' => ['insertnomor'],
                                      'method' => 'POST',
                                      'id'=>'formint', 
                                    ]);
                  ?>
<div class="modal fade" id="undang_internal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Nomor</h4>
                </div>
                  <br>
                  <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label col-md-4">Nomor Surat</label>
                          <div class="col-md-3">
                            <input type="text" id="nomor" class="form-control" name="nomor" style="width: 150px;"> 
                            <input type="hidden" id="surat_was9" class="form-control" name="surat_was9" style="width: 150px;">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label col-md-4">Tanggal Surat</label>
                          <div class="col-md-3">
                            <input type="text" id="tanggal_surat" class="form-control" name="tanggal_surat" style="width: 150px;" readonly="">  
                          </div>
                        </div>
                      </div>
                </div>
                <br> <br>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Perihal</label>
                        <div class="col-md-3">
                          <input type="text" id="perihal" class="form-control" name="perihal" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Lampiran</label>
                        <div class="col-md-3">
                          <input type="text" id="lampiran" class="form-control" name="lampiran" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div>
                </div>
                <br> <br>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Sifat Surat</label>
                        <div class="col-md-3">
                          <input type="text" id="sifat" class="form-control" name="sifat" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div> 
                </div>
                <br><br> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">Pemeriksa</div>
                          <div class="panel-body">
                              <!--<div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Kepada</label>
                                    <div class="col-md-3">
                                      <input type="text" id="kepada" class="form-control" name="kepada" style="width: 210px;" readonly=''>  
                                    </div>
                                </div>
                              </div>-->
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Bertemu</label>
                                    <div class="col-md-3">
                                      <input type="text" id="bertemu" class="form-control" name="bertemu" style="width: 210px;" readonly>  
                                    </div>
                                </div>
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Di</label>
                                  <div class="col-md-3">
                                    <input type="text" id="di" class="form-control" name="di" style="width: 210px;" readonly>  
                                  </div>
                                </div>
                              </div> 
                          </div> 
                      </div>
                  </div> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">Jadwal Kehadiran</div>
                          <div class="panel-body">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Hari</label>
                                    <div class="col-md-3">
                                      <input type="text" id="hari" class="form-control" name="hari" style="width: 210px;" readonly=''>  
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal</label>
                                    <div class="col-md-3">
                                      <input type="text" id="tanggal" class="form-control" name="tanggal" style="width: 100px;" readonly>  
                                    </div>
                                </div>
                              </div>
                              <br><br> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Tempat</label>
                                  <div class="col-md-3">
                                    
                                    <textarea id="tempat" name="tempat" style="width: 210px;" readonly=""></textarea>
                                  </div>
                                </div>
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Jam</label>
                                  <div class="col-md-3">
                                    <input type="text" id="jam" class="form-control" name="jam" style="width: 75px;" readonly>  
                                  </div>
                                </div>
                              </div> 
                          </div> 
                      </div>
                  </div> 
                <br>
                <div class="modal-footer" style="margin-top:20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-default">Simpan</button>
                </div>
            </div>
               <?php ActiveForm::end(); ?>
      </div>
  </div>

                  <?php
                  $form = ActiveForm::begin([
                                      'action' => ['insertnomoreksternal'],
                                      'method' => 'POST',
                                      'id'=>'formint', 
                                    ]);
                  ?>
<!--Alam-->
<div class="modal fade" id="undang_eksternal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Nomor</h4>
                </div>
                  <br>
                  <div class="col-md-12">
                    <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat</label>
                        <div class="col-md-3">
                          <input type="text" id="nomorek" class="form-control" name="nomor" style="width: 150px;"> 
                          <input type="hidden" id="surat_was9ek" class="form-control" name="surat_was9" style="width: 150px;">
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label col-md-4">Tanggal Surat</label>
                          <div class="col-md-3">
                            <input type="text" id="tanggal_surat_ext" class="form-control" name="tanggal_surat_ext" style="width: 150px;" readonly="">  
                          </div>
                        </div>
                      </div>
                </div>
                <br> <br>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Perihal</label>
                        <div class="col-md-3">
                          <input type="text" id="perihal_ext" class="form-control" name="perihal_ext" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Lampiran</label>
                        <div class="col-md-3">
                          <input type="text" id="lampiran_ext" class="form-control" name="lampiran_ext" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div>
                </div>
                <br> <br>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Sifat Surat</label>
                        <div class="col-md-3">
                          <input type="text" id="sifat_ext" class="form-control" name="sifat_ext" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div> 
                </div>
                <br><br> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">Pemeriksa</div>
                          <div class="panel-body">
                              <!--<div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Kepada</label>
                                    <div class="col-md-3">
                                      <input type="text" id="kepada" class="form-control" name="kepada" style="width: 210px;" readonly=''>  
                                    </div>
                                </div>
                              </div>-->
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Bertemu</label>
                                    <div class="col-md-3">
                                      <input type="text" id="bertemu_ext" class="form-control" name="bertemu_ext" style="width: 210px;" readonly>  
                                    </div>
                                </div>
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Di</label>
                                  <div class="col-md-3">
                                    <input type="text" id="di_ext" class="form-control" name="di_ext" style="width: 210px;" readonly>  
                                  </div>
                                </div>
                              </div> 
                          </div> 
                      </div>
                  </div> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">Jadwal Kehadiran</div>
                          <div class="panel-body">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Hari</label>
                                    <div class="col-md-3">
                                      <input type="text" id="hari_ext" class="form-control" name="hari_ext" style="width: 210px;" readonly=''>  
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal</label>
                                    <div class="col-md-3">
                                      <input type="text" id="tanggal_ext" class="form-control" name="tanggal_ext" style="width: 100px;" readonly>  
                                    </div>
                                </div>
                              </div>
                              <br><br> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Tempat</label>
                                  <div class="col-md-3">
                                    
                                    <textarea id="tempat_ext" name="tempat_ext" style="width: 210px;" readonly=""></textarea>
                                  </div>
                                </div>
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Jam</label>
                                  <div class="col-md-3">
                                    <input type="text" id="jam_ext" class="form-control" name="jam_ext" style="width: 75px;" readonly>  
                                  </div>
                                </div>
                              </div> 
                          </div> 
                      </div>
                  </div>
                <br>
                <div class="modal-footer" style="margin-top:20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-default">Simpan</button>
                </div>
            </div>
               <?php ActiveForm::end(); ?>
      </div>
  </div>

<script type="text/javascript">

window.onload=function(){
   function select_option(i) {
      return $('#Mwarga_eks select option[value="' + i + '"]').html();
}

    $("#Mtanggal_eks").datepicker({
        maxDate: '-17y',
        beforeShow: function() {
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    }
    });

  //  $("#Mtanggal_eks").datepicker();

//});
  /*///////////////////////////////////////TOMBOL CLICK SAKSI INTERNAL/////////////////////////////////////////*/
        
        $(document).on('click','#Msaksi_internal',function(){
                $('.role').html("<a class='btn btn-primary btn-sm pull-right' id='cetak_was9_internal'><i class='glyphicon glyphicon-plus'> </i> Tambah Nomor</a>");
            }); 

         $("#ubah_was9_int").addClass("disabled");
        $("#hapus_was9_int").addClass("disabled");
        $("#cetak_was9_internal").addClass("disabled");
        $('.select-on-check-all').prop('checked',false);
        $('.MselectionSI_one').prop('checked',false);
      //  $('tbody table').addClass('eksternal');
        $('tbody tr').removeClass('danger');

        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
             if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            $('.MselectionSI_one').prop('checked',c);
            var x=$('.MselectionSI_one:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.MselectionSI_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.MselectionSI_one:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#ubah_was9_int,#cetak_was9_internal, #hapus_was9_int').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was9_int').removeClass('disabled');
                   $('#ubah_was9_int,#cetak_was9_internal').addClass('disabled');
                } else{
                   $('#ubah_was9_int,#cetak_was9_internal, #hapus_was9_int').addClass('disabled');
                }
        }

        $("#Mubah_undangan_int").addClass("disabled");
        $("#Mhapus_undangan_int").addClass("disabled");

        $(document).on('change','#MselectionSIn_one',function() {
            var c = this.checked ? true : false;
            if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            $('.MselectionSIn_one').prop('checked',c);
            var x=$('.MselectionSIn_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.MselectionSIn_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.MselectionSIn_one:checked').length;
            ConditionOfButton(x);
        });

        $(document).on('change','#MselectionSIn_one2',function() {
            var c = this.checked ? true : false;
            if(c==true){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            $('.MselectionSIn_one').prop('checked',c);
            var x=$('.MselectionSIn_one:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.MselectionSIn_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.MselectionSIn_one:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#Mubah_undangan_int, #Mhapus_undangan_int').removeClass('disabled');
                } else if(n > 1){
                   $('#Mhapus_undangan_int').removeClass('disabled');
                   $('#Mubah_undangan_int').addClass('disabled');
                } else{
                   $('#Mubah_undangan_int, #Mhapus_undangan_int').addClass('disabled');
                }
        }

         /*////////////////////////////////////UBAH SAKSI INTERNAL/////////////////////////////////*/


        $(document).on('click','#Msaksi_eksternal',function(){
            

  /*///////////////////////////////////////TOMBOL CLICK SAKSI EKSTERNAL/////////////////////////////////////////*/
            $('.role').html("<a class='btn btn-primary btn-sm pull-right' id='eksternal'><i class='glyphicon glyphicon-plus'> </i> Tambah Nomor</a>");
            //tombol action eksternal was 9//

            $("#ubah_was9_eks").addClass("disabled");
            $("#hapus_was9_eks").addClass("disabled");
            $("#cetak_was9_eksternal").addClass("disabled");

            $('.select-on-check-all').prop('checked',false);
            $('.MselectionSI_one').prop('checked',false);
          //  $('tbody table').addClass('eksternal');
            $('tbody tr').removeClass('danger');

            $(document).on('change','.select-on-check-all',function() {
                var c = this.checked ? true : false;
                if(c==true){
                    $('tbody tr').addClass('danger');
                }else{
                    $('tbody tr').removeClass('danger');
                }
                $('.MselectionSI_one').prop('checked',c);
                var x=$('.MselectionSI_one:checked').length;
                ConditionOfButtonTr(x);
            });
                
            $(document).on('change','.MselectionSI_one',function() {
                var c = this.checked ? '#f00' : '#09f';
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.MselectionSI_one:checked').length;
                ConditionOfButtonTr(x);
            });


            function ConditionOfButtonTr(n){
                    if(n == 1){
                       $('#ubah_was9_eks,#cetak_was9_eksternal, #hapus_was9_eks').removeClass('disabled');
                    } else if(n > 1){
                       $('#hapus_was9_eks').removeClass('disabled');
                       $('#ubah_was9_eks,#cetak_was9_eksternal').addClass('disabled');
                    } else{
                       $('#ubah_was9_eks,#cetak_was9_eksternal, #hapus_was9_eks').addClass('disabled');
                    }
            }

            //tombol action eksternal was 9 saksi eksternal//
            $("#Mubah_undangan_eks").addClass("disabled");
            $("#Mhapus_undangan_eks").addClass("disabled");

            $(document).on('change','#MselectionSIe_one',function() {
                var c = this.checked ? true : false;
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                $('.MselectionSIe_one').prop('checked',c);
                var x=$('.MselectionSIe_one:checked').length;
                ConditionOfButton1(x);
            });
                
            $(document).on('change','.MselectionSIe_one',function() {
                var c = this.checked ? '#f00' : '#09f';
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.MselectionSIe_one:checked').length;
                ConditionOfButton1(x);
            });
           
            function ConditionOfButton1(n){
                    if(n == 1){
                       $('#Mubah_undangan_eks, #Mhapus_undangan_eks').removeClass('disabled');
                    } else if(n > 1){
                       $('#Mhapus_undangan_eks').removeClass('disabled');
                       $('#Mubah_undangan_eks').addClass('disabled');
                    } else{
                       $('#Mubah_undangan_eks, #Mhapus_undangan_eks').addClass('disabled');
                    }
            }

             $(document).on('change','#MselectionSIe_one2',function() {
                var c = this.checked ? true : false;
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                $('.MselectionSIe_one').prop('checked',c);
                var x=$('.MselectionSIe_one:checked').length;
                ConditionOfButtonTr1(x);
            });
                
            $(document).on('change','.MselectionSIe_one',function() {
                var c = this.checked ? '#f00' : '#09f';
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.MselectionSIe_one:checked').length;
                ConditionOfButtonTr1(x);
            });


             function ConditionOfButtonTr1(n){
                    if(n == 1){
                       $('#Mubah_undangan_eks, #Mhapus_undangan_eks').removeClass('disabled');
                    } else if(n > 1){
                       $('#Mhapus_undangan_eks').removeClass('disabled');
                       $('#Mubah_undangan_eks').addClass('disabled');
                    } else{
                       $('#Mubah_undangan_eks, #Mhapus_undangan_eks').addClass('disabled');
                    }
            }




            ///////////end tombol eks///////
        }); 
}
        
    /*//////////////////////////////////////////MODAL POPUP CETAK UNDANGAN SAKSI INTERNAL///////////////////////////////////////////*/
//alam   
        $(document).on('click','#cetak_was9_internal',function(){
             var check=JSON.parse($('.MselectionSI_one:checked').attr('json'));
             if(check.sifat_was9==1){
                sifat='Biasa';
             }else if(check.sifat_was9==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             
             $('#surat_was9').val(check.id_surat_was9);
             $('#nomor').val(check.nomor_surat_was9);
             $('#tanggal_surat').val(check.tanggal_was9);
             $('#perihal').val(check.perihal_was9);
             $('#lampiran').val(check.lampiran_was9);
             $('#bertemu').val(check.nama_pemeriksa);
             $('#di').val(check.di_was9);
             $('#hari').val(check.hari_pemeriksaan_was9);
             $('#tanggal').val(check.tanggal_pemeriksaan_was9);
             $('#tempat').val(check.tempat_pemeriksaan_was9);
             $('#jam').val(check.jam_pemeriksaan_was9);
             $('#sifat').val(sifat);
             $('#undang_internal').modal({backdrop: 'static', keyboard: false});
        }); 

        $(document).on('click','#eksternal',function(){
             var check=JSON.parse($('.MselectionSI_one:checked').attr('json'));
             if(check.sifat_was9==1){
                sifat='Biasa';
             }else if(check.sifat_was9==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was9ek').val(check.id_surat_was9);
             $('#tanggal_surat_ext').val(check.tanggal_was9);
             $('#perihal_ext').val(check.perihal_was9);
             $('#lampiran_ext').val(check.lampiran_was9);
             $('#bertemu_ext').val(check.nama_pemeriksa);
             $('#di_ext').val(check.di_was9);
             $('#hari_ext').val(check.hari_pemeriksaan_was9);
             $('#tanggal_ext').val(check.tanggal_pemeriksaan_was9);
             $('#tempat_ext').val(check.tempat_pemeriksaan_was9);
             $('#jam_ext').val(check.jam_pemeriksaan_was9);
             $('#sifat_ext').val(sifat);
             $('#nomorek').val(check.nomor_surat_was9);
             $('#undang_eksternal').modal({backdrop: 'static', keyboard: false});
          
        });

        //   $(document).on('click','#Msaksi_eksternal',function(){
        //      var check=JSON.parse($('.MselectionSI_one:checked').attr('json'));
        //      $('#surat_was9').val(check.id_surat_was9);
        //      $('#nomor').val(check.nomor_surat_was9);
        //      $('#undang_eksternal').modal({backdrop: 'static', keyboard: false});
          
        // });

 /*//////////////////////////////////////////MODAL POPUP  CETAK UNDANGAN SAKSI EKSTERNAL///////////////////////////////////////////*/
          $(document).on('click','#cetak_was9_eksternal',function(){
            // $('#undang_eksternal').modal('show');
            $('#undang_eksternal').modal({backdrop: 'static', keyboard: false});

             var check=JSON.parse($('.MselectionSI_one:checked').attr('json'));
             // alert(check.id_saksi_eksternal); 
             // alert(check.nama_saksi_eksternal);  

             $.ajax({
                    type:'POST',
                    url:'/pengawasan/was9-inspeksi/getsaksieks',
                    data:'jenis_saksi=Eksternal&id_saksi='+check.id_saksi_eksternal+'&nm='+check.nama_saksi_eksternal,
                    success:function(data){
                        $('#M2').html(data);
                    }
                });
        });

        /*MODAL TAMBAH SAKSI EKSTERNAL */   
        $(document).on('click','#Mtambah_undangan_eks',function(){
            var nama = $('.Mnm_eks').val();
            var id_saksi = $('.Mid_eks').val();

            location.href='/pengawasan/was9-inspeksi/create?jns=Eksternal&nm='+nama+'&id_saksi='+id_saksi; 
        });  

        /*MODAL TAMBAH SAKSI INTERNAL */   
        $(document).on('click','#Mtambah_undangan_int',function(){
            var id   = $('.Mnip_int').val();
            var nama = $('.Mnm_int').val();
            var id_saksi = $('.Mid').val();
            // alert(id);
            // alert(nama);
            location.href='/pengawasan/was9-inspeksi/create?jns=Internal&id='+id+'&nm='+nama+'&id_saksi='+id_saksi; 
        });

        /*MODAL UBAH SAKSI INTERNAL*/
        $(document).on('click','#Mubah_undangan_int',function(){
            var data= JSON.parse($(".MselectionSIn_one:checked").attr('json'));
            var data1= $(".MselectionSIn_one:checked").attr('surat').split('#');
            // var checkValues = $('.MselectionSIn_one:checked').map(function()
            //                         {
            //                              return $(this).attr('json');
            //                         }).get();
            // var a = JSON.parse(checkValues);
            //var a = JSON.parse(checkValues[0]);
           //alert(data.nip);

              location.href='/pengawasan/was9-inspeksi/update?jns=Internal&id='+data.nip+'&nm='+data.nama_saksi_internal+'&id_saksi='+data.id_saksi_internal+'&no='+data.nomor_surat_was9+'&id_was9='+data1[2];
        });

         /*MODAL UBAH SAKSI EKSTERNAL*/
         $(document).on('click','#Mubah_undangan_eks',function(){
            var data= JSON.parse($(".MselectionSIe_one:checked").attr('json'));
            var data1= $(".MselectionSIe_one:checked").attr('surat').split('#');

             location.href='/pengawasan/was9-inspeksi/update?jns=Eksternal&id=&nm='+data.nama_saksi_eksternal+'&id_saksi='+data.id_saksi_eksternal+'&no='+data.nomor_surat_was9+'&id_was9='+data1[2];
        });

        /*///////////////////////////////////////TOMBOL UBAH SAKSI INTERNAL/////////////////////////////////////////////*/   
           $(document).on('click','#ubah_was9_int',function(){
               // alert('aaaa');
                $('#Mubah_internal').modal({backdrop: 'static', keyboard: false});
                var data= JSON.parse($(".MselectionSI_one:checked").attr('json'));
                //var id = data.id_saksi_internal;
                $('#Mnip').val(data.nip);
                $('#Mnrp').val(data.nrp);
                $('#Mnama').val(data.nama_saksi_internal);
                $('#Mid').val(data.id_saksi_internal);
                $('#Mjabatan').val(data.jabatan_saksi_internal);
                $('#Mgolongan').val(data.golongan_saksi_internal);
                $('#Mpangkat').val(data.pangkat_saksi_internal);
             //   alert(id);
            });   

        /*///////////////////////////////////////PILIH GANTI SAKSI INTERNAL/////////////////////////////////////////////*/   
           $(document).on('click','.MTpilih_terlapor',function(){
            var data= JSON.parse($(this).attr('json'));
           // alert(data.peg_nip_baru);
            //var id = data.id_saksi_internal;
            $('#Mnip').val(data.peg_nip_baru);
            $('#Mnama').val(data.nama);
            $('#Mnrp').val(data.peg_nrp);
            $('#Mjabatan').val(data.jabatan);
            $('#Mgolongan').val(data.gol_kd);
            $('#Mpangkat').val(data.gol_pangkat2);
            //alert(id);
        });

        /*///////////////////////////////////////TOMBOL UBAH SAKSI EKSTERNAL/////////////////////////////////////////////*/   
        $(document).on('click','#ubah_was9_eks',function(){
            $('#Mubah_eksternal').modal({backdrop: 'static', keyboard: false});
            var data= JSON.parse($(".MselectionSI_one:checked").attr('json'));
            //var id = data.id_saksi_internal;
     //       alert(data.nama_saksi_eksternal);
            $('#Mtempat_eks').val(data.tempat_lahir_saksi_eksternal);
            $('#Mnama_eks').val(data.nama_saksi_eksternal);
            $('#Mid_eks').val(data.id_saksi_eksternal);
            $('#Mtanggal_eks').val(data.tanggal_lahir_saksi_eksternal);
            $('#Magama_eks').val(data.id_agama_saksi_eksternal);
            $('#Mwarga_eks').val(data.id_negara_saksi_eksternal);
            $('#Mpendidikan_eks').val(data.pendidikan);
            $('#Malamat_eks').val(data.alamat_saksi_eksternal);
            $('#Mkota_eks').val(data.nama_kota_saksi_eksternal);
            $('#Mkerja_eks').val(data.pekerjaan_saksi_eksternal);

         
        });    

   
        /*///////////////////////////////////////TOMBOL HAPUS INSPEKSI INTERNAL/////////////////////////////////////////////*/   
    $(document).on('click','#hapus_was9_int',function(){
  
        var x=$(".MselectionSI_one:checked").length;
       // alert(x);/
         if(x<=0){
         return false
         }else{
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){   
                                var checkValues = $('.MselectionSI_one:checked').map(function()
                                {
                                     return $(this).attr('panggilan');
                                }).get();
                                $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/was9-inspeksi/delete',
                                        data:'id='+checkValues,
                                        success:function(data){
                                            alert(data);
                                    }
                                    });                           
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        }
    });

        /*///////////////////////////////////////TOMBOL HAPUS INSPEKSI EKSTERNAL/////////////////////////////////////////////*/   
           $(document).on('click','#hapus_was9_eks',function(){
  
        var x=$(".MselectionSI_one:checked").length;
        var data= JSON.parse($(".MselectionSI_one:checked").attr('json'));
        var id = data.id_saksi_eksternal;
      //  alert(data.id_saksi_eksternal);

       // alert(x);/
         if(x<=0){
         return false
         }else{
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){   
                                var checkValues = $('.MselectionSI_one:checked').map(function()
                                {

                                     return $(this).attr('json');
                                }).get();
                                $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/was9-inspeksi/delete2',
                                        data:'id='+id,
                                        success:function(data){
                                            alert(data);
                                    }
                                    });                           
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        }
    });



/*///////////////////////////////////////TOMBOL HAPUS WAS9 INSPEKSI INTERNAL/////////////////////////////////////////////*/   
$(document).on('click','#Mhapus_undangan_int',function(){
  
            var x=$(".MselectionSIn_one:checked").length;
            // var data= JSON.parse($(".MselectionSIn_one:checked").attr('json'));
            // var checkValues = data.id_saksi;
          
             if(x<=0){
             return false
             }else{
                 bootbox.dialog({
                            title: "Peringatan",
                            message: "Apakah anda ingin menghapus data ini?",
                            buttons:{
                                ya : {
                                    label: "Ya",
                                    className: "btn-warning",
                                    callback: function(){   
                                    var checkValues = $('.MselectionSIn_one:checked').map(function()
                                    {
                                         return $(this).attr('surat');
                                    }).get();
                                  
                                    $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was9-inspeksi/deletewas9',
                                            data:'id='+checkValues,
                                            success:function(data){
                                                alert(data);
                                        }
                                        });                           
                                    }
                                },
                                tidak : {
                                    label: "Tidak",
                                    className: "btn-warning",
                                    callback: function(result){
                                        console.log(result);
                                    }
                                },
                            },
                        });
            }
        });
        
/*///////////////////////////////////////TOMBOL HAPUS WAS9 INSPEKSI EKSTERNAL/////////////////////////////////////////////*/   
         $(document).on('click','#Mhapus_undangan_eks',function(){
  
        var x=$(".MselectionSIe_one:checked").length;
       // alert(x);/
         if(x<=0){
         return false
         }else{
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){   
                                var checkValues = $('.MselectionSIe_one:checked').map(function()
                                    {
                                         return $(this).attr('surat');
                                    }).get();
                                  
                                    $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was9-inspeksi/deletewas9b',
                                            data:'id='+checkValues,
                                            success:function(data){
                                                alert(data);
                                        }
                                        });                           
                                    }
                                },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        }
    });



$(document).ready(function(){
$('.table-bordered tr').hover(function() {
      $(this).addClass('hover');
    }, function() {
      $(this).removeClass('hover');
    });

$('.table-bordered tr').on('click', function() {
    $(this).toggleClass('click-row');
    var z=$(this).attr('class');
      if(z=='hover'){
       $(this).find('.checkbox-row').prop('checked',false);
        $("#ubah_inspektur").addClass("disabled");
        $("#hapus_inspektur").addClass("disabled");
      }else{
        $(this).find('.checkbox-row').prop('checked',true);
        $("#ubah_inspektur").removeClass("disabled");
        $("#hapus_inspektur").removeClass("disabled");
      }
});

$("#ubah_inspektur").addClass("disabled");
    $("#hapus_inspektur").addClass("disabled");

/* $('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/dipamaster/update?id="+id;
        $(location).attr('href',url);
        
    }); */

$('#ubah_inspektur').click (function (e) {
        var count =$('.checkbox-row:checked').length;
        if (count != 1 )
        {
         bootbox.dialog({
                message: "<center>Silahkan pilih hanya 1 data untuk diubah</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
        } else {
        var id = $('.checkbox-row:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/dipamaster/update?id="+id;
        $(location).attr('href',url);
        }
            
    });

$('#hapus_inspektur').click(function(){
    $('form').submit();

});

});

// $(document).on("dblclick", "#areaA tr:has(td)", function(e) {
    $(document).on("dblclick", "#internal tr", function(e) {
                var check=JSON.parse($('.MselectionSI_one').attr('json'));
             if(check.sifat_was9==1){
                sifat='Biasa';
             }else if(check.sifat_was9==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             
             $('#surat_was9').val(check.id_surat_was9);
             $('#nomor').val(check.nomor_surat_was9);
             $('#tanggal_surat').val(check.tanggal_was9);
             $('#perihal').val(check.perihal_was9);
             $('#lampiran').val(check.lampiran_was9);
             $('#bertemu').val(check.nama_pemeriksa);
             $('#di').val(check.di_was9);
             $('#hari').val(check.hari_pemeriksaan_was9);
             $('#tanggal').val(check.tanggal_pemeriksaan_was9);
             $('#tempat').val(check.tempat_pemeriksaan_was9);
             $('#jam').val(check.jam_pemeriksaan_was9);
             $('#sifat').val(sifat);
             $('#undang_internal').modal({backdrop: 'static', keyboard: false});
    });

    $(document).on("dblclick", "#eksternal tr", function(e) {
               var check=JSON.parse($('.MselectionSI_one').attr('json'));
             if(check.sifat_was9==1){
                sifat='Biasa';
             }else if(check.sifat_was9==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was9ek').val(check.id_surat_was9);
             $('#tanggal_surat_ext').val(check.tanggal_was9);
             $('#perihal_ext').val(check.perihal_was9);
             $('#lampiran_ext').val(check.lampiran_was9);
             $('#bertemu_ext').val(check.nama_pemeriksa);
             $('#di_ext').val(check.di_was9);
             $('#hari_ext').val(check.hari_pemeriksaan_was9);
             $('#tanggal_ext').val(check.tanggal_pemeriksaan_was9);
             $('#tempat_ext').val(check.tempat_pemeriksaan_was9);
             $('#jam_ext').val(check.jam_pemeriksaan_was9);
             $('#sifat_ext').val(sifat);
             $('#nomorek').val(check.nomor_surat_was9);
             $('#undang_eksternal').modal({backdrop: 'static', keyboard: false});
    });

</script>
<style type="text/css">
.panel-default > .panel-heading {
        background-color: #2a8cbd;
        color: #0f5e86;
        text-transform: uppercase;
        font-weight: 500;
    }
    .nav-tabs > li.active > a:after {
        position: absolute;
        content: " ";
        background: #2a8cbd;
        width: 12px;
        height: 12px;
        border-radius: 3px 0 0 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        box-shadow: none;
        bottom: -35%;
        right: 50%;
    }
    .nav-tabs {
        border-bottom: 0px;
    }
    .nav-tabs>li>a{
        border-radius: 0px;
        color: #fff;
        border: none!important;
    }
    .modal-lebar{
      width: 1200px;
      overflow: hidden;
    }
    .modal-lebar table{
      font-size: 12px;
    }
</style>