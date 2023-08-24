<?php

namespace modules\dumper\twigextensions;

use Craft;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Symfony\Component\VarDumper\VarDumper;
use craft\helpers\Html;

class TwigExtensions extends AbstractExtension 
{
  public function getFilters()
  {
    return [
      new TwigFilter('dump',    [$this, 'dump']),
      new TwigFilter('inspect', [$this, 'inspect']),
    ];
  }

  /**
   * Dumps any data out using the VarDumper UI
   * @return VarDumper
   */
  public static function dump(...$args)
  {
    $args = count($args) == 1 ? $args[0] : $args;

    // start output buffering
    ob_start(); 

    // call VarDumper that uses fwrite,
    // this will output directly to the buffer
    VarDumper::dump($args);
    
    // get the contents of the buffer and store it in a variable
    $buffer = ob_get_contents();
    // clear the buffer
    ob_end_clean();

    $style = '
    var-dumper { 
      display:block; 
      background-color: #000000;
      border-radius: 4px;
      padding:16px 32px;
      position:relative;
      z-index:9999; 
      min-width: 500px;
      direction:ltr;
      overflow: auto;
      text-align:left; 
    }
    var-dumper pre.sf-dump {
      font-size: 16px;
      line-height: 1.4;
    }';
    $markup = str_replace('</style>', $style.'</style>', $buffer);
    $markup = str_replace('#262626', '#0f7fb4', $markup);
    echo Html::tag('var-dumper', $markup);
  }

  /**
   * Inspects any data type and attemps to return useful information in the Dump format
   * 
   * @link: https://www.php.net/manual/en/function.get-class.php
   * @link: https://www.php.net/manual/en/function.get-class-methods.php 
   * @link: https://www.php.net/manual/en/function.get-object-vars.php 
   * 
   * @return VarDumper
   */
  public static function inspect(...$args)
  {

    $results = [];

    foreach ($args as $arg) {

      $result = [];

      if(is_object($arg)){
        try {
            $result['name'] = get_class($arg);
        } catch (\Exception $e) { }

        try {
          $methods = get_class_methods($arg);
          sort($methods);
          $result['methods'] = $methods;
        } catch (\Exception $e) { }

        try {
          $properties = get_object_vars($arg);
          ksort($properties);
          $result['properties'] = $properties;
        } catch (\Exception $e) { }

        try {
          $result['isElement'] = in_array(get_class($arg), Craft::$app->getElements()->getAllElementTypes());
        } catch (\Exception $e) { }
  
        try {
          $result['isField'] = in_array(get_class($arg), Craft::$app->getFields()->getAllFieldTypes());
        } catch (\Exception $e) { }

      }

      if ( is_countable($arg) ) {
        try {
          $result['length'] = count($arg);
        } catch (\Exception $e) { }
      }

      try {
        $result['type'] = gettype($arg);
      } catch (\Exception $e) { }

      $result['data'] = $arg;

      $results[] = $result;

    }

    return static::dump(...$results);
  }

}
