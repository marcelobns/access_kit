<?php
App::uses('AppHelper', 'View/Helper');

class AuthViewHelper extends AppHelper {
 	var $helpers = array('Html', 'Form'); 	
  	
  	function link($title, $url, $options = array()) {
  		$user = CakeSession::read('Auth.User');
  		if(@$user['Rule'])
		foreach ($user['Rule'] as $key => $value) {
			if(strtolower($value['controller']) == $this->request->params['controller'] && $value['action'] == $url['action']){
				if($value['allow']){
					return $this->Html->link($title, $url, $options);
				}
				return null;
			}
        }
  	}

  	function postLink($title, $url, $options = array(), $message = 'Are you sure you want to delete %s?') {
  		$user = CakeSession::read('Auth.User');
  		if(@$user['Rule'])
		foreach ($user['Rule'] as $key => $value) {
			if(strtolower($value['controller']) == $this->request->params['controller'] && $value['action'] == $url['action']){
				if($value['allow']){
					return $this->Form->postLink($title, $url, $options, $message);
				}
				return null;
			}
        }
  	}

  	//TODO será????
  	function input_rules($rules = array(), $requester = 'UserGroup'){  		
  		$i = 0;				
		$controller = "";
		if(sizeof($rules) > 0)
		foreach ($rules as $rule) {
			if($rule['controller'] != $controller) {				
				echo "<legend>{$rule['controller']}</legend>";
				$controller = $rule['controller'];
			}
			echo $this->Form->hidden("Rule.$i.id");
			echo $this->Form->hidden("Rule.$i.requester", array('value'=>$requester));
			echo $this->Form->hidden("Rule.$i.controller", array('value'=>$controller));
			echo $this->Form->hidden("Rule.$i.action", array('value'=>$rule['action']));
			echo $this->Form->input("Rule.$i.allow", array('label'=>$rule['action']));
			$i++;
		}
  	}
}
