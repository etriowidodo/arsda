<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was11;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'DAFTAR WAS-12 ';
$this->subtitle = 'Bantuan Penyampaian Surat Panggilan Terlapor' ;//'SURAT BANTUAN UNTUK MELAKUKAN PEMANGGILAN TERHADAP TERLAPOR';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>

<div class="lapdu-index">
     <h4><?php ?></h4>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
         <div class="btn-toolbar">
                <a class="btn btn-primary btn-sm pull-right" id="btnTambah"><i class="fa fa-envelope"> </i> Tambah Nomor </a>&nbsp;
                
         </div>
    </p>
        <?php //print_r($dataProvider); ?>
        <?php Pjax::begin(['id' => 'Was12-grid', 'timeout' => false,'formSelector' => '#searchFormWas12','enablePushState' => false]) ?>
        <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'No WAS-12',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'value' => function ($data) {
                     return $data['no_surat']; 
                  },    
                ],

                
                ['label'=>'Nama Terlapor',
                    'format'=>'raw',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'value' => function ($data) {
                    
                        $pecah=explode('#', $data['nama_pegawai_terlapor']); 
                        $result="";
                        $no=1;
                        for ($i=0; $i < count($pecah); $i++) { 
                            if(count($pecah)<=1){
                                $result .=$pecah[$i];
                            }else{
                                $result .=$no.'. '.$pecah[$i].'<br>';
                            }
                            $no++;
                        }
                     return $result; 
                  },
                ],

                ['label'=>'Nama Atasan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'value' => function ($data) {
                     return $data['kepada_was12']; 
                   },
                ], 


               ['class' => 'yii\grid\CheckboxColumn',
                'headerOptions'=>['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center; width:5%'],
                           'checkboxOptions' => function ($data) {
                            $result=json_encode($data);
                            return [ 'value'=>$data['id_was_12'],'json'=>$result,'class'=>'selection_one'];
                            },
                    ],
                 ],   

        ]); ?>
        <?php Pjax::end(); ?>
</div>

<!-- buat nomor -->

 <div class="modal fade" id="buat_nomor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <?php
                    $form = ActiveForm::begin([
                                  'action' => ['insertnomor'],
                                  'method' => 'POST',
                                  'id'=>'formint', 
                                ]);
              ?>
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
                          <input type="hidden" id="surat_was12_ins_tu" class="form-control" name="surat_was12_ins_tu" style="width: 150px;">
                          <input type="hidden" id="id_pegawai_terlapor" class="form-control" name="id_pegawai_terlapor" style="width: 150px;">
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

<script type="text/javascript">
window.onload=function(){

/*json='{"id_tingkat":"0","id_kejati":"00","id_kejari":"00","id_cabjari":"00","id_wilayah":1,
"id_level1":6,"id_level2":8,"id_level3":2,"id_level4":1,"id_was_12":1,"no_register":"Reg00190",
"no_surat":"WAS-12Bantuan AtasanA","tanggal_was12":"2017-07-12",
"perihal_was12":"Bantuan Untuk Melakukan Pemanggilan Terhadap Terlapor",
"lampiran_was12":"1","kepada_was12":"kajati aceh","di_was12":"aceh",
"nip_penandatangan":"196409291989101001","nama_penandatangan":"MARTONO, S.H., 
M.H.","pangkat_penandatangan":"","golongan_penandatangan":"",
"jabatan_penandatangan":"Inspektur I","was12_file":"16821_002K810BHFVM.jpg",
"sifat_surat":1,"jbtn_penandatangan":"","created_by":6,"created_ip":"::1",
"created_time":"2017-07-25 05:56:56","updated_by":6,"updated_ip":"::1",
"updated_time":"2017-07-25 06:43:54","nama_pegawai_terlapor":"IQBAL TAWAKAL#EDY PRIYANTO"}'*/

  $('#Mubah_undangan, #Mhapus_undangan, #btnTambah').addClass('disabled');

  $(document).on('click','#btnTambah',function(){
    var data=JSON.parse($('.selection_one:checked').attr('json'));
      if(data.sifat_surat==1){
        sifat='Biasa';
      }else if(data.sifat_surat==2){
        sifat='Segera';
      }else{
        sifat='Rahasia';
      }
    $('#surat_was12_ins_tu').val(data.id_was_12);
    $('#nomor').val(data.no_surat);
    $('#tanggal_surat').val(data.tanggal_was12);
    $('#perihal').val(data.perihal_was12);
    $('#lampiran').val(data.lampiran_was12);
    $('#kepada').val(data.kepada_was12);
    $('#di').val(data.di_was12); 

    $('#sifat').val(sifat);
    $('#buat_nomor').modal({backdrop: 'static', keyboard: false});
       
  });

  $(document).on('change','.select-on-check-all',function() {
    var c = this.checked ? true : false;
    if(c==true){
        $('tbody tr').addClass('danger');
    }else{
        $('tbody tr').removeClass('danger');
    }
    $('.selection_one').prop('checked',c);
    var x=$('.selection_one:checked').length;
    ConditionOfButton(x);
});
    
$(document).on('change','.selection_one',function() {
    var c = this.checked ? '#f00' : '#09f';
     if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
    var x=$('.selection_one:checked').length;
    ConditionOfButton(x);
});


function ConditionOfButton(n){
        if(n == 1){
           $('#Mubah_undangan, #Mhapus_undangan, #btnTambah').removeClass('disabled');
        } else if(n > 1){
           $('#Mhapus_undangan').removeClass('disabled');
           $('#Mubah_undangan,#btnTambah').addClass('disabled');
        } else{
           $('#Mubah_undangan, #Mhapus_undangan, #btnTambah').addClass('disabled');
        }
}

$(document).on("dblclick", "tr", function(e) {
              var dat = $(this).find('.selection_one').attr('json');
              var data= JSON.parse(dat);
             //  var check=JSON.parse($('.selection_oneInt').attr('json'));
              if(data.sifat_surat==1){
                sifat='Biasa';
              }else if(data.sifat_surat==2){
                sifat='Segera';
              }else{
                sifat='Rahasia';
              }
            $('#surat_was12_ins_tu').val(data.id_was_12);
            $('#nomor').val(data.no_surat);
            $('#tanggal_surat').val(data.tanggal_was12);
            $('#perihal').val(data.perihal_was12);
            $('#lampiran').val(data.lampiran_was12);
            $('#kepada').val(data.kepada_was12);
            $('#di').val(data.di_was12); 

            $('#sifat').val(sifat);
            $('#buat_nomor').modal({backdrop: 'static', keyboard: false});
    });

     
}
</script>
