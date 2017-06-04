<?php

namespace LitePubl\Core\Session;

interface SessionInterface
{
    public function init(bool $useCookie = false);
    public function start($id);
}
