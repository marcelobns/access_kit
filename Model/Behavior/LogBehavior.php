<?php

class LogBehavior extends ModelBehavior {

    public function setup(Model $model, $config = array()){        
        $this->user_id = @$config['user_id'] ? $config['user_id'] : 'User.id';
        $this->username = @$config['username'] ? $config['username'] : 'User.username';

		$hasMany = array(		
			'Log' => array(
				'className' => 'Log',
				'foreignKey' => 'oid',
				'dependent' => false,
				'conditions' => array(
				    'Log.alias' => $model->name
				),
				'fields' => '',
				'order' => array('Log.date_time'=>'DESC')				
			)
		);    	
		$model->hasMany = array_merge($model->hasMany, $hasMany);
        
        if(!isset($model->hasMany['Rule']))
            $model->recursive = 0;

	}
    
    public function afterSave(Model $model, $created, $options = array()) {
        if($model->name != 'Log'){
            foreach($model->hasMany as $v){
                if($v['className'] == 'Log'){
                    $model->Log->save(array(
                        'date_time'=>date('Y-m-d H:i:s'),
                        'schema'=>'public',
                        'alias'=>$model->name,
                        'action'=>$created?'INSERT':'UPDATE',
                        'oid'=>$model->data[$model->name]['id'],
                        'content'=> json_encode($model->data[$model->name]),
                        'user_id'=>CakeSession::read('Auth.'.$this->user_id),
                        'username'=>CakeSession::read('Auth.'.$this->username),
                        'client_ip'=>CakeSession::read('clientIp')
                    ));
                }
            }
        }
    }

    public function beforeDelete(Model $model, $cascade = false) {
        if($model->name != 'Log'){
            foreach($model->hasMany as $v){
                if($v['className'] == 'Log'){
                    $data = $model->find('first', array('recursive'=>-1,'conditions'=>array($model->name.'.id'=>$model->id)));
                    $model->Log->save(array(
                        'date_time'=>date('Y-m-d H:i:s'),
                        'schema'=>'public',
                        'alias'=>$model->alias,
                        'action'=>'DELETE',
                        'oid'=>$model->id,
                        'content'=> json_encode($data[$model->name]),
                        'user_id'=>CakeSession::read('Auth.'.$this->user_id),
                        'username'=>CakeSession::read('Auth.'.$this->username),
                        'client_ip'=>CakeSession::read('clientIp')
                    ));
                }
            }
        }
        return true;
    }
}