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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Arikaim\Core\Framework\Middleware\Middleware;
use Arikaim\Core\Framework\MiddlewareInterface;
use Arikaim\Core\Utils\ClientIp;

/**
 * Stats middleware class
 */
class StatsMiddleware extends Middleware implements MiddlewareInterface
{
    /**
     * Process middleware 
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return array [$request,$response]
     */
    public function process(ServerRequestInterface $request, ResponseInterface $response): array
    {     
        global $arikaim;

        $uri = $request->getUri();
        
        $statsData = [
            'method'          => $request->getMethod(),
            'query_params'    => $request->getQueryParams(),
            'scheme'          => $uri->getScheme(),           
            'path'            => $uri->getPath(),
            'fragment'        => $uri->getFragment(),                    
            'url'             => (string)$uri,
            'client_ip'       => ClientIp::getClientIpAddress($request),
            'http_user_agent' => $request->getHeader('User-Agent')[0] ?? null
        ];

        if (($this->options['dispatch_event'] ?? null) == true) {
            // dispatch event
            $arikaim->get('event')->dispatch('stats.middleware',$statsData);
        }
                  
        $request = $request->withAttribute('stats_data',$statsData); 

        return [$request,$response];   
    }
}
