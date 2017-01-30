<?php

namespace App\Library;

use \Interop\Container\ContainerInterface as ContainerInterface;

abstract class AController {
    protected $ci;
    protected $filterList = array();

    protected $sort = array();
    protected $filters = array();
    protected $limit = 10;
    protected $offSet = 0;
    protected $search;
    protected $cache;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->cache = $ci->get('cdb');
    }

    protected function parseQueryParams($req)
    {
        if ($req->isMethod('GET')) {
            foreach ($req->getQueryParams() as $param => $value) {
                switch (strtolower($param)) {
                    case 'sort':
                        $this->sort[$param] = $value;
                        break;
                    case 'limit':
                        $this->limit = (int)$value;
                        break;
                    case 'offset':
                        $this->offSet = (int)$value;
                        break;
                    case 'q':
                        $this->search = $value;
                        break;
                    default:
                        $this->filters[$param] = $value;
                        break;
                }
            }
        }
    }
}