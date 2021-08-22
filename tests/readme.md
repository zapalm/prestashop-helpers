**Examples for how to run test cases.**

How to run all test cases from the library directory:
```
cd prestashop-helpers 
phpunit --bootstrap vendor\autoload.php tests
```

How to run `ArrayHelperTest` test case from the library directory:
```
cd prestashop-helpers
phpunit --bootstrap vendor\autoload.php tests\ArrayHelperTest
```

How to run all test cases from a module directory:
```
cd some-module-dir
phpunit --bootstrap vendor\autoload.php vendor\zapalm\prestashop-helpers\tests
```
