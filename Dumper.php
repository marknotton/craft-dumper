<?php

namespace modules\dumper;

use Craft;

use yii\base\Module;
use modules\dumper\twigextensions\TwigExtensions;

class Dumper extends Module
{
  public static Dumper $instance;

  public function __construct($id, $parent = null, array $config = [])
  {
    Craft::setAlias('@modules/dumper', $this->getBasePath());

    static::setInstance($this);

    parent::__construct($id, $parent, $config);
  }

  public function init(): void
  {
    parent::init();

    self::$instance = $this;

    if ( Craft::$app->request->isSiteRequest ) {
      Craft::$app->view->registerTwigExtension(new TwigExtensions());
    }
  }
}

/**
 * This is so we can refer to the Debug instance anywhere.
 * If you're unhappy with how 'imposing' this is on the global scope, ditch it. 
 * It's intended for quick debugging, never to be relied on in production environments.
 * @example \VarDump::dump(...)
 * @example \VarDump::inspect(...)
 * @link https://www.php.net/manual/en/function.class-alias.php
 */
class_alias(TwigExtensions::class, 'VarDump');
class_alias(TwigExtensions::class, 'Var');
