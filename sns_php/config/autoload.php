<?php

/*
MyApp
index.php controller
MyApp\Controller\Index
->lib/Controller/Index.php
*/


spl_autoload_register(function($class){
  $prefix = 'MyApp\\';
  $preconst = 'Config\\';
  if(strpos($class, $prefix) === 0){
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className).
    '.php';

    if(file_exists($classFilePath)){
      require $classFilePath;
    }
  } else if(strpos($class, $preconst) === 0) {
      $className = substr($class, strlen($preconst));
      $classFilePath = __DIR__ . '/../config/' . str_replace('\\', '/', $className).
      '.php';

      if(file_exists($classFilePath)){
          require $classFilePath;
      }
  }
});

// TODO: autoroloader flexible
// class ClassAutoloader {
//
//   public static $loader;
//
//   public static function init() {
//     if (self::$loader == NULL) {
//       self::$loader = new Self();
//       return self::$loader;
//     }
//   }
//
//   public function __construct()
//   {
//     spl_autoload_register(array($this, 'loader'));
//   }
//
//   private function loader($className) {
//     $include = explode(PATH_SEPARATOR ,getincludePath());
//     $className = ltrim($className, '\\');
//   }
//
// }
