<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use app\modules\pengawasan\models\BaWas2Search;
use yii\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\db\Query;
use kartik\widgets\FileInput;


use app\models\LookupItem;

?>



  <?php $form = ActiveForm::begin([
        'id' => 'ba-was2-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
        'options'=>['enctype'=>'multipart/form-data'] ,
    ]); ?>
<section class="content" style="padding: 0px;">
<div class="content-wrapper-1">		
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
<?php
$connection = \Yii::$app->db;
        $sql="select a.* from was.sp_was_1 a
				where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
$spwas1=$connection->createCommand($sql)->queryOne();
?>
<div class="col-md-7">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-4">Tanggal Berita Acara</label>
        <div class="col-md-4">			
             <?= $form->field($model, 'tgl',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
							'startDate' => date("d-m-Y",strtotime($spwas1['tanggal_mulai_sp_was1'])),
							'endDate' => 0,
                            'autoclose' => true,
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
        <label class="control-label col-md-4">Nomor Sprint</label>
        <div class="col-md-8">			
                <input type="text" name="NomorSprint" class="form-control" readonly="true" value="<?= $spwas1['nomor_sp_was1'] ?>">
		</div>
	</div>
</div>
</div>
<div class="col-md-7">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-4">Tempat</label>
        <div class="col-md-8">
               <?=  $form->field($model, 'tempat')->textArea() ?>
             
				
		</div>
		</div> 
	</div>
</div>
 
 <div class="col-md-5">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-4">Tanggal Sprint</label>
        <div class="col-md-8">		
        	<div class="input-group">
				<span class="input-group-addon">
					<i class="glyphicon glyphicon-calendar"></i>
				</span>	
                <input type="text" name="TglSprint" class="form-control" readonly="true" value="<?= date('d-m-Y',strtotime($spwas1['tanggal_sp_was1']))?>">
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!--=====================================================3-->
<div class="box box-primary">
  <div class="box-header with-border">
    <!-- <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12"> -->
      <div class="btn-toolbar">
        <label style="margin-top:5px;" class="control-label col-md-6">DAFTAR PEMERIKSA</label>
		<a class="btn btn-primary btn-sm pull-right" id="hapus_riksa"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
      </div>
    <!-- </div> -->
    <hr>
      <table id="table_pemeriksa" class="table table-bordered">
			<thead>
				<tr>
					<th width="3%">No</th>
					<th width="33%">NIP</th>
					<th width="33%">Nama</th>
					<th width="33%">Jabatan</th>
					<th width="33%">Pangkat</th>
					<th width="33%">Golongan</th>
					<th width="4%">Pilih</th>
				</tr>
			</thead>
			 <tbody class="bd_pemeriksa_tmp">
			 	<?php
			 		// if($model->isNewRecord){ 
			 			$no=1;
						foreach ($modelPemeriksa as $data) {
			 		?>
			 	<tr>
			 		<td><?=$no?></td>
			 		<td><?=$data['nip']?></td>
			 		<td><?=$data['nama_pemeriksa']?></td>
			 		<td><?=$data['jabatan_pemeriksa']?></td>
			 		<td><?=$data['pangkat_pemeriksa']?></td>
			 		<td><?=$data['golongan_pemeriksa']?></td>
			 		<td>
			 			<input type="checkbox" name="selection_one_pemeriksa" class="selection_one_pemeriksa" value="<?=$data['nip']?>">
			 			<input type="hidden" name="nip_pemeriksa[]" value="<?=$data['nip']?>">
			 			<input type="hidden" name="nrp_pemeriksa[]" value="<?=$data['nrp']?>">
			 			<input type="hidden" name="nama_pemeriksa[]" value="<?=$data['nama_pemeriksa']?>">
			 			<input type="hidden" name="golongan_pemeriksa[]" value="<?=$data['golongan_pemeriksa']?>">
			 			<input type="hidden" name="pangkat_pemeriksa[]" value="<?=$data['pangkat_pemeriksa']?>">
			 			<input type="hidden" name="jabatan_pemeriksa[]" value="<?=$data['jabatan_pemeriksa']?>">
			 		</td>
			 	</tr>
			 	<?php
			 		$no++;
			 			}	
			 		// }
			 	?>
               
            </tbody>
		</table>
    
   
  </div>
</div>
<!--=====================================================3-->

<!-- <div calss="col-md-12">
<div class=" col-md-12 container"> -->
  <ul class="nav nav-tabs">
    <li id="int" class="active"><a id="saksi_int" href="#home"  data-toggle="tab">Saksi Internal</a></li>
    <li id="ekst" class=""><a id="saksi_eks" href="#menu1"  data-toggle="tab">Saksi Eksternal</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

<div class="box box-primary">
    <!-- <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12"> -->
    <div class="btn-toolbar">
        <label style="margin-top:5px;" class="control-label col-md-8">DAFTAR SAKSI YANG DIWAWANCARA (Saksi Internal)</label>
        <a class="btn btn-primary btn-sm pull-right" id="hapus_internal" style="margin-right:10px;margin-top: 10px;"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
    </div>
    <hr>
   
      <table id="table_internal" class="table table-bordered" style="padding:10px;">
			<thead>
				<tr>
					<th width="3%">No</th>
					<th width="21%">Nama</th>
					<th width="18%">Pangkat</th>
					<th width="18%">NIP/NRP</th>
					<th width="20%">Jabatan</th>
					<th width="10%">Golongan</th>
					<th width="4%">Pilih</th>
				</tr>
			</thead>
			<tbody id="tbody-internal">
				<?php
			 		// if($model->isNewRecord){ 
			 			$no=1;
						foreach ($modelSaksiInternal as $dataSaksiInt) {
			 		?>
			 	<tr>
			 		<td><?=$no?></td>
			 		<td><?=$dataSaksiInt['nama_saksi_internal']?></td>
			 		<td><?=$dataSaksiInt['pangkat_saksi_internal']?></td>
			 		<td><?=$dataSaksiInt['nip']?></td>
			 		<td><?=$dataSaksiInt['jabatan_saksi_internal']?></td>
			 		<td><?=$dataSaksiInt['golongan_saksi_internal']?></td>
			 		<td>
			 			<input type="checkbox" name="selection_one_saksi_int" class="selection_one_saksi_int" value="<?=$dataSaksiInt['nip']?>">
			 			<input type="hidden" name="nip_saksi_internal[]" value="<?=$dataSaksiInt['nip']?>">
			 			<input type="hidden" name="nrp_saksi_internal[]" value="<?=$dataSaksiInt['nrp']?>">
			 			<input type="hidden" name="nama_saksi_internal[]" value="<?=$dataSaksiInt['nama_saksi_internal']?>">
			 			<input type="hidden" name="pangkat_saksi_internal[]" value="<?=$dataSaksiInt['pangkat_saksi_internal']?>">
			 			<input type="hidden" name="golongan_saksi_internal[]" value="<?=$dataSaksiInt['golongan_saksi_internal']?>">
			 			<input type="hidden" name="jabatan_saksi_internal[]" value="<?=$dataSaksiInt['jabatan_saksi_internal']?>">
			 		</td>
			 	</tr>
			 	<?php
			 		$no++;
			 			}	
			 		// }
			 	?>
			</tbody>
		</table>
  <!-- </div> -->
</div>
          
      </div>
    
<div id="menu1" class="tab-pane fade">
<div class="box box-primary">
    <!-- <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12"> -->
    <div class="btn-toolbar">
        <label style="margin-top:5px;" class="control-label col-md-8">DAFTAR SAKSI YANG DIWAWANCARA (Saksi Eksternal)</label>
        <a class="btn btn-primary btn-sm pull-right" id="hapus_eksternal" style="margin-right:10px;margin-top:10px;"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
    </div>
    <hr>
   
      <table id="table_eksternal" class="table table-bordered" style="padding:10px;">
			<thead>
				<tr>

					<th width="3%">No</th>
					<th width="20%">Nama</th>
					<th width="13%">TTL</th>
					<th width="10%">Kewarganegaraan</th>
					<th width="25%">Alamat</th>
					<th width="13%">Agama</th>
					<th width="20%">Pekerjaan</th>
					<th width="4%">Pilih</th>
				</tr>
			</thead>
			<tbody id="tbody-eksternal">
				<?php
			 		// if($model->isNewRecord){ 
			 			$no=1;
						foreach ($modelSaksiEksternal as $dataSaksiEks) {
			 		?>
			 	<tr>
			 		<td><?=$no?></td>
			 		<td><?=$dataSaksiEks['nama_saksi_eksternal']?></td>
			 		<td><?=$dataSaksiEks['tempat_lahir_saksi_eksternal']?></td>
			 		<td><?=$dataSaksiEks['warga']?></td>
			 		<td><?=$dataSaksiEks['alamat_saksi_eksternal']?></td>
			 		<td><?=$dataSaksiEks['agama']?></td>
			 		<td><?=$dataSaksiEks['pekerjaan_saksi_eksternal']?></td>
			 		<td>
			 			<input type="checkbox" name="selection_one_saksi_eks" class="selection_one_saksi_eks" value="<?=$dataSaksiEks['id_saksi_eksternal']?>">
			 			<input type="hidden" name="id_saksi_eksternal[]" value="<?=$dataSaksiEks['id_saksi_eksternal']?>">
			 			<input type="hidden" name="nama_saksi_eksternal[]" value="<?=$dataSaksiEks['nama_saksi_eksternal']?>">
			 			<input type="hidden" name="tempat_lahir_saksi_eksternal[]" value="<?=$dataSaksiEks['tempat_lahir_saksi_eksternal']?>">
			 			<input type="hidden" name="tanggal_lahir_saksi_eksternal[]" value="<?=$dataSaksiEks['tanggal_lahir_saksi_eksternal']?>">
			 			<input type="hidden" name="id_negara_saksi_eksternal[]" value="<?=$dataSaksiEks['id_negara_saksi_eksternal']?>">
			 			<input type="hidden" name="pendidikan_saksi_eksternal[]" value="<?=$dataSaksiEks['pendidikan']?>">
			 			<input type="hidden" name="id_agama_saksi_eksternal[]" value="<?=$dataSaksiEks['id_agama_saksi_eksternal']?>">
			 			<input type="hidden" name="alamat_saksi_eksternal[]" value="<?=$dataSaksiEks['alamat_saksi_eksternal']?>">
			 			<input type="hidden" name="nama_kota_saksi_eksternal[]" value="<?=$dataSaksiEks['nama_kota_saksi_eksternal']?>">
			 			<input type="hidden" name="id_warga_saksi_eksternal[]" value="<?=$dataSaksiEks['id_warganegara']?>">
			 			<input type="hidden" name="pekerjaan_saksi_eksternal[]" value="<?=$dataSaksiEks['pekerjaan_saksi_eksternal']?>">
			 		</td>
			 	</tr>
			 	<?php
			 		$no++;
			 			}	
			 		// }
			 	?>
			
			</tbody>
		</table>
    
   
  <!-- </div> -->
</div>
    </div>
    
    
  </div>
  
  
<!-- </div>
</div> -->
<div class="box box-primary">
  <div class="box-header with-border">
    <fieldset class="group-border">
	
        <legend class="group-border">Daftar Hasil Wawancara </legend>
		 <!-- <div class="col-md-12" style="margin-top:2%;"> -->
		<div class="col-sm-12"  style="margin-top:10px; margin-bottom:10px">
        <div class="btn-toolbar">
        <?php //if ($model->isNewRecord) { ?>
		<a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="tambah_pertanyaan"><i class="glyphicon glyphicon-plus"> Tambah </i></a>
		<?php// } else{ ?> 
		<!-- <a class="btn btn-primary btn-sm pull-right"  style="margin-left:-10%;"   type="button" id="tambah_pertanyaan" data-toggle="modal" data-target="#modal_pertanyaan"><i class="glyphicon glyphicon-pencil"> Ubah </i></a> -->
		<?php// } ?>
        </div>
        </div>


		<!-- </div> -->
    <table id="table_pertanyaan" style="margin-top:3%;" class="table table-bordered">
			<thead>
				<tr>
					<th width="4%">No</th>
					<th width="93%">Hasil Wawancara</th>
					<th width="3%">Aksi</th>
				</tr>
			</thead>
			<tbody id="tbody_pertanyaan">
				<?php
			if(!$model->isNewRecord){
				$i=1;					
				foreach($modelWawancara as $rowhasil){
				echo '<tr data-id="'.$rowhasil['no_urut_hasil'].'" id="trpertanyaan"'.$rowhasil['no_urut_hasil'].'""></td>';
				echo '<td align="center"> '.$i++.'</td>';
				echo '<td><input type="hidden" class="form-control" name="pertanyaan[]" readonly="true" value="'.$rowhasil['hasil_wawancara'].'">'.$rowhasil['hasil_wawancara'].'</td>';
				
				echo '<td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td>';
				echo '</tr>';
				} 
						}
                ?>
			</tbody>
		</table>
</fieldset>   
  </div>
</div>
<!--=======================pertanyaan==============================3-->

 <div class="col-md-12" style="padding:0px;">
        <div class="panel panel-primary">
            <div class="panel-heading">Penandatangan</div>
                <div class="panel-body">
                   <div class="col-md-4">
                      <div class="form-group">
                          <!--<label class="control-label col-md-3">WAS-1</label>-->
                          <label class="control-label col-md-2" style="width:22%">Nip</label>
                          <div class="col-md-10" style="width:75%">
                            <?php
                            if(!$model->isNewRecord){
                            echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan", "data-backdrop"=>"static", "data-keyboard"=>false]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                          }else{
                            echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                          }
                             ?>
                          </div>
                      </div>  
                  </div>
                  <div class="col-md-4">
                       <div class="form-group">
                          <label class="control-label col-md-2">Nama</label>
                      <div class="col-sm-10">
                           <?//= $form->field($model, 'was1_nama_penandatangan')->textInput(['readonly'=>'readonly']) ?>
                           <?php
                              if(!$model->isNewRecord){
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                            }else{
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                            }
                            ?>
                      </div>
                      </div>
                  </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label col-md-2">Jabatan</label>
                    <div class="col-sm-10">
                      <?php
                      /*sebenarnya ini ada default pas awal tpi kang putut blm kasih tau defaulnya apa*/
                            if(!$model->isNewRecord){
                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                          }else{
                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                          }
                          ?>
                    </div>
                </div>
            </div>
          </div>
         </div>
      </div>
<?php 
	if(!$model->isNewRecord){
?>

<div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
    <label>Unggah Berkas Ba-WAS-2 :
        <?php if (substr($model->upload_file,-3)!='pdf'){?>
            <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_ba_was2='.$model['id_ba_was2'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
        <?php } else{?>
            <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_ba_was2='.$model['id_ba_was2'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
        <?php } ?>
    </label>
    <!-- <input type="file" name="upload_file" /> -->
    <div class="fileupload fileupload-new" data-provides="fileupload">
    <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
    <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="upload_file" id="upload_file" /></span>
    <span class="fileupload-preview"></span>
    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
</div>
</div>
<?php
}
?>
<!--=====================================================3-->

<hr style="border-color: #c7c7c7;margin: 10px 0;">

    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'simpan']) ?>
	  <input type="hidden" name="print" value="0" id="print"/>
      <?php
      if (!$model->isNewRecord) {
        echo Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/ba-was2/cetak', 'id_ba_was2' => $model->id_ba_was2], ['id' => 'cetak','class' => 'btn btn-primary']);
       // echo " ".Html::a('<i class ="fa fa-times"></i> Hapus', ['/pengawasan/ba-was3/hapus', 'id' => $model->id_sp_was1], ['id' => 'hapusSpwas2', 'class' => 'btn btn-primary']);
      }
      
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Kembali', ['/pengawasan/ba-was2/index'], ['id' => 'KembaliBaWas2', 'class' => 'btn btn-primary']);
	   ?>
    </div>

