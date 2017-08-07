<?php

namespace BobbyFramework\Acl;

/**
 * Class Acl
 * @package BobbyFramework\Acl
 */
class Acl extends AclAbstract
{
    /**
     * @var
     */
    protected $roles;

    /**
     * @var
     */
    protected $roleNames;

    /**
     * @var
     */
    protected $resourcesNames;

    /**
     * @var
     */
    protected $resources;

    /**
     * @var array
     */
    protected $access = array();

    /**
     * @var int
     */
    protected $defaultAccess = 0;

    /**
     * Acl constructor.
     * @param array $access
     */
    public function __construct(array $access = [])
    {
        $this->access = $access;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->access;
    }

    /**
     *  Check whether resource exist in the resources list
     *
     * @param string $resourceName
     * @return bool
     */
    public function isResource($resourceName)
    {
        return isset($this->resourcesNames[$resourceName]);
    }

    /**
     * Check whether role exist in the roles list
     *
     * @param string $roleName
     * @return bool
     */
    public function isRole($roleName)
    {
        return isset($this->roleNames[$roleName]);
    }

    /**
     * Adds a resource to the ACL list
     *
     * @param string $resource
     * @param string $rights
     */
    public function addResource($resource, $rights)
    {
        if (is_object($resource) && $resource instanceof ResourceInterface) {
            $resourceName = $resource->getName();
        } else {
            $resourceName = $resource;
        }

        if (isset($this->resourcesNames[$resourceName])) {
            $this->resourcesNames[$resourceName] = array();
        }

        if (is_array($rights)) {
            foreach ($rights as $right) {
                $this->resources[$resourceName][$right] = $this->defaultAccess;
            }
        } else {
            $this->resources[$resourceName][$rights] = $this->defaultAccess;
        }
    }

    /**
     * @param $role
     * @throws \Exception
     */
    public function addRole($role)
    {
        if (is_object($role) && $role instanceof RoleInterface) {
            $newRole = $role;
        } elseif (is_string($role)) {
            $newRole = new Role($role);
        } else {
            throw new \Exception("Error");
        }

        $this->roleNames[] = $newRole->getName();
        $this->roles[] = $newRole;
    }

    /**
     * @param string|array $roleName
     * @param null $resourceName
     * @param null $rights
     * @return int
     */
    public function isAllowed($roleName, $resourceName = null, $rights = null)
    {
        if (!is_array($roleName)) {
            $roleName = array($roleName);
        }

        $return = self::DENY;

        foreach ($roleName as $role) {
            if ((isset($this->access[$role]) && is_null($resourceName) && is_null($rights))
                || (!is_null($resourceName) && isset($this->access[$role][$resourceName]) && is_null($rights))
            ) {
                $return += self::ALLOW;
            } elseif (isset($this->access[$role][$resourceName][$rights])) {
                $return += $this->access[$role][$resourceName][$rights];
            }
        }

        return $return;
    }

    /**
     * Checks if a role has access to a resource
     *
     * @param string $roleName
     * @param string $resourceName
     * @param string $rights
     * @param string $action
     * @throws \Exception
     */
    private function allowOrDeny($roleName, $resourceName, $rights, $action)
    {
        if (isset($this->roleNames[$roleName])) {
            throw new \Exception("Role '" . $roleName . "' does not exist in ACL");
        }

        if (isset($this->resourcesNames[$resourceName])) {
            throw new \Exception("Role '" . $resourceName . "' does not exist in ACL");
        }

        foreach ($this->resources as $key => $rs) {
            if ($key == $resourceName) {
                foreach ($rs as $j => $t) {
                    if (!isset($this->access[$roleName][$key][$j])) {
                        $this->access[$roleName][$key][$j] = self::DENY;
                    }
                }
            }
        }

        if (is_array($rights)) {
            foreach ($rights as $right) {
                $this->access[$roleName][$resourceName][$right] = $action;
            }
        } else {
            $this->access[$roleName][$resourceName][$rights] = $action;
        }
    }

    /**
     * Allow access to a role on a resource
     *
     * Example:
     * <code>
     * //Allow access to guests to search on customers
     * $acl->allow("guests", "customers", "search");
     * </code>
     *
     * @param string $role
     * @param string $resource
     * @param string $right
     */
    public function allow($role, $resource, $right)
    {
        $this->allowOrDeny($role, $resource, $right, self::ALLOW);
    }

    /**
     * Deny access to a role on a resource
     *
     * Example:
     * <code>
     * //Deny access to guests to search on customers
     * $acl->deny("guests", "customers", "search");
     * </code>
     *
     * @param string $role
     * @param string $resource
     * @param string $right
     */
    public function deny($role, $resource, $right)
    {
        $this->allowOrDeny($role, $resource, $right, self::DENY);
    }
}
