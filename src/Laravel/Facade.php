<?php

namespace OjiSatriani\SsoRiau\Laravel;

use Illuminate\Support\Facades\Facade as BaseFacade;
use OjiSatriani\SsoRiau\SsoClientLibrary;

class Facade extends BaseFacade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return SsoClientLibrary::class;
    }
}
