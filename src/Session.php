<?php

namespace LitePubl\Core\Session;

use Psr\Container\ContainerInterface;

class Session implements SessionInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function init(bool $useCookie = false)
    {
            ini_set('session.use_cookies', $useCookie);
            ini_set('session.use_only_cookies', $useCookie);
            ini_set('session.use_trans_sid', 0);
            session_cache_limiter(false);

        if (function_exists('igbinary_serialize')) {
            ini_set('igbinary.compact_strings', 0);
            ini_set('session.serialize_handler', 'igbinary');
        }

        $this->initMemCache();
    }

    protected function initMemCache(): bool
    {
        $memCache = $this->container->get(\MemCache::class);
        if ($memCache) {
            $this->container->get(MemCacheSession::class);
            return true;
        }

        return false;
    }

    public function start(string $id)
    {
        $this->init(false);
        session_id($id);
        session_start();
    }
}
