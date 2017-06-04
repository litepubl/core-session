<?php

namespace LitePubl\Core\Session;

class MemCacheSession
{
    protected $memcache;
    protected $prefix;
    protected $lifetime;

    public function __construct(\MemCache $memCache, string $prefix, int $lifetime = 3600)
    {
        $this->memcache = $memCache;
        $this->prefix = 'ses-' . $prefix;
        $this->lifetime = $lifetime;

        session_set_save_handler(
            [$this, 'truefunc'],
            [$this, 'truefunc'],
        [$this, 'read'],
        [$this, 'write'],
        [$this, 'destroy'],
            [$this, 'truefunc']
        );
    }

    public function truefunc()
    {
        return true;
    }

    public function read($id)
    {
        return $this->memcache->get($this->prefix . $id);
    }

    public function write($id, $data)
    {
        return $this->memcache->set($this->prefix . $id, $data, false, $this->lifetime);
    }

    public function destroy($id)
    {
        return $this->memcache->delete($this->prefix . $id);
    }
}
