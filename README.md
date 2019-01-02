# BlajMVC - simple mvc framework
This is a simple MVC framework for building web applications writen in PHP. It's free and open source.

<h2>First Start</h2>
1. Download the framework.
2. Configure your web server to have the public folder as the web root.
3. Open config/config.php and enter your database configuration data and other settings.
4. Create routes, controller, views and models...
See below for more details.

<h2>Requirments</h2>
* PHP >= 7.0
* PDO library
* .htaccess

<h2>Configuration</h2>
Configuration settings are stored in config/config.php
<h5>Database config</h5>
```
define('DB_USER', 'root');          // Database user
define('DB_PSWD', 'qwe123');        // Database password
define('DB_NAME', 'blajmvc');       // Database name
define('DB_HOST', 'localhost');     // Database host
```

<h5>Directories config</h5>
```
define('DIR_VENDOR', '../vendor/');                 // Composer directory
define('DIR_CONFIG', '../config/');                 // Config directory
define('DIR_CONTROLLER', '../src/controller/');     // Controller directory
define('DIR_MODEL', '../model/');                   // Model directory
define('DIR_TEMPLATE', '../src/template/');         // Template directory
define('HTTP_SERVER', 'http://blajmvc.pl/');        // HTTP address
```

<h2>Routing</h2>
Open config/routes.php and add your routes:
```
$routeCollection->addRoute('home', new Route(
    '',
    'HomeController@index'
));
```

You can add route with parameters and specify a custom regular expression for that parameter:
```
$routeCollection->addRoute('article/read', new Route(
    'article/{id}',
    'HomeController@read',
    [
        'id' => '\d+'
    ],
    [
        'id' => 1
    ]
));
```
You can also specify a default variable for paremeter:
```
$routeCollection->addRoute('article/read', new Route(
    'article/{id}',
    'HomeController@read',
    [
        'id' => '\d+'
    ],
    [
        'id' => 1
    ]
));
```

<h2>Controller</h2>
Controllers are stored in **src/controller** folder. Controllers must be in **Blaj\BlajMVC\Controller** namespace.
Controllers extends by **Controller** class.
In controller you can use models and views.
```
namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Model\ArticleModel;

class HomeController extends Controller {

    private $view;
    private $articleModel;

    public function __construct()
    {
        $this->view = new View('layout/layout.phtml');
        $this->articleModel = new ArticleModel();
    }

    public function index()
    {
        $articles = $this->articleModel->getAll();

        $this->view->body = new View('index.phtml');
        $this->view->body->articles = $articles;
        return $this->view;
    }
}
```

<h2>Model</h2>
Models are stored in **src/model** folder. Models must be in **Blaj\BlajMVC\Model** namespace.
Models extends by **Model** class.
```
namespace Blaj\BlajMVC\Model;

use Blaj\BlajMVC\Core\Model;

class ArticleModel extends Model
{

    public function getAll()
    {
        $query = $this->db->query("SELECT * FROM article");
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (isset($items))
            return $items;
        else
            return null;
    }

    public function getOne($id)
    {
        $query = $this->db->prepare("SELECT * FROM article WHERE id = :id");
        $query->execute(['id' => $id]);
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (isset($items[0])) {
            return $items[0];
        } else {
            return null;
        }
    }
}
```

<h2>Views</h2>
Views are used to display information (normally HTML). View files go in the **src/template** folder. 
You can render a standard PHP view in a controller, optionally passing in variables, like this:
```
$this->view->body = new View('index.phtml');
$this->view->body->articles = $articles;
```
