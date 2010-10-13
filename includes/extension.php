<?php
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

        $this->_init();
        $this->init();
    }



    /**
     * Default initializer
     *
     * @access private
     * @return Void
     */
    function _init() {
        add_action("admin_init", array(&$this, "init_admin"));
    }



    /**
     * Override initialize method
     *
     * @access public
     * @return Void
     */
    function init() {}



    /**
     * Admin init callback hook
     *
     * @access public
     * @return Void
     */
    function init_admin() {
        global $pagenow, $plugin_page;
        if($pagenow != "themes.php")
            return;

        wp_enqueue_style("uf_admin_css", get_bloginfo("template_url"). "/css/admin.css", array(), UF_VERSION, "all");
    }



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

