# BlajMVC - simple mvc framework
This is a simple MVC framework for building web applications writen in PHP. It's free and open source.

## First Start
1. Download the framework.
2. Configure your web server to have the **public** folder as the web root.
3. Open config/config.php and enter your database configuration data and other settings.
4. Create routes, controller, views and models...

See below for more details.

## Requirments
* PHP >= 7.0
* PDO library
* htaccess

## Configuration
Configuration settings are stored in config/config.php
##### Database config
```
define('DB_USER', 'root');          // Database user
define('DB_PSWD', 'qwe123');        // Database password
define('DB_NAME', 'blajmvc');       // Database name
define('DB_HOST', 'localhost');     // Database host
```

##### Directories
```
define('DIR_VENDOR', '../vendor/');                 // Composer directory
define('DIR_CONFIG', '../config/');                 // Config directory
define('DIR_CONTROLLER', '../src/controller/');     // Controller directory
define('DIR_MODEL', '../model/');                   // Model directory
define('DIR_TEMPLATE', '../src/template/');         // Template directory
define('HTTP_SERVER', 'http://blajmvc.pl/');        // HTTP address
```

##### Default language for Translations class
```
define('DEFAULT_LANG', 'pl');
```

## Routing
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

## Controller
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

## Model
Models are stored in **src/model** folder. Models must be in **Blaj\BlajMVC\Model** namespace.
Models extends by **Model** class and implements **IModel** interface.
```
namespace Blaj\BlajMVC\Model;

use Blaj\BlajMVC\Core\Model;
use Blaj\BlajMVC\Core\IModel;

class ArticleModel extends Model implements IModel
{
    private $id;

    private $title;

    private $content;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
```

## Repository
Repository are stored in **src/repositry**. Variables must be same as fields in database table.
```
namespace Blaj\BlajMVC\Repository;

use Blaj\BlajMVC\Core\Repository;

class ArticleRepository extends Repository
{
    protected $tableName = 'article';

    private $id;

    private $title;

    private $content;
}

```

## Views
Views are used to display information (normally HTML). View files go in the **src/template** folder.
You can render a standard PHP view in a controller, optionally passing in variables, like this:
```
$this->view->body = new View('index.phtml');
$this->view->body->article = 'Test article';
return $this->view;
```

## Flash Messages
```
```

## Form Validation
Form Validation class is useful to validate HTML forms and more.
If you want add more than 1 rule use **|** like this **required|min_length:3**.
##### PHP Usage
```
use Blaj\BlajMVC\Core\FormValidation\FormValidator;

if (!empty($_POST)) {

    // Validate config
    $validator_config = array(
        array(
            'value' => $_POST['title'],         // Value to validate
            'name' => 'title',                  // Name
            'displayname' => 'Title',           // Display name
            'rules' => 'required|alphanum'      // Rules list
        ),
        array(
            'value' => $_POST['content'],
            'name' => 'content',
            'displayname' => 'Content',
            'rules' => 'required|alpha'
        )
    );

    // You can also add rules with following method
    $validator->addRule($_POST['author'], 'author', 'Author', 'required|min_length:3|max_length:10');

    // Create new FormValidator object
    $validator = new FormValidator($validator_config);

    // Run validator to check if validate process is ok
    if ($validator->run()) {
        echo 'Validate ok!';
    } else {
        echo $validator->showErrors();
    }
}
```

##### HTML Form
```
<form method="post">
    Title: <input type="text" name="title"><br>
    Content: <textarea name="content" cols="30" rows="10"></textarea><br>
    Author: <input type="text" name="author"><br>
    <button type="submit">Add</button>
</form>
```

##### Rules list
Rule|Description|Example
----|-----------|-------
required|Return true if the input is not empty|$validator->addRule($_POST['title'], 'title', 'Title', 'required');
min_length|Return true if the input is longer than x|$validator->addRule($_POST['title'], 'title', 'Title', 'min_length:3');
max_length|Return true if the input is not longer than x|$validator->addRule($_POST['title'], 'title', 'Title', 'max_length:10');
email|Return true if the input is email|$validator->addRule($_POST['title'], 'title', 'Title', 'email');
int|Return true if the input is int|$validator->addRule($_POST['title'], 'title', 'Title', 'int');
float|Return true if the input is float|$validator->addRule($_POST['title'], 'title', 'Title', 'float');
bool|Return true if the input is bool|$validator->addRule($_POST['title'], 'title', 'Title', 'bool');
alpha|Retrun true if the input is alpha|$validator->addRule($_POST['title'], 'title', 'Title', 'alpha');
alphanum|Return true if the input is alphanumeric|$validator->addRule($_POST['title'], 'title', 'Title', 'alphanum');
url|Return true if the input is URL|$validator->addRule($_POST['title'], 'title', 'Title', 'url');
equal_to|Return true if the input is the same as equaled input|$validator->addRule($_POST['title'], 'title', 'Title', 'equal_to:re_title');
unique|Return true if the input value is unique in database|$validator->addRule($_POST['title'], 'title', 'Title', 'unique:article');

## Translations
Translations class is used to translate. Translations configs are stored in **config/translations.php**.

##### Config
```
$translations['en'] = [
    'not_exist' => 'Translation {translation} do not exist!',
    'app_title' => 'BlajMVC - Home page'
];
```

##### Usage
```
use Blaj\BlajMVC\Core\Utils\Translations;

$app_title = Translations::Translate('app_title');
$not_exist = Translations::Translate('not_exist', ['translation' => 'something']);
```
