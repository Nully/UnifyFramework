<?php
/**
 * @see UnifyFramework_Admin
 */
require_once UNIFY_INC_PATH. "/class-page.php";


class UnifyFramework_Admin_Widgets extends UnifyFramework_Admin_Page
{
    public function __construct()
    {
        add_action("admin_menu", array(&$this, "add_subpage"));
        add_action("admin_menu", array(&$this, "register_settings_field"));
    }


    public function add_subpage()
    {
        add_submenu_page(
            UnifyFramework_Admin_Dashboard::PAGE_SLUG,
            "ウィジェット一覧",
            "ウィジェット一覧",
            UnifyFramework_Admin_Dashboard::CAPABILITY,
            UnifyFramework_Admin_Dashboard::PAGE_SLUG. "-widget-list",
            array(&$this, "page_widget_list")
        );

        add_submenu_page(
            UnifyFramework_Admin_Dashboard::PAGE_SLUG,
            "ウィジェット登録",
            "ウィジェット登録",
            UnifyFramework_Admin_Dashboard::CAPABILITY,
            UnifyFramework_Admin_Dashboard::PAGE_SLUG. "-widget-add",
            array(&$this, "page_widget_add")
        );
    }


    public function register_settings_field()
    {
        // ウィジェット登録のための設定フィールド
        register_setting(UnifyFramework_Admin_Dashboard::PAGE_SLUG. "-widget-add", "widget_name", "esc_attr");
    }


    /**
     * 登録済みウィジェット一覧
     *
     * @access public
     * @return void
     */
    public function page_widget_list()
    {
?>
<div class="wrap">
<?php screen_icon("options-general"); ?>
<h2>ウィジェット一覧</h2>
<!-- End wrap --></div>
<?php
    }


    /**
     * ウィジェット登録画面
     *
     * @access public
     * @return void
     */
    public function page_widget_add()
    {
?>
<div class="wrap">
<?php screen_icon("options-general"); ?>
<h2>ウィジェット登録</h2>
<form action="options.php" method="post">
<?php settings_fields(UnifyFramework_Admin_Dashboard::PAGE_SLUG. "-widget-add"); ?>

<input type="text" name="widget_name" value="hoge" />

<p><input type="submit" name="save" value="ウィジェットを登録" class="button-primary" /></p>
</form>

<!-- End wrap --></div>
<?php
    }
}

