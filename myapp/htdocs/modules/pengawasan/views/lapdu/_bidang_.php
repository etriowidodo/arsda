<?php
use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\grid\GridView;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
use yii\helpers\ArrayHelper;
use app\modules\pengawasan\components\FungsiComponent; 

?>
<div class="modal fade" id="modalBidang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pilih Bidang</h4>
                </div>
                <div class="modal-body">
                    <p>
                          <?php
                              $connection = \Yii::$app->db;
                              $query = "select id_wilayah,id_level1,id_level2,\"UNITKERJA_NAMA\" as nama_kejagung_unit from kepegawaian.v_kp_unit_kerja where id_wilayah='1'  and id_level3='0' and id_level4='0' order by id_level1,id_level2";
                              $result = $connection->createCommand($query)->queryAll();


                              $connection = \Yii::$app->db;
                              $query1 = "select B.\"UNITKERJA_NAMA\" as nama_bidang,B.id_level1 as id_bidang,
                                        (select A.id_inspektur from was.wilayah_inspektur A where A.id_wilayah::integer = 0 
                                        and A.id_kejati::integer = B.id_level1::integer  ) as id_inspektur from kepegawaian.v_kp_unit_kerja B 
                                        where B.id_wilayah ='1' 
                                        and length(B.\"UNITKERJA_KD\")=3 order by id_bidang";
                              $result_bidang = $connection->createCommand($query1)->queryAll();
                          ?>
                    </p>
                        <div class="box box-primary" id="get-bidang-index" style="padding: 15px;overflow: hidden;">
                          <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormBidang', 
                                      'options'=>['name'=>'searchFormBidang'],
                                      // 'fieldConfig' => [
                                                  // 'options' => [
                                                  //     'tag' => false,
                                                  //     ],
                                                  // ],
                                  ]); ?>
                                  <div class="col-md-12">
                                     <div class="form-group">
                                        <label class="control-label col-md-2">Cari</label>
                                          <div class="col-md-8 kejaksaan">
                                          <?=
                                          $form->field($model, 'cmb_bidang')->dropDownList(
                                            ArrayHelper::map($result_bidang, 'id_bidang', 'nama_bidang'),
                                            ['prompt'=>'Pilih Bidang']
                                            )->label(false)
                                          ?>
                                      </div>
                                          <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> </i> Cari</button>
                                    </div>
                                  </div>
                                 <?php ActiveForm::end(); ?>
                        <!-- <div class="col-md-12" style="margin-top:20px;"> -->
                          <div id="w0" class="grid-view">
                              <?php
                            $MsearchBidang = new LapduSearch();
                            $dataProviderBidang = $MsearchBidang->searchBidang(Yii::$app->request->queryParams);
                        ?>
                            <?php Pjax::begin(['id' => 'MBidang-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormBidang','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderBidang,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center; width:8%'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                 
                                    ['label'=>'Unit kerja',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_kejagung_unit',
                                    ],


                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $komponen=new FungsiComponent();
                                            $insp=$komponen->Getinsp($data['id_level1']);
                                            $result=json_encode($data);
                                          return ['value' => $data['id_surat'],'class'=>'MBidangselection_one','json'=>$result,'insp'=>$insp];
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
                    <button type="button" class="btn btn-default" id="Mtambah_bidang">Pilih</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
</div>
<style>
  #get-bidang-index.loading {overflow: hidden;}
  #get-bidang-index.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
$(document).ready(function(){
   $("#MBidang-tambah-grid").on('pjax:send', function(){
      $('#get-bidang-index').addClass('loading');
    }).on('pjax:success', function(){
      $('#get-bidang-index').removeClass('loading');
    });

  $('#Mtambah_bidang').click(function(){
        var data=JSON.parse($(".MBidangselection_one:checked").attr("json"));
        var nama_bidang=$('#lapdu-cmb_bidang option:selected').text();
        var id_inspektur=$(".MBidangselection_one:checked").attr("insp");
    /*perubahan full karena databse juga berubah total 90%berubah*/
      if(nama_bidang=='Pilih Bidang'){
       // alert(nama_bidang+data.nama_kejagung_unit);
        bootbox.alert("Bidang Tidak Boleh Kosong");
      }else{
       // alert(nama_bidang+data.nama_kejagung_unit);
        $('#idbidang').val(data.id_level1);/*Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati*/
        $('#bidang').val(nama_bidang);
        $('#idunit').val(data.id_level2);
        $('#unit_kerja').val(data.nama_kejagung_unit);
        $('#idinspektur').val(id_inspektur);  
        $("#modalBidang").modal('hide');
      }
  });
});
</script>