<?php

namespace BobbyFramework\Acl;

/**
 * Interface RoleInterface
 * @package BobbyFramework\Acl
 */
interface RoleInterface
{
    /**
     * @return string The role name
     */
    public function getName();

    /**
     * @return string The role description
     */
    public function getDescription();

    /**
     * @return mixed Magic method __toString
     */
    public function __toString();
}