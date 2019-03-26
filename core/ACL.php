<?php

namespace Blaj\BlajMVC\Core;

abstract class ACL
{
    private static $role = 'Guest';

    private static $roles = array();

    private static $privilenges = array();

    public function __call($name, $arguments)
    {
        if ($this->isAllowed(self::$role, $name))
            return call_user_func_array(array($this, $name), $arguments);

        return false;
    }

    protected function addRole($role, $parent)
    {
        self::$roles[$role] = $parent;
    }

    protected function addPrivilenge(bool $isAllowed, string $role = null, string $privelenge = null)
    {
        $privilenges = func_get_args();
        $allowed = array_shift($privilenges);
        $role = array_shift($privilenges);
        $resource = get_class($this);
        if (!$privilenges) {
            $privilenges = array(null);
        }

        foreach ($privilenges as $privilenge) {
            self::$privilenges[$role][$resource][$privilenge] = (bool)$allowed;
        }
    }

    protected function isAllowed(string $role = null, string $privilenge = null): bool
    {
        $resource = get_class($this);
        if (isset(self::$privilenges[$role][$resource][$privilenge])) {
            return self::$privilenges[$role][$resource][$privilenge];
        }

        if (isset($privilenge) && isset(self::$privilenges[$role][$resource][null])) {
            return self::$privilenges[$role][$resource][null];
        }

        for ($item = get_parent_class($this), $reflection = new \ReflectionClass($item); !$reflection->isAbstract(); $item = get_parent_class($item), $reflection = new ReflectionClass($item))  {
            $item = new $item;

            if (($allowed = $item->isAllowed($role, $privilenge)) !== null) {
                return $allowed;
            }
        }

        if (isset($role)) {
            $result = isset(self::$roles[$role]) && ($allowed = $this->isAllowed(self::$roles[$role], $privilenge)) !== null ? $allowed : $this->isAllowed(null, $privilenge);

            return $result;
        }

        return false;
    }

    protected function getRole(): string
    {
        return self::$role;
    }

    protected function setRole(string $role)
    {
        self::$role = $role;
    }

    protected function getRoles(): array
    {
        return $this->roles;
    }

    protected function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    protected function getPrivilenges(): array
    {
        return $this->privilenges;
    }

    protected function setPrivilenges(array $privilenges)
    {
        $this->privilenges = $privilenges;
    }
}