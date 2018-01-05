<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\modules\pengawasan\models\Was15Search;
use kartik\builder\Form;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\models\SpRTingkatphd;
use app\modules\pengawasan\models\VPejabatTembusan;
use app\modules\pengawasan\models\Was15AKD;
use app\modules\pengawasan\models\Was15Saran;
use app\modules\pengawasan\models\DugaanPelanggaran;
use yii\web\View;
?>
<script>
var url1='<?php echo  Url::toRoute('l-was2/popup-terlapor'); ?>';
var urleksternal='<?php echo  Url::toRoute('l-was-1/_saksiEksternal'); ?>';
</script>

<?php 
$script = <<<JS
    function removeRow(id)
    {
		$("#"+id).remove();
    }
        
    function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
       
		$("#delete_tembusan").val(nilai);
		$("#"+id).remove();
    }

    function removeTembusan(id){
        $("#tembusan"+id).remove();
    }

    function removeData(id)
    {
        console.log(id);
        $("#data-"+id).remove();
    }
JS;
$this->registerJs($script, View::POS_BEGIN);

$script= <<<JS
    function pilihTerlaporWas15(id,id_terlapor,nip,nama, jabatan)
    {
         $.ajax({
            type: "POST",
            url: url1,
            data: "id_register="+id+"&id_terlapor="+id_terlapor+"&nip="+nip+"&nama="+nama+"&jabatan="+jabatan,
            dataType : "json",
            cache: false,
            success: function(data)
            {
                $("#terlapordetail").html(data.view_terlapor);
                $('#m_terlapor_was15').modal('show');
            }
        });
    }
JS;
$this->registerJs($script,View::POS_BEGIN);

$script= <<<JS
        function pilihSaksiInternalWas15 (id,id_terlapor,nip,nama,jabatan)
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
      
                $("#saksiinternaldetail").html(data.view_terlapor);
                $('#m_saksiinternal_was15').modal('show');
            }
        });
    }
JS;
$this->registerJs($script,View::POS_BEGIN);
?>

