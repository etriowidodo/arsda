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
<div class="modal fade" id="modalKejari" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Kejari</h4>
                </div>
                <div class="modal-body">
                    <p>
                          <?php
                              $connection = \Yii::$app->db;
                              $query = "select id_wilayah,id_level1,id_level2,\"UNITKERJA_NAMA\" as nama_kejagung_unit from kepegawaian.v_kp_unit_kerja where id_wilayah='1'  and id_level3='0' and id_level4='0' order by id_level1,id_level2";
                              $result = $connection->createCommand($query)->queryAll();


                              $connection = \Yii::$app->db;
                              $query1 = "select B.\"UNITKERJA_NAMA\" as nama_bidang,B.id_level1 as id_bidang,(select A.id_inspektur from was.wilayah_inspektur A where A.id_wilayah::integer = 0 and A.id_kejati::integer = B.id_level1::integer  ) as id_inspektur from kepegawaian.v_kp_unit_kerja B where B.id_wilayah ='1' and length(B.\"UNITKERJA_KD\")=3";
                              $result_bidang = $connection->createCommand($query1)->queryAll();
                          ?>
                    </p>
                        <div class="box box-primary"  id="get-kejari-index" style="padding: 15px;overflow: hidden;">
                          <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormKejari', 
                                      'options'=>['name'=>'searchFormKejari'],
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
                                          $form->field($model, 'cari_kejari',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-default','type'=>'submit', 'id'=>'Mcari_kejari']),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput()->label(false)
                                          ?>
                                      </div>
                                          <!-- <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> </i> Cari</button> -->
                                    </div>
                                  </div>
                                 <?php ActiveForm::end(); ?>
                                  <div id="w0" class="grid-view">
                                      <?php
                                    $MsearchKejari = new LapduSearch();
                                    $dataProviderKejari = $MsearchKejari->searchKejari(Yii::$app->request->queryParams);
                                ?>
                                    <?php Pjax::begin(['id' => 'MKejari-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormKejari','enablePushState' => false]) ?>
                                    <?php
                                    echo GridView::widget([
                                        'dataProvider'=> $dataProviderKejari,
                                        // 'filterModel' => $searchModel,
                                        // 'layout' => "{items}\n{pager}",
                                        'columns' => [
                                            ['header'=>'No',
                                            'headerOptions'=>['style'=>'text-align:center; width:8%'],
                                            'contentOptions'=>['style'=>'text-align:center;'],
                                            'class' => 'yii\grid\SerialColumn'],
                                            
                                            ['label'=>' Nama Kejati',
                                                'headerOptions'=>['style'=>'text-align:center;'],
                                                'attribute'=>'nama_kejati',
                                            ],
                                            
                                            ['label'=>'Nama Kejari',
                                                'headerOptions'=>['style'=>'text-align:center;'],
                                                'attribute'=>'inst_nama',
                                            ],


                                         ['class' => 'yii\grid\CheckboxColumn',
                                         'headerOptions'=>['style'=>'text-align:center'],
                                         'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                                   'checkboxOptions' => function ($data) {
                                                    $komponen=new FungsiComponent();
                                                    $insp=$komponen->Getinsp($data['id_level1']);
                                                    $result=json_encode($data);
                                                  return ['value' => $data['id_surat'],'class'=>'MKejariselection_one','json'=>$result,'insp'=>$insp];
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
                    <button type="button" class="btn btn-default" id="Mtambah_kejari">Tambah</button>
                </div>
            </div>
        </div>
</div>
<style>
  #get-kejari-index.loading {overflow: hidden;}
  #get-kejari-index.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
$(document).ready(function(){

  $("#MKejari-tambah-grid").on('pjax:send', function(){
      $('#get-kejari-index').addClass('loading');
    }).on('pjax:success', function(){
      $('#get-kejari-index').removeClass('loading');
    });

  $('#Mtambah_kejari').click(function(){
    var data =JSON.parse($('.MKejariselection_one:checked').attr('json'));
          $('#idbidang').val(data.id_kejati); //Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati
          $('#nmkejati').val(data.nama_kejati);
          $('#idinspektur').val(data.id_inspektur);
          $('#nmkejari').val(data.inst_nama);
          $('#idunit').val(data.kode_kejari);
          $("#modalKejari").modal('hide');
      });
    
});
</script>


       