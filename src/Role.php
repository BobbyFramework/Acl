<?php

namespace BobbyFramework\Acl;

/**
 * Class Role
 * @package BobbyFramework\Acl
 */
class Role implements RoleInterface
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
     * @var array
     */
    private $options = [];

    /**
     * Role constructor.
     *
     * @param string $name
     * @param string $description
     * @param array $options
     */
    public function __construct($name = '', $description = '', array $options = [])
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setOptions($options);
    }

    /**
     * @param $name
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
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $key
     * @param string $defaultValue
     * @return mixed
     */
    public function getOption($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->options)) ? $this->options[$key] : $defaultValue;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
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

    /**
     * Hydrate
     *
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $attr => $value) {
            $attributPart = explode('_', $attr);

            array_walk_recursive($attributPart, function (&$v) {
                $v = ucfirst($v);
            });
            $attr = implode('', $attributPart);

            $methode = 'set' . ucfirst($attr);

            if (is_callable([$this, $methode])) {
                $this->$methode($value);
            } else {
                $this->options[lcfirst($attr)] = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        //TODO implement...
        return [
            'name' => $this->name,
            'description' => $this->description,
            'options' => $this->options
        ];
    }
}
