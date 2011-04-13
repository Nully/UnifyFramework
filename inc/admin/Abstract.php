<?php
/**
 * UnifyFramework admin page class Abstract
 */
abstract class UnifyFramework_Admin_Abstract
{
    /**
     * Display notice message
     *
     * @access public
     * @return Void
     */
    abstract public static function notices();


    /**
     * shown admin page.
     *
     * @access public
     * @return Void
     */
    abstract public static function form();
}
