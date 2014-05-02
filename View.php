<?php

namespace PF\View;

class View
{
    protected $_TEMPLATE_DIR = "";
    protected $_vars = [];

    public function __construct($templateDir)
    {
        $this->_templateDir = $templateDir;
    }
    
    public function render($templateName, $templateNameIsAbsolutePath = false)
    {
        if ($templateNameIsAbsolutePath) {
            include $templateName;
        } else {
            include $this->_templateDir . '/' . $templateName . '.phtml';
        }
    }
    
    public function __isset($name)
    {
        return array_key_exists($name, $this->_vars);
    }

    public function __unset($name)
    {
        unset($this->_vars[$name]);
    }

    public function __set($name, $value)
    {
        $this->_vars[$name] = $value;
    }
    
    public function __get($name)
    {
        if ($this->__isset($name)) {
            return (is_scalar($this->_vars[$name])
                ? htmlspecialchars($this->_vars[$name])
                : $this->_vars[$name]
            );
        }
        
        // todo
        trigger_error("Undefined view var '$name'", E_USER_NOTICE);
    }
}