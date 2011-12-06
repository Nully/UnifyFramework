<?php
/**
 * テーマ管理画面の抽象化クラス
 *
 */
abstract class UnifyFramework_Admin
{
    public function __construct()
    {
        // テーマ用管理ルートメニューの追加
        add_action("admin_menu", array(&$this, "admin_menu"));

        // 初期化を実行
        $this->init();
    }


    /**
     * 各管理画面の初期化を行う
     */
    public function init()
    {
    }


    /**
     * 管理画面にメニューを追加する
     *
     * @access protected
     * @return void
     */
    public function admin_menu()
    {
        add_menu_page("UnifyFramework", "UnifyFramework", "edit_themes", "unify-framework", array(&$this, "admin_dashboard"));
    }


    /**
     * テーマ用のメニューに子メニューとしてメニューを追加する
     *
     * @access protected
     * @return void
     */
    protected function add_child_menu()
    {
    }


    public function admin_dashboard()
    {
?>
<div class="wrap">
aaaa
</div>
<?php
    }
}




