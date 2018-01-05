<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use \app\modules\pengawasan\models\LWas2Search;
?>

<div class="box box-primary" style="overflow:hidden;padding:15px 0px 0px 0px;">

    <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <!--<label class="control-label col-md-3">#WAS-2</label> -->
                <label class="control-label col-md-3" style="margin-top: 7px;">NIP</label>
                <div class="col-md-9">

                    <?php echo Html::textInput('nip',$nip,['class'=>"form-control"]); ?>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="margin-top: 10px;">
        <div class="col-md-8">
            <div class="form-group">
                <!--<label class="control-label col-md-3">#WAS-2</label> -->
                <label class="control-label col-md-3" style="margin-top: 5px;">Nama</label>
                <div class="col-md-9">

                    <?php echo Html::textInput('nama',$nama,['class'=>"form-control"]); ?>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12" style="margin-top: 10px;margin-bottom: 20px;">
        <div class="col-md-8">
            <div class="form-group">
                <!--<label class="control-label col-md-3">#WAS-2</label> -->
                <label class="control-label col-md-3" style="margin-top: 5px;">Jabatan</label>
                <div class="col-md-9">

                    <?php echo Html::textInput('nama',$jabatan,['class'=>"form-control"]); ?>
                    
                </div>
            </div>
        </div>
    </div>

<div class="box-header with-border">
        <?php
        $searchModel = new LWas2Search();
        $dataProvider = $searchModel->searchBaWas3($id_register, $id_terlapor);

        $gridColumn = [
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'keterangan',
                'label' => 'isi',
            ],
        ];


        echo GridView::widget([

            'dataProvider' => $dataProvider,
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







   
    
    
    


    


