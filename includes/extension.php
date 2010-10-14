<?php
/**
 * UnifyFramework extensions scripts
 *
 */
/**
 * Load enabled extension
 *
 * @access protected
 */
function uf_load_extensions() {
    $extensions = uf_get_option("theme_options", "extensions");
    if(empty($extensions))
        return;

    foreach($extensions as $extension => $enable_or_disable) {
        if($enable_or_disable === false)
            continue;

        var_dump($extension);
    }
}
add_action("init", "uf_load_extensions");



class UF_Extension {
    /**
     * Protected extension vars
     *
     * @id          unique Extension ID
     * @name        Extension name
     * @description extension description
     */
    var $id, $name, $description;


    /**
     * under PHP 4 Constructor
     *
     * @access public
     * @param  $id   {@see UF_Extension::id}
     * @param  $name   {@see UF_Extension::name}
     * @param  $description   {@see UF_Extension::description}
     */
    function UF_Extension($id, $name = null, $description = null) {
        $this->__construct($id, $name, $description);
    }


    /**
     * over PHP 5 Constructor
     *
     * @access public
     * @param  $id   {@see UF_Extension::id}
     * @param  $name   {@see UF_Extension::name}
     * @param  $description   {@see UF_Extension::description}
     */
    function __construct($id, $name = null, $description = null) {
        $this->id   = $id;
        $this->name = $name;
        $this->description = $description;

        $this->init();
    }



    /**
     * Override initialize method
     *
     * @access public
     * @return Void
     */
    function init() {}



    /**
     * Load UnifyFramework extension
     *   register also action_hook ( filter_hook ).
     *
     * @access public
     * @return Void
     */
    function load() {
        trigger_error(sprintf(
            __("%s is override method ! your class extended this class.", "unify_framework"), __METHOD__
        ), E_USER_NOTICE);
    }
}

