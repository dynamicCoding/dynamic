<?php

namespace Illustrator;

use ArrayAccess;
use LogicException;

class Application implements ArrayAccess
{
    /**
     * @var array
     */

    public $register = array();

    /**
     * @var array
     */

    public $app = array();

    /**
     *
     *
     * @param string $name property
     * @param string $value value
     */
    public function __set($name, $value)
    {
        $this->singleton($name, $value);
    }

    /**
     * obtener la clase cuando es llamado este metodo magico
     *
     * @param string $name
     * @return null
     */

    public function __get($name)
    {
        return $this->invoke($name);
    }

    /**
     * @param $name
     * @return bool
     */

    public function __isset($name)
    {
        return $this->exists($name);
    }

    /**
     * @param string $name
     */

    public function __unset($name)
    {
        $this->remove($name);
    }

    /**
     * @param mixed $name
     * @return bool
     */

    public function offsetExists($name)
    {
        return $this->exists($name);
    }

    /**
     * @param mixed $name
     * @param mixed $closure
     */

    public function offsetSet($name, $closure)
    {
        $this->singleton($name, $closure);
    }

    /**
     * @param mixed $name
     * @return null
     */

    public function offsetGet($name)
    {
        return $this->invoke($name);
    }

    /**
     * @param mixed $name
     */

    public function offsetUnset($name)
    {
        $this->remove($name);
    }

    /**
     * @param string $name
     * @param callable $val
     */

    public function apply($name, $val)
    {
        $this->app[$name] = $val;
    }

    /**
     * @param string $name
     * @return bool
     */

    public function exists($name)
    {
        return isset($name);
    }

    /**
     * @param string $name
     * @return mixed
     */

    public function get($name)
    {
        return $this->app[$name];
    }

    /**
     * @param string $name
     */

    public function remove($name)
    {
        unset($this->app[$name]);
    }

    /**
     * @param $name
     * @return string | bool
     */

    private function keyExists($name)
    {
        if(!array_key_exists($name, $this->app)) {
            throw new LogicException('la clave '.$name.' no existe '. __METHOD__);

            return false;
        }

        return $name;
    }

    /**
     * @param string $property
     * @param callable $closure
     */

    public function singleton($property, $closure)
    {
        $this->apply($property, function($c) use ($closure) {
            static $null;
            if($null == null) {
                $null = $closure($c);
            }
            return $null;
        });
    }

    /**
     * @param string $name
     * @param null $default
     * @return object | null
     */
     
    protected function invoke($name, $default = null)
    {
        if($this->keyExists($name)) {

            $call = is_object($this->app[$name]) && method_exists($this->app[$name], '__invoke');

            return $call ? $this->app[$name]($this) : $this->app[$name];

        }

        return $default;
    }
}