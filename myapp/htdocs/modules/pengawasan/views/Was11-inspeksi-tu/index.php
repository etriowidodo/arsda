<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\SaksiEksternal;
use app\modules\pengawasan\models\SaksiInternal;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-11 TU';
$this->subtitle = 'SURAT BANTUAN PENYAMPAIAN SURAT PANGGILAN SAKSI';
$session = Yii::$app->session;
// $this->params['ringkasan_perkara'] = $session->get('was_register');

//$this->params['ringkasan_perkara'] = $session->get('was_register');
//$this->params['breadcrumbs'][] = ['label' => 'Was-10', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>



<div class="was-11-index">

    
    <?php// echo $this->render('_search', ['model' => $searchModel]); 
      // print_r($searchModel);
      // exit();
    ?>

   <p>
        <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_was11_int"><i class="glyphicon glyphicon-plus"> </i> Tambah Nomor</a>
        </div>
    </p>
  
  <br /><br />
  
  <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading single-project-nav">
            <ul class="nav nav-tabs"> 
                <li class="active">
                    <a href="#saksi_internal" data-toggle="tab" id="Msaksi_internal">Saksi Internal</a>
                </li>
                <li>
                    <a href="#saksi_eksternal" data-toggle="tab" id="Msaksi_eksternal">Saksi Eksternal</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="saksi_internal">
                  <?= GridView::widget([
                    'dataProvider' => $dataProviderInt,

                    // 'filterModel' => $searchModel,
                     'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'internal'],
                     // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                         'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                         'contentOptions'=>['style'=>'text-align:center;'],            
                        'class' => 'yii\grid\SerialColumn'],

                        ['label'=>'No Surat',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'no_was_11',
                            'value' => function ($data) {
                             return $data['no_was_11']; 
                          },    
                        ], 

                        // 'header'=>'No'],
                        ['label'=>'No Register',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                         'attribute'=>'no_register',
                        ],

                         ['label' => 'Nama Saksi',
                         'format'=>'raw',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    $nm = explode('#', $data['nama_saksi']);
                                    $nama='';  
                                    $nomor = 1;
                                    for ($i=0; $i < count($nm) ; $i++) { 
                                       if(count($nm) <= 1){
                                          $nama .= $nm[$i];
                                       }else{
                                           $nama .= $nomor.' . '.$nm[$i].'<br>';
                                       }
                                     $nomor++;
                                     } 
                                    
                                    return $nama; 
                                  },
                              ],

                        ['label' => 'Jabatan Atasan',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    return $data['kepada_was11']; 
                                  },
                              ],
                        
                         
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                                'contentOptions'=>['style'=>'text-align:center;'],
                                   // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                                // you may configure additional properties here
                                   'checkboxOptions' => function ($data) {
                                    $result=json_encode($data);
                                    return ['value' => $data['id_surat_was11'],'class'=>'selection_oneInt','sts'=>'Internal','json'=>$result];
                                    },
                            ],
                          
                        ],
                     
                ]); 

                //  print_r($dataProviderInt);
                ?>

                </div>
                <div class="tab-pane fade" id="saksi_eksternal">
                  <?= GridView::widget([
                    'dataProvider' => $dataProviderEks,
                    // 'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'eksternal'],
                     // 'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['header'=>'No',
                         'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                         'contentOptions'=>['style'=>'text-align:center;'],            
                        'class' => 'yii\grid\SerialColumn'],

                        ['label'=>'No Surat',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'attribute'=>'no_was_11',
                            'value' => function ($data) {
                             return $data['no_was_11']; 
                          },    
                        ], 

                        // 'header'=>'No'],
                        ['label'=>'No Register',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                         'attribute'=>'no_register',
                        ],

                        ['label' => 'Nama Saksi',
                         'format'=>'raw',
                         'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    $nm = explode('#', $data['nama_saksi']);
                                    $nama='';  
                                    $nomor = 1;
                                    for ($i=0; $i < count($nm) ; $i++) { 
                                       if(count($nm) <= 1){
                                          $nama .= $nm[$i];
                                       }else{
                                           $nama .= $nomor.' . '.$nm[$i].'<br>';
                                       }
                                     $nomor++;
                                     } 
                                    
                                    return $nama; 
                                  },
                              ],

                        ['label' => 'Jabatan Atasan',
                        'headerOptions'=>['style'=>'text-align:center;'],            
                                  'value' => function ($data) {
                                    return $data['kepada_was11']; 
                                  },
                              ],
                        
                         
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                                'contentOptions'=>['style'=>'text-align:center;'],
                                   // 'checkboxOptions'=>['class'=>'selection_one','value'=>''],
                                // you may configure additional properties here
                                   'checkboxOptions' => function ($data) {
                                    $result=json_encode($data);
                                    return ['value' => $data['id_surat_was11'],'class'=>'selection_oneEk','sts'=>'Eksternal','json'=>$result];
                                    },
                            ],
                          
                        ],
                     
                ]); ?>
                </div>
            </div>
        </div>
  </div>      

