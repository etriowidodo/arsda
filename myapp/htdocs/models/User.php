<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    /**
     * Creates new user account. It generates password if it is not provided by user.
     *
     * @return bool
     */
    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }
        $post = \Yii::$app->request->post('User');
        $this->confirmed_at = time();
        $this->password = $this->password;
        /*$this->peg_nip = $post['id_pegnip'];
        $this->peg_nik = $post['id_pegnik'];*/

        $this->trigger(self::BEFORE_CREATE);

        if (!$this->save()) {
            return false;
        }

        $this->mailer->sendWelcomeMessage($this, null, true);
        $this->trigger(self::AFTER_CREATE);

        return true;
    }
}