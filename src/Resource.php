<?php
namespace BobbyFramework\Acl;

/**
 * Class Resource
 * @package BobbyFramework\Acl
 */
class Resource implements ResourceInterface
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $name;

    /**
     * Resource constructor.
     * @param string $name
     * @param string $description
     */
    public function __construct($name = '', $description = '')
    {
        $this->setName($name);
        $this->setDescription($description);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the role name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns role description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Magic method __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
