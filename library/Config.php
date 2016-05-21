<?php

namespace Illustrator;

use ArrayAccess;
use Countable;
use ReflectionClass;
use RuntimeException;

class Config implements ArrayAccess, Countable
{
    /**
     * @var array
     */

    private $register = array();

    /**
     * @param string $key
     * @param string $val
     * @param array $params
     */

    public function register($key, $val, $params = array())
    {
        $params = is_array($params) ? $params : array($params);
        if(is_string($val) && class_exists($val)){
            $val = $this->constructor($val, $params);
        }
        $this->register[$key] = $val;
    }

    /**
     * @param string $key
     * @param string|array $value
     */

    public function __set($key, $value)
    {
        $this->register($key, $value);
    }

    /**
     * @param string $key
     * @throws RuntimeException
     * @return object|array|string
     */

    public function __get($key)
    {
        if(!$this->exists($key)){
            throw new RuntimeException("the key {$key} not exists");
        }

        return $this->get($key);
    }

    /**
     * @param null $inv
     */

    public function __invoke($inv)
    {

    }

    /**
     * @param string $offset
     * @return bool
     */

    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }

    /**
     * @param string $offset
     * @throws RuntimeException
     * @return object|array|string
     */

    public function offsetGet($offset)
    {
        $offset = is_string($offset) && class_exists($offset) ? $this->registerKey($offset) : $offset;
        if(!$this->exists($offset)){
            throw new RuntimeException("the key {$offset} not exists");
        }

        return $this->get($offset);
    }

    /**
     * @param string $offset
     * @param string|array $value
     */

    public function offsetSet($offset, $value)
    {
        $this->register($offset, $value);
    }

    /**
     * @param string $offset
     */

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }


    /**
     * @return array
     */

    public function count()
    {
        return $this->register;
    }

    /**
     * @access private
     * @param string $class
     * @return ReflectionClass
     */

    private function reflection($class)
    {
        return new ReflectionClass($class);
    }

    /**
     * @param string $object class
     * @return string
     */

    protected function registerKey($object)
    {
        $reflection = $this->reflection($object);
        $shortName = strtolower($reflection->getShortName());

        if(!$this->exists($shortName)){
            $this->register($shortName, $object);
        }
        return $shortName;
    }

    /**
     * @access protected
     * @param string $key
     * @return mixed
     */

    protected function get($key)
    {
        return $this->register[$key];
    }

    /**
     * @access protected
     * @param string $value class
     * @param array $params
     * @return object
     */

    protected function constructor($value, $params = array())
    {
        if(class_exists($value)){
            $reflection = $this->reflection($value);
            if($reflection->isInstantiable()){
                $class = empty($params) ? $reflection->newInstance() : $reflection->newInstanceArgs($params);

                return $class;
            }
        }
    }

    /**
     * @access protected
     * @param string $key
     */

    protected function delete($key)
    {
        unset($this->register[$key]);
    }

    /**
     * @access protected
     * @param string $key
     * @return bool
     */

    protected function exists($key)
    {
        return isset($this->register[$key]);
    }
}