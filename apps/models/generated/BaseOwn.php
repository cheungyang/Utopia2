<?php

/**
 * BaseOwn
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $src_id
 * @property integer $tgt_id
 * @property enum $src_model
 * @property enum $tgt_model
 * @property enum $rel
 * @property integer $is_active
 * @property integer $is_block
 * @property integer $is_close
 * @property integer $is_delete
 * @property Entity $Entity
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseOwn extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('own');
        $this->hasColumn('src_id', 'integer', 20, array('type' => 'integer', 'primary' => true, 'length' => '20'));
        $this->hasColumn('tgt_id', 'integer', 20, array('type' => 'integer', 'primary' => true, 'length' => '20'));
        $this->hasColumn('src_model', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'USER', 1 => 'SUBSCRIBER', 2 => 'PERMISSION', 3 => 'CATEGORY', 4 => 'PGROUP', 5 => 'PAGE', 6 => 'TEMPLATE', 7 => 'FORM', 8 => 'WALL', 9 => 'RESOURCE', 10 => 'EMAIL', 11 => 'ANNOUNCEMENT'), 'notnull' => true));
        $this->hasColumn('tgt_model', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'USER', 1 => 'SUBSCRIBER', 2 => 'PERMISSION', 3 => 'CATEGORY', 4 => 'PGROUP', 5 => 'PAGE', 6 => 'TEMPLATE', 7 => 'FORM', 8 => 'WALL', 9 => 'RESOURCE', 10 => 'EMAIL', 11 => 'ANNOUNCEMENT'), 'notnull' => true));
        $this->hasColumn('rel', 'enum', null, array('type' => 'enum', 'values' => array(0 => '[\'OWN\', \'REQUEST\', \'INVITE\', \'CONNECT\'] }'), 'default' => 'OWN', 'notnull' => true));
        $this->hasColumn('is_active', 'integer', 1, array('type' => 'integer', 'default' => '1', 'length' => '1'));
        $this->hasColumn('is_block', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('is_close', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('is_delete', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));

        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Entity', array('local' => 'tgt_id',
                                      'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}