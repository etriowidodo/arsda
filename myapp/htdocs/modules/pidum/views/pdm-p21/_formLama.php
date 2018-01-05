<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmPenandatangan;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

 <?php
        $form = ActiveForm::begin([
                'id' => 'p21-form',
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
	
	//Danar Wido P21_02 23-06-2016
	$_SESSION['tgl_ba']=$modelP24->tgl_ba;
	//End Danar Wido P21_02 23-06-2016
	 ?>
		
		<?= $this->render('//default/_formHeader3', ['form' => $form, 'model' => $model]) ?>
     
     <!--<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
         <div class="box-header with-border">
             <h3 class="box-title">
                 Referensi
             </h3>
         </div>
         <div class="form-group">
             <label class="control-label col-md-2">No Perkara</label>
             <div class="col-md-4">
                 <input type="text" class="form-control" value="<?= $modelBerkas->no_pengiriman ?>" readonly="true">
             </div>
             <div class="col-md-3">
                 <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($modelBerkas->tgl_pengiriman)) ?>" readonly="true">
             </div>
         </div>
     </div>-->

     <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
         <div class="box-header with-border">
			<h3 class="box-title">
                 Referensi
             </h3><br>
		</div>	 
		<div class="control-label col-md-10">
            <h5>Berkas Perkara a.n tersangka	:	<?= $listTersangka ?></h5>
			<h5>No Perkara	: <?= $modelBerkas->no_pengiriman ?>	Tanggal	:		<?= date('d-m-Y', strtotime($modelBerkas->tgl_pengiriman))?></h5>
         </div>
		 </div>
        <!-- <table id="table_jpu" class="table table-bordered">
             <thead>
             <tr>
                 <th>Nama</th>
             </tr>
             </thead>
             <tbody id="tbody_tersangka">

             <?php
            /* if($modelTersangka != null){
                 foreach($modelTersangka as $key => $value){
                     echo "<tr><td>".$value['nama']."</td></tr>";
                 }
             }*/
             ?>

             </tbody>
         </table> -->
         <div class="box box-primary" style="border-color: #f39c12">
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P21, 'id_table' => $model->id_p21]) ?>
    </div>
     </div>


    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p21/cetak?id_p21='.$model->id_p21.'&id_berkas='.$_GET['id_berkas']])?>">Cetak</a>
		<?php } ?>
        <!-- jaka | 24 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/pdm-p21/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
		 
    </div>

    <?php ActiveForm::end(); ?>
	</div>
	</section>