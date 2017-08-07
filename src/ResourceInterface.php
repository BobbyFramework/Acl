<?php

namespace BobbyFramework\Acl;

/**
 * Interface ResourceInterface
 * @package BobbyFramework\Acl
 */
interface ResourceInterface
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