</div>

                <?php
                  $form = ActiveForm::begin([
                                      'action' => ['insertnoint'],
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
                          <input type="hidden" id="surat_was11" class="form-control" name="surat_was11" style="width: 150px;">
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
                        <div class="col-md-3" style="padding-bottom: 10px;">
                         <!--<input type="text" id="perihal" class="form-control" name="perihal" style="width: 150px;" readonly=""> -->
                          <textarea id="perihal" class="form-control" name="perihal" style="width: 150px;" readonly=""></textarea>
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
                        <div class="col-md-3" style="padding-bottom: 10px;">
                          <input type="text" id="sifat" class="form-control" name="sifat" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div> 
                </div>
                <br><br> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">&nbsp;</div>
                          <div class="panel-body"> 
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Kepada</label>
                                    <div class="col-md-3">
                                      <input type="text" id="kepada" class="form-control" name="kepada" style="width: 210px;" readonly>  
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
                                      'action' => ['insertnoeks'],
                                      'method' => 'POST',
                                      'id'=>'formint', 
                                    ]);
                  ?>
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
                          <input type="text" id="nomor_eks" class="form-control" name="nomor_eks" style="width: 150px;"> 
                          <input type="hidden" id="surat_was11eks" class="form-control" name="surat_was11eks" style="width: 150px;">
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label col-md-4">Tanggal Surat</label>
                          <div class="col-md-3">
                            <input type="text" id="tanggal_surateks" class="form-control" name="tanggal_surateks" style="width: 150px;" readonly="">  
                          </div>
                        </div>
                      </div>
                </div>
                <br> <br>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Perihal</label>
                        <div class="col-md-3" style="padding-bottom: 10px;">
                    <!--      <input type="text" id="perihaleks" class="form-control" name="perihaleks" style="width: 150px;" readonly=""> -->
                          <textarea id="perihaleks" class="form-control" name="perihaleks" style="width: 150px;" readonly=""></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Lampiran</label>
                        <div class="col-md-3">
                          <input type="text" id="lampiraneks" class="form-control" name="lampiraneks" style="width: 150px;" readonly=""> 
                        </div>
                      </div>
                    </div>
                </div>
                <br> <br>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-4">Sifat Surat</label>
                        <div class="col-md-3"  style="padding-bottom: 10px;">
                          <input type="text" id="sifateks" class="form-control" name="sifateks" style="width: 150px;" readonly="">
                        </div>
                      </div>
                    </div> 
                </div>
                <br><br> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">&nbsp;</div>
                          <div class="panel-body"> 
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Kepada</label>
                                    <div class="col-md-3">
                                      <input type="text" id="kepadaeks" class="form-control" name="kepadaeks" style="width: 210px;" readonly>  
                                    </div>
                                </div>
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label col-md-4">Di</label>
                                  <div class="col-md-3">
                                    <input type="text" id="dieks" class="form-control" name="dieks" style="width: 210px;" readonly>  
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

