# Helper classes for PrestaShop CMS
Full documented helper classes for PrestaShop CMS.
With these helpers some programming tasks becomes more simple and done faster.
[The library homepage][5].

**Helper list:**
- ArrayHelper
- BackendHelper
- DateHelper
- DiagnosticHelper
- FileHelper
- FormHelper
- HtaccessHelper
- LogHelper
- ModuleHelper
- ObjectHelper
- SecurityHelper
- StringHelper
- UrlHelper
- ValidateHelper

**Controller list:**
- BaseModuleFrontController.php
- AjaxModuleFrontController.php

**Component list:**
- QualityService

## Examples

**ArrayHelper**, indexing an array.
~~~
$array = [
    ['id' => '123', 'data' => 'abc'],
    ['id' => '345', 'data' => 'def'],
];
$result = ArrayHelper::index($array, 'id');
// The result is:
// [
//     '123' => ['id' => '123', 'data' => 'abc'],
//     '345' => ['id' => '345', 'data' => 'def'],
// ]
~~~ 

**FormHelper**, generating a source array for a `select` element. 
~~~
$array = [
    ['123' => 'abc'],
    ['345' => 'def'],
];
$result = FormHelper::generateList($array);
// The result is:
// [
//     ['id' => '123', 'name' => 'abc'],
//     ['id' => '345', 'name' => 'def']
// ]

// The usage in a form definition:
array(
    'type'    => 'select',
    'label'   => 'Example',
    'name'    => 'example',
    'options' => array(
        'query' => $result,
        'id'    => 'id',
        'name'  => 'name',
    ),
)
~~~

**LogHelper**, logging an error in a module.
~~~
public function example() {
    $this->log('An error occupied.');
}
public function log($messages, $level = AbstractLogger::WARNING) {
    LogHelper::log($messages, $level, $this->displayName, $this->id);
}
~~~

**DiagnosticHelper**, checking if a method is overridden.
~~~
if (DiagnosticHelper::isMethodOverridden('AddressController', 'init')) {
    $this->_errors[] = $this->l('The AddressController::init() already overridden.');
}
~~~

**AjaxModuleFrontController**, creating a simple Ajax controller for a module.
~~~
class ExampleAjaxModuleFrontController extends AjaxModuleFrontController {
    protected function actionSave() {
        $this->ajaxResponse->result  = true;
        $this->ajaxResponse->message = 'Success!';
    }
}
// The output result is:
// {"result":true,"data":null,"html":"","message":"Success!","errors":[]}
~~~

**ModuleHelper**, getting an instance of a module by given directory path.
~~~
$path   = '/var/www/prestashop/modules/homecategoriez/classes'; 
$module = ModuleHelper::getInstanceByPath($path); /** @var HomeCategoriez $module The instance of the module: HomeCategoriez */
~~~

**Autoloader**, using Composer's autoloader to automatically load PHP classes, for example, *in a module* by adding classmap to your `composer.json` file.
~~~
"autoload": {
  "classmap": [
    "classes/",
    "interfaces/"
  ]
}
~~~

## Installation
Add the dependency directly to your `composer.json` file:
```
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/zapalm/prestashopHelpers"
  }
],
"require": {
  "php": ">=5.4",
  "zapalm/prestashopHelpers": "dev-master"
},
```

## How to help the project grow and get updates
* **Become the [patron][2]** or support me by **[Flattr][6]** to help me work more for supporting and improving this project.
* Report an issue.
* Give me feedback or [contact with me][3].
* Give the star to the project.
* Contribute to the code.

## Contributing to the code

### Requirements for code contributors 

Contributors **must** follow the following rules:

* **Make your Pull Request on the *dev* branch**, NOT the *master* branch.
* Do not update a helper version number.
* Follow [PSR coding standards][1].

### Process in details for code contributors

Contributors wishing to edit the project's files should follow the following process:

1. Create your GitHub account, if you do not have one already.
2. Fork the project to your GitHub account.
3. Clone your fork to your local machine.
4. Create a branch in your local clone of the project for your changes.
5. Change the files in your branch. Be sure to follow [the coding standards][1].
6. Push your changed branch to your fork in your GitHub account.
7. Create a pull request for your changes **on the *dev* branch** of the project.
   If you need help to make a pull request, read the [Github help page about creating pull requests][4].
8. Wait for the maintainer to apply your changes.

**Do not hesitate to create a pull request if even it's hard for you to apply the coding standards.**

[1]: https://www.php-fig.org/psr/
[2]: https://www.patreon.com/zapalm
[3]: https://prestashop.modulez.ru/en/contact-us
[4]: https://help.github.com/articles/about-pull-requests/
[5]: https://prestashop.modulez.ru/en/tools-scripts/53-helper-classes-for-prestashop.html
[6]: https://flattr.com/@zapalm