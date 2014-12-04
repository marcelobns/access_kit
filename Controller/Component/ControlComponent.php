<?php
class ControlComponent extends Component { 

    public function initialize(Controller $controller) {
        $this->controller = $controller;
        $this->controller->Session->write('clientIp', $this->controller->request->clientIp());    
    }

    public function get_controllers() {
        $controllers = App::objects('controller');
        foreach($controllers as $k=>$v) {
            if($v == 'AppController') {
                unset($controllers[$k]);
            }else{
                $controllers[$k] = str_replace('Controller', '', $v);
            }        
        }
        return $controllers;
    }

    public function get_actions($controller = "pages") {
        $controller = $controller.'Controller';
        App::uses($controller, 'Controller');        
        $metodos_controller = get_class_methods(new $controller());

        App::uses('AppController', 'Controller');        
        $metodos_app_controller = get_class_methods(new AppController());

        $actions = array_diff($metodos_controller, $metodos_app_controller);
                
        return preg_grep("/^_/", $actions, PREG_GREP_INVERT);        
    }

    public function rules($exist_list = array()) {
        $list = array();
        if(sizeof($exist_list) == 0) {
            foreach ($this->get_controllers() as $i => $controller) {
                foreach ($this->get_actions($controller) as $j => $action) {
                    array_push($list, array(
                        'id'=>null, 
                        'requester'=>null, 
                        'requester_key'=>null,
                        'controller'=>$controller,
                        'action'=>$action,
                        'allow'=>($action=='login' || $action=='logout') ? true : false
                        )
                    );
                }
            }    
        } else {
            $control_list = $this->rules();
            foreach ($exist_list as $i=>$v1) {
                foreach ($control_list as $j => $v2) {
                    if($v1['controller'] == $v2['controller'] && $v1['action'] == $v2['action']){                       
                        unset($control_list[$j]);
                    }
                }
            }            
            $list = array_merge($exist_list, $control_list);
        }          
        return $list;
    }

    public function authorize($user_rules = array(), $controller = '', $action = '') {
        if(!isset($_SERVER['HTTP_REFERER'])){
            $uri = split('/', $_SERVER['REQUEST_URI']);            
            $_SERVER['HTTP_REFERER'] = '//'.$_SERVER['HTTP_HOST'].'/'.$uri[1];
        }
        if(sizeof($user_rules)>0)
        foreach ($user_rules as $key => $value) {
            if($value['controller'] == $controller && $value['action'] == $action){
                if(!$value['allow']){
                    $this->controller->response->header('Location', $_SERVER['HTTP_REFERER']); 
                }
                return true;
            }
        }
        return false;
    }
}