</div>
</section>
<?php ActiveForm::end(); ?>

<div class="modal fade" id="penandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Terlapor</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPenandatangan', 
                                      'options'=>['name'=>'searchFormPenandatangan'],
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
                                      <input type="text" name="cari_penandatangan" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatangan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelBaWas2 = new BaWas2Search();
                            $dataProviderPenandatangan = $searchModelBaWas2->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w4" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatangan,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_jabatan',
                                    ],

                                    ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabtan_asli',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_penandatangan">Tambah</button>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

$(".ck_saksiEk").click(function(){
			 var x=$(".ck_saksiEk:checked").length;
			if(x>=2){
				alert('asdasd');
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
				 '</div>')
			}else{
				$('.bd_saksiEk').find('.tr_saksiEk'+nilai).find('.td_saksiEk'+nilai).find('.input_saksiEk'+nilai).remove();
			} 

		}
		});
		
		window.onload = function () {
 	$(document).on('click','a.hapus_pertanyaan', function(){
			$(this).closest('tr').remove();
			// $('.'+x).remove();
		});
	$(document).on('click','a#tambah_pertanyaan', function(){
			$('#tbody_pertanyaan').append('<tr class=\"rows\">'+
				'<td class=\"no\"></td>'+
				'<td><textarea class="form-control" name="pertanyaan[]" rows="2"></textarea></td>'+

				'<td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td></tr>');
		i = 0;
		$('#tbody_pertanyaan').find('.rows').each(function () {

        i++;
        $(this).addClass('rows'+i);
        $(this).find('.hapus_pertanyaan').attr('rel','rows'+i);
        // $(this).find('.cekbok').val(i);
    	});	

		});

	$(document).on('hidden.bs.modal','#penandatangan', function (e) {
          $(this).find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();

        });

	$('#hapus_eksternal,#hapus_riksa,#hapus_internal').addClass('disabled');
	$(document).on('click','#hapus_eksternal', function(){
		$('.selection_one_saksi_eks:checked').closest('tr').remove();
		});

	$(document).on('click','#hapus_internal', function(){
		$('.selection_one_saksi_int:checked').closest('tr').remove();
		});

	$(document).on('click','#hapus_riksa', function(){
		$('.selection_one_pemeriksa:checked').closest('tr').remove();
		});
            
    $(document).on('change','.selection_one_pemeriksa',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x =$('.selection_one_pemeriksa:checked').length;
            var asal='pemeriksa';
            ConditionOfButton(x,asal);
        });

    $(document).on('change','.selection_one_saksi_int',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x =$('.selection_one_saksi_int:checked').length;
            var asal='internal';
            ConditionOfButton(x,asal);
        });

    $(document).on('change','.selection_one_saksi_eks',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x =$('.selection_one_saksi_eks:checked').length;
            var asal='eksternal';
            ConditionOfButton(x,asal);
        });

    $(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".selection_one:checked").attr("json"));
       $('#bawas2-nip_penandatangan').val(data.nip);
       $('#bawas2-nama_penandatangan').val(data.nama);
       $('#bawas2-jabatan_penandatangan').val(data.nama_jabatan);
       $('#bawas2-golongan_penandatangan').val(data.gol_kd);
       $('#bawas2-pangkat_penandatangan').val(data.gol_pangkat2);
       $('#bawas2-jbtn_penandatangan').val(data.jabtan_asli);
       $('#penandatangan').modal('hide');
                                
    });

    function ConditionOfButton(n,z){
            if(n == 1 && z=='pemeriksa'){
               $('#hapus_riksa').removeClass('disabled');
            } else if(n > 1 && z=='pemeriksa'){
               $('#hapus_riksa').removeClass('disabled');
            } else if(z=='pemeriksa'){
               $('#hapus_riksa').addClass('disabled');
            }

            if(n == 1 && z=='internal'){
               $('#hapus_internal').removeClass('disabled');
            } else if(n > 1 && z=='internal'){
               $('#hapus_internal').removeClass('disabled');
            } else if(z=='internal'){
               $('#hapus_internal').addClass('disabled');
            }

            if(n == 1 && z=='eksternal'){
               $('#hapus_eksternal').removeClass('disabled');
            } else if(n > 1 && z=='eksternal'){
               $('#hapus_eksternal').removeClass('disabled');
            } else if(z=='eksternal'){
               $('#hapus_eksternal').addClass('disabled');
            }
    }
 }

 /*////////////reload grid penandatangan surat/////////////////*/
     $(document).on('click','.cari_ttd',function() { 
      $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/ba-was2/getttd",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

      $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
	      $('#grid-penandatangan_surat').addClass('loading');
	    }).on('pjax:success', function(){
	      $('#grid-penandatangan_surat').removeClass('loading');
	    });

    $(document).on('hidden.bs.modal','#penandatangan', function (e) {
      $(this)
        .find("input[name=cari_penandatangan]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });
		
</script>
<style type="text/css">

/*Penandatangan-id-grid*/
#grid-penandatangan_surat.loading {overflow: hidden;}
#grid-penandatangan_surat.loading .modal-loading-new {display: block;}

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