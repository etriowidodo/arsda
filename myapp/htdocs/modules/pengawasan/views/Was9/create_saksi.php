<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Was9Search;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Was9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-9 (Surat Permintaan Keterangan Saksi)';
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>

<div class="was9-index">
     <?php $form = ActiveForm::begin([
            // 'action' => ['create'],
            //'method' => 'get',
            //'id'=>'searchFormKpegawai', 
            //'options'=>['name'=>'searchFormKpegawai'],
            /*'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                            ],
                        ],*/
        ]); ?>
    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_saksiInt"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create_saksiInt"><i class="glyphicon glyphicon-search"> </i> Cari Pegawai</a>
        </div>
    </p>
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <fieldset class="group-border">
        <legend class="group-border">Daftar Saksi</legend>
        <div id="w0" class="grid-view">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="">
                        <th style="width: 2%;text-align: center;">No</th>
                        <th style="width: 10%;">NIP / NRP</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 5%;">Jabatan</th>
                        <th style="width: 5%;">Golongan/Pangkat</th>
                        <th style="width: 4%;text-align: center;"><input class="selection_all" name="selection_all[]" value="" type="checkbox"></th>
                    </tr>
                </thead>
                <tbody id="body_tmp_terlapor">
                    <?= $form->field($model, 'no_register')->hiddenInput(['value'=>$_SESSION['was_register']])->label(false); ?>
                </tbody>
            </table>
        </div>
    </fieldset>
    </div>
<div class="btn-toolbar">                                                                                                                 
    <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was9/index"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Batal</a>
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right'])  ?>
</div>
<?php ActiveForm::end(); ?>
</div>

<!-- modal Load kp Pegawai -->
<div class="modal fade" id="Mcreate_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Saksi</h4>
                </div>
                <div class="modal-body">
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">

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
                            $searchModel = new Was9Search();
                            $dataProviderTerlapor = $searchModel->searchPegawai(Yii::$app->request->queryParams);
                            ?>
                        <div id="M2" class="grid-view">
                           <?php Pjax::begin(['id' => 'Mterlapor-Kpegawai-grid', 'timeout' => false,'formSelector' => '#searchFormKpegawai','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                    'dataProvider'=> $dataProviderTerlapor,
                                    'columns' => [
                                        ['header'=>'No',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['style'=>'text-align:center;'],
                                        'class' => 'yii\grid\SerialColumn'],
                                        
                                        ['label'=>'Nama',
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="Madd_saksi_internal">Tambah</button>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">
window.onload=function(){
localStorage.removeItem("was10_nip_terlaporKp");
localStorage.removeItem("was10_nip_terlapor");

        $(document).on('click','#create_saksiInt',function(){
            // $('#undang_internal').modal('show');
            $('#Mcreate_Modal').modal({backdrop: 'static', keyboard: false});
        });

    $(document).on('click','#Madd_saksi_internal',function(){
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
            var cek = JSON.parse(localStorage.getItem("was10_nip_terlapor"));
           
            if(jQuery.inArray(trans.peg_nip_baru,cek)==-1 && trans.peg_nip_baru!='' && jQuery.inArray(trans.peg_nip_baru,cekKp)==-1){/*jika data tidak ada maka tambahkan*/
            $('#body_tmp_terlapor').append('<tr>'+
              '<td></td>'+
              '<td><input type="hidden" name="nip[]" class="nip" value="'+trans['peg_nip_baru']+'"><input type="hidden" name="nrp[]" class="nrp" value="'+trans['peg_nrp']+'">'+trans['peg_nrp']+'</td>'+
              '<td><input type="hidden" name="nama[]" class="nama" value="'+trans['nama']+'">'+trans['nama']+'</td>'+
              '<td><input type="hidden" name="jabatan[]" class="jabatan" value="'+trans['jabatan']+'">'+trans['jabatan']+'</td>'+
              '<td><input type="hidden" name="golongan[]" class="golongan" value="'+trans['gol_kd']+'"><input type="hidden" name="pangkat[]" class="pangkat" value="'+trans['gol_pangkat2']+'">'+trans['gol_pangkat']+'</td>'+
              '<td style="text-align: center;"><input type="hidden" name="satker[]" class="satker" value="'+trans['instansi']+'"><input class="selection_one" name="selection[]" value="'+trans['peg_nip_baru']+'" type="checkbox"></td>'+
            '</tr>');
            }
                }
            var namesKp = arrnipKp;
            localStorage.setItem("was10_nip_terlaporKp", JSON.stringify(namesKp));
            $('#Mcreate_Modal').modal('hide');
});



 }
</script>


