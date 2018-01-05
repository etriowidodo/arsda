<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was10Search;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-10 Surat Permintaan Keterangan Terlapor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="Madd_hapus_terlapor"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
            <!-- <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur" data-toggle="modal" data-target="#Mubah_terlapor"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp; -->
            <a class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#Mcreate_terlapor" data-backdrop="static" data-keyboard="false"><i class="glyphicon glyphicon-plus"> Terlapor</i></a>
            <!-- <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was-10-inspeksi/form1"><i class="glyphicon glyphicon-plus"> Terlapor</i></a> -->
        </div>
    </p>
<?php
 $form = ActiveForm::begin();
?>
<?=  $form->field($model, 'nrp_pegawai_terlapor')->hiddenInput()->label(false) ?>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div id="w0" class="grid-view">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="">
                        <th style="width: 2%;text-align: center;">#</th>
                        <th style="width: 10%;">NIP / NRP</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 5%;">Jabatan</th>
                        <th style="width: 5%;">Golongan/Pangkat</th>
                        <th style="width: 4%;text-align: center;"><input class="selection_all" name="selection_all[]" value="" type="checkbox"></th>
                    </tr>
                </thead>
                <tbody id="body_tmp_terlapor">
                    
                </tbody>
            </table>
        </div>
    </div>
    <?php
    $connection = \Yii::$app->db;
    $sql="select string_agg(nip,',') as nip from was.pegawai_terlapor_was10 where  no_register='".$_SESSION['was_register']."' AND id_tingkat = '".$_SESSION['kode_tk']."' AND id_kejati = '".$_SESSION['kode_kejati']."' AND id_kejari = '".$_SESSION['kode_kejari']."' AND id_cabjari = '".$_SESSION['kode_cabjari']."'";
    $result_terlapor = $connection->createCommand($sql)->queryOne();
    ?>
    <input type="hidden" name="tmp_nip" value="<?=$result_terlapor['nip']?>" id="tmp_nip">
    <p>
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was10/index"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Batal</a>
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary pull-right' : 'btn btn-primary pull-right'])  ?>
        </div>
    </p>
    <?php ActiveForm::end(); ?>


    <!-- Modal Tambah Baru -->
    <div class="modal fade" id="Mcreate_terlapor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Terlapor</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12" style="padding-bottom: 10px;">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active">
                                <a href="#spwas" data-toggle="tab" id="Mspwas">SP-Was-1</a>
                            </li>
                            <li>
                                <a href="#kepegawaian" data-toggle="tab" id="Mkepegawaian">KP Pegawai</a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="spwas">
                                    <?php 
                                    $searchModel = new Was10Search();
                                    $dataProvider = $searchModel->searchSpwas(Yii::$app->request->queryParams);
                                    ?>
                                <div id="w0" class="grid-view">
                                <?php Pjax::begin(['id' => 'Mterlapor-ubah-grid', 'timeout' => false,'formSelector' => '#searchFormMterlapor','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                    'dataProvider'=> $dataProvider,
                                    'columns' => [
                                        ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],
                                        
                                        ['label'=>'Nama Terlapor',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'attribute'=>'nama_pegawai_terlapor',    
                                        ],

                                        
                                        ['label'=>'NIP/NRP',
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['nip'].($data['nrp_pegawai_terlapor']==''?'':'/'.$data['nrp_pegawai_terlapor']); 
                                          },
                                        ],

                                        ['label'=>'Jabatan',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['jabatan_pegawai_terlapor']; 
                                           },
                                        ], 

                                        ['label'=>'Satker',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['satker_pegawai_terlapor']; 
                                           },
                                        ],   

                                   ['class' => 'yii\grid\CheckboxColumn',
                                    'headerOptions'=>['style'=>'text-align:center'],
                                    'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                               'checkboxOptions' => function ($data) {
                                                $result=json_encode($data);
                                                return [ 'value'=>$data['nip'],'json'=>$result,'class'=>'Mselection_one'];
                                                },
                                        ],
                                     ],   

                                ]); ?>
                                <?php Pjax::end(); ?>
                                </div>
                                <font color="red">Hanya terlapor yang memiliki nip yang bisa di tambahkan</font>
                            </div>
                            <div class="tab-pane fade" id="kepegawaian">
                                       <?php $form = ActiveForm::begin([
                                              // 'action' => ['create'],
                                              'method' => 'get',
                                              'id'=>'searchFormKpegawai', 
                                              'options'=>['name'=>'searchFormKpegawai'],
                                              'fieldConfig' => [
                                                          'options' => [
                                                              'tag' => false,
                                                              ],
                                                          ],
                                          ]); ?>
                                          <div class="col-md-12">
                                             <div class="form-group">
                                                <label class="control-label col-md-1">Cari</label>
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
                                <?php 
                                $searchModel = new Was10Search();
                                $dataProviderTerlapor = $searchModel->searchPegawai(Yii::$app->request->queryParams);
                                ?>
                                <div id="w1" class="grid-view">
                                <?php Pjax::begin(['id' => 'Mterlapor-Kpegawai-grid', 'timeout' => false,'formSelector' => '#searchFormKpegawai','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                    'dataProvider'=> $dataProviderTerlapor,
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
                                            'format'=>'raw',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['nip_nrp']; 
                                          },
                                        ],

                                        ['label'=>'Jabatan',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['jabatan']; 
                                           },
                                        ], 

                                        ['label'=>'Satker',
                                            'headerOptions'=>['style'=>'text-align:center;'],
                                            'value' => function ($data) {
                                             return $data['unitkerja_nama']; 
                                           },
                                        ],   

                                   ['class' => 'yii\grid\CheckboxColumn',
                                    'headerOptions'=>['style'=>'text-align:center'],
                                    'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                               'checkboxOptions' => function ($data) {
                                                $result=json_encode($data);
                                                return [ 'value'=>$data['peg_nip_baru'],'json'=>$result,'class'=>'MselectionKP_one'];
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
                    <input type="hidden" name="asal" id="asal" value="1" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_terlapor">Tambah</button>
                </div>
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
</style>

    <script type="text/javascript">
    $(document).ready(function(){
         localStorage.removeItem("was10_nip_terlapor");
         localStorage.removeItem("was10_nip_terlaporKp");
         localStorage.removeItem("was10_nip_OnDB");
         var nipOnDB=$('#tmp_nip').val().split(',');
         localStorage.setItem("was10_nip_OnDB", JSON.stringify(nipOnDB));

    });
    window.onload=function(){
        $('#Madd_hapus_terlapor').addClass('disabled');
            $(document).on('click','#Mspwas',function(){
                $('#asal').val(1);
            });

            $(document).on('click','#Mkepegawaian',function(){
                $('#asal').val(2);
            });

            $(document).on('click','#tambah_terlapor',function(){
            var asal=$('#asal').val();
        if(asal==1){/*jika mengambil data dari pegawai terlapor*/
            var jml=$('.Mselection_one:checked').length;
            var checkValues = $('.Mselection_one:checked').map(function()
                        {
                        return $(this).attr("json");
                        }).get();
            var arrnip = $('.Mselection_one:checked').map(function()
                        {
                        return $(this).val();
                        }).get();
                for (var i = 0; i < jml; i++) {
            var trans=JSON.parse(checkValues[i]);
            var cek = JSON.parse(localStorage.getItem("was10_nip_terlapor"));
            var cekKp = JSON.parse(localStorage.getItem("was10_nip_terlaporKp"));
            var cekOnDB = JSON.parse(localStorage.getItem("was10_nip_OnDB"));

            if(jQuery.inArray(trans.nip,cek)==-1 && trans.nip!='' && jQuery.inArray(trans.nip,cekKp)==-1 && jQuery.inArray(trans.nip,cekOnDB)==-1){/*jika data tidak ada maka tambahkan*/
            $('#body_tmp_terlapor').append('<tr>'+
              '<td></td>'+
              '<td><input type="hidden" name="nip[]" class="nip" value="'+trans['nip']+'"><input type="hidden" name="nrp[]" class="nrp" value="'+trans['nrp_pegawai_terlapor']+'">'+trans['nip']+'</td>'+
              '<td><input type="hidden" name="nama[]" class="nama" value="'+trans['nama_pegawai_terlapor']+'">'+trans['nama_pegawai_terlapor']+'</td>'+
              '<td><input type="hidden" name="jabatan[]" class="jabatan" value="'+trans['jabatan_pegawai_terlapor']+'">'+trans['jabatan_pegawai_terlapor']+'</td>'+
              '<td><input type="hidden" name="golongan[]" class="golongan" value="'+trans['pangkat_pegawai_terlapor']+'"><input type="hidden" name="pangkat[]" class="pangkat" value="'+trans['golongan_pegawai_terlapor']+'">'+trans['golongan_pegawai_terlapor']+'/'+trans['jabatan_pegawai_terlapor']+'</td>'+
              '<td style="text-align: center;"><input type="hidden" name="satker[]" class="satker" value="'+trans['satker_pegawai_terlapor']+'"><input class="selection_one" name="selection[]" value="'+trans['nip']+'" type="checkbox"></td>'+
            '</tr>');
            }
                }
            var names = arrnip;
            localStorage.setItem("was10_nip_terlapor", JSON.stringify(names));
            $('#Mcreate_terlapor').modal('hide');
        }else{ /*jika mengambil data dari Kp pegawai*/
            var jml=$('.MselectionKP_one:checked').length;
            var checkValues = $('.MselectionKP_one:checked').map(function()
                        {
                        return $(this).attr("json");
                        }).get();
            var arrnipKp = $('.MselectionKP_one:checked').map(function()
                        {
                        return $(this).val();
                        }).get();
                for (var i = 0; i < jml; i++) {
            var trans=JSON.parse(checkValues[i]);
            var cekKp = JSON.parse(localStorage.getItem("was10_nip_terlaporKp"));
            var cekOnDB = JSON.parse(localStorage.getItem("was10_nip_OnDB"));
            var cek = JSON.parse(localStorage.getItem("was10_nip_terlapor"));
           
            if(jQuery.inArray(trans.peg_nip_baru,cek)==-1 && trans.peg_nip_baru!='' && jQuery.inArray(trans.peg_nip_baru,cekKp)==-1 && jQuery.inArray(trans.peg_nip_baru,cekOnDB)==-1){/*jika data tidak ada maka tambahkan*/
            $('#body_tmp_terlapor').append('<tr>'+
              '<td></td>'+
              '<td><input type="hidden" name="nip[]" class="nip" value="'+trans['peg_nip_baru']+'"><input type="hidden" name="nrp[]" class="nrp" value="'+trans['peg_nrp']+'">'+trans['peg_nrp']+'</td>'+
              '<td><input type="hidden" name="nama[]" class="nama" value="'+trans['nama']+'">'+trans['nama']+'</td>'+
              '<td><input type="hidden" name="jabatan[]" class="jabatan" value="'+trans['jabatan']+'">'+trans['jabatan']+'</td>'+
              '<td><input type="hidden" name="golongan[]" class="golongan" value="'+trans['gol_kd']+'"><input type="hidden" name="pangkat[]" class="pangkat" value="'+trans['gol_pangkat2']+'">'+trans['gol_pangkat']+'</td>'+
              '<td style="text-align: center;"><input type="hidden" name="satker[]" class="satker" value="'+trans['instansi']+'"><input class="selection_one" name="selection[]" value="'+trans['peg_nip_baru']+'" type="checkbox"></td>'+
            '</tr>');
            }else{
                
              $('#Mcreate_terlapor').modal('hide');
            }
            }

            var namesKp = arrnipKp;
            localStorage.setItem("was10_nip_terlaporKp", JSON.stringify(namesKp));
            $('#Mcreate_terlapor').modal('hide');
        }
        });

        $(document).on('hidden.bs.modal','#Mcreate_terlapor', function (e) {
          $(this)
            // .find("input,textarea,select")
            //    .val('')
            //    .end()
            .find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();

        });

        $(document).on('click','#Madd_hapus_terlapor', function () {
            $('.selection_one:checked').closest('tr').remove();
            localStorage.removeItem("was10_nip_terlapor");
            localStorage.removeItem("was10_nip_terlaporKp");
            var checkValues = $('.selection_one').map(function()
                        {
                        return $(this).val();
                        }).get();
            localStorage.setItem("was10_nip_terlapor", JSON.stringify(checkValues));

        });

        $(document).on('change','.selection_all',function() {
            var c = this.checked ? true : false;
            $('.selection_one').prop('checked',c);
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.selection_one:checked').length;
            var z=$('.selection_one').length;
           // alert(z);
            if(x===z){
                $('.selection_all').prop('checked',true);
            }else{
                $('.selection_all').prop('checked',false);
            }
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#Madd_ubah_terlapor, #Madd_hapus_terlapor').removeClass('disabled');
                } else if(n > 1){
                   $('#Madd_hapus_terlapor').removeClass('disabled');
                   $('#Madd_ubah_terlapor').addClass('disabled');
                } else{
                   $('#Madd_ubah_terlapor, #Madd_hapus_terlapor').addClass('disabled');
                }
        }
    }

     $(document).on('hidden.bs.modal','#Mcreate_terlapor', function (e) {
      $(this)
        .find("input[name=cari]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });
    </script>