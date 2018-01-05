<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was9Search;
use yii\widgets\Pjax;
use app\modules\pengawasan\components\FungsiComponent; 
use app\modules\pengawasan\models\SaksiEksternal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Was9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-9 (Surat Permintaan Keterangan Saksi)';
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was9-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right disabled" id="cetak_was9_internal"><i class="fa fa-envelope">  </i> Undang Saksi</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right disabled" id="hapus_was9_int"><i class="fa fa-trash">  </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right disabled" id="ubah_was9_int"><i class="fa fa-pencil">  </i> Ubah Saksi</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was9/createsaksi"><i class="fa fa-plus"> </i> Tambah Saksi Internal</a>
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
<!-- ///////////////////////////////////////////////////// -->
                <div class="tab-pane fade in active" id="saksi_internal">

                    <?php $form = ActiveForm::begin([
                                // 'action' => ['create'],
                                'method' => 'get',
                                'id'=>'searchFormSaksiInternal', 
                                'options'=>['name'=>'searchFormSaksiInternal'],
                                'fieldConfig' => [
                                            'options' => [
                                                'tag' => false,
                                                ],
                                            ],
                            ]); ?>
                            <div class="col-md-12">
                               <div class="form-group">
                                  <label class="control-label col-md-1">Cari</label>
                                    <div class="col-md-6 kejaksaan">
                                      <div class="form-group input-group">       
                                        <input type="text" name="cari" class="form-control">
                                      <span class="input-group-btn">
                                          <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Saksi Internal"><i class="fa fa-search"> Cari </i></button>
                                      </span>
                                    </div>
                                </div>
                              </div>
                            </div>
                    <?php ActiveForm::end(); ?>
          
                    <?php 
                    $searchModel = new Was9Search();
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

                                        ['label'=>'Panggilan Ke-',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'golongan_saksi_internal',
                                            'value' => function ($data) {
                                                $jns_saksi='Internal';
                                                $FungsiWas      =new FungsiComponent();
                                                $getPanggilan   =$FungsiWas->FunctPanggilan_saksiInt($jns_saksi,$data['id_saksi_internal'],$data['no_register']);
                                                return $getPanggilan; 
                                           //  return $data['golongan_saksi_internal'].'/'.$data['pangkat_saksi_internal']; 
                                           },
                                        ],   

                                       ['class' => 'yii\grid\CheckboxColumn',
                                        'headerOptions'=>['style'=>'text-align:center'],
                                        'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $result=json_encode($data);
                                                    $jns_saksi='Internal';
                                                    $FungsiWas      =new FungsiComponent();
                                                    $getPanggilan   =$FungsiWas->FunctPanggilan_saksiInt($jns_saksi,$data['id_saksi_internal'],$data['no_register']);
                                                    return [ 'value'=>$data['pieg_nip_baru'],'json'=>$result,'class'=>'MselectionSI_one','panggilan'=>$getPanggilan.'#'.$data['id_saksi_internal'].'#'.$data['nip'].'#'.$data['nama_saksi_internal']];
                                                    },
                                            ],
                                         ],   

                                ]); ?>
                                <?php Pjax::end(); ?>
                    
                    </div>
                </div>
                <div class="tab-pane fade" id="kepegawaian">

                    <?php $form = ActiveForm::begin([
                                // 'action' => ['create'],
                                'method' => 'get',
                                'id'=>'searchFormSaksiEksternal', 
                                'options'=>['name'=>'searchFormSaksiEksternal'],
                                'fieldConfig' => [
                                            'options' => [
                                                'tag' => false,
                                                ],
                                            ],
                            ]); ?>
                            <div class="col-md-12">
                               <div class="form-group">
                                  <label class="control-label col-md-1">Cari</label>
                                    <div class="col-md-6 kejaksaan">
                                      <div class="form-group input-group">       
                                        <input type="text" name="cari" class="form-control">
                                      <span class="input-group-btn">
                                          <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Saksi Internal"><i class="fa fa-search"> Cari </i></button>
                                      </span>
                                    </div>
                                </div>
                              </div>
                            </div>
                    <?php ActiveForm::end(); ?>
          
                    <?php 
                    $searchModel = new Was9Search();
                    $dataProviderSaskiEksternal = $searchModel->searchSaksiEksternal(Yii::$app->request->queryParams);
                    ?>
                    <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'MSaksi-eksternal-grid', 'timeout' => false,'formSelector' => '#searchFormSaksiEksternal','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                    'dataProvider'=> $dataProviderSaskiEksternal,
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'eksternal'],
                                    'columns' => [
                                        ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],
                                        
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

                                        ['label'=>'Panggilan Ke-',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'golongan_saksi_internal',
                                            'value' => function ($data) {
                                                $jns_saksi='Eksternal';
                                                $FungsiWas      =new FungsiComponent();
                                                $getPanggilan   =$FungsiWas->FunctPanggilan_saksiEks($jns_saksi,$data['id_saksi_eksternal'],$data['no_register']);
                                                return $getPanggilan; 
                                           },
                                        ],

                                       ['class' => 'yii\grid\CheckboxColumn',
                                        'headerOptions'=>['style'=>'text-align:center'],
                                        'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $result=json_encode($data);
                                                    return [ 'value'=>$data['pieg_nip_baru'],'json'=>$result,'class'=>'MselectionSE_one'];
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

<!-- modal saksi internal -->
<div class="modal fade" id="undang_internal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Saksi</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <div class="btn-toolbar">
                            <a class="btn btn-primary btn-sm pull-right" id="Mhapus_undangan_int"><i class="glyphicon glyphicon-trash"></i> Hapus</a>&nbsp;
                            <a class="btn btn-primary btn-sm pull-right" id="Mubah_undangan_int"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>&nbsp;
                            <a class="btn btn-primary btn-sm pull-right" id="Mtambah_undangan_int"><i class="glyphicon glyphicon-plus"></i> Buat Surat</a>
                        </div>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">

                            <?php 
                                $searchModel = new Was9Search();
                                $id_saksi = 0 ;
                                $dataProviderWas9Int = $searchModel->searchSaksiInt('Internal',$id_saksi);
                            ?>
                        <div id="M1" class="grid-view">
                            <?/*= GridView::widget([
                                    'dataProvider'=> $dataProviderWas9Int,
                                    'columns' => [
                                        ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],
                                        
                                        ['label'=>'Nip',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['id_saksi']; 
                                          },    
                                        ],

                                        ['label'=>'Jenis Saksi',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['jenis_saksi']; 
                                          },    
                                        ],

                                       ['class' => 'yii\grid\CheckboxColumn',
                                        'headerOptions'=>['style'=>'text-align:center'],
                                        'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $result=json_encode($data);
                                                    return [ 'value'=>$data['no_register'],'json'=>$result,'class'=>'MselectionSIn_one'];
                                                    },
                                            ],
                                         ],   

                                ]); */?>
                        </div>
                        <div class="modal-loading-new"></div>
                        <i style='color:red'>Data Dengan Nomor Surat Tidak Dapat Di Hapus</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tambah</button>
                </div>
            </div>
        </div>
</div>

<!-- modal saksi eksternal -->
<div class="modal fade" id="undang_eksternal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Saksi</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <div class="btn-toolbar">
                            <a class="btn btn-primary btn-sm pull-right" id="Mhapus_undangan_eks"><i class="glyphicon glyphicon-trash"></i> Hapus</a>&nbsp;
                            <a class="btn btn-primary btn-sm pull-right" id="Mubah_undangan_eks"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>&nbsp;
                            <a class="btn btn-primary btn-sm pull-right" id="Mtambah_undangan_eks"><i class="glyphicon glyphicon-plus"></i> Buat Surat</a>
                        </div>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                            <?php 
                                $searchModel = new Was9Search();
                                $id_saksi = 0 ;
                                $dataProviderWas9Eks = $searchModel->searchSaksiEks('Eksternal',$id_saksi);
                           ?>
                        <div id="M2" class="grid-view">
                            <?/*= GridView::widget([
                                    'dataProvider'=> $dataProviderWas9Eks,
                                    'columns' => [
                                        ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],
                                        
                                        ['label'=>'Nama Saksi',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['nama_saksi_eksternal']; 
                                          },    
                                        ],

                                       ['class' => 'yii\grid\CheckboxColumn',
                                        'headerOptions'=>['style'=>'text-align:center'],
                                        'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $result=json_encode($data);
                                                    return [ 'value'=>$data['no_register'],'json'=>$result,'class'=>'MselectionSI_one'];
                                                    },
                                            ],
                                         ],   

                                ]);*/ ?>
                            
                        </div>
                        <div class="modal-loading-new"></div>
                        <i style='color:red'>Data Dengan Nomor Surat Tidak Dapat Di Hapus</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tambah</button>
                </div>
            </div>
        </div>
</div>


<!-- bagian uabah -->
<!-- modal saksi internal -->
<div id="Mubah_internal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lebar">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ubah Saksi Internal</h4>
      </div>
      <div class="modal-body">
        <div class="col-md-6">
        <div class="box box-primary" style="padding: 15px 0px;margin-top:70px;">
         <?php $form = ActiveForm::begin([
                       'action' => ['updateinternal'],
                      'method' => 'post',
                      'id'=>'searchFormUbahSaksi_Int', 
                      'options'=>['name'=>'searchFormUbahSaksi_Int'],
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
            <button type="submit" class="btn btn-default" id="Madd_internal">Ubah</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          </div>
    <?php ActiveForm::end(); ?>    
    </div>
    </div>
    <div class="col-md-6">
       <?php $form = ActiveForm::begin([
                      // 'action' => ['create'],
                      'method' => 'get',
                      'id'=>'searchFormUbahSaksiInt', 
                      'options'=>['name'=>'searchFormUbahSaksiInt'],
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
            $searchModel = new Was9Search();
            $dataProviderSksiUbah = $searchModel->searchPegawai(Yii::$app->request->queryParams);
            $dataProviderSksiUbah->pagination->pageSize = 5;
            ?>
            <?php Pjax::begin(['id' => 'Msaksi_internal-ubah-grid', 'timeout' => false,'formSelector' => '#searchFormUbahSaksiInt','enablePushState' => false]) ?>
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
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" id="Madd_internal">Tambah</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>

<!-- modal saksi eksternal -->
<div class="modal fade" id="Mubah_eksternal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Saksi Eksternal</h4>
                </div>
        <?php $form = ActiveForm::begin([
                      'action' => ['updateeksternal'],
                      'method' => 'POST',
                      'id'=>'searchFormUbahSaksi_Eks', 
                      'options'=>['name'=>'searchFormUbahSaksi_Eks'],
                      'fieldConfig' => [
                                  'options' => [
                                      'tag' => false,
                                      ],
                                  ],
                  ]); ?>
                          
        <div class="modal-body">
            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
                <div class="form-group">
                    <label class="control-label col-md-5">Nama</label>
                    <div class="col-md-7 kejaksaan">
                        <input id="Mnama_eks" class="form-control" name="Mnama_eks" maxlength="20" type="text">
                        <input class="form-control" id="Mid_eks" name="Mid_eks" value="" type="hidden">
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
                <div class="form-group">
                    <label class="control-label col-md-5">Tempat Lahir</label>
                    <div class="col-md-7 kejaksaan">
                        <input id="Mtempat_eks" class="form-control" name="Mtempat_eks" maxlength="60" type="text">
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
                <div class="form-group">
                        <label class="control-label col-md-5">Tanggal Lahir</label>
                    <div class="col-md-7 kejaksaan">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input id="Mtanggal_eks" class="form-control" name="Mtanggal_eks" value="" type="text">
                            </div>
                    </div>
                </div>
            </div>

             <div class="col-md-6" style="margin:4px 0px 4px 0px;">
              <div class="form-group">
                <label class="control-label col-md-5">Warganegara</label>
                <div class="col-md-7 kejaksaan">
                  <div class="form-group field-saksieksternal-id_negara_saksi_eksternal">
                    <select id="Mwarga_eks" class="form-control" name="Mwarga_eks">
                    <!-- <option value="">Pilih Negara</option> -->
                    <?php
                        $connection = \Yii::$app->db;
                        $warga      = "select * from public.ms_warganegara order by id";
                        $result     = $connection->createCommand($warga)->queryAll();
                        foreach ($result as $val) {
                            ?>
                        
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['nama']; ?></option>
                    <?        
                        }
                     ?>
                    </select>
                  </div>  
                  <div class="help-block"></div>
                </div>                
              </div>
            </div>

            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
             <div class="form-group">
                <label class="control-label col-md-5">Agama</label>
                <div class="col-md-7 kejaksaan"> 
                    <div class="form-group field-saksieksternal-id_agama_saksi_eksternal">
                         <select id="Magama_eks" class="form-control" name="Magama_eks">
                        <!--     <option value="">Pilih Agama</option> -->
                            <?php
                                $connection = \Yii::$app->db;
                                $agama      = "select * from public.ms_agama order by id_agama";
                                $result     = $connection->createCommand($agama)->queryAll();
                                foreach ($result as $val) {
                                    ?>
                                
                                <option value="<?php echo $val['id_agama']; ?>"><?php echo $val['nama']; ?></option>
                            <?        
                                }
                             ?>
                          </select>
                        <div class="help-block"></div>
                    </div>               
                </div>
             </div>
            </div>

            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
            <div class="form-group">
                <label class="control-label col-md-5">Pendidikan</label>
                  <div class="col-md-7 kejaksaan">
                    <div class="form-group field-saksieksternal-pendidikan">
                        <select id="Mpendidikan_eks" class="form-control" name="Mpendidikan_eks">
                        <!-- <option value="">Pilih Pendidikan</option> -->
                            <?php
                                $connection = \Yii::$app->db;
                                $pendk      = "select * from public.ms_pendidikan order by id_pendidikan";
                                $result     = $connection->createCommand($pendk)->queryAll();
                                foreach ($result as $val) {
                                    ?>
                                
                                <option value="<?php echo $val['id_pendidikan']; ?>"><?php echo $val['nama']; ?></option>
                            <?        
                                }
                             ?>
                          </select>   
                        <div class="help-block"></div>
                    </div>                
                </div>
            </div>
            </div>

            <div class="col-md-12" style="margin:4px 0px 4px 0px;">
            <div class="form-group">
                <label class="control-label col-md-2">Alamat</label>
                  <div class="col-md-10 kejaksaan">
                    <div class="form-group field-saksieksternal-alamat_saksi_eksternal has-success" style="margin-left:21px;">
                     <textarea id="Malamat_eks" class="form-control" name="Malamat_eks" maxlength="30"> 
                     </textarea>
                      <div class="help-block"></div>
                    </div>                
                  </div>
            </div> 
            </div>

            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
            <div class="form-group">
                <label class="control-label col-md-5">Kota</label>
                 <div class="col-md-7 kejaksaan">
                  <div class="form-group field-saksieksternal-nama_kota_saksi_eksternal">
                    <input id="Mkota_eks" class="form-control" name="Mkota_eks" maxlength="30" type="text">
                    <div class="help-block"></div>
                   </div>                
                 </div>
            </div> 
            </div>

            <div class="col-md-6" style="margin:4px 0px 4px 0px;">
            <div class="form-group">
                <label class="control-label col-md-5">Pekerjaan</label>
                  <div class="col-md-7 kejaksaan">
                    <div class="form-group field-saksieksternal-pekerjaan_saksi_eksternal">
                        <input id="Mkerja_eks" class="form-control" name="Mkerja_eks" maxlength="30" type="text">
                    <div class="help-block"></div>
                    </div>                
                   </div>
            </div>                  
            </div>
          <div class="clearfix"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-default" >Simpan</button>
          </div>   
      </div>
          <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>


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

 
        $(document).on('click','#Msaksi_internal',function(){
                $('.role').html("<a class='btn btn-primary btn-sm pull-right disabled' id='cetak_was9_internal'><i class='fa fa-envelope'>  </i> Undang Saksi</a>&nbsp;"+
                      "<a class='btn btn-primary btn-sm pull-right disabled' id='hapus_was9_int'><i class='fa fa-trash'>  </i> Hapus</a>&nbsp;"+
                      "<a class='btn btn-primary btn-sm pull-right disabled' id='ubah_was9_int'><i class='fa fa-pencil'>  </i> Ubah Saksi</a>&nbsp;"+
                      "<a class='btn btn-primary btn-sm pull-right' href='/pengawasan/was9/createsaksi'><i class='fa fa-plus'> </i> Tambah Saksi Internal</a>");
                $('.select-on-check-all').prop('checked',false);
                $('.MselectionSI_one').prop('checked',false);
                $('.MselectionSE_one').prop('checked',false);
                $('tbody tr').removeClass('danger');    

            }); 
        $(document).on('click','#Msaksi_eksternal',function(){
                $('.role').html("<a class='btn btn-primary btn-sm pull-right disabled' id='cetak_was9_eksternal'><i class='fa fa-envelope'>  </i> Undang Saksi</a>&nbsp;"+
                      "<a class='btn btn-primary btn-sm pull-right disabled' id='hapus_was9_eks'><i class='fa fa-trash'>  </i> Hapus</a>&nbsp;"+
                      "<a class='btn btn-primary btn-sm pull-right disabled' id='ubah_was9_eks'><i class='fa fa-pencil'>  </i> Ubah Saksi</a>&nbsp;"+
                      "<a class='btn btn-primary btn-sm pull-right' href='/pengawasan/was9/createsaksi2'><i class='fa fa-plus'> </i> Tambah Saksi Eksternal</a>");
                $('.select-on-check-all').prop('checked',false);
                $('.MselectionSI_one').prop('checked',false);
                $('.MselectionSE_one').prop('checked',false);
                $('tbody tr').removeClass('danger');    

            }); 

            


            //tombol action internal was 9 index nya//
            $(document).on('change','.select-on-check-all',function() {
                var c = this.checked ? true : false;
                if(c==true){
                    $('tbody tr').addClass('danger');
                }else{
                    $('tbody tr').removeClass('danger');
                }
                $('.MselectionSI_one').prop('checked',c);
                var x=$('.MselectionSI_one:checked').length;
                ConditionOfButtonSIindex(x);
            });
                
            $(document).on('change','.MselectionSI_one',function() {
                var c = this.checked ? '#f00' : '#09f';
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.MselectionSI_one:checked').length;
                ConditionOfButtonSIindex(x);
            });


            //tombol action eksternal was 9 index nya//
            $(document).on('change','.select-on-check-all',function() {
                var c = this.checked ? true : false;
                if(c==true){
                    $('tbody tr').addClass('danger');
                }else{
                    $('tbody tr').removeClass('danger');
                }
                $('.MselectionSI_one').prop('checked',c);
                $('.MselectionSE_one').prop('checked',c);
                var x=$('.MselectionSE_one:checked').length;
                ConditionOfButtonSEindex(x);
            });
                
            $(document).on('change','.MselectionSE_one',function() {
                var c = this.checked ? '#f00' : '#09f';
                var c = this.checked ? '#f00' : '#09f';
                if(c=='#f00'){
                    $(this).closest('tr').addClass('danger');
                }else{
                    $(this).closest('tr').removeClass('danger');
                }
                var x=$('.MselectionSE_one:checked').length;
                ConditionOfButtonSEindex(x);
            });

            function ConditionOfButtonSIindex(n){
                    if(n == 1){
                       $('#ubah_was9_int,#cetak_was9_internal, #hapus_was9_int').removeClass('disabled');
                    } else if(n > 1){
                       $('#hapus_was9_int').removeClass('disabled');
                       $('#ubah_was9_int,#cetak_was9_internal').addClass('disabled');
                    } else{
                       $('#ubah_was9_int,#cetak_was9_internal, #hapus_was9_int').addClass('disabled');
                    }
            }

            function ConditionOfButtonSEindex(n){
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
                $('.MselectionSIe_one').prop('checked',c);
                var x=$('.MselectionSIe_one:checked').length;
                ConditionOfButton1(x);
            });
                
            $(document).on('change','.MselectionSIe_one',function() {
                var c = this.checked ? '#f00' : '#09f';
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
                $('.MselectionSIe_one').prop('checked',c);
                var x=$('.MselectionSIe_one:checked').length;
                ConditionOfButtonTr1(x);
            });
                
            $(document).on('change','.MselectionSIe_one',function() {
                var c = this.checked ? '#f00' : '#09f';
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
        

        $(document).on('click','#cetak_was9_internal',function(){
            $('#undang_internal').modal({backdrop: 'static', keyboard: false});
            var check=JSON.parse($('.MselectionSI_one:checked').attr('json'));

            $('.modal-loading-new').css('display','block'); 
                $.ajax({
                    type:'POST',
                    url:'/pengawasan/was9/getsaksiint',
                    data:'jenis_saksi=Internal&id_saksi='+check.id_saksi_internal+'&nip='+check.nip+'&nm='+check.nama_saksi_internal,
                    success:function(data){
                        $('#M1').html(data);
                    },
              complete: function(){
                $('.modal-loading-new').css('display','none');
              }
                });
        });


        $(document).on('click','#cetak_was9_eksternal',function(){
            // $('#undang_eksternal').modal('show');
            $('#undang_eksternal').modal({backdrop: 'static', keyboard: false});

             var check=JSON.parse($('.MselectionSE_one:checked').attr('json'));
             // alert(check.id_saksi_eksternal); 
             // alert(check.nama_saksi_eksternal);  
             $('.modal-loading-new').css('display','block');  
                 $.ajax({
                    type:'POST',
                    url:'/pengawasan/was9/getsaksieks',
                    data:'jenis_saksi=Eksternal&id_saksi='+check.id_saksi_eksternal+'&nm='+check.nama_saksi_eksternal,
                    success:function(data){
                            $('#M2').html(data);
                        },
                    complete: function(){
                    $('.modal-loading-new').css('display','none');
              }
            });
        });

        $(document).on('click','#Mtambah_undangan_eks',function(){
            var nama = $('.Mnm_eks').val();
            var id_saksi = $('.Mid_eks').val();

            location.href='/pengawasan/was9/create?jns=Eksternal&nm='+nama+'&id_saksi='+id_saksi; 
        });     
        $(document).on('click','#Mtambah_undangan_int',function(){
            var id   = $('.Mnip_int').val();
            var nama = $('.Mnm_int').val();
            var id_saksi = $('.Mid').val();
            /*alert(id);
            alert(nama);*/
            location.href='/pengawasan/was9/create?jns=Internal&id='+id+'&nm='+nama+'&id_saksi='+id_saksi; 
        });

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

              location.href='/pengawasan/was9/update?jns=Internal&id='+data.nip+'&nm='+data.nama_saksi_internal+'&id_saksi='+data.id_saksi_internal+'&no='+data.nomor_surat_was9+'&id_was9='+data1[2];
        });

        $(document).on('click','#Mubah_undangan_eks',function(){
            var data= JSON.parse($(".MselectionSIe_one:checked").attr('json'));
            var data1= $(".MselectionSIe_one:checked").attr('surat').split('#');

             location.href='/pengawasan/was9/update?jns=Eksternal&id=&nm='+data.nama_saksi_eksternal+'&id_saksi='+data.id_saksi_eksternal+'&no='+data.nomor_surat_was9+'&id_was9='+data1[2];
        });
        
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
                                    className: "btn-primary",
                                    callback: function(){   
                                    var checkValues = $('.MselectionSIn_one:checked').map(function()
                                    {
                                         return $(this).attr('surat');
                                    }).get();
                                  
                                    $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was9/deletewas9',
                                            data:'id='+checkValues,
                                            success:function(data){
                                                alert(data);
                                        }
                                        });                           
                                    }
                                },
                                tidak : {
                                    label: "Tidak",
                                    className: "btn-primary",
                                    callback: function(result){
                                        console.log(result);
                                    }
                                },
                            },
                        });
            }
        });
        
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
                                className: "btn-primary",
                                callback: function(){   
                                var checkValues = $('.MselectionSIe_one:checked').map(function()
                                    {
                                         return $(this).attr('surat');
                                    }).get();
                                  
                                    $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was9/deletewas9b',
                                            data:'id='+checkValues,
                                            success:function(data){
                                                alert(data);
                                        }
                                        });                           
                                    }
                                },
                            tidak : {
                                label: "Tidak",
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        }
    });

        $(document).on('click','#ubah_was9_int',function(){
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
            //alert(id);
        });

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

        $(document).on('click','#ubah_was9_eks',function(){
            $('#Mubah_eksternal').modal({backdrop: 'static', keyboard: false});
            var data= JSON.parse($(".MselectionSE_one:checked").attr('json'));
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
 
/////////////////////////////HAPUS SAKSI INTERNAL////////////////////////////////////////////////////    
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
                                className: "btn-primary",
                                callback: function(){   
                                var checkValues = $('.MselectionSI_one:checked').map(function()
                                {
                                     return $(this).attr('panggilan');
                                }).get();
                                $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/was9/delete',
                                        data:'id='+checkValues,
                                        success:function(data){
                                            alert(data);
                                    }
                                    });                           
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        }
    });

