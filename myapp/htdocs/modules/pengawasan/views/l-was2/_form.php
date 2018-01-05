<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\models\VPejabatPimpinan;
use yii\web\View;
use app\models\LookupItem;
use app\modules\pengawasan\models\SpRTingkatphd;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\LWas2 */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
    var url1 = '<?php echo Url::toRoute('l-was2/popup-terlapor'); ?>';

</script>
<?php
$script = <<<JS
        
    
    function pilihTerlaporLWas2(id,id_terlapor,nip,nama,jabatan)
    {
         $.ajax(
        {
            type: "POST",
            url: url1,
            data: "id_register="+id+"&id_terlapor="+id_terlapor+"&nip="+nip+"&nama="+nama+"&jabatan="+jabatan,
            dataType : "json",
            cache: false,
            success: function(data)
            {
      
                $("#terlapordetail").html(data.view_terlapor);
                 $('#m_terlapor_lwas2').modal('show');
            }
        });
      
      

    }
JS;
$this->registerJs($script, View::POS_BEGIN);

$this->registerJs("
    $(document).ready(function(){
   $('.cetakwas').click(function(){
         
       window.open('" . Url::to('pengawasan/l-was2/cetak', true) . "?id_register=' + $(\"#lwas2-id_register\").val() + '&id_l_was_2=' + $(\"#lwas2-id_l_was_2\").val());

      });
      
          $('#tambah_barangbukti').click(function(){
         
          $('#tbody_barangbukti-lwas2').append(
		'<tr id=\"barangBukti\"><td><input type=\"text\" class=\"form-control\" name=\"barbuk_nama[]\"></td><td><input type=\"text\" class=\"form-control\" name=\"barbuk_jumlah[]\"> </td><td> " . trim(preg_replace('/\s+/', ' ', Html::dropDownList('barbuk_satuan[]', null, ArrayHelper::map(app\modules\pengawasan\models\MsSatuan::find()->all(), 'id', 'nama'), ['class' => 'form-control', 'prompt' => 'Pilih Satuan',]))) . "</td><td><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>');	
          

      });
      
  $('#tambah_analisa').click(function(){
         
          $('#tbody_analisa-lwas2').append(
			'<tr id=\"analisa\"><td><textarea rows=\"5\" class=\"form-control\" name=\"analisa[]\"></textarea></td><td><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>');
           

      });
      
  $('#tambah_kesimpulan').click(function(){
         
          $('#tbody_kesimpulan-lwas2').append(
			'<tr id=\"analisa\"><td><textarea rows=\"5\" class=\"form-control\" name=\"kesimpulan[]\"></textarea></td><td><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>');
           

      });
      
  $('#tambah_pendapat').click(function(){
         
          $('#tbody_pendapat-lwas2').append(
			'<tr id=\"analisa\"><td><input type=\"text\" class=\"form-control\" name=\"pendapat[]\"></td><td><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>');
           

      });
      
$('#tambah_halberat').click(function(){
         
          $('#tbody_halberat-lwas2').append(
			'<tr id=\"analisa\"><td><input type=\"text\" class=\"form-control\" name=\"halberat[]\"></td><td><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>');
           

      });
      
$('#tambah_halringan').click(function(){
         
          $('#tbody_halringan-lwas2').append(
			'<tr id=\"analisa\"><td><input type=\"text\" class=\"form-control\" name=\"halringan[]\"></td><td><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>');
           

      });

}); ", \yii\web\View::POS_END);
// <?php echo Html::dropDownList(\'barbuk_satuan[]\',null,ArrayHelper::map(LookupItem::find()->where(\"kd_lookup_group=\'03\'\")->all(),\'kd_lookup_item\',\'nm_lookup_item\'),[\'prompt\'=>\'Pilih Satuan\',])
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'l-was2-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ]
        ]);
        ?>
        <?php
        $was_register = 0;
        $searchModel = new \app\modules\pengawasan\models\Was1Search();
        if ($model->isNewRecord) {
            $session = Yii::$app->session;
            $was_register = $session->get('was_register');
        } else {
            $was_register = $model->id_register;
        }
        $no_register = $searchModel->searchRegister($was_register);

        $model->no_register = $no_register->no_register;
        $model->id_register = $no_register->id_register;

        $data_satker = $searchModel->searchSatker($was_register);
        $model->inst_satkerkd = $data_satker['inst_satkerkd'];
        $model->inst_nama = $data_satker['inst_nama'];
        ?>
        <?= Html::activeHiddenInput($model, 'id_l_was_2')//$form->field($model, 'id_l_was_2')->hiddenInput(['maxlength' => true]) ?>
        <?= Html::activeHiddenInput($model, 'id_register')//$form->field($model, 'id_register')->hiddenInput() ?>
        <?= Html::activeHiddenInput($model, 'inst_satkerkd')//$form->field($model, 'inst_satkerkd')->hiddenInput(['maxlength' => true]) ?>
        <div class="box box-primary" style="overflow:hidden;padding:15px 0px 8px 0px;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">NO. Surat</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_register')->textInput() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-4">Kejaksaan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'inst_nama')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Surat Perintah</label>
                        <div class="col-md-8">
                            <?php
                            $querySpWas2 = SpWas2::find()->select('ttd_sp_was_2, no_sp_was_2, tgl_sp_was_2 ')->where('id_register = :idRegister', [':idRegister' => $was_register])->asArray()->one();
                            $model->no_sprint_lwas_2 = $querySpWas2['no_sp_was_2'];
                            $model->tgl_sprint_lwas_2 = date('d-m-Y', strtotime($querySpWas2['tgl_sp_was_2']));

                            echo $form->field($model, 'sprint_lwas_2')->dropDownList(
                                    ArrayHelper::map(VPejabatPimpinan::find()->where('id_jabatan_pejabat = :id', [':id' => $querySpWas2['ttd_sp_was_2']])->all(), 'id_jabatan_pejabat', 'jabatan'), ['disabled' => true])
                            /* $form->field($model, 'wilayah')->dropDownList(
                              ArrayHelper::map(SpWas2::find()->all(),'ttd_sp_was2','nm_wilayah'),
                              ['prompt'=>'Pilih Wilayah',
                              'id'=>'cbWilayah',
                              ]
                              ) */
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No. SPRINT</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'no_sprint_lwas_2')->textInput(['readonly' => 'true']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal SPRINT</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'tgl_sprint_lwas_2')->textInput(['readonly' => 'true']);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal L.WAS-2</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [

                                    'pluginOptions' => [

                                        'autoclose' => true,
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border" style="border-color: #c7c7c7;padding-left: 0px;">
                <label class="control-label col-md-2">Pemeriksa</label>
            </div>
            <div class="box-header with-border">
                <?php
                $searchModel2 = new VRiwayatJabatan();
                $dataProvider2 = $searchModel2->searchPemeriksa($was_register);
                $gridColumn = [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'peg_nama',
                        'label' => 'Nama',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'peg_nip_baru',
                        'label' => 'NIP',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'jabatan',
                        'label' => 'JABATAN',
                    ]
                ];


                echo GridView::widget([

                    'dataProvider' => $dataProvider2,
                    // 'filterModel' => $searchModel,
                    'layout' => "{items}",
                    'columns' => $gridColumn,
                    'responsive' => true,
                    'hover' => true,
                    'export' => false,
                        //'panel'=>[
                        //      'type'=>GridView::TYPE_PRIMARY,
                        //  'heading'=>$heading,
                        //],
                ]);
                ?>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border" style="border-color: #c7c7c7;padding-left: 0px;">
                <label class="control-label col-md-2">Identitas Pelapor</label>
            </div>
            <div class="box-header with-border">
                <?php
                $dataProvider3 = $searchModel->searchPelapor($was_register);
                $gridColumn = [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'nama',
                        'label' => 'Nama',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'alamat',
                        'label' => 'Alamat',
                ]];


                echo GridView::widget([

                    'dataProvider' => $dataProvider3,
                    // 'filterModel' => $searchModel,
                    'layout' => "{items}",
                    'columns' => $gridColumn,
                    'responsive' => true,
                    'hover' => true,
                    'export' => false,
                        //'panel'=>[
                        //      'type'=>GridView::TYPE_PRIMARY,
                        //  'heading'=>$heading,
                        //],
                ]);
                ?>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border" style="border-color: #c7c7c7;padding-left: 0px;">
                <label class="control-label col-md-2">Terlapor</label>
            </div>
            <div class="box-header with-border">
                <?php
                $dataProvider4 = $searchModel2->searchTerlapor($was_register);
                $gridColumn = [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'peg_nama',
                        'label' => 'Nama',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'peg_nip_baru',
                        'label' => 'NIP',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'jabatan',
                        'label' => 'JABATAN',
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'template' => '{pilih}',
                        'buttons' => [
                            'pilih' => function ($url, $model, $key) use($was_register) {
                                return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary', 'onClick' => 'pilihTerlaporLWas2("' . $was_register . '","' . $model['id_terlapor'] . '","' . $model['peg_nip_baru'] . '","' . $model['peg_nama'] . '","'.$model['jabatan'].'")']);
                            },
                                ]
                        ]];


                        echo GridView::widget([

                            'dataProvider' => $dataProvider4,
                            // 'filterModel' => $searchModel,
                            'layout' => "{items}",
                            'columns' => $gridColumn,
                            'responsive' => true,
                            'hover' => true,
                            'export' => false,
                                //'panel'=>[
                                //      'type'=>GridView::TYPE_PRIMARY,
                                //  'heading'=>$heading,
                                //],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border" style="border-color: #c7c7c7;padding-left: 0px;">
                        <label class="control-label col-md-2">Saksi Internal</label>
                    </div>
                    <div class="box-header with-border">
                        <?php
                        $searchModel2 = new VRiwayatJabatan();
                        $dataProvider2 = $searchModel2->searchSaksiInternal($was_register);
                        $gridColumn = [
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'peg_nama',
                                'label' => 'Nama',
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'peg_nip_baru',
                                'label' => 'NIP',
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'jabatan',
                                'label' => 'JABATAN',
                            ]
                        ];


                        echo GridView::widget([

                            'dataProvider' => $dataProvider2,
                            // 'filterModel' => $searchModel,
                            'layout' => "{items}",
                            'columns' => $gridColumn,
                            'responsive' => true,
                            'hover' => true,
                            'export' => false,
                                //'panel'=>[
                                //      'type'=>GridView::TYPE_PRIMARY,
                                //  'heading'=>$heading,
                                //],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border" style="border-color: #c7c7c7;padding-left: 0px;">
                        <label class="control-label col-md-2">Saksi Eksternal</label>
                    </div>
                    <div class="box-header with-border">
                        <?php
                        $searchModel3 = new app\modules\pengawasan\models\SaksiEksternal();
                        $dataProvider3 = $searchModel3->searchSaksiEksternal($was_register);
                        $gridColumn = [
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'nama',
                                'label' => 'Nama',
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'alamat',
                                'label' => 'Alamat',
                            ],
                        ];


                        echo GridView::widget([

                            'dataProvider' => $dataProvider3,
                            // 'filterModel' => $searchModel,
                            'layout' => "{items}",
                            'columns' => $gridColumn,
                            'responsive' => true,
                            'hover' => true,
                            'export' => false,
                                //'panel'=>[
                                //      'type'=>GridView::TYPE_PRIMARY,
                                //  'heading'=>$heading,
                                //],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label class="col-md-2" style="margin-top:5px;">Barang Bukti</label>-->
                        <span class="pull-left">
                            <button id="tambah_barangbukti" class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Tambah Barang Bukti</button>
                        </span> </div>
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label class="control-label col-md-2"></label>-->
                        <table id="table_barangbukti-lwas2" class="table table-bordered" style="margin-bottom: 0px;">
                            <thead>
                                <tr>
                                    <th>Barang Bukti</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_barangbukti-lwas2">
                                <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelBarbuk as $dataBarbuk) {
                                        ?>
                                        <tr id="barangBukti">
                                            <td><input type="text" name="barbuk_nama[]" class="form-control" value="<?php echo $dataBarbuk['nm_barbuk'] ?>"></td>
                                            <td><input type="text" name="barbuk_jumlah[]" class="form-control" value="<?php echo $dataBarbuk['jml'] ?>">
                                            </td>
                                            <td><select name="barbuk_satuan[]">
                                                    <option value="">Pilih Satuan</option>
                                                    <option value="1" <?php echo ($dataBarbuk['satuan'] == "1" ? "selected=selected" : "" ) ?>>Berkas</option>
                                                    <option value="2"  <?php echo ($dataBarbuk['satuan'] == "2" ? "selected=selected" : "" ) ?>>Lembar</option>
                                                </select></td>
                                            <td><button class="removebutton" type="button">Hapus</button></td>
                                        </tr
                                        >
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="box box-primary">
                    <div class="box-header with-border" style="padding-bottom: 0px;">
                        <div class="form-group">
                            <label class="control-label col-md-2">Uraian Permasalahan</label>
                            <div class="col-md-10">
                                <?php
                                $dugaan_pelanggaran = app\modules\pengawasan\models\DugaanPelanggaran::find()->where('id_register = :id', [':id' => $was_register])->asArray()->one();
                                $model->ringkasan = $dugaan_pelanggaran['ringkasan'];
                                ?>
                                <?= $form->field($model, 'ringkasan')->textarea(['rows' => 5]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label class="col-md-2" style="margin-top:5px;">Analisa</label>-->
                        <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_analisa"><i class="fa fa-plus"></i> Tambah Analisa</button>
                        </span> </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_analisa-lwas2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Analisa</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_analisa-lwas2">
                                <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelAnalisa as $dataAnalisa) {
                                        ?>
                                        <tr id="analisa">
                                          <td><textarea rows="5" class="form-control" name="analisa[]"><?php echo $dataAnalisa['isi']; ?></textarea></td>
                                            <td><button type="button"  class="removebutton">Hapus</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;"> <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_kesimpulan"><i class="fa fa-plus"></i> Tambah Kesimpulan</button>
                        </span> </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_kesimpulan-lwas2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kesimpulan</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_kesimpulan-lwas2">
                                <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelKesimpulan as $dataKesimpulan) {
                                        ?>
                                        <tr id="analisa">
                                            <td><textarea rows="5" class="form-control" name="kesimpulan[]"><?php echo $dataKesimpulan['isi']; ?></textarea></td>
                                            <td><button type="button"  class="removebutton">Hapus</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;"> <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_pendapat"><i class="fa fa-plus"></i> Tambah Pendapat</button>
                        </span> </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_pendapat-lwas2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Pendapat</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_pendapat-lwas2">
                                  <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelPendapat as $dataPendapat) {
                                        ?>
                                        <tr id="analisa">
                                            <td><input type="text" class="form-control" name="pendapat[]" value="<?php echo $dataPendapat['pendapat'] ?>"></td>
                                            <td><button type="button"  class="removebutton">Hapus</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;"> <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_halberat"><i class="fa fa-plus"></i> Tambah Hal-hal yang memberatkan</button>
                        </span> </div>
                    <div class="box-header with-border">
                        <table id="table_halberat-lwas2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Pernyataan</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_halberat-lwas2">
                                 <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelPertimbanganBerat as $dataBerat) {
                                        ?>
                                        <tr id="analisa">
                                            <td><input type="text" class="form-control" name="halberat[]" value="<?php echo $dataBerat['isi'] ?>"></td>
                                            <td><button type="button"  class="removebutton">Hapus</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;"> <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_halringan"><i class="fa fa-plus"></i> Tambah Hal-hal yang meringankan</button>
                        </span> </div>
                    <div class="box-header with-border">
                        <table id="table_halringan-lwas2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Pernyataan</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_halringan-lwas2">
                                  <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelPertimbanganRingan as $dataRingan) {
                                        ?>
                                        <tr id="analisa">
                                            <td><input type="text" class="form-control" name="halringan[]" value="<?php echo $dataRingan['isi'] ?>"></td>
                                            <td><button type="button"  class="removebutton">Hapus</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;padding-left: 0px;">
                        <label class="col-md-2" style="margin-top:5px;">Saran</label>
                    </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_saran-lwas2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th  width=25%>Terlapor</th>
                                    <th  width=65%>Saran</th>
                                </tr>
                            </thead>
                            <?php
                            $searchTerlapor = new VRiwayatJabatan();
                            $dataTerlapor = $searchTerlapor->searchTerlaporQuery($was_register);
                            ?>
                            <tbody id="tbody_saran-lwas2">
                                <?php
                                $model_dropdown = new SpRTingkatphd();
                                $data_dropdown = $model_dropdown->searchListSaran();
                                $isisaran = null;
                                foreach ($dataTerlapor as $rows) {
                                    
                                if(!$model->isNewRecord){
                                 
                                 $isisaran = app\modules\pengawasan\models\LWas2Saran::find()->where('id_terlapor = :idTerlapor and id_l_was_2 = :idLWas2', [":idTerlapor"=> $rows['id_terlapor'],"idLWas2"=>$model->id_l_was_2])->one()->tingkat_kd;
                                
                                }
                               
                                    ?>
                                    <tr>
                                        <td><?= Html::hiddenInput('peg_id_terlapor[]', $rows['id_terlapor'], ['class' => 'form-control']) ?>
                                            <?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'], ['class' => 'form-control']) ?></td>
                                        <td><?= Html::dropDownList('saran[]', $isisaran, ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['class' => 'form-control', 'prompt' => 'Pilih Hukuman Disiplin',]) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-primary" style="overflow:hidden;padding:15px 0px 8px 0px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <!--<label class="control-label col-md-3">#WAS-2</label> -->
                            <label class="control-label col-md-4">Upload File</label>
                            <div class="col-md-8">
                                <?php
                                echo $form->field($model, 'upload_file')->widget(FileInput::classname(), [

                                    'options' => [
                                        'multiple' => false,
                                    ],
                                    'pluginOptions' => [
                                        'showPreview' => true,
//'uploadUrl' => Url::to(['/modules/pengawasan/upload']),
                                        'showUpload' => false,
//'uploadExtraData' => [
//'album_id' => 20,
//'cat_id' => 'Nature'
//],
//'maxFileCount' => 1
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?php if (!$model->isNewRecord && !empty($model['upload_file'])) { ?>
                            <label class="control-label col-md-2">
                                <?= Html::label($model['upload_file']); ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
         
                <hr style="border-color: #c7c7c7;margin: 10px 0;">
                <div class="box-footer" style="margin:0px;padding:0px;background:none;">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-retweet"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                    <?= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$was_register]) ?>
                     <?php if (!$model->isNewRecord) { ?> 
             <?= Html::Button('Hapus', ['class' => 'hapuswasform btn btn-primary','url'=>Url::to('pengawasan/l-was2/delete', true),'namaform'=>'l-was2-form']) ?>
                      <?= Html::Button('<i class="fa fa-print"></i> Cetak', ["id" => 'testcetak', 'class' => 'cetakwas btn btn-primary']) ?>
                     <?php echo $form->field($model, 'id_l_was_2')->hiddenInput(['name'=>'id']) ?>
            <?php } ?>
                     
                  
                </div>
            </div>
            <!--form-->
            <?php ActiveForm::end(); ?>
        </div>
        </section>
        <?php
        Modal::begin([
            'id' => 'm_terlapor_lwas2',
            'header' => 'Form Terlapor',
        ]);
        ?>
        <div id="terlapordetail"> </div>
        <?php
        Modal::end();
        ?>
