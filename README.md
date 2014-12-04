# CakePHP AccessKit

CakePHP Plugin: an alternative to ACL and log of CRUD operations;

##Installation
In your app directory type:

```bash
git submodule add git://github.com/marcelobns/access_kit.git Plugin/AccessKit
git submodule init
git submodule update
```

or in your plugin directory type:

```bash
git clone git://github.com/cakephp/access_kit.git AccessKit
```

### Enable plugin
* In 2.x you need to enable the plugin at `app/Config/bootstrap.php` file, using `CakePlugin::loadAll();` or `CakePlugin::loadAll('AccessKit');`

in AppController:
```php
class AppController extends Controller {
	public $components = array(
		'Auth' => array(            
            'authorize' => array('Controller'),            
        ),
		'AccessKit.Control'
	);

	public function isAuthorized($user) {              
        return $this->Control->authorize(
          $user['Rule'],
          $this->name,
          $this->action);
    }
}
```
in Model:
```php
class Role extends AppModel {
	public $actsAs = array('AccessKit.Requester');

}

class User extends AppModel {
	public $actsAs = array(
		'AccessKit.Requester'=>array(
			'Group'=>'Role',
			'GroupKey'=>'role_id'
			)
		);
}
```
##feel free to contribute
