<?php
class RequesterBehavior extends ModelBehavior {		
	public function setup(Model $Model, $config = array()){
		$hasMany = array(
			'Rule' => array(
				'className' => 'Rule',
				'foreignKey' => 'requester_key',
				'exclusive' => true,
				'conditions' => array(
					'Rule.requester'=> $Model->name
				),
				'order' => array('Rule.controller'=>'ASC', 'Rule.action'=>'ASC')
			)
		);
		$Model->hasMany = array_merge($Model->hasMany, $hasMany);
		$Model->Group = @$config['Group'];
		$Model->GroupKey = @$config['GroupKey'];
	}

	public function afterFind(Model $Model, $results, $primary = false){		
		if(isset($results[0]['Rule']))
		if(@$Model->Group !== null && @$Model->GroupKey !== null){
			$rules = $Model->Rule->find('all', array(
					'conditions'=>array(
						'Rule.requester'=>$Model->Group, 
						'Rule.requester_key'=>@$results[0]['User'][$Model->GroupKey]
						)
					)
				);
			$group_rule = array();
			foreach ($rules as $key=>$value) {
				array_push($group_rule, $value['Rule']);
			}				
			$results[0]['User']['Rule'] = array_merge($results[0]['Rule'], $group_rule);
			return $results;
		}
	}
}