<?php

/**
 * BaseSubscriber
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $entity_id
 * @property integer $is_active
 * @property integer $is_block
 * @property integer $is_close
 * @property integer $is_delete
 * @property string $email
 * @property Entity $Entity
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseSubscriber extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('subscriber');
        $this->hasColumn('id', 'integer', 20, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'length' => '20'));
        $this->hasColumn('name', 'string', 100, array('type' => 'string', 'notnull' => true, 'length' => '100'));
        $this->hasColumn('entity_id', 'integer', 20, array('type' => 'integer', 'notnull' => true, 'length' => '20'));
        $this->hasColumn('is_active', 'integer', 1, array('type' => 'integer', 'default' => '1', 'length' => '1'));
        $this->hasColumn('is_block', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('is_close', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('is_delete', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('email', 'string', 50, array('type' => 'string', 'notnull' => true, 'length' => '50'));


        $this->index('entity_idx', array('fields' => array(0 => 'entity_id')));
        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Entity', array('local' => 'entity_id',
                                      'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}