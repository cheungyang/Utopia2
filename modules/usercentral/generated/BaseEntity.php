<?php

/**
 * BaseEntity
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $property
 * @property enum $model
 * @property string $name
 * @property integer $is_active
 * @property integer $is_block
 * @property integer $is_close
 * @property integer $is_delete
 * @property Doctrine_Collection $Maps
 * @property Doctrine_Collection $Owns
 * @property Doctrine_Collection $Entity
 * @property Doctrine_Collection $Map
 * @property Doctrine_Collection $Own
 * @property Doctrine_Collection $Page
 * @property Doctrine_Collection $Page_version
 * @property Doctrine_Collection $Template
 * @property Doctrine_Collection $Template_version
 * @property Doctrine_Collection $Form
 * @property Doctrine_Collection $Form_version
 * @property Doctrine_Collection $User
 * @property Doctrine_Collection $User_version
 * @property Doctrine_Collection $Permission
 * @property Doctrine_Collection $Pgroup
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseEntity extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('entity');
        $this->hasColumn('id', 'integer', 20, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'length' => '20'));
        $this->hasColumn('property', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'MALLOCWORKS,WILGRIST'), 'notnull' => true));
        $this->hasColumn('model', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'PAGE', 1 => 'TEMPLATE', 2 => 'FORM', 3 => 'USER', 4 => 'PERMISSION', 5 => 'PGROUP'), 'notnull' => true));
        $this->hasColumn('name', 'string', 100, array('type' => 'string', 'notnull' => true, 'length' => '100'));
        $this->hasColumn('is_active', 'integer', 1, array('type' => 'integer', 'default' => '1', 'length' => '1'));
        $this->hasColumn('is_block', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('is_close', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));
        $this->hasColumn('is_delete', 'integer', 1, array('type' => 'integer', 'default' => 0, 'length' => '1'));


        $this->index('idx_permlink', array('fields' => array(0 => 'property', 1 => 'model', 2 => 'permlink'), 'type' => 'unique'));
        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasMany('Entity as Maps', array('refClass' => 'Map',
                                               'local' => 'src_id',
                                               'foreign' => 'tgt_id'));

        $this->hasMany('Entity as Owns', array('refClass' => 'Own',
                                               'local' => 'src_id',
                                               'foreign' => 'tgt_id'));

        $this->hasMany('Entity', array('refClass' => 'Map',
                                       'local' => 'tgt_id',
                                       'foreign' => 'src_id'));

        $this->hasMany('Map', array('local' => 'id',
                                    'foreign' => 'tgt_id'));

        $this->hasMany('Own', array('local' => 'id',
                                    'foreign' => 'tgt_id'));

        $this->hasMany('Page', array('local' => 'id',
                                     'foreign' => 'entity_id'));

        $this->hasMany('Page_version', array('local' => 'id',
                                             'foreign' => 'entity_id'));

        $this->hasMany('Template', array('local' => 'id',
                                         'foreign' => 'entity_id'));

        $this->hasMany('Template_version', array('local' => 'id',
                                                 'foreign' => 'entity_id'));

        $this->hasMany('Form', array('local' => 'id',
                                     'foreign' => 'entity_id'));

        $this->hasMany('Form_version', array('local' => 'id',
                                             'foreign' => 'entity_id'));

        $this->hasMany('User', array('local' => 'id',
                                     'foreign' => 'entity_id'));

        $this->hasMany('User_version', array('local' => 'id',
                                             'foreign' => 'entity_id'));

        $this->hasMany('Permission', array('local' => 'id',
                                           'foreign' => 'entity_id'));

        $this->hasMany('Pgroup', array('local' => 'id',
                                       'foreign' => 'entity_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array('fields' => array(0 => 'name'), 'name' => 'permlink', 'unqiue' => false, 'canUpdate' => true));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}