/////////////////////////////HAPUS SAKSI EKSTERNAL////////////////////////////////////////////////////
    $(document).on('click','#hapus_was9_eks',function(){
  
        var x=$(".MselectionSI_one:checked").length;
        var data= JSON.parse($(".MselectionSE_one:checked").attr('json'));
        var id = data.id_saksi_eksternal;
        //alert('dddd');

       // alert(x);/
         /* if(x<=0){
         return false
         }else{ */
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-primary",
                                callback: function(){   
                                var checkValues = $('.MselectionSE_one:checked').map(function()
                                {

                                     return $(this).attr('json');
                                }).get();
                                $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/was9/delete2',
                                        data:'id='+id,
                                        success:function(data){
                                            alert(data);
                                    }
                                    });                           
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        //}
    });


        $("#Mubah_undangan_int").addClass("disabled");
        $("#Mhapus_undangan_int").addClass("disabled");

        // $(document).on('change','#MselectionSIn_one',function() {
        //     var c = this.checked ? true : false;
        //     $('.MselectionSIn_one').prop('checked',c);
        //     var x=$('.MselectionSIn_one:checked').length;
        //     ConditionOfButton(x);
        // });
            
        // $(document).on('change','.MselectionSIn_one',function() {
        //     var c = this.checked ? '#f00' : '#09f';
        //     var x=$('.MselectionSIn_one:checked').length;
        //     ConditionOfButton(x);
        // });

        $(document).on('change','#MselectionSIn_one2',function() {
            var c = this.checked ? true : false;
            $('.MselectionSIn_one').prop('checked',c);
            var x=$('.MselectionSIn_one:checked').length;
            ConditionOfButtonTr(x);
        });
            
        $(document).on('change','.MselectionSIn_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.MselectionSIn_one:checked').length;
            ConditionOfButtonTr(x);
        });


        //  function ConditionOfButton(n){
        //         if(n == 1){
        //            $('#Mubah_undangan_eks, #Mhapus_undangan_eks').removeClass('disabled');
        //         } else if(n > 1){
        //            $('#Mhapus_undangan_eks').removeClass('disabled');
        //            $('#Mubah_undangan_eks').addClass('disabled');
        //         } else{
        //            $('#Mubah_undangan_eks, #Mhapus_undangan_eks').addClass('disabled');
        //         }
        // }

        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#Mubah_undangan_int, #Mhapus_undangan_int').removeClass('disabled');
                } else if(n > 1){
                   $('#Mhapus_undangan_int').removeClass('disabled');
                   $('#Mubah_undangan_int').addClass('disabled');
                } else{
                   $('#Mubah_undangan_int, #Mhapus_undangan_int').addClass('disabled');
                }
        }      
 }

  $(document).on("dblclick", "#internal tr", function(e) {
               var dat = $(this).find('.MselectionSI_one').attr('json');
                var data= JSON.parse(dat);
                 $('#Mnip').val(data.nip);
                 $('#Mnrp').val(data.nrp);
                 $('#Mnama').val(data.nama_saksi_internal);
                 $('#Mid').val(data.id_saksi_internal);
                 $('#Mjabatan').val(data.jabatan_saksi_internal);
                 $('#Mgolongan').val(data.golongan_saksi_internal);
                 $('#Mpangkat').val(data.pangkat_saksi_internal);
                 $('#Mubah_internal').modal({backdrop: 'static', keyboard: false});
    });

    $(document).on("dblclick", "#eksternal tr", function(e) {
               var dat = $(this).find('.MselectionSE_one').attr('json');
                var data= JSON.parse(dat);
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
                $('#Mubah_eksternal').modal({backdrop: 'static', keyboard: false});
    });
</script>

