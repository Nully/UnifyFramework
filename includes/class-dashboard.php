<?php
class UnifyFramework_Admin_Dashboard
{
    /**
     * @PAGE_SLUG
     */
    const PAGE_SLUG = "unify-framework";


    /**
     * @CAPABILITY
     */
    const CAPABILITY = "edit_themes";


    /**
     * テーマページ一覧
     *
     * @access protected
     * @var    Array
     */
    protected $_pages = array();


    public function __construct()
    {
        add_action("admin_menu", array(&$this, "add_theme_menu"), 0);
    }


    public function add_theme_menu()
    {
        add_menu_page("UnifyFramework", "UnifyFramework", self::CAPABILITY, self::PAGE_SLUG, array(&$this, "dashboard"));
    }


    // テーマのページを登録する
    public function register_theme_page(UnifyFramework_Admin_Page &$page)
    {
        $name = get_class($page);
        if(!isset($this->_pages[$name])) {
            $this->_pages[get_class($page)] = $page;
        }
        return $this;
    }


    // ダッシュボードを表示
    public function dashboard()
    {
        echo '<h1>Hello World !</h1>';
    }
}
