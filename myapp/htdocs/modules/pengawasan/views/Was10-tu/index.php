<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was10TuSearch;
use yii\db\Query;
use yii\widgets\Pjax;
use app\modules\pengawasan\components\FungsiComponent; 

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-10 Surat Permintaan Keterangan Terlapor';
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="detail_terlapor"><i class="fa fa-envelope"> </i> Tambah Nomor</a>
            <!-- <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="fa fa-trash"> Hapus </i></a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur"><i class="fa fa-pencil"> Ubah </i></a>&nbsp; -->
            <!-- <a class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#create"><i class="glyphicon glyphicon-plus"> Tambah Baru</i></a> -->
           <!--  <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was10-inspeksi/form1"><i class="fa fa-plus"> </i>Was10</a> -->
        </div>
    </p>


    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div id="w0" class="grid-view">
           
            <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover', 'id' => 'terlapor'],
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                 ['label'=>'Nomor Surat',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'no_surat',    
                ],

                ['label'=>'Nama Terlapor',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama_pegawai_terlapor',    
                ],

                
                ['label'=>'NIP/NRP',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'format'=>'raw',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'contentOptions'=>['class'=>'panggilan'],
                        'value' => function ($data) {
                            return $data['nip_pegawai_terlapor'].($data['nrp_pegawai_terlapor']==''?'':'/'.$data['nrp_pegawai_terlapor']); 
                    },
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan_pegawai_terlapor',
                ], 

                ['label'=>'Panggilan Ke-',
                    'format'=>'raw',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'contentOptions'=>['class'=>'panggilan'],
                        'value' => function ($data) {
                            $FungsiWas      =new FungsiComponent();
                            $getPanggilan   =$FungsiWas->FunctPanggilanTu($data['id_pegawai_terlapor'],$data['nip_pegawai_terlapor'],$data['no_register']);
                            return $getPanggilan; 
                    },
                ],  


             ['class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'text-align:center'],
             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                       'checkboxOptions' => function ($data) {
                        $resultdata=json_encode($data);
                        $FungsiWas      =new FungsiComponent();
                        $getPanggilan   =$FungsiWas->FunctPanggilanInsTu($data['id_pegawai_terlapor'],$data['nip'],$data['no_register']);
                        return ['value' => $data['no_register'],'class'=>'selection_one','json'=>$resultdata,'panggilan'=>$getPanggilan.'#'.$data['nip_pegawai_terlapor'].'#'.$data['id_pegawai_terlapor']];
                        },
                ],
                
             ],   

        ]); ?>
        </div>
    </div>

 <!-- Modal Tambah Baru Terlapor -->
    <div class="modal fade" id="undang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Terlapor</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <div class="btn-toolbar">
                           <!--  <a class="btn btn-primary btn-sm pull-right" id="Mhapus_undangan"><i class="fa fa-trash"></i> Hapus</a>&nbsp;
                            <a class="btn btn-primary btn-sm pull-right" id="Mubah_undangan"><i class="fa fa-pencil"></i> Ubah Surat</a>&nbsp;
                            <a class="btn btn-primary btn-sm pull-right" id="Mtambah_undangan"><i class="fa fa-plus"></i> Buat Surat</a> -->
                            <a class="btn btn-primary btn-sm pull-right" id="tambah_nomor"><i class="fa fa-plus"></i> Tambah Nomor</a>
                        </div>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas10 = new Was10TuSearch();
                            $dataProviderWas10 = $searchModelWas10->searchWas10(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?= GridView::widget([
                                'dataProvider'=> $dataProviderWas10,
                                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'nomor1'],
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'No Surat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'no_surat',
                                    ],

                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Tanggal Pemeriksaan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'tanggal_pemeriksaan_was10',
                                    ],

                                    ['label'=>'Tempat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'tempat_pemeriksaan_was10',
                                    ],

                                    ['label'=>'Pemriksa',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pemeriksa',
                                    ],
                                 ],   

                            ]); ?>
                           
                        </div>
                    <div class="modal-loading-new"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Terlapor -->
    <div id="MubahTerlapor" class="modal fade" role="dialog">
       <div class="modal-dialog modal-lebar">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Pegawai Terlapor</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-6">
            <div class="box box-primary" style="padding: 15px 0px;margin-top:70px;">
             <?php $form = ActiveForm::begin([
                          'action' => ['updateterlapor'],
                          'method' => 'post',
                          'id'=>'FormUbahTerlapor', 
                          'options'=>['name'=>'FormUbahTerlapor'],
                          'fieldConfig' => [
                                      'options' => [
                                          'tag' => false,
                                          ],
                                      ],
                      ]); ?>

            <div class="col-md-12" style="margin:4px 0px 4px 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-2">NIP</label>
                        <div class="col-md-8 kejaksaan">
                          <input class="form-control" id="Mnip" name="Mnip" value="" type="text" readonly="readonly">
                          <input class="form-control" id="Mid" name="Mid" value="" type="hidden">
                          <input class="form-control" id="Mnrp" name="Mnrp" value="" type="hidden">

                        </div>
                    </div>
            </div>

            <div class="col-md-12" style="margin:4px 0px 4px 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10 kejaksaan">
                          <input class="form-control" id="Mnama" name="Mnama" value="" type="text" readonly="readonly">
                        </div>
                    </div>
            </div>

            <div class="col-md-12" style="margin:4px 0px 4px 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-2">Jabatan</label>
                        <div class="col-md-10 kejaksaan">
                          <input class="form-control" id="Mjabatan" name="Mjabatan" value="" type="text" readonly="readonly">
                        </div>
                    </div>
            </div>
                
            <div class="col-md-12" style="margin:4px 0px 4px 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-2">Golongan</label>
                        <div class="col-md-8 kejaksaan"> 
                          <input class="form-control" id="Mgolongan" name="Mgolongan" value="" type="text" readonly="readonly">
                        </div>
                    </div>
            </div>

            <div class="col-md-12" style="margin:4px 0px 4px 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-2">Pangkat</label>
                        <div class="col-md-10 kejaksaan">
                          <input class="form-control" id="Mpangkat" name="Mpangkat" value="" type="text" readonly="readonly">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" id="Madd_internal">Tambah</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              </div>
        <?php ActiveForm::end(); ?>    
        </div>
        </div>
        <div class="col-md-6">
           <?php $form = ActiveForm::begin([
                          // 'action' => ['create'],
                          'method' => 'get',
                          'id'=>'searchFormUbahTerlapor', 
                          'options'=>['name'=>'searchFormUbahTerlapor'],
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
                            <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                        </span>
                      </div>
                  </div>
                </div>
              </div>
              <?php ActiveForm::end(); ?>

          <?php
                $searchModel = new Was10TuSearch();
                $dataProviderSksiUbah = $searchModel->searchPegawai(Yii::$app->request->queryParams);
                $dataProviderSksiUbah->pagination->pageSize = 5;
                ?>
                <?php Pjax::begin(['id' => 'Msaksi_internal-ubah-grid', 'timeout' => false,'formSelector' => '#searchFormUbahTerlapor','enablePushState' => false]) ?>
                <?= GridView::widget([
                'dataProvider'=> $dataProviderSksiUbah,
                // 'filterModel' => $searchModel,
                // 'layout' => "{items}\n{pager}",
                'columns' => [
                    ['header'=>'No',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'contentOptions'=>['style'=>'text-align:center;'],
                    'class' => 'yii\grid\SerialColumn'],
                    
                    ['label'=>'Nama penandatangan',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'attribute'=>'nama',    
                    ],

                    
                    ['label'=>'NIP',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'attribute'=>'peg_nip_baru',
                    ],

                    ['label'=>'Jabatan',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'attribute'=>'jabatan',
                    ],   

                ['header'=>'Action',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:5%;text-align:center;'],
                'contentOptions' => ['style' => 'width:5%;text-align:center;'],
                        'template' => '{pilih}',
                        'buttons' => [
                            'pilih' => function ($url, $model,$key) use ($param){
                                $result=json_encode($model);
                                return Html::button('<i class="fa fa-plus"> Pilih </i>', ['class' => 'btn btn-primary btn-xs MTpilih_terlapor','json'=>$result,'data-placement'=>'left', 'title'=>'Pilih Terlapor']);
                            },
                        ]
                    ],
                    
                 ],   

            ]); ?>
            <?php Pjax::end(); ?>

        </div>
        <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>


<!--  Tambah/Ubah Nomor -->
     <?php
        $form = ActiveForm::begin([
                      'action' => ['insertnomor'],
                      'method' => 'POST',
                      'id'=>'formint', 
                    ]);
  ?>
<div class="modal fade" id="buat_nomor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                            <input type="hidden" id="surat_was10_ins_tu" class="form-control" name="surat_was10_ins_tu" style="width: 150;">
                            <input type="hidden" id="id_pegawai_terlapor" class="form-control" name="id_pegawai_terlapor" style="width: 150px;">
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="control-label col-md-4">Tanggal Surat</label>
                          <div class="col-md-3">
                            <input type="text" id="tgl_surat" class="form-control" name="tgl_surat" style="width: 150px;" readonly>  
                          </div>
                      </div>
                    </div>
                  </div> 
                  <br><br> 
                  <div class="col-md-12">
                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="control-label col-md-4">Perihal</label>
                          <div class="col-md-3">
                            <input type="text" id="perihal" class="form-control" name="perihal" style="width: 150px;" readonly>  
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="control-label col-md-4">Lampiran</label>
                          <div class="col-md-3">
                            <input type="text" id="lampiran" class="form-control" name="lampiran" style="width: 150px;" readonly>  
                          </div>
                      </div>
                    </div>
                  </div>
                  <br><br> 
                  <div class="col-md-12">
                    <div class="col-md-6">
                       <div class="form-group">
                          <label class="control-label col-md-4">Sifat Surat</label>
                          <div class="col-md-3">
                            <input type="text" id="sifat" class="form-control" name="sifat" style="width: 150px;" readonly>  
                          </div>
                      </div>
                    </div>
                     
                  </div>
                  <br><br> 
                  <div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
                      <div class="panel panel-primary">
                          <div class="panel-heading">Terlapor</div>
                          <div class="panel-body">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Kepada</label>
                                    <div class="col-md-3">
                                      <input type="text" id="kepada" class="form-control" name="kepada" style="width: 210px;" readonly=''>  
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label col-md-4">Bertemu</label>
                                    <div class="col-md-3">
                                      <input type="text" id="bertemu" class="form-control" name="bertemu" style="width: 210px;" readonly>  
                                    </div>
                                </div>
                              </div>
                              <br><br> 
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
                <div class="modal-footer col-md-12" style="margin-top:20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-default">Simpan</button>
                </div>
            </div>
               <?php ActiveForm::end(); ?>
      </div>
  </div>

    <style type="text/css">
    .modal-lebar{
      width: 1200px;
      overflow: hidden;
    }
    .modal-lebar table{
      font-size: 12px;
    }
    </style>

    <script type="text/javascript">
    $(document).ready(function(){
        localStorage.removeItem("was10_nip_terlapor");
    })
    </script>

    <script type="text/javascript">
    window.onload=function(){
        $(document).on('click','#Mubah_undangan',function() {
            var data=JSON.parse($('.Mselection_one:checked').attr('json'));
            var id_was10=data.id_surat_was10;
            var nip=$('#Mnip').val();
            var no_register=$('.Mselection_one:checked').val();
            var id_tingkat="<?php echo $_SESSION['kode_tk']?>";
            var id_kejati="<?php echo $_SESSION['kode_kejati']?>";
            var id_kejari="<?php echo $_SESSION['kode_kejari']?>";
            var id_cabjari="<?php echo $_SESSION['kode_cabjari']?>";
           // alert(nip);
            location.href='/pengawasan/was10-inspeksi/update?id='+no_register+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari+'&id_was10='+id_was10+'&nip='+nip;   
        });



        // $(document).on('click','#detail_terlapor_old',function() {
        //     var data=JSON.parse($('.selection_one:checked').attr('json'));
        //     //alert(data.id_pegawai_terlapor);
        //     $('.modal-loading-new').css('display','block');
        //      $.ajax({
        //             type:'POST',
        //             url:'/pengawasan/was10-inspeksi/getdata',
        //             data:'no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor,
        //             success:function(data){
        //                 $('#w1').html(data);
        //             }
        //             });
        //     // $('#undang').modal('show');
        //     $('#undang').modal({backdrop: 'static', keyboard: false});
        // });

         $(document).on('click','#tambah_nomor',function(){
             var check=JSON.parse($('.Mselection_one:checked').attr('json'));
             if(check.sifat_surat==1){
                sifat='Biasa';
             }else if(check.sifat_surat==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was10_tu').val(check.id_surat_was10);
             $('#nomor').val(check.no_surat);
             $('#tgl_surat').val(check.was10_tanggal);
             $('#perihal').val(check.was10_perihal);
             $('#lampiran').val(check.was10_lampiran);
             $('#sifat').val(sifat); 
             $('#kepada').val(check.nama_pegawai_terlapor);
             $('#bertemu').val(check.nama_pemeriksa);
             $('#di').val(check.tempat_pemeriksaan_was10); 
             $('#hari').val(check.hari_pemeriksaan_was10); 
             $('#tempat').val(check.tempat_pemeriksaan_was10); 
             $('#tanggal').val(check.tanggal_pemeriksaan_was10); 
             $('#jam').val(check.jam_pemeriksaan_was10); 
             $('#id_pegawai_terlapor').val(check.id_pegawai_terlapor);
             $('#buat_nomor').modal({backdrop: 'static', keyboard: false});
        });  


         $(document).on('click','#detail_terlapor_old',function() {
            var data=JSON.parse($('.selection_one:checked').attr('json'));
            location.href='/pengawasan/was10-inspeksi-tu/detail?no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor;   
            
        });

        //  $(document).on('click','#detail_terlapor',function() {
        //     var data=JSON.parse($('.selection_one:checked').attr('json'));
        //     //alert(data.id_pegawai_terlapor);
        //      $.ajax({
        //             type:'POST',
        //             url:'/pengawasan/was10-inspeksi/getdata',
        //             data:'no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor,
        //             success:function(data){
        //                 $('#w1').html(data);
        //             },
        //     complete: function(){
        //         $('.modal-loading-new').css('display','none');
        //       }
        //             });
        //     // $('#undang').modal('show');
        //     $('#undang').modal({backdrop: 'static', keyboard: false});
        // });

         $(document).on('click','#detail_terlapor',function() {
            var data=JSON.parse($('.selection_one:checked').attr('json'));
            //alert(data.id_pegawai_terlapor);
            $('.modal-loading-new').css('display','block');
             $.ajax({
                    type:'POST',
                    url:'/pengawasan/was10-tu/getdata',
                    data:'no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor,
                    success:function(data){
                        $('#w1').html(data);
                    },
                        complete: function(){
                            $('.modal-loading-new').css('display','none');
                          }
                    });
            // $('#undang').modal('show');
            $('#undang').modal({backdrop: 'static', keyboard: false});
        });


        $(document).on('click','#ubah_inspektur',function() {
            var data= JSON.parse($(".selection_one:checked").attr('json'));
            //var id = data.id_saksi_internal;
            $('#Mnip').val(data.nip_pegawai_terlapor);
            $('#Mnrp').val(data.nrp_pegawai_terlapor);
            $('#Mnama').val(data.nama_pegawai_terlapor);
            $('#Mid').val(data.id_pegawai_terlapor);
            $('#Mjabatan').val(data.jabatan_pegawai_terlapor);
            $('#Mgolongan').val(data.golongan_pegawai_terlapor);
            $('#Mpangkat').val(data.pangkat_pegawai_terlapor);
            $('#MubahTerlapor').modal({backdrop: 'static', keyboard: false});
        });

        $(document).on('click','.MTpilih_terlapor',function() {
            var data= JSON.parse($(this).attr('json'));
            //var id = data.id_saksi_internal;
            $('#Mnip').val(data.peg_nip_baru);
            $('#Mnama').val(data.nama);
            $('#Mnrp').val(data.peg_nrp);
            $('#Mjabatan').val(data.jabatan);
            $('#Mgolongan').val(data.gol_kd);
            $('#Mpangkat').val(data.gol_pangkat2);
        });

        $(document).on('click','#Mtambah_undangan',function() {
            var nip=$('#Mnip').val();
           // alert(nip);
            location.href='/pengawasan/was10-inspeksi/create?nip='+nip;   
            
        });

        $(document).on('click','#hapus_terlapor',function() {
             var checkValues = $('.selection_one:checked').map(function()
                                {
                                    return $(this).attr('panggilan');
                                }).get();
             $.ajax({
                    type:'POST',
                    url:'/pengawasan/was10/hapusterlapor',
                    data:'id='+checkValues,
                    success:function(data){
                        // $('#w1').html(data);
                        alert(data);
                    }
                    });
            
        });

        $(document).on('click','#Mhapus_undangan_old',function() {
             var checkValues = $('.Mselection_one:checked').map(function()
                                {
                                    return $(this).attr('json');
                                }).get();
             // alert(checkValues[0]);
             // alert(data.id_tingkat);
             var jml=$('.Mselection_one:checked').length;
                // var pecah=checkValues.split(',');
                for (var i = 0; i<jml; i++) {
                    var data=JSON.parse(checkValues[i]);
                    $.ajax({
                        type:'POST',
                        url:'/pengawasan/was10-inspeksi/hapusundangan',
                        data:'id='+data.id_surat_was10+'&no_register='+data.no_register,
                        success:function(data){
                            // $('#w1').html(data);
                             alert(data);
                        }
                        });

             // location.href='/pengawasan/was10/index';
                };
                $('#undang').modal('hide');
            
        });

            $(document).on('click','#Mhapus_undangan',function(){
                      
                            var x=$(".Mselection_one:checked").length;
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
                                                    var checkValues = $('.Mselection_one:checked').map(function()
                                                    {
                                                         return $(this).attr('panggilan');
                                                    }).get();
                                                    $.ajax({
                                                            type:'POST',
                                                            url:'/pengawasan/was10-inspeksi/hapusundangan',
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


        $(document).on('click','#hapus_inspektur',function(){
          
                var x=$(".selection_one:checked").length;
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
                                        var checkValues = $('.selection_one:checked').map(function()
                                        {
                                             return $(this).attr('panggilan');
                                        }).get();
                                        $.ajax({
                                                type:'POST',
                                                url:'/pengawasan/was10-inspeksi/deleteterlapor',
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

        $("#hapus_terlapor").addClass("disabled");
        $("#ubah_terlapor").addClass("disabled");
        $("#detail_terlapor").addClass("disabled");
        $("#ubah_inspektur").addClass("disabled");
        $("#hapus_inspektur").addClass("disabled");

        $("#Mubah_undangan").addClass("disabled");
        $("#Mhapus_undangan").addClass("disabled");
        $("#tambah_nomor").addClass("disabled");

        $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
            if(c==true){
                 $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            $('.selection_one').prop('checked',c);
            var x=$('.selection_one:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#ubah_terlapor,#detail_terlapor, #hapus_terlapor,#ubah_inspektur,#hapus_inspektur').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_terlapor').removeClass('disabled');
                   $('#ubah_terlapor,#detail_terlapor,#ubah_inspektur').addClass('disabled');
                } else{
                   $('#ubah_terlapor,#detail_terlapor, #hapus_terlapor,#ubah_inspektur').addClass('disabled');
                }
        }

        $(document).on('change','#Mselection_all',function() {
            var c = this.checked ? true : false;
            if(c==true){
                 $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            $('.Mselection_one').prop('checked',c);
            var x=$('.Mselection_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.Mselection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.Mselection_one:checked').length;
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#Mubah_undangan, #Mhapus_undangan, #tambah_nomor').removeClass('disabled');
                } else if(n > 1){
                   $('#Mhapus_undangan').removeClass('disabled');
                   $('#Mubah_undangan,#tambah_nomor').addClass('disabled');
                } else{
                   $('#Mubah_undangan, #Mhapus_undangan, #tambah_nomor').addClass('disabled');
                }
        }
    }

    // $(document).ready(function(){ 

    //       $('tr').dblclick(function(){
    //         var dat = $(this).find('.selection_one').attr('json');
    //         var data= JSON.parse(dat);
    //         //alert(data.id_pegawai_terlapor);
    //         $('.modal-loading-new').css('display','block');
    //          $.ajax({
    //                 type:'POST',
    //                 url:'/pengawasan/was10-inspeksi-tu/getdata',
    //                 data:'no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor,
    //                 success:function(data){
    //                     $('#w1').html(data);
    //                 },
    //                     complete: function(){
    //                         $('.modal-loading-new').css('display','none');
    //                       }
    //                 });
    //         // $('#undang').modal('show');
    //         $('#undang').modal({backdrop: 'static', keyboard: false});
    //       }); 
    //  });


      $(document).on("dblclick", "#terlapor tr", function(e) {
            var dat = $(this).find('.selection_one').attr('json');
            var data= JSON.parse(dat);
            //alert(data.id_pegawai_terlapor);
            $('.modal-loading-new').css('display','block');
             $.ajax({
                    type:'POST',
                    url:'/pengawasan/was10-tu/getdata',
                    data:'no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor,
                    success:function(data){
                        $('#w1').html(data);
                    },
                        complete: function(){
                            $('.modal-loading-new').css('display','none');
                          }
                    });
            // $('#undang').modal('show');
            $('#undang').modal({backdrop: 'static', keyboard: false});
    });

    $(document).on("dblclick", "#nomor1 tr", function(e) {
             var dat = $(this).find('.Mselection_one').attr('json');
             var check= JSON.parse(dat);   
             if(check.sifat_surat==1){
                sifat='Biasa';
             }else if(check.sifat_surat==2){
                sifat='Segera';
             }else{
                sifat='Rahasia';
             }
             $('#surat_was10_ins_tu').val(check.id_surat_was10);
             $('#nomor').val(check.no_surat);
             $('#tgl_surat').val(check.was10_tanggal);
             $('#perihal').val(check.was10_perihal);
             $('#lampiran').val(check.was10_lampiran);
             $('#sifat').val(sifat); 
             $('#kepada').val(check.nama_pegawai_terlapor);
             $('#bertemu').val(check.nama_pemeriksa);
             $('#di').val(check.tempat_pemeriksaan_was10); 
             $('#hari').val(check.hari_pemeriksaan_was10); 
             $('#tempat').val(check.tempat_pemeriksaan_was10); 
             $('#tanggal').val(check.tanggal_pemeriksaan_was10); 
             $('#jam').val(check.jam_pemeriksaan_was10); 
             $('#id_pegawai_terlapor').val(check.id_pegawai_terlapor);
             $('#buat_nomor').modal({backdrop: 'static', keyboard: false});
    });




            // var dat = $(this).find('.selection_one').attr('json');
            // var data= JSON.parse(dat);
            // alert(data.id_pegawai_terlapor);
            //  $.ajax({
            //         type:'POST',
            //         url:'/pengawasan/was10-inspeksi/getdata',
            //         data:'no_register='+data.no_register+'&id_pegawai_terlapor='+data.id_pegawai_terlapor+'&nip='+data.nip_pegawai_terlapor,
            //         success:function(data){
            //             $('#w1').html(data);
            //         }
            //     });
            // // $('#undang').modal('show');
            // $('#undang').modal({backdrop: 'static', keyboard: false});
    </script>