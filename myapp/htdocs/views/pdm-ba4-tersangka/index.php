<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdmBa4TersangkaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm Ba4 Tersangkas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba4-tersangka-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm Ba4 Tersangka', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_register_perkara',
            'tgl_ba4',
            'id_peneliti',
            'no_reg_tahanan',
            'no_reg_perkara',
            // 'alasan:ntext',
            // 'id_penandatangan',
            // 'upload_file',
            // 'no_urut_tersangka',
            // 'tmpt_lahir',
            // 'tgl_lahir',
            // 'alamat',
            // 'no_identitas',
            // 'no_hp',
            // 'warganegara',
            // 'pekerjaan',
            // 'suku',
            // 'nama',
            // 'id_jkl',
            // 'id_identitas',
            // 'id_agama',
            // 'id_pendidikan',
            // 'umur',
            // 'id_kejati',
            // 'id_kejari',
            // 'id_cabjari',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'nama_ttd',
            // 'pangkat_ttd',
            // 'jabatan_ttd',
            // 'updated_time',
            // 'created_by',
            // 'updated_by',
            // 'foto:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