<br />
<script type="text/javascript">
window.onload=function(){
       $('#cetak_was11_int').addClass('disabled');

        $(document).on('click', '#Msaksi_internal', function () {
           $('.role').html('<a class="btn btn-primary btn-sm pull-right disabled" id="cetak_was11_int"><i class="glyphicon glyphicon-plus"> </i> Tambah Nomor</a>');
            $('.selection_oneEk').prop('checked',false);
            $('.select-on-check-all').prop('checked',false);
            $('tbody tr').removeClass('danger');
        });

        $(document).on('click', '#Msaksi_eksternal', function () {
           $('.role').html('<a class="btn btn-primary btn-sm pull-right disabled" id="cetak_was11_eks"><i class="glyphicon glyphicon-plus"> </i> Tambah Nomor</a>');
            $('.selection_oneInt').prop('checked',false);
            $('.select-on-check-all').prop('checked',false);
            $('tbody tr').removeClass('danger');
        });
};
         //tombol action eksternal was 9 saksi eksternal//

            $(document).on('change','#selection_oneInt',function() {
                var c = this.checked ? true : false;
                 if(c=='#f00'){
                    $('tbody tr').addClass('danger');
                }else{
                    $('tbody tr').removeClass('danger');
                }
                $('.selection_oneInt').prop('checked',c);
                var x=$('.selection_oneEk:checked').length;
                ConditionOfButton1(x);
            });
                
            $(document).on('change','.selection_oneInt',function() {
                var c = this.checked ? '#f00' : '#09f';
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.selection_oneInt:checked').length;
                
                ConditionOfButton1(x);
            });
           
            function ConditionOfButton1(n){
                    if(n == 1){
                       $('#cetak_was11_int').removeClass('disabled');
                    } else{
                       $('#cetak_was11_int').addClass('disabled');
                    }
            }



             $(document).on('change','#selection_oneEk',function() {
                var c = this.checked ? true : false;
                if(c=='#f00'){
                    $('tbody tr').addClass('danger');
                }else{
                    $('tbody tr').removeClass('danger');
                }
                $('.selection_oneEk').prop('checked',c);
                var x=$('.selection_oneEk:checked').length;
                ConditionOfButtonTr1(x);
            });
                
            $(document).on('change','.selection_oneEk',function() {
                var c = this.checked ? '#f00' : '#09f';
                 if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.selection_oneEk:checked').length;
                ConditionOfButtonTr1(x);
            });


             function ConditionOfButtonTr1(n){
                    if(n == 1){
                       $('#cetak_was11_eks').removeClass('disabled');
                    }  else{
                       $('#cetak_was11_eks').addClass('disabled');
                    }
            }
         $(document).on('click','#cetak_was11_int',function(){
          //alert('aaaa');
             var check=JSON.parse($('.selection_oneInt:checked').attr('json'));
             if(check.sifat_surat==1){
                sifat='Biasa';
             }else if(check.sifat_surat==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was11').val(check.id_surat_was11);
             $('#nomor').val(check.no_was_11); 
             $('#tanggal_surat').val(check.tgl_was_11);
             $('#perihal').val(check.perihal);
             $('#lampiran').val(check.lampiran_was11);
             $('#kepada').val(check.kepada_was11);
             $('#di').val(check.di_was11); 

             $('#sifat').val(sifat);
             $('#undang_internal').modal({backdrop: 'static', keyboard: false});
          
        }); 

        $(document).on('click','#cetak_was11_eks',function(){
             var check=JSON.parse($('.selection_oneEk:checked').attr('json'));
            // alert(check.id_surat_was11);
            if(check.sifat_surat==1){
                sifat='Biasa';
             }else if(check.sifat_surat==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was11eks').val(check.id_surat_was11);
             $('#tanggal_surateks').val(check.tgl_was_11);
             $('#perihaleks').val(check.perihal);
             $('#lampiraneks').val(check.lampiran_was11);
             $('#kepadaeks').val(check.kepada_was11);
             $('#dieks').val(check.di_was11); 

             $('#sifateks').val(sifat);
             $('#nomor_eks').val(check.no_was_11);
             $('#undang_eksternal').modal({backdrop: 'static', keyboard: false});
          
        });

   $(document).on("dblclick", "#internal tr", function(e) {
              var dat = $(this).find('.selection_oneInt').attr('json');
              var check= JSON.parse(dat);
             //  var check=JSON.parse($('.selection_oneInt').attr('json'));
               if(check.sifat_surat==1){
                  sifat='Biasa';
               }else if(check.sifat_surat==2){
                  sifat='Segera';
               }else{
                  sifat='Rahasia';
               }
               $('#surat_was11').val(check.id_surat_was11);
               $('#nomor').val(check.no_was_11); 
               $('#tanggal_surat').val(check.tgl_was_11);
               $('#perihal').val(check.perihal);
               $('#lampiran').val(check.lampiran_was11);
               $('#kepada').val(check.kepada_was11);
               $('#di').val(check.di_was11); 

               $('#sifat').val(sifat);
               $('#undang_internal').modal({backdrop: 'static', keyboard: false});
    });

    $(document).on("dblclick", "#eksternal tr", function(e) {
              var dat = $(this).find('.selection_oneEk').attr('json');
              var check= JSON.parse(dat);  
             // var check=JSON.parse($('.selection_oneEk').attr('json'));
            // alert(check.id_surat_was11);
            if(check.sifat_surat==1){
                sifat='Biasa';
             }else if(check.sifat_surat==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was11eks').val(check.id_surat_was11);
             $('#tanggal_surateks').val(check.tgl_was_11);
             $('#perihaleks').val(check.perihal);
             $('#lampiraneks').val(check.lampiran_was11);
             $('#kepadaeks').val(check.kepada_was11);
             $('#dieks').val(check.di_was11); 

             $('#sifateks').val(sifat);
             $('#nomor_eks').val(check.no_was_11);
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
</style>





