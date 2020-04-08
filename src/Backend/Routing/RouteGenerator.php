<?php

namespace Bambamboole\LaravelCms\Backend\Routing;

use Tightenco\Ziggy\BladeRouteGenerator;

class RouteGenerator extends BladeRouteGenerator
{
    public function generate($group = false)
    {
        $url = url('/');
        $parsedUrl = parse_url($url);

        return [
            'namedRoutes' => $this->getRoutePayload($group),
            'baseUrl' => $url.'/',
            'baseProtocol' => array_key_exists('scheme', $parsedUrl) ? $parsedUrl['scheme'] : 'http',
            'baseDomain' => array_key_exists('host', $parsedUrl) ? $parsedUrl['host'] : '',
            'basePort' => array_key_exists('port', $parsedUrl) ? $parsedUrl['port'] : 'false',
            'defaultParameters' => method_exists(app('url'), 'getDefaultParameters')
                ? app('url')->getDefaultParameters()
                : [],
        ];
    }
}
