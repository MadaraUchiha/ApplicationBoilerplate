<?php

const DS = DIRECTORY_SEPARATOR;

/**
 * Class Autoloader
 *
 * This is an autoloader I wrote myself. It implements PSR-0.
 */
class Autoloader {

    private $path;
    private $namespace;

    public function __construct($path, $namespace) {
        $this->setPath($path);
        $this->setNamespace($namespace);
    }

    public function load($className) {
        if (strpos($className, $this->namespace) !== 0) {
            throw new Exception("Class $className is not found in the default namespace $this->namespace");
        }
        $loadPath = explode(DS, $this->path);
        $className = str_replace($this->namespace, "", $className);
        $classPath = explode("\\", $className);
        $loadPath = array_merge($loadPath, $classPath);
        $loadPath = implode(DS, $loadPath) . ".php";
        $loadPath = realpath($loadPath);
        if (!file_exists($loadPath)) {
            return false;
        }

        require_once $loadPath;
        return true;
    }

    public function register() {
        spl_autoload_register(array($this, "load"));
    }

    /**
     * @param string $path
     *
     * This method cleans the path and then sets it as a property.
     * Cleaning means remove all excess directory separators, and add one at the beginning of the path.
     *
     * AS A RESULT, ONLY ABSOLUTE PATHS ARE ACCEPTED!
     *
     * Using relative paths may result in unexpected behavior!
     */
    public function setPath($path) {
        $path = preg_replace("|[\\\\/]|", DS, $path);
        $path = trim($path, "\\/");
        $path = DS . $path;
        $this->path = $path;
    }


    public function setNamespace($namespace) {
        $namespace = trim($namespace, "\\");
        $this->namespace = $namespace;
    }

}