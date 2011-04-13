<?php
/**
 * class-widget.php
 */
class UF_Widget extends UF_Plugin
{
    public function admin_menu()
    {
        add_theme_page("ウィジェット管理", "ウィジェット管理", 10, "uf-widget", array( $this, "list_widgets" ));
    }


    /**
     * display widget admin page
     */
    public function list_widgets()
    {
?>
<div class="wrap">
<?php screen_icon(); ?><h2>ウィジェット管理</h2>
</div>
<?php
    }
}

$uf_widget = new UF_Widget();
add_action("admin_menu", array($uf_widget, "admin_menu"));
