<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\web\View;
use kartik\growl\Growl;

  echo Growl::widget([
    'type' => Growl::TYPE_SUCCESS,
    'title' => 'Simpan Data',
    'icon' => 'fa fa-users',
      'delay' => 7000,
    'body' => 'Data Berhasil di Simpan',
    'showSeparator' => true,
    'pluginOptions' => [
        'showProgressbar' => true,
        'placement' => [
            'from' => 'top',
            'align' => 'center',
        ]
    ]
]);
  
  ?>