<?php
$this->registerJs( "
    $(document).ready(function(){
  
	$('#tambah_data').click(function(){
         
          $('#tbody_data').append(
	    '<tr id=\"data\"><td><textarea rows=\"5\"  class=\"form-control\" name=\"data[]\"></textarea></td><td><button onclick=\"removeRow()\" type=\"button\"  class=\"btn btn-primary removebutton\">Hapus</button></td></tr>');
      
      });

}); ", \yii\web\View::POS_END);
?>

<?php
$this->registerJs( "
    $(document).ready(function(){
  
	$('#tambah_analisa').click(function(){
         
          $('#tbody_analisa').append(
			'<tr id=\"analisa\"><td><textarea rows=\"5\"  class=\"form-control\" name=\"analisa[]\"></textarea></td><td><button type=\"button\"  class=\"btn btn-primary removebutton\">Hapus</button></td></tr>');
           

      });

}); ", \yii\web\View::POS_END);
?>

<?php
$this->registerJs( "
    $(document).ready(function(){
  
	$('#tambah_kesimpulan').click(function(){
         
          $('#tbody_kesimpulan').append(
			'<tr id=\"kesimpulan\"><td><textarea rows=\"5\" class=\"form-control\" name=\"kesimpulan[]\"></textarea></td><td><button type=\"button\"  class=\"btn btn-primary removebutton\">Hapus</button></td></tr>');
           

      });

}); ", \yii\web\View::POS_END);
?>

<?php
$this->registerJs( "
    $(document).ready(function(){
  
	$('#tambah_memberatkan').click(function(){
         
          $('#tbody_memberatkan').append(
			'<tr id=\"memberatkan\"><td><textarea rows=\"5\" class=\"form-control\" name=\"memberatkan[]\"></textarea></td><td><button type=\"button\"  class=\"btn btn-primary removebutton\">Hapus</button></td></tr>');
           

      });

}); ", \yii\web\View::POS_END);
?>

<?php
$this->registerJs( "
    $(document).ready(function(){
  
	$('#tambah_meringankan').click(function(){
         
          $('#tbody_meringankan').append(
			'<tr id=\"meringankan\"><td><textarea rows=\"5\" class=\"form-control\" name=\"memberatkan[]\"></textarea></td><td><button type=\"button\"  class=\"btn btn-primary removebutton\">Hapus</button></td></tr>');
           

      });

}); ", \yii\web\View::POS_END);
?>

<div class="was15-form">

    <?php 
    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'was15-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
    ]); 
    ?>
    
    
    <div class="box box-primary">
    <div class="box-header with-border">
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">No. Surat</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'no_register')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Kejaksaan</label>
                    <div class="col-md-8">
                        <?php
                        $sql = (new \yii\db\Query())
                                ->select('dugaan_pelanggaran.inst_satkerkd,kp_inst_satker.inst_nama')
                                ->from('was.dugaan_pelanggaran')
                                ->innerjoin('kepegawaian.kp_inst_satker', 'dugaan_pelanggaran.inst_satkerkd = kp_inst_satker.inst_satkerkd')
                                ->where(['length(dugaan_pelanggaran.inst_satkerkd)' => 2])
                                ->andWhere(['dugaan_pelanggaran.id_register' => $model->id_register])
                                ->andWhere(['kp_inst_satker.is_active' => '1'])
                                ->all();
                        $data = ArrayHelper::map($sql, 'inst_satkerkd', 'inst_nama');

                        echo $form->field($model, 'inst_satkerkd')->dropDownList($data, ['prompt' => '---Pilih---'], ['label' => '']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Kepada Yth.</label>
                    <div class="col-md-8">	
                        <?php
                        $sql = (new \yii\db\Query())
                                ->select('id_jabatan_pejabat,jabatan')
                                ->from('was.v_pejabat_pimpinan')
                                ->all();
                        $data = ArrayHelper::map($sql, 'id_jabatan_pejabat', 'jabatan');
                        echo $form->field($model, 'kepada')->dropDownList($data, 
                            ['label' => '', 'style' => 'width:350px']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Dari</label>
                    <div class="col-md-8">	
                        <?php
                        $sql = (new \yii\db\Query())
                                ->select('id_jabatan_pejabat,jabatan')
                                ->from('was.v_pejabat_pimpinan')
                                ->all();
                        $data = ArrayHelper::map($sql, 'id_jabatan_pejabat', 'jabatan');
                        echo $form->field($model, 'ttd_was_15')->dropDownList($data, 
                            ['label' => '', 'style' => 'width:350px']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor</label>
                    
                        <?php if($model->isNewRecord){?>
                    <div class="col-sm-8">
                    <div class="input-group">
                                    <span class="input-group-addon">R-</span>
                                    <input class="form-control" type="text" id="no_was_15" name="Was15[no_was_15]">
                                </div>
                    </div>
                        <?php }
                        else{?>
                    <div class="col-sm-8">
                    <div class="input-group">
                                    <span class="input-group-addon"><?php echo substr($model->no_was_15, 0, 2); ?></span>
                                    <input class="form-control" type="text" id="no_was_15" name="Was15[no_was_15]" value="<?php echo substr($model->no_was_15, 2); ?>">
                                </div>
                    </div>
                        <?php }?>
                </div>
            </div>
            
             <div class="col-md-6">
                 <div class="form-group">
                 <label class="control-label col-md-4">Tanggal</label>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, 'tgl_was_15')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                 </div>
                </div>
        </div>
        
        
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Sifat</label>
                    <div class="col-md-8">	
                        <?php
                        $sql = (new \yii\db\Query())
                                ->select('kd_lookup_item, nm_lookup_item')
                                ->from('was.lookup_item')
                                ->where(['kd_lookup_group' => '01'])
                                ->andWhere(['kd_lookup_item' => '3'])
                                ->all();
                        $data = ArrayHelper::map($sql, 'kd_lookup_item', 'nm_lookup_item');
                        echo $form->field($model, 'sifat_surat')->dropDownList($data,['label' => '','readonly'=>true]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Lampiran</label>
                    <div class="col-md-4">	
                        <?php echo $form->field($model, 'jml_lampiran')->textInput(['maxlength' => true]); ?>
                    </div>
                    <text class="control-label col-md-4">Berkas</text>

                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Perihal</label>
                    <div class="col-md-8">	
                        <?php echo $form->field($model, 'perihal')->
                                textarea(['rows' => 5, 'style' => 'width:637px','value'=>'Pertimbangan terhadap hukuman disiplin yang akan dijatuhkan kepada Terlapor atas nama ']); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">    
                <h4>Terlapor</h4>
                <?php
                    $searchGrid = new \app\modules\pengawasan\models\Was15Search();
                    $dataProvider = $searchGrid->searchData($model->id_register);
                    $gridColumn =  [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
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
                            'attribute' => 'gol_pangkat',
                            'label' => 'Pangkat',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'jabatan',
                            'label' => 'Jabatan',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=>'Action', 
                            'template' => '{detail}',
                            'buttons' => [
                              'detail' => function ($url,$model,$key) use($was_register) {
                                  return Html::button('Detail',['class'=>'btn btn-primary','onClick'=>'pilihTerlaporWas15("'.$was_register.'","'.$model['id_terlapor'].'","'.$model['peg_nip_baru'].'","'.$model['peg_nama'] . '","'.$model['jabatan'].'")']);
                              },
                          ],
                        ],

                    ];
                    echo GridView::widget([
                        'dataProvider'=> $dataProvider,
                        'layout'=>"{items}",
                        'columns' => $gridColumn,
                        'responsive'=>true,
                        'hover'=>true,
                        'export'=>false,
                    ]); 
            
            ?>
            </div>
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">    
                <h4> Identitas Pelapor</h4>
			<?php
                            $searchModel = new \app\modules\pengawasan\models\Was15Search();
                            $dataProvider = $searchModel->searchPelapor($no_register->id_register);

                            $gridColumn =  [
                                    [
                                            'class' => '\kartik\grid\DataColumn',
                                            'attribute' => 'nama',
                                            'label' => 'Nama',
                                    ],
                                    [
                                            'class' => '\kartik\grid\DataColumn',
                                            'attribute' => 'alamat',
                                            'label' => 'Alamat',
                                    ]
                            ];
                            echo GridView::widget([
                                    'dataProvider'=> $dataProvider,
                                    'layout'=>"{items}",
                                    'columns' => $gridColumn,
                                    'responsive'=>true,
                                    'hover'=>true,
                                    'export'=>false,
                            ]); 
                    ?>
		
            </div>
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">    
                <h4>Saksi Internal</h4>
                <?php
                    $searchGrid = new \app\modules\pengawasan\models\LWas1Search();
                    $dataProvider = $searchGrid->searchSaksiInternalLwas1($model->id_register);
                    $gridColumn =  [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
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
                            'attribute' => 'gol_pangkat',
                            'label' => 'Pangkat',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'jabatan',
                            'label' => 'Jabatan',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=>'Action', 
                            'template' => '{detail}',
                            'buttons' => [
                              'detail' => function ($url,$model) {
                                  return Html::button('Detail',['class'=>'btn btn-primary','onClick'=>'pilihSaksiInternalWas15("'.$was_register.'","'.$model['id_terlapor'].'","'.$model['peg_nip_baru'].'","'.$model['peg_nama'] . '","'.$model['jabatan'].'")']);
                              },
                          ],
                        ],

                    ];
                    echo GridView::widget([
                        'dataProvider'=> $dataProvider,
                        'layout'=>"{items}",
                        'columns' => $gridColumn,
                        'responsive'=>true,
                        'hover'=>true,
                        'export'=>false,
                    ]); 
            
            ?>
            </div>
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">    
                <h4>Saksi Eksternal</h4>
                <?php
                    $searchGrid = new \app\modules\pengawasan\models\LWas1Search();
                    $dataProvider = $searchGrid->searchSaksiEksternalLwas1($model->id_register);
                    $gridColumn =  [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
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
                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'header'=>'Action', 
                            'template' => '{detail}',
                            'buttons' => [
                              'detail' => function ($url,$model) {
                                  return Html::button('Detail',['class'=>'btn btn-primary','onClick'=>'']);
                              },
                          ],
                        ],*/

                    ];
                    echo GridView::widget([
                        'dataProvider'=> $dataProvider,
                        'layout'=>"{items}",
                        'columns' => $gridColumn,
                        'responsive'=>true,
                        'hover'=>true,
                        'export'=>false,
                    ]); 
            
            ?>
            </div>
        </div>
        <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Uraian Permasalahan</label>
                        <div class="col-md-8">
                            <?php
                            /*if ($model->isNewRecord) {
                                echo $form->field($model, 'ringkasan')->
                                        textarea(['rows' => 5, 'style' => 'width:637px']);
                            } else {
                                echo $form->field($model, 'ringkasan')->
                                        textarea(['rows' => 5, 'style' => 'width:637px','value' => app\modules\pengawasan\models\LWas2::findOne(['id_register' => $model->id_register])->id_register]);
                            }*/
                            echo $form->field($model, 'ringkasan')->textarea(['rows' => 5, 'style' => 'width:637px', 'value' => app\models\DugaanPelanggaran::findOne(['id_register' => $model->id_register])->ringkasan]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
            
        
        <div class="box-header with-border">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top:5px;">Data-data</label>
			<div class="col-lg-10">
				<div class="col-lg-10"> 
                                    <span class="pull-left" style="margin-left:-55px;"> 
                                        <button class="btn btn-primary" type="button" id="tambah_data">Tambah
                                        </button> 
                                    </span> 
                                </div>
			</div>
		</div>
	
            <div class="col-md-12" style="margin-top:5px;">
                <table id="table_pendapat" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width='90%'>Data-data</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_data">
                        <?php if(!$model->isNewRecord): ?>
					<?php foreach ($modelData as $data): ?>
						<tr id="data-<?= $data['id_was_15_a_k_d'] ?>">
                            <td><textarea rows="5"  name="data[]" class="form-control"><?= $data->isi; ?></textarea></td>
							<td><button onclick="removeData('<?=$data['id_was_15_a_k_d']?>')" class="btn btn-primary" type="button">Hapus</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
                    </tbody>
                </table>
            </div>
	</div>
        
        <div class="box-header with-border">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top:5px;">Analisa</label>
			<div class="col-lg-10">
				<div class="col-lg-10"> 
                                    <span class="pull-left" style="margin-left:-55px;"> 
                                        <button class="btn btn-primary" type="button" id="tambah_analisa">Tambah
                                        </button> 
                                    </span> 
                                </div>
			</div>
		</div>
	
            <div class="col-md-12" style="margin-top:5px;">
                <table id="table_pendapat" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width='90%'>Analisa</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_analisa">
                        <?php if(!$model->isNewRecord): ?>
					<?php foreach ($modelAnalisa as $data): ?>
						<tr id="data-<?= $data['id_was_15_a_k_d'] ?>">
                             <td><textarea rows="5" name="analisa[]" class="form-control"><?= $data->isi; ?></textarea></td>
							<td><button onclick="removeData('<?=$data['id_was_15_a_k_d']?>')" class="btn btn-primary" type="button">Hapus</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
                    </tbody>
                </table>
            </div>
	</div>
        
        <div class="box-header with-border">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top:5px;">Kesimpulan</label>
			<div class="col-lg-10">
				<div class="col-lg-10"> 
                    <span class="pull-left" style="margin-left:-55px;"> 
                        <button class="btn btn-primary" type="button" id="tambah_kesimpulan">Tambah
                        </button> 
                    </span> 
                </div>
			</div>
		</div>
	
            <div class="col-md-12" style="margin-top:5px;">
                <table id="table_kesimpulan" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width='90%'>Kesimpulan</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_kesimpulan">
                        <?php if(!$model->isNewRecord): ?>
					<?php foreach ($modelKesimpulan as $data): ?>
						<tr id="data-<?= $data['id_was_15_a_k_d'] ?>">
                            <td><textarea rows="5"  name="kesimpulan[]" class="form-control"><?= $data->isi; ?></textarea></td>
							<td><button onclick="removeData('<?=$data['id_was_15_a_k_d']?>')" class="btn btn-primary" type="button">Hapus</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
                    </tbody>
                </table>
            </div>
	</div>
        
        <div class="box-header with-border">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top:5px;">Hal-hal yang memberatkan</label>
			<div class="col-lg-10">
				<div class="col-lg-10"> 
                                    <span class="pull-left" style="margin-left:-55px;"> 
                                        <button class="btn btn-primary" type="button" id="tambah_memberatkan">Tambah
                                        </button> 
                                    </span> 
                                </div>
			</div>
		</div>
	
            <div class="col-md-12" style="margin-top:5px;">
                <table id="table_memberatkan" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width='90%'>Pernyataan</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_memberatkan">
                         <?php if(!$model->isNewRecord): ?>
					<?php foreach ($modelMemberatkan as $data): ?>
						<tr id="data-<?= $data['id_was_15_ptimbangan'] ?>">
                                                        <td><textarea rows="5"  name="memberatkan[]" class="form-control"><?= $data->isi; ?></textarea></td>
							<td><button onclick="removeData('<?=$data['id_was_15_ptimbangan']?>')" class="btn btn-primary" type="button">Hapus</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
                    </tbody>
                </table>
            </div>
	</div>
        
        <div class="box-header with-border">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top:5px;">Hal-hal yang meringankan</label>
			<div class="col-lg-10">
				<div class="col-lg-10"> 
                                    <span class="pull-left" style="margin-left:-55px;"> 
                                        <button class="btn btn-primary" type="button" id="tambah_meringankan">Tambah
                                        </button> 
                                    </span> 
                                </div>
			</div>
		</div>
	
            <div class="col-md-12" style="margin-top:5px;">
                <table id="table_meringankan" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width='90%'>Pernyataan</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_meringankan">
                        <?php if(!$model->isNewRecord): ?>
					<?php foreach ($modelMeringankan as $data): ?>
						<tr id="data-<?= $data['id_was_15_ptimbangan'] ?>">
                                                        <td><textarea rows=\"5\" class=\"form-control\" name=\"meringankan[]\"><?= $data->isi; ?></textarea></td>
                                                        <td><button onclick="removeData('<?=$data['id_was_15_ptimbangan']?>')" class="btn btn-primary" type="button">Hapus</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
                    </tbody>
                </table>
            </div>
	</div>
        <hr>
        <h4>Rencana Penjatuhan Hukuman Disiplin</h4>
        <div class="box box-primary" style="overflow: hidden;">    
        <div class="box-header with-border">
                <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="col-md-4" style="margin-top:5px;">1. Tim Pemeriksa</label>
                            <div class="col-md-8">
                        <?php
                            $query = (new \yii\db\Query())
                                    ->select(['kd_lookup_item','nm_lookup_item'])
                                    ->from('was.lookup_item ')
                                    ->where(['kd_lookup_group' => '13']);
                                    //->orWhere(['id_jabatan_pejabat'=>'35']);
                            $command = $query->createCommand();
                            $data = $command->queryAll();
                         ?>
                        <?php 
                            echo $form->field($model, 'rncn_jatuh_hukdis_1_was_15')->dropDownList(
                            ArrayHelper::map($data,'kd_lookup_item','nm_lookup_item'),
                            ['prompt'=>'Pilih Wilayah Kerja','style'=>'width:290px']) 
                        ?>
                        </div>
                            </div>
                        </div>    
                </div>
                <div class="col-md-6" style="margin-top:15px;">
                    <div class="form-group">
                        <div class="col-md-8" style="margin-left:0px;">
                            <label class="col-md-2" style="margin-top:5px;">Saran</label>
                            <table id="table_saran-was15" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center; width:25%;">Terlapor</th>
                                        <th style="text-align:center; width:65%;">Saran</th>
                                    </tr>
                                </thead>
                                <?php
                                $searchTerlapor = new VRiwayatJabatan();
                                $dataTerlapor = $searchTerlapor->searchTerlaporQuery($no_register->id_register);
                                
                                ?>
                                <tbody id="tbody_saran-was15">
                                    <?php
                                    $model_dropdown = new SpRTingkatphd();
                                    $data_dropdown = $model_dropdown->searchListSaran();
                                    if($model->isNewRecord){
                                    foreach ($dataTerlapor as $rows) {
                                        ?>

                                        <tr>
                                            <td><?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'],['style'=>'width:300px;']) ?></td>
                                            <?= Html::hiddenInput('id_terlapor[]', $rows['id_terlapor']) ?>
                                            <td><?= Html::dropDownList('saran[]', null, ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['prompt' => 'Pilih Hukuman Disiplin',],['options'=>['selected'=>true]]) ?></td>
                                            
                                        </tr>    
                                    <?php }}
                                    else{

                                    foreach ($dataTerlapor as $rows) { ?>
                                    <tr>
                                        <?php $selected = Was15Saran::findOne(['id_terlapor'=>$rows['id_terlapor'],'rncn_jatuh_hukdis_was_15'=>$model->rncn_jatuh_hukdis_1_was_15])->tingkat_kd; ?>
                                            <td><?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'],['style'=>'width:300px;']) ?></td>
                                            <?= Html::hiddenInput('id_terlapor[]', $rows['id_terlapor']) ?>
                                            <td><?= Html::dropDownList('saran[]', $selected, ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['prompt' => 'Pilih Hukuman Disiplin',],['options'=>['selected'=>true]]) ?></td>
                                            
                                        </tr> 
                                        <?php }}?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
<hr>
        <div class="box box-primary" style="overflow: hidden;">    
            <div class="box-header with-border">
                <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
                    <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label col-md-1">2.</label>
                    <div class="col-md-8">
                        <?php
                        $query2 = (new \yii\db\Query())
                                    ->select(['id_pejabat_tembusan','jabatan'])
                                    ->from('was.v_pejabat_tembusan')
                                    ->where(['LIKE','jabatan',['INSPEKTUR']])
                                    ->orWhere(['id_pejabat_tembusan'=>'160'])
                                    ->all();;
                            $data = ArrayHelper::map($query2,'id_pejabat_tembusan','jabatan');
                         ?>     
                        <?php 
                        echo $form->field($model, 'rncn_jatuh_hukdis_2_was_15')->dropDownList($data,
                                ['prompt' => '---Pilih---','style'=>'width:290px'],
                                ['label'=>'']);
                        ?>
                        </div>
                    </div>
                    </div>
                </div>
             
                <div class="col-md-6" style="margin-top:15px;">
                    <div class="form-group">
                        <div class="col-md-8" style="margin-left:0px;">
                            <label class="col-md-2" style="margin-top:5px;">Saran</label>
                            <table id="table_saran-was15" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center; width:25%;">Terlapor</th>
                                        <th style="text-align:center; width:65%;">Saran</th>
                                    </tr>
                                </thead>
                                <?php
                                $searchTerlapor = new VRiwayatJabatan();
                                $dataTerlapor = $searchTerlapor->searchTerlaporQuery($no_register->id_register);
                                ?>
                                <tbody id="tbody_saran-was15">
                                    <?php
                                    $model_dropdown = new SpRTingkatphd();
                                    $data_dropdown = $model_dropdown->searchListSaran();
                                    if($model->isNewRecord){
                                    foreach ($dataTerlapor as $rows) {
                                        ?>
                                        <tr>
                                            <td><?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'],['style'=>'width:300px;']) ?></td>
                                            <?= Html::hiddenInput('id_terlapor2[]', $rows['id_terlapor']) ?>
                                            <td><?= Html::dropDownList('saran2[]', null, ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['prompt' => 'Pilih Hukuman Disiplin',]) ?></td>
                                            
                                        </tr>    
                                     <?php }}
                                    else{

                                    foreach ($dataTerlapor as $rows) { ?>
                                    <tr>
                                        <?php $selected = Was15Saran::findOne(['id_terlapor'=>$rows['id_terlapor'],'rncn_jatuh_hukdis_was_15'=>$model->rncn_jatuh_hukdis_2_was_15])->tingkat_kd; ?>
                                            <td><?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'],['style'=>'width:300px;']) ?></td>
                                            <?= Html::hiddenInput('id_terlapor2[]', $rows['id_terlapor']) ?>
                                            <td><?= Html::dropDownList('saran2[]', $selected, ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['prompt' => 'Pilih Hukuman Disiplin',],['options'=>['selected'=>true]]) ?></td>
                                            
                                        </tr> 
                                        <?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
<hr>
        <div class="box box-primary" style="overflow: hidden;">    
            <div class="box-header with-border">
                <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
                    <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label col-md-1">3.</label>
                    <div class="col-md-8">
                        <?php
                            $query3 = (new \yii\db\Query())
                                    ->select(['id_jabatan_pejabat','jabatan'])
                                    ->from('was.v_pejabat_pimpinan')
                                    ->where(['id_jabatan_pejabat'=>'35'])
                                    ->all();;
                            $data = ArrayHelper::map($query3,'id_jabatan_pejabat','jabatan');
                         ?>     
                        <?php 
                        echo $form->field($model, 'rncn_jatuh_hukdis_3_was_15')->dropDownList($data,
                                ['prompt' => '---Pilih---','style'=>'width:290px'],
                                ['label'=>'']);
                        ?>
                        </div>
                    </div>
                    </div>
                </div>
             
                <div class="col-md-6" style="margin-top:15px;">
                    <div class="form-group">
                        <div class="col-md-8" style="margin-left:0px;">
                            <label class="col-md-2" style="margin-top:5px;">Saran</label>
                            <table id="table_saran-was15" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center; width:25%;">Terlapor</th>
                                        <th style="text-align:center; width:65%;">Saran</th>
                                    </tr>
                                </thead>
                                <?php
                                $searchTerlapor = new VRiwayatJabatan();
                                $dataTerlapor = $searchTerlapor->searchTerlaporQuery($no_register->id_register);
                                ?>
                                <tbody id="tbody_saran-was15">
                                    <?php
                                    $model_dropdown = new SpRTingkatphd();
                                    $data_dropdown = $model_dropdown->searchListSaran();
                                    if($model->isNewRecord){
                                    foreach ($dataTerlapor as $rows) {
                                        ?>
                                        <tr>
                                            <td><?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'],['style'=>'width:300px;']) ?></td>
                                            <?= Html::hiddenInput('id_terlapor3[]', $rows['id_terlapor']) ?>
                                            <td><?= Html::dropDownList('saran3[]', null, 
                                            ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['prompt' => 'Pilih Hukuman Disiplin',]) ?></td>
                                            
                                        </tr>    
                                    <?php }}
                                    else{

                                    foreach ($dataTerlapor as $rows) { ?>
                                    <tr>
                                        <?php $selected = Was15Saran::findOne(['id_terlapor'=>$rows['id_terlapor'],'rncn_jatuh_hukdis_was_15'=>$model->rncn_jatuh_hukdis_3_was_15])->tingkat_kd; ?>
                                            <td><?= Html::textInput('peg_nama_saranterlapor[]', $rows['peg_nama'],['style'=>'width:300px;']) ?></td>
                                            <?= Html::hiddenInput('id_terlapor3[]', $rows['id_terlapor']) ?>
                                            <td><?= Html::dropDownList('saran3[]', $selected, ArrayHelper::map($data_dropdown, 'tingkat_kd', 'hukdis'), ['prompt' => 'Pilih Hukuman Disiplin',],['options'=>['selected'=>true]]) ?></td>
                                            
                                        </tr> 
                                        <?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        
<div class="box box-primary" style="overflow: hidden;">    
            <div class="box-header with-border">
            <label class="col-md-8" style="margin-top:5px;">Persetujuan / Pendapat</label>
            <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
                <div class="col-md-6">
                <div class="form-inline">
                    
                <div class="col-md-8">
                    <?php
                    $options2 = [
                        'item' => function($index, $label, $name, $checked, $value) {

                            // check if the radio button is already selected
                            $checked = ($checked) ? 'checked' : '';

                            $return = '<label class="radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                            $return .= $label;
                            $return .= '</label>';

                            return $return;
                        }
                    ];
                    
                    $query_saran2 = app\models\LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '12'")->all();
                    $query_saran = ArrayHelper::map($query_saran2, 'kd_lookup_item', 'nm_lookup_item');
                    ?>
                    <?= $form->field($model, 'persetujuan')->radioList($query_saran, $options2) ?>
                    
                    <?php echo $form->field($model, 'pendapat')->
                                textarea(['rows' => 5, 'style' => 'width:637px','value'=>$model->isNewRecord{$model->pendapat}]);
                    ?>
                    </div>
                </div>
                </div>
            </div>
    </div>
</div>


<div class="box box-primary" style="overflow: hidden;">    
            <div class="box-header with-border">
        <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2" style="margin-top:5px;">Penandatangan</label>
                    <div class="col-lg-10"> <span style="margin-left:-55px;margin-right:20px;" class="pull-right"> <a data-target="#penandatangan" data-toggle="modal" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i> Tambah</a> </span> </div>
                </div>
            </div>
            <hr>
            <?php  
            if(!$model->isNewRecord){
                $searchModel2 = new \app\models\KpPegawaiSearch();
                $modelKepegawaian = $searchModel2->searchPegawaiTtd($model->ttd_peg_nik,$model->ttd_id_jabatan);
                $model->ttd_peg_nama = $modelKepegawaian['peg_nama'];
                $model->ttd_peg_nip = (empty($modelKepegawaian['peg_nip_baru']) ? $modelKepegawaian['peg_nip']:$modelKepegawaian['peg_nip_baru']);
                $model->ttd_peg_pangkat = $modelKepegawaian['gol_pangkat'];
                $model->ttd_peg_jabatan = $modelKepegawaian['jabatan'];
            } 
            ?>
            <?= $form->field($model, 'ttd_peg_nik')->hiddenInput() ?>
            <?= $form->field($model, 'ttd_id_jabatan')->hiddenInput() ?>
            <div class="col-md-6">
              <div class="form-group">
                <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
                <div class="col-lg-9">
                  <div class="form-group field-was15-ttd_peg_nik">
                    <div class="col-sm-12">
                     
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                      <div class="help-block"></div>
                    </div>
                  </div>
                  <div class="form-group field-was15-ttd_peg_nama">
                    <div class="col-sm-12">
                     
                       <?= $form->field($model, 'ttd_peg_nama')->textInput(['class' => 'form-control','readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">NIP</label>
                <div class="col-lg-9">
                  <div class="form-group field-was15-ttd_peg_nip">
                    <div class="col-sm-12">
                       <?= $form->field($model, 'ttd_peg_nip')->textInput(['class' => 'form-control','readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
              </div>
             
            </div>
            <div style="margin-top:15px;" class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3">Pangkat</label>
                <div class="col-lg-9">
                  <div class="form-group field-was15-ttd_peg_jabatan">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'ttd_peg_pangkat')->textInput(['class' => 'form-control','readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Jabatan</label>
                <div class="col-lg-9">
                  <div class="form-group field-was15-ttd_peg_inst_satker">
                    <div class="col-sm-12">
                       <?= $form->field($model, 'ttd_peg_jabatan')->textInput(['class' => 'form-control','readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
</div>
    

    <div class="box box-primary" style="overflow: hidden;">    
    <div class="box-header with-border">
        <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top:5px;">Tembusan</label>
                <div class="col-lg-10"> <span style="margin-left:-55px;margin-right:20px;" class="pull-right"> <a class="btn btn-primary" data-toggle="modal" data-target="#tembusan"><i class="glyphicon glyphicon-user"></i> Tambah</a> </span> </div>
            </div>
        </div>
        <table id="table_tembusan" class="table table-bordered">
            <thead>
                <tr>
                    <th>Tembusan</th>
                    <th width=10%>Hapus</th>
                </tr>
            </thead>
            <tbody id="tbody_tembusan-was15">
                <?php if(!$model->isNewRecord): ?>
					<?php foreach ($modelTembusan as $data): ?>
						<tr id="tembusan<?= $data['id_pejabat_tembusan'] ?>">
                            <input type="hidden" name="id_jabatan[]" class="form-control" readonly="true" value="<?= $data['id_pejabat_tembusan']?>">
							<td><input type="text" name="jabatan[]" class="form-control" readonly="true" value="<?= VPejabatTembusan::findOne(['id_pejabat_tembusan'=>$data->id_pejabat_tembusan])->jabatan; ?>"></td>
							<td><button onclick="removeTembusan('<?=$data['id_pejabat_tembusan']?>')" class="btn btn-primary" type="button">Hapus</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
    <br>
        
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Upload File</label>
                <div class="col-md-8">  
                    <?php 
                    echo $form->field($model, 'upload_file')->widget(FileInput::classname(), [
                        'options'=>[
                            'multiple'=>false,
                        ],
                        'pluginOptions' => [
                            'showPreview'=>true, 
                            'showUpload' => false,
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
        <?php if (!$model->isNewRecord) { ?>
          <div class="col-md-4">
            <div class="form-group">
              <div class="col-md-8">
                <?php echo $model->upload_file; ?>
              </div>
            </div>
          </div>
        <?php } ?>
    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
                
    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    <?= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$model->id_register]) ?>
    <?php
    if(!$model->isNewRecord)
    {
      echo Html::a('Cetak', ['/pengawasan/was15/cetak', 'id_was_15'=>$model->id_was_15,'id_register'=>$model->id_register], ['class' => 'btn btn-primary']);
      echo " ".Html::a('Hapus', ['/pengawasan/was15/delete', 'id'=>$model->id_was_15], ['id'=> 'hapusWas15','class' => 'btn btn-primary']); 
    }?>
      </div>
    </div>
    
    </div>
<?php ActiveForm::end(); ?>

<?php
Modal::begin([
'id' => 'm_terlapor_was15',
'header' => 'Detail Terlapor',

]);
?> 
<div id="terlapordetail">
</div>
    <?php
    Modal::end();
?>
<?php
    Modal::begin([
    'id' => 'penandatangan',
    'size' => 'modal-lg',
    'header' => '<h2>Pilih Riwayat Jabatan Pemeriksa</h2>',
    
    ]);
    echo $this->render( '_dataPegawai');
Modal::end();
?>
    
<?php
    Modal::begin([
        'id' => 'tembusan',
        'size' => 'modal-lg',
        'header' => '<h2>Pilih Tembusan</h2>',
    ]);
    echo $this->render( '@app/modules/pengawasan/views/global/_tembusan', ['param'=> 'was15'] );
Modal::end();
?>

<?php
Modal::begin([
'id' => 'm_saksiinternal_was15',
'header' => 'Detail Saksi Internal',

]);
?> 
<div id="saksiinternaldetail">
</div>
<?php
Modal::end();
?>