<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use app\modules\pengawasan\models\BaWas3inspeksi;
use app\modules\pengawasan\models\BaWas3inspeksiSearch;
use app\modules\pengawasan\models\BaWas3Search;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\db\Query;
use kartik\widgets\FileInput;
use app\modules\pengawasan\models\PemeriksaBawas3;

use app\models\LookupItem;

?>

<section class="content" style="padding: 0px;">
  <div class="content-wrapper-1">

  <?php $form = ActiveForm::begin([
        'id' => 'ba-was3-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
        'options' => [
                    'enctype' => 'multipart/form-data',
                ]
    ]); ?>

 <div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
  <div class="col-md-7">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-4">Tanggal Berita Acara</label>
        <div class="col-md-4">			
             <?=
                $form->field($model, 'tanggal_ba_was3',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                         	'startDate' => date('d-m-Y',strtotime($modelSpWas2['tanggal_sp_was2'])),
                            'endDate' => 0,
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?>
		</div>
	</div>
</div>
</div>

<div class="col-md-5">

    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-5">Nomor Sprint</label>
        <div class="col-md-7">
        			
				<input type="text" name="NomorSprint" class="form-control" readonly="true" value="<?= $modelSpWas2->nomor_sp_was2 ?>">
		</div>
	</div>
</div>
</div>

<div class="col-md-7">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-4">Tempat</label>
        <div class="col-md-8">
             <?= $form->field($model, 'tempat_ba_was3')->textArea(['rows' => '2']) ?>
				
		</div>
		</div> 
	</div>
</div>
 
 <div class="col-md-5">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-5">Tanggal Sprint</label>
        <div class="col-md-7">		
        	<div class="input-group">
        	<span class="input-group-addon">
				<i class="glyphicon glyphicon-calendar"></i>
			</span>	
				<input type="text" name="TglSprint" class="form-control" readonly="true" value="<?= date('d-m-Y',strtotime($modelSpWas2->tanggal_sp_was2))?>">
			</div>
	</div>
</div>
</div>
 </div>
 
<div class="col-md-12">
  <ul class="nav nav-tabs">
    <li  id="menu1" class="active"><a href="#TabTerlapor" id="terlapor" rell="0" data-toggle="tab">Terlapor</a></li>
    <li  id="menu2" class=""><a href="#TabSaksiIn"  id="saksiIn" rell="1" data-toggle="tab">Saksi Internal</a></li>
    <li  id="menu3" class=""><a href="#TabSaksiEk"  id="saksiEk" rell="2" data-toggle="tab">Saksi Eksternal</a></li>
  </ul>
</div>

  <div class="tab-content">
    <div id="TabSaksiIn" class="tab-pane fade"><!-- Saksi Internal -->

<!--=====================================================3-->
<div class="box box-primary">
  <div class="box-header with-border">
 
    <fieldset class="group-border">
        <legend class="group-border">Daftar Saksi Yang Dimintai Keterangan (Saksi Internal)</legend>
  		<?php if($model->isNewRecord){ ?>
   		<div class="col-sm-12"  style="margin-top:10px; margin-bottom:10px">
        <div class="btn-toolbar">
		<a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="Tambah_skasi_int"><i class="glyphicon glyphicon-plus">  </i> Tambah </a>
        </div>
        </div>
        <?php } ?>
    <input type="hidden" class="form-control" name="in_saksi_id" id="in_saksi_id" readonly="true" value="<?php echo $_GET['id2']; ?>">    
    <table id="table_saksi" class="table table-bordered">
			<thead>
				<tr>
					<th width="5px">No</th>
					<th width="33%">Nama</th>
					<th width="15%">NIP</th>
					<th width="20%">Golongan</th>
					<th width="20%">Pangkat</th>
					<th width="10%">Jabatan</th>
				</tr>
			</thead>
			<tbody class="bd_saksiIn">
			<?php
			if($model->isNewRecord){
				
			}else{
				$i=1;					
				foreach($modelSaksiInternal as $rowInternal){

				echo '<tr class="tr_saksiIn'.$rowInternal['nip'].'">';
				echo '<td align="center"> '.$i.'</td>';
				echo '<td>'.$rowInternal['nama_saksi_internal'].'</td>';
				echo '<td class="td_saksiIn'.$rowInternal['nip'].'">'.$rowInternal['nip'].'</td>';
				echo '<td>'.$rowInternal['golongan_saksi_internal'].'</td>';
				echo '<td>'.$rowInternal['pangkat_saksi_internal'].'</td>';
				echo '<td>'.$rowInternal['jabatan_saksi_internal'].'</td>';
				echo '</tr>';
				$i++;
				
				}

				}

                ?>
			</tbody>
		</table>
</fieldset>   
  </div>
</div>
<!--=====================================================3-->

</div>


 <div id="TabTerlapor" class="tab-pane fade in active"><!-- Terlapor -->
<?php
echo '<br>';
//print_r($modelTerlapor);
?>
<!--=====================================================3-->
<div class="box box-primary">
  <div class="box-header with-border">
  	<fieldset class="group-border">
        <legend class="group-border">Daftar Terlapor </legend>
   		<?php if($model->isNewRecord){ ?>
   		<div class="col-sm-12"  style="margin-top:10px; margin-bottom:10px">
        <div class="btn-toolbar">
		<a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="Tambah_terlapor"><i class="glyphicon glyphicon-plus">  </i> Tambah </a>
        </div>
        </div>
        <?php } ?>
    	<input type="hidden" class="form-control" name="terlapor_id" id="terlapor_id" readonly="true" value="<?php echo $_GET['id2']; ?>">
    	<table id="table_terlapor" class="table table-bordered">
			<thead>
				<tr>
					<th width="5px">No</th>
					<th width="40%">Nama</th>
					<th width="20%">NIP</th>
					<th width="25%">Jabatan</th>
					<th width="20%">Satker</th>
				</tr>
			</thead>
			<tbody class="tbody_terlapor">
			
			<?php
			if($model->isNewRecord){
				
			}else{
				$i=1;
				foreach($modelTerlapor as $rowTerlapor)			
				{
				echo '<tr>';
				echo '<td align="center"> '.$i.'</td>';
				echo '<td><input type="hidden" class="form-control" name="nama_pegawai_terlapor[]" readonly="true" value="'.$rowTerlapor['nama_pegawai_terlapor'].'">'.$rowTerlapor['nama_pegawai_terlapor'].'</td>';
				echo '<td><input type="hidden" class="form-control" name="nip[]" readonly="true" value="'.$rowTerlapor['nip_pegawai_terlapor'].'">'.$rowTerlapor['nip_pegawai_terlapor'].'</td>';
				echo '<td><input type="hidden" class="form-control" name="jabatan_pegawai_terlapor[]" readonly="true" value="'.$rowTerlapor['jabatan_pegawai_terlapor'].'"><input type="hidden" class="form-control" name="jabatan_pegawai_terlapor[]" readonly="true" value="'.$rowTerlapor['pangkat_pegawai_terlapor'].'">'.$rowTerlapor['jabatan_pegawai_terlapor'].'</td>';
				echo '<td><input type="hidden" class="form-control" name="satker_pegawai_terlapor[]" readonly="true" value="'.$rowTerlapor['satker_pegawai_terlapor'].'">'.$rowTerlapor['satker_pegawai_terlapor'].'</td>';
				echo '</tr>';
				$i++;
				} 
			}

                ?>
			</tbody>
		</table>
		</fieldset>
  </div>
</div>
<!--=====================================================3-->
</div>

<div id="TabSaksiEk" class="tab-pane fade"><!-- saksi Ekternal -->

<!--=====================================================3-->
<div class="box box-primary">
  <div class="box-header with-border">
	<!--=====================================================3-->

    <fieldset class="group-border">
        <legend class="group-border">Daftar Saksi Yang Dimintai Keterangan (Saksi Eksternal)</legend>
    		<?php if($model->isNewRecord){ ?>
	   		<div class="col-sm-12"  style="margin-top:10px; margin-bottom:10px">
	        <div class="btn-toolbar">
			<a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="Tambah_skasi_eks"><i class="glyphicon glyphicon-plus">  </i> Tambah </a>
	        </div>
	        </div>
	        <?php } ?>
    <!-- <input type="hidden" class="form-control" name="ck_eksternal" id="ck_eksternal" readonly="true" value="<?php // echo $_GET['id2']; ?>">         -->
    <table id="table_saksi_eksternal" class="table table-bordered">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="30%">Nama</th>
					<th width="13%">TTL</th>
					<th width="20%">Alamat</th>
					<th width="20%">Pekerjaan</th>
				</tr>
			</thead>
			<tbody class="bd_saksiEk">
			<?php
			if(!$model->isNewRecord){
				$i=1;					
				foreach($modelSaksiEksternal as $rowEksternal){

				echo '<tr class="tr_saksiEk'.$rowEksternal['id_saksi_eksternal'].'">';
				echo '<td align="center"> '.$i.'</td>';
				echo '<td class="td_saksiEk'.$rowEksternal['id_saksi_eksternal'].'">'.$rowEksternal['nama_saksi_eksternal'].'</td>';
				echo '<td>'.$rowEksternal['tempat_lahir_saksi_eksternal'].', '.date('d-m-Y',strtotime($rowEksternal['tanggal_lahir_saksi_eksternal'])).'</td>';
				echo '<td>'.$rowEksternal['alamat_saksi_eksternal'].'</td>';
				echo '<td>'.$rowEksternal['pekerjaan'].'</td>';
				echo '</tr>';
				$i++;
				} 
			
			}
                ?>
			</tbody>
		</table>

  </div>
</div>
<!--=====================================================3-->
</div>
</div>	

<!--==========================pemeriksa===========================3-->
<div class="box box-primary">
  <div class="box-header with-border">
    <fieldset class="group-border">
        <legend class="group-border">Daftar Pemeriksa</legend>
    		
    		<table id="table_pemeriksa" class="table table-bordered">
			<thead>
				<tr>
					<th width="5px">No</th>
					<th width="33%">Nama</th>
					<th width="33%">NIP</th>
					<th width="33%">Jabatan</th>
				</tr>
			</thead>
			<tbody class="bdRiksa">
			
			<?php  if($model->IsNewRecord){
				
			}else{
			$i=1;					
				foreach($modelPemeriksa as $rowPemeriksa){
				//pemeriksaBawas3= PemeriksaBawas3::::findOne(["id_ba_was_3"=>$model->id_ba_was_3]);
				echo '<tr class="trRiksa'.$rowPemeriksa['nip'].'">';
				echo '<td align="center"> '.$i.'</td>';
				echo '<td>'.$rowPemeriksa['nama_pemeriksa'].'</td>';
				echo '<td>'.$rowPemeriksa['nip_pemeriksa'].'</td>';
				echo '<td>'.$rowPemeriksa['jabatan_pemeriksa'].'</td>';
				if($rowPemeriksa['NipRiksa'] !=''){
				echo '<td align="center"  class="tdRiksa'.$rowPemeriksa['nip'].'" ><input type="hidden" class="form-control x'.$rowPemeriksa['nip'].'" name="nipInput[]"  value="'.$rowPemeriksa['nip'].'"><input type="hidden" class="form-control x'.$rowPemeriksa['nip'].'" name="namaInput[]"  value="'.$rowPemeriksa['nama_pemeriksa'].'"><input type="hidden" class="form-control x'.$rowPemeriksa['nip'].'" name="pangkatInput[]"  value="'.$rowPemeriksa['pangkat_pemeriksa'].'"><input type="hidden" class="form-control x'.$rowPemeriksa['nip'].'" name="jabatanInput[]"  value="'.$rowPemeriksa['jabatan_pemeriksa'].'"><input type="hidden" class="form-control x'.$rowPemeriksa['nip'].'" name="golonganInput[]"  value="'.$rowPemeriksa['golongan_pemeriksa'].'"><input type="hidden" class="form-control x'.$rowPemeriksa['nip'].'" name="nrpInput[]"  value="'.$rowPemeriksa['nrp'].'"><input class="td_pr" type="checkbox" checked="checked" name="ck_riksa" rel="trpemeriksa'.$rowPemeriksa['id_pemeriksa_sp_was1'].'" value="'.$rowPemeriksa['id_pemeriksa_sp_was1'].'" Nip="'.$rowPemeriksa['nip'].'" Nama="'.$rowPemeriksa['nama_pemeriksa'].'" Jabatan="'.$rowPemeriksa['jabatan_pemeriksa'].'" Nrp="'.$rowPemeriksa['nrp'].'" Pangkat="'.$rowPemeriksa['pangkat_pemeriksa'].'" Gol="'.$rowPemeriksa['golongan_pemeriksa'].'"></td>';
				}else{
				
				}
				echo '</tr>';
					$i++;
					} 
			}
                ?>
			</tbody>
		</table>
</fieldset>   
  </div>
</div>
<!--=====================================================3-->

<!--=======================pertanyaan==============================3-->
<div class="box box-primary">
  <div class="box-header with-border">
    <fieldset class="group-border">
	
        <legend class="group-border">Daftar Pertanyaan dan Jawaban </legend>
		 <!-- <div class="col-md-12" style="margin-top:2%;"> -->
		<div class="col-sm-12"  style="margin-top:10px; margin-bottom:10px">
        <div class="btn-toolbar">
		<a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="tambah_pertanyaan"><i class="glyphicon glyphicon-plus">  </i> Tambah </a>
		
        </div>
        </div>


		<!-- </div> -->
    <table id="table_pertanyaan" style="margin-top:3%;" class="table table-bordered">
			<thead>
				<tr>
					<th width="5px">No</th>
					<th width="50%">Pertanyaan</th>
					<th width="50%">Jawaban</th>
					<th width="50%">Aksi</th>
				</tr>
			</thead>
			<tbody id="tbody_pertanyaan">
				<?php
			if(!$model->isNewRecord){
				$i=1;					
				foreach($modelPertanyaan as $rowPertanyaan){
				echo '<tr data-id="'.$rowPertanyaan['no_urut'].'" class="trpertanyaan'.$rowPertanyaan['no_urut'].'"></td>';
				echo '<td align="center"> '.$i++.'</td>';
				echo '<td><input type="hidden" class="form-control" name="pertanyaan[]" readonly="true" value="'.$rowPertanyaan['pertanyaan'].'">'.$rowPertanyaan['pertanyaan'].'</td>';
				echo '<td><input type="hidden" class="form-control" name="jawaban[]" readonly="true" value="'.$rowPertanyaan['jawaban'].'">'.$rowPertanyaan['jawaban'].'</td>';
				echo '<td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="trpertanyaan'.$rowPertanyaan['no_urut'].'" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td>';
				echo '</tr>';
				} 
						}
                ?>
			</tbody>
		</table>
</fieldset>   
  </div>
</div>
<!--=====================================================3-->
			<?php 
				if($model->isNewRecord){
				echo $form->field($model, 'sebagai')->hiddenInput(['value'=>'0']);				

				}else{
				echo $form->field($model, 'sebagai')->hiddenInput();				
				}
			?>
<!--========================penandatangan=========================3-->

		<?php if(!$model->isNewRecord) { ?>
        <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas BA-WAS-3 Inspeksi :
                    <?php if (substr($model->bawas3_file,-3)!='pdf'){?>
                        <?= ($model['bawas3_file']!='' ? '<a href="viewpdf?id='.$model['id_ba_was3'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['bawas3_file']!='' ? '<a href="viewpdf?id='.$model['id_ba_was3'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                    <?php } ?>
                </label>
                <!-- <input type="file" name="bawas3_file" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="bawas3_file" id="bawas3_file" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
        <?php
        }
        ?>

  
<!--=====================================================3-->
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<input type="hidden" name="print" value="2" id="print"/> 
    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
      <?php
      if (!$model->isNewRecord) {
       echo " ".Html::a('<i class ="fa fa-trash"></i> Hapus', ['/pengawasan/ba-was3-inspeksi/hapus', 'id' => $model->id_ba_was3], ['id' => 'hapusBaWas3', 'class' => 'btn btn-primary']);
       	if($model->peruntukan_ba=='Saksi Eksternal'){
       		echo " ".Html::a('<i class ="fa fa-print"></i> Cetak', ['/pengawasan/ba-was3-inspeksi/cetakeks', 'id' => $model->id_ba_was3], ['id' => 'hapusBaWas3', 'class' => 'btn btn-primary']);
       	}else if($model->peruntukan_ba=='Saksi Internal'){
       		echo " ".Html::a('<i class ="fa fa-print"></i> Cetak', ['/pengawasan/ba-was3-inspeksi/cetakint', 'id' => $model->id_ba_was3], ['id' => 'hapusBaWas3', 'class' => 'btn btn-primary']);
       }else if($model->peruntukan_ba=='Terlapor'){
       		echo " ".Html::a('<i class ="fa fa-print"></i> Cetak', ['/pengawasan/ba-was3-inspeksi/cetak', 'id' => $model->id_ba_was3], ['id' => 'hapusBaWas3', 'class' => 'btn btn-primary']);
       	}
      }
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Kembali', ['/pengawasan/ba-was3-inspeksi/index'], ['id' => 'KembaliBaWas3', 'class' => 'btn btn-primary']);
	   ?>
    </div>
    </div>
<?php ActiveForm::end(); ?>
  </div>
<section>


	<div class="modal fade" id="Mterlapor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Daftar Terlapor Yang Diundang</h4>
                </div>
                <div class="modal-body">
                    <p>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                           // $searchModelBawas3 = new BaWas3inspeksiSearch();
                           //$dataProviderBawas3 = $searchModelBawas3->searchBawas3Inspeksiterlapor(Yii::$app->request->queryParams);
                            $searchModelBawas3 = new BaWas3InspeksiSearch();
                            $dataProviderBawas3 = $searchModelBawas3->searchBawas3Inspeksiterlapor(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?= GridView::widget([
                                'dataProvider'=> $dataProviderBawas3,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_pegawai_terlapor',
                                    ],
                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],
                                    ['label'=>'Golongan Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'golongan_pegawai_terlapor',
                                    ],
                                    ['label'=>'Satker Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'satker_pegawai_terlapor',
                                    ],
                                    ['class' => 'yii\grid\CheckboxColumn',
	                                 'headerOptions'=>['style'=>'text-align:center'],
	                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
	                                           'checkboxOptions' => function ($data) {
	                                            $result=json_encode($data);
	                                            return ['value' => $data['nip_pegawai_terlapor'],'class'=>'selection_one_terlapor','json'=>$result];
	                                            },
	                                    ],


                                 ],   

                            ]); ?>
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="Mbtntmbahterlapor">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MsaksiInt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Daftar Saksi Internal Yang Diundang</h4>
                </div>
                <div class="modal-body">
                    <p>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelBawas3In = new BaWas3inspeksiSearch();
                            $dataProviderBawas3In = $searchModelBawas3In->searchBawas3skasiint(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?= GridView::widget([
                                'dataProvider'=> $dataProviderBawas3In,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],
                                    ['label'=>'Nama Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_saksi_internal',
                                    ],
                                    ['label'=>'Golongan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'golongan_saksi_internal',
                                    ],
                                    ['label'=>'Jabatan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_saksi_internal',
                                    ],
                                    ['class' => 'yii\grid\CheckboxColumn',
	                                 'headerOptions'=>['style'=>'text-align:center'],
	                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
	                                           'checkboxOptions' => function ($data) {
	                                            $result=json_encode($data);
	                                            return ['value' => $data['nip'],'class'=>'selection_one_saksi_int','json'=>$result];
	                                            },
	                                    ],


                                 ],   

                            ]); ?>
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="Mbtntmbahsaksiint">Tambah</button>
                </div>
            </div>
        </div>
    </div>

	<div class="modal fade" id="MsaksiEks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title" id="myModalLabel">Daftar Saksi Eksternal Yang Diundang</h4>
	                </div>
	                <div class="modal-body">
	                    <p>
	                    </p>
	                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
	                        <?php
	                            $searchModelBawas3Ek = new BaWas3inspeksiSearch();
	                            $dataProviderBawas3Ek = $searchModelBawas3Ek->searchBawas3skasieks(Yii::$app->request->queryParams);
	                        ?>
	                        <div id="w1" class="grid-view">
	                            <?= GridView::widget([
	                                'dataProvider'=> $dataProviderBawas3Ek,
	                                // 'filterModel' => $searchModel,
	                                // 'layout' => "{items}\n{pager}",
	                                'columns' => [
	                                    ['header'=>'No',
	                                    'headerOptions'=>['style'=>'text-align:center;'],
	                                    'contentOptions'=>['style'=>'text-align:center;'],
	                                    'class' => 'yii\grid\SerialColumn'],
	                                    
	                                    
	                                    ['label'=>'Nama Saksi',
	                                        'headerOptions'=>['style'=>'text-align:center;'],
	                                        'attribute'=>'nama_saksi_eksternal',
	                                    ],
	                                    ['label'=>'Golongan Saksi',
	                                        'headerOptions'=>['style'=>'text-align:center;'],
	                                        'attribute'=>'alamat_saksi_eksternal',
	                                    ],
	                                    ['label'=>'Kota',
	                                        'headerOptions'=>['style'=>'text-align:center;'],
	                                        'attribute'=>'nama_kota_saksi_eksternal',
	                                    ],
	                                    ['class' => 'yii\grid\CheckboxColumn',
		                                 'headerOptions'=>['style'=>'text-align:center'],
		                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
		                                           'checkboxOptions' => function ($data) {
		                                            $result=json_encode($data);
		                                            return ['value' => $data['nip'],'class'=>'selection_one_saksi_eks','json'=>$result];
		                                            },
		                                    ],


	                                 ],   

	                            ]); ?>
	                           
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	                    <button type="button" class="btn btn-default" id="Mbtntmbahsaksieks">Tambah</button>
	                </div>
	            </div>
	        </div>
	</div>




<script type="text/javascript">
$(document).ready(function(){
	    var surat="<?php echo $model['sebagai']?>";

    if(surat=="0"){/*terlapor*/
         $('.nav-tabs a[href="#TabTerlapor"]').tab('show');
         $('#terlapor').css({"font-weight": "bold"});
         $('#menu2').attr('class', 'disabled active');
         $('#menu3').attr('class', 'disabled active');
    }else if(surat=="1"){/*Sakasi Internal*/
         $('.nav-tabs a[href="#TabSaksiIn"]').tab('show');
         $('#saksiIn').css({"font-weight": "bold"});
         $('#menu1').attr('class', 'disabled active');
         $('#menu3').attr('class', 'disabled active');
         // $('#was12').attr('class', 'disabled active');
    }else if(surat=="2"){/*Saksi Eksternal*/
         // $('#was11').attr('class', 'active');
         $('.nav-tabs a[href="#TabSaksiEk"]').tab('show');
         $('#saksiEk').css({"font-weight": "bold"});
         $('#menu1').attr('class', 'disabled active');
         $('#menu2').attr('class', 'disabled active');
         // $('#was12').attr('class', 'disabled active');
    }
});
//Validasi File 3MB by Danar
	   $('#bawas3-bawas3_file').bind('change', function() {
			var batas =this.files[0].size;
			if (batas > 3145728){
            bootbox.dialog({
                message: "Maaf Ukuran File B.Was-3 Lebih Dari 3 MB",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
			document.getElementById("bawas3-bawas3_file").value = "";
			}
        });
		
		$('.td_tl').bind('change', function() {
			var jabatan=$('input[name=rb_terlapor]:checked').attr('ejabatan');
			var satker=$('input[name=rb_terlapor]:checked').attr('esatker');
			var nama=$('input[name=rb_terlapor]:checked').attr('enama');
			var nip=$('input[name=rb_terlapor]:checked').attr('enip');
			var pangkat=$('input[name=rb_terlapor]:checked').attr('epangkat');
			var idterlapor=$('input[name=rb_terlapor]:checked').attr('eidterlapor');
			$("#bawas3-nama_dimintai_keterangan").val(nama);
			$("#bawas3-nip_dimintai_keterangan").val(nip);
			$("#bawas3-jabatan_dimintai_keterangan").val(jabatan);
			$("#bawas3-satker_dimintai_keterangan").val(satker);
			$("#bawas3-pangkat_dimintai_keterangan").val(pangkat);
			$("#bawas3-id_terlapor_saksi").val(idterlapor);
			$("#terlapor_id").val(idterlapor);
			//alert('aaaa');
		});

		// $('.td_pr').bind('change', function() {
		
		// var nip=$(this).attr('Nip');
		// var nama=$(this).attr('Nama');
		// var jabatan=$(this).attr('Jabatan');
		// var golongan=$(this).attr('Gol');
		// var nrp=$(this).attr('Nrp');
		// var pangkat=$(this).attr('Pangkat');
		// if($(this).is(":checked")) {
  //     $('.bdRiksa').find('.trRiksa'+nip).find('.tdRiksa'+nip).append('<input type=\"hidden\" class=\"form-control x'+nip+'\" name=\"nipInput[]\"  value=\"'+nip+'\">'+
		// 															'<input type=\"hidden\" class=\"form-control x'+nip+'\" name=\"namaInput[]\"  value=\"'+nama+'\">'+
		// 															'<input type=\"hidden\" class=\"form-control x'+nip+'\" name=\"jabatanInput[]\"  value=\"'+jabatan+'\">'+
		// 															'<input type=\"hidden\" class=\"form-control x'+nip+'\" name=\"golonganInput[]\"  value=\"'+golongan+'\">'+
		// 															'<input type=\"hidden\" class=\"form-control x'+nip+'\" name=\"pangkatInput[]\"  value=\"'+pangkat+'\">'+
		// 															'<input type=\"hidden\" class=\"form-control x'+nip+'\" name=\"nrpInput[]\"  value=\"'+nrp+'\">');	
		// }else{
		// 	$('.x'+nip).remove();
	
		// }		
		// });

		$(".ck_saksiIn").click(function(){
			var nilai=$(this).val();
			var nm=$(this).attr('nm');
			var jabat=$(this).attr('jabat');
			var pangkat=$(this).attr('pangkat');
			var gol=$(this).attr('gol');
			var id_saksi_internal=$(this).attr('id_saksi_internal');
			$("#bawas3-nama_dimintai_keterangan").val(nm);
			$("#bawas3-id_terlapor_saksi").val(id_saksi_internal);
			$("#in_saksi_id").val(id_saksi_internal);
			// if( $(this).is(':checked') ){
			// 	$('.bd_saksiIn').find('.tr_saksiIn'+nilai).find('.td_saksiIn'+nilai).append('<div class=\"input_saksiIn'+nilai+'\">'+
			// 		'<input type=\"hidden\" name=\"nip_saksi_internal\" value=\"'+nilai+'\">'+
			// 		'<input type=\"hidden\" name=\"nama_saksi_internal\" value=\"'+nm+'\">'+
			// 		'<input type=\"hidden\" name=\"pangkat_saksi_internal\" value=\"'+pangkat+'\">'+
			// 		'<input type=\"hidden\" name=\"golongan_saksi_internal\" value=\"'+gol+'\">'+
			// 		'<input type=\"hidden\" name=\"jabatan_saksi_internal\" value=\"'+jabat+'\">'+
			// 	 '</div>')
			// 	// alert("checked");
			// }else{
			// 	$('.bd_saksiIn').find('.tr_saksiIn'+nilai).find('.td_saksiIn'+nilai).find('.input_saksiIn'+nilai).remove();
			// } 
		});	

		$(".ck_saksiEk").click(function(){
			 var x=$(".ck_saksiEk:checked").length;
			if(x>=2){
			//	alert('asdasd');
				return false;
			}else{
			var nilai=$(this).val();
			var nm=$(this).attr('nm');
			var alamat=$(this).attr('alamat');
			var tmpat_lahir=$(this).attr('tmpat_lahir');
			var tgl_lahir=$(this).attr('tgl_lahir');
			var wn=$(this).attr('wn');
			var pendidikan=$(this).attr('pendidikan');
			var agama=$(this).attr('agama');
			var kota=$(this).attr('kota');
			var pakerjaan=$(this).attr('pakerjaan');
			// alert(nilai);
			
			if( $(this).is(':checked') ){
				$('.bd_saksiEk').find('.tr_saksiEk'+nilai).find('.td_saksiEk'+nilai).append('<div class=\"input_saksiEk'+nilai+'\">'+
					'<input type=\"hidden\" name=\"id_saksi_internal\" value=\"'+nilai+'\">'+
					'<input type=\"hidden\" name=\"nama_saksi_eksternal\" value=\"'+nm+'\">'+
					'<input type=\"hidden\" name=\"tempat_lahir_saksi_eksternal\" value=\"'+tmpat_lahir+'\">'+
					'<input type=\"hidden\" name=\"tanggal_lahir_saksi_eksternal\" value=\"'+tgl_lahir+'\">'+
					'<input type=\"hidden\" name=\"wn_saksi_eksternal\" value=\"'+wn+'\">'+
					'<input type=\"hidden\" name=\"pendidikan_saksi_eksternal\" value=\"'+pendidikan+'\">'+
					'<input type=\"hidden\" name=\"agama_saksi_eksternal\" value=\"'+agama+'\">'+
					'<input type=\"hidden\" name=\"alamat_saksi_eksternal\" value=\"'+alamat+'\">'+
					'<input type=\"hidden\" name=\"kota_saksi_eksternal\" value=\"'+kota+'\">'+
					'<input type=\"hidden\" name=\"pekerjaan_saksi_eksternal\" value=\"'+pakerjaan+'\">'+
				 '</div>');
				 
			}else{
				$('.bd_saksiEk').find('.tr_saksiEk'+nilai).find('.td_saksiEk'+nilai).find('.input_saksiEk'+nilai).remove();
			} 

		}
		});
 window.onload = function () {
 	 $(document).on('click','a#terlapor', function(){
			var nilai=$(this).attr('rell');
			$("#bawas3inspeksi-sebagai").val(nilai);
		});
 	 $(document).on('click','a#saksiIn', function(){
			var nilai=$(this).attr('rell');
			$("#bawas3inspeksi-sebagai").val(nilai);
		});
 	 $(document).on('click','a#saksiEk', function(){
			var nilai=$(this).attr('rell');
			$("#bawas3inspeksi-sebagai").val(nilai);
		});
 	 $(document).on('click','a.hapus_pertanyaan', function(){
			var x=$(this).attr('rel');
		//	alert(x);
			// $('.'+x).remove();
			$(this).closest('tr').remove();
		});

 	$(document).on('click','#menu1', function(){
		$('.rows_riksa').remove();
        $('.rows_saksi_int').remove();
        $('.rows_saksi_eks').remove();
	});
 	$(document).on('click','#menu2', function(){
		$('.rows_riksa').remove();
        $('.rows').remove();
        $('.rows_saksi_eks').remove();
	});
 	$(document).on('click','#menu3', function(){
		$('.rows_riksa').remove();
		$('.rows').remove();
        $('.rows_saksi_int').remove();
	});

	/*clear modal*/
	$(document).on('hidden.bs.modal','#Mterlapor', function (e) {
          $(this)
            .find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();

    });
    $(document).on('hidden.bs.modal','#MsaksiInt', function (e) {
          $(this)
            .find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();

    });
    $(document).on('hidden.bs.modal','#MsaksiEks', function (e) {
          $(this)
            .find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();

    });



 	$(document).on('click','#Tambah_terlapor', function(){
		 $('#Mterlapor').modal({backdrop: 'static', keyboard: false});
		});


 	$(document).on('click','#Mbtntmbahterlapor', function(){
 			var data=JSON.parse($('.selection_one_terlapor:checked').attr('json'));
 			$('.rows').remove();
			$('.tbody_terlapor').append('<tr class=\"rows\">'+
				'<td><input type=\"hidden\" name=\"terlapor_id\" value=\"'+data.id_pegawai_terlapor+'\" id=\"terlapor_id\">'+
				'<input type=\"hidden\" name=\"id_spwas_terlapor\" value=\"'+data.id_sp_was2+'\" id=\"id_spwas_terlapor\"></td>'+
				'<input type=\"hidden\" name=\"id_was10\" value=\"'+data.id_surat_was10+'\" id=\"id_spwas_terlapor\"></td>'+
				'<td>'+data.nama_pegawai_terlapor+'</td>'+
				'<td>'+data.nip_pegawai_terlapor+'</td>'+
				'<td>'+data.jabatan_pegawai_terlapor+'</td>'+
				'<td>'+data.satker_pegawai_terlapor+'</td>'+
				'</tr>');

 			$('.rows_riksa').remove();
			$('.bdRiksa').append('<tr class=\"rows_riksa\">'+
				'<td>'+
				'<input type=\"hidden\" name=\"id_pemeriksa\" value=\"'+data.id_pemeriksa+'\" id=\"id_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nama_pemeriksa\" value=\"'+data.nama_pemeriksa+'\" id=\"nama_pemeriksa\">'+
				'<input type=\"hidden\" name=\"pangkat_pemeriksa\" value=\"'+data.pangkat_pemeriksa+'\" id=\"pangkat_pemeriksa\">'+
				'<input type=\"hidden\" name=\"golongan_pemeriksa\" value=\"'+data.golongan_pemeriksa+'\" id=\"golongan_pemeriksa\">'+
				'<input type=\"hidden\" name=\"jabatan_pemeriksa\" value=\"'+data.jabatan_pemeriksa+'\" id=\"jabatan_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nip_pemeriksa\" value=\"'+data.nip_pemeriksa+'\" id=\"nip_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nrp_pemeriksa\" value=\"'+data.nrp_pemeriksa+'\" id=\"nrp_pemeriksa\">'+
				'</td>'+
				'<td>'+data.nama_pemeriksa+'</td>'+
				'<td>'+data.nip_pemeriksa+'</td>'+
				'<td>'+data.jabatan_pemeriksa+'</td>'+
				'</tr>');

			 $('#Mterlapor').modal('hide');
		});


 	/*saksi Internal*/
 	$(document).on('click','#Tambah_skasi_int', function(){
		 $('#MsaksiInt').modal({backdrop: 'static', keyboard: false});
		});

 	$(document).on('click','#Mbtntmbahsaksiint', function(){
 			var data=JSON.parse($('.selection_one_saksi_int:checked').attr('json'));
 			$('.rows_saksi_int').remove();
			$('.bd_saksiIn').append('<tr class=\"rows_saksi_int\">'+
				'<td><input type=\"hidden\" name=\"in_saksi_id\" value=\"'+data.id_saksi_internal+'\" id=\"in_saksi_id\">'+
				'<input type=\"hidden\" name=\"id_spwas_in\" value=\"'+data.id_sp_was2+'\" id=\"id_spwas_in\"></td>'+
				'<input type=\"hidden\" name=\"id_was10\" value=\"'+data.id_surat_was9+'\" id=\"id_spwas_in\"></td>'+
				'<td>'+data.nama_saksi_internal+'</td>'+
				'<td>'+data.nip+'</td>'+
				'<td>'+data.golongan_saksi_internal+'</td>'+
				'<td>'+data.pangkat_saksi_internal+'</td>'+
				'<td>'+data.jabatan_saksi_internal+'</td>'+
				'</tr>');

 			$('.rows_riksa').remove();
			$('.bdRiksa').append('<tr class=\"rows_riksa\">'+
				'<td>'+
				'<input type=\"hidden\" name=\"id_pemeriksa\" value=\"'+data.id_pemeriksa+'\" id=\"id_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nama_pemeriksa\" value=\"'+data.nama_pemeriksa+'\" id=\"nama_pemeriksa\">'+
				'<input type=\"hidden\" name=\"pangkat_pemeriksa\" value=\"'+data.pangkat_pemeriksa+'\" id=\"pangkat_pemeriksa\">'+
				'<input type=\"hidden\" name=\"golongan_pemeriksa\" value=\"'+data.golongan_pemeriksa+'\" id=\"golongan_pemeriksa\">'+
				'<input type=\"hidden\" name=\"jabatan_pemeriksa\" value=\"'+data.jabatan_pemeriksa+'\" id=\"jabatan_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nip_pemeriksa\" value=\"'+data.nip_pemeriksa+'\" id=\"nip_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nrp_pemeriksa\" value=\"'+data.nrp_pemeriksa+'\" id=\"nrp_pemeriksa\">'+
				'</td>'+
				'<td>'+data.nama_pemeriksa+'</td>'+
				'<td>'+data.nip_pemeriksa+'</td>'+
				'<td>'+data.jabatan_pemeriksa+'</td>'+
				'</tr>');

			 $('#MsaksiInt').modal('hide');
		});

 	/*saksi Eksternal*/
 	$(document).on('click','#Tambah_skasi_eks', function(){
		 $('#MsaksiEks').modal({backdrop: 'static', keyboard: false});
		});
	
	$(document).on('click','#Mbtntmbahsaksieks', function(){
 			var data=JSON.parse($('.selection_one_saksi_eks:checked').attr('json'));
 			$('.rows_saksi_eks').remove();
			$('.bd_saksiEk').append('<tr class=\"rows_saksi_eks\">'+
				'<td><input type=\"hidden\" name=\"ek_saksi_id\" value=\"'+data.id_saksi_eksternal+'\" id=\"ek_saksi_id\">'+
				'<input type=\"hidden\" name=\"id_spwas_ek\" value=\"'+data.id_sp_was2+'\" id=\"id_spwas_ek\"></td>'+
				'<input type=\"hidden\" name=\"id_was9\" value=\"'+data.id_surat_was9+'\" id=\"id_spwas_ek\"></td>'+
				'<td>'+data.nama_saksi_eksternal+'</td>'+
				'<td>'+data.tempat_lahir_saksi_eksternal+' '+data.tanggal_lahir_saksi_eksternal+'</td>'+
				'<td>'+data.alamat_saksi_eksternal+'</td>'+
				'<td>'+data.pekerjaan_saksi_eksternal+'</td>'+
				'</tr>');

 			$('.rows_riksa').remove();
			$('.bdRiksa').append('<tr class=\"rows_riksa\">'+
				'<td>'+
				'<input type=\"hidden\" name=\"id_pemeriksa\" value=\"'+data.id_pemeriksa+'\" id=\"id_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nama_pemeriksa\" value=\"'+data.nama_pemeriksa+'\" id=\"nama_pemeriksa\">'+
				'<input type=\"hidden\" name=\"pangkat_pemeriksa\" value=\"'+data.pangkat_pemeriksa+'\" id=\"pangkat_pemeriksa\">'+
				'<input type=\"hidden\" name=\"golongan_pemeriksa\" value=\"'+data.golongan_pemeriksa+'\" id=\"golongan_pemeriksa\">'+
				'<input type=\"hidden\" name=\"jabatan_pemeriksa\" value=\"'+data.jabatan_pemeriksa+'\" id=\"jabatan_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nip_pemeriksa\" value=\"'+data.nip_pemeriksa+'\" id=\"nip_pemeriksa\">'+
				'<input type=\"hidden\" name=\"nrp_pemeriksa\" value=\"'+data.nrp_pemeriksa+'\" id=\"nrp_pemeriksa\">'+
				'</td>'+
				'<td>'+data.nama_pemeriksa+'</td>'+
				'<td>'+data.nip_pemeriksa+'</td>'+
				'<td>'+data.jabatan_pemeriksa+'</td>'+
				'</tr>');

			 $('#MsaksiEks').modal('hide');
		});


	$(document).on('click','a#tambah_pertanyaan', function(){
			$('#tbody_pertanyaan').append('<tr class=\"rows\">'+
				'<td class=\"no\"></td>'+
				'<td><textarea class="form-control" name="pertanyaan[]" rows="2"></textarea></td>'+
				'<td><textarea class="form-control" name="jawaban[]" rows="2"></textarea></td>'+
				'<td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td></tr>');
		i = 0;
		$('#tbody_pertanyaan').find('.rows').each(function () {

        i++;
        $(this).addClass('rows'+i);
        $(this).find('.hapus_pertanyaan').attr('rel','rows'+i);
        // $(this).find('.cekbok').val(i);
    	});	

		});
 }

 $('#cetak').click(function(){

          $('#print').val('1');
        });

        $('#simpan').click(function(){
          $('#print').val('2');
        });

</script>




<style type="text/css">
fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
/*upload file css*/
.clearfix{*zoom:1;}.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0;}
.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.btn-file{overflow:hidden;position:relative;vertical-align:middle;}.btn-file>input{position:absolute;top:0;right:0;margin:0;opacity:0;filter:alpha(opacity=0);transform:translate(-300px, 0) scale(4);font-size:23px;direction:ltr;cursor:pointer;}
.fileupload{margin-bottom:9px;}.fileupload .uneditable-input{display:inline-block;margin-bottom:0px;vertical-align:middle;cursor:text;}
.fileupload .thumbnail{overflow:hidden;display:inline-block;margin-bottom:5px;vertical-align:middle;text-align:center;}.fileupload .thumbnail>img{display:inline-block;vertical-align:middle;max-height:100%;}
.fileupload .btn{vertical-align:middle;}
.fileupload-exists .fileupload-new,.fileupload-new .fileupload-exists{display:none;}
.fileupload-inline .fileupload-controls{display:inline;}
.fileupload-new .input-append .btn-file{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
.thumbnail-borderless .thumbnail{border:none;padding:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;}
.fileupload-new.thumbnail-borderless .thumbnail{border:1px solid #ddd;}
.control-group.warning .fileupload .uneditable-input{color:#a47e3c;border-color:#a47e3c;}
.control-group.warning .fileupload .fileupload-preview{color:#a47e3c;}
.control-group.warning .fileupload .thumbnail{border-color:#a47e3c;}
.control-group.error .fileupload .uneditable-input{color:#b94a48;border-color:#b94a48;}
.control-group.error .fileupload .fileupload-preview{color:#b94a48;}
.control-group.error .fileupload .thumbnail{border-color:#b94a48;}
.control-group.success .fileupload .uneditable-input{color:#468847;border-color:#468847;}
.control-group.success .fileupload .fileupload-preview{color:#468847;}
.control-group.success .fileupload .thumbnail{border-color:#468847;}

</style>

<script type="text/javascript">
  /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

</script>