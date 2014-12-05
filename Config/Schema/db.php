<?php 
class DbSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {

	}

	public $rules = array(
		'id' => array('type'=>'integer', 'null'=> false, 'default'=>null, 'key'=>'primary'),
		'requester' => array('type'=>'string', 'null'=> false),
		'requester_key' => array('type'=>'integer', 'null'=>false),
		'controller' => array('type'=>'string', 'null'=>false),
		'action' => array('type'=>'string', 'null'=>false),
		'allow' => array('type'=>'boolean', 'null'=>false)
	);

	public $logs = array(
		'id' => array('type'=>'biginteger', 'null'=>false, 'default'=>null, 'key'=>'primary'),
		'date_time' => array('type'=>'datetime', 'null'=>false),
		'alias' => array('type'=>'string', 'null'=>false),
		'action' => array('type'=>'string', 'null'=>false),
		'oid' => array('type'=>'integer', 'null'=> false),
		'content' => array('type'=>'string', 'null'=>false),
		'user_id' => array('type'=>'integer', 'null'=>false),
		'username' => array('type'=>'string', 'null'=>false),
		'client_ip' => array('type'=>'string', 'null'=>false)
	);
}