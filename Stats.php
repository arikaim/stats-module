<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Stats;

use Arikaim\Core\Extension\Module;
use Arikaim\Modules\Stats\StatsMiddleware;

/**
 * Stats middleware module class
 */
class Stats extends Module 
{
    /**
     * Boot module
     *
     * @return void
     */
    public function boot()
    {
        $this->addMiddlewareClass(StatsMiddleware::class);
    }
}
