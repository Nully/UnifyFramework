<?php
/**
 * class-admin.php
 */
class UF_Admin {
    /**
     * UF_Admin object
     *
     * @access protected
     * @var    Array
     */
    protected static $__instance = array();


    protected $_plugins = array();


    /**
     * get Singletone object
     *
     * @access public
     * @return UF_Admin
     */
    public static function &getInstance()
    {
        if(empty(self::$__instance)) {
            self::$__instance[0] = new self();
        }

        return self::$__instance[0];
    }


    /**
     * register theme admin plugin
     *
     * @access public
     * @param  $plugin
     * @return Bool
     */
    public function registerPlugin($plugin)
    {
        $name = strtolower(get_class($plugin));
        if(!$this->hasPlugin($name) && $plugin instanceof UF_Plugin) {
            $this->_plugins[$name] = $plugin;
            return true;
        }
        return false;
    }


    /**
     * already has plugin ?
     *
     * @access public
     * @param  $name
     * @return Bool
     */
    public function hasPlugin($name)
    {
        return isset($this->_plugins[$name]);
    }
}


// register admin menu
