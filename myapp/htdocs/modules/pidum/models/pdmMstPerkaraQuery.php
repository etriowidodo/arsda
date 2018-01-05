<?php

namespace app\modules\pidum\models;

/**
 * This is the ActiveQuery class for [[pdmMstPerkara]].
 *
 * @see pdmMstPerkara
 */
class pdmMstPerkaraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return pdmMstPerkara[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return pdmMstPerkara|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}