<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

\app\modules\pengawasan\components\WasAlert::showMsg('warning info','a test2 only',['delay'=>5000]);
\app\modules\pengawasan\components\WasAlert::showFlashes(['alertType'=>'Alert']);
\app\modules\pengawasan\components\WasAlert::setMsg('title','body');