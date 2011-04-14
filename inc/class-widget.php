<?php
/**
 * class-widget.php
 */
class UF_Widget extends UF_Plugin
{
    public function admin_menu()
    {
        add_theme_page( "ウィジェット管理", "ウィジェット管理", 10,
                "uf-widget", array( $this, "list_widgets" ));
        add_theme_page("ウィジェットの追加", "ウィジェットの追加", 10,
                "uf-widget-add", array( $this, "manage_widget" ));
    }


    /**
     * display widget admin page
     */
    public function list_widgets()
    {
        $url = admin_url("themes.php");
        $widgets = array();
?>
<div class="wrap">
<?php screen_icon(); ?><h2>ウィジェット管理</h2>

<?php if(!empty($widgets)): ?>
<table border="0" cellpadding="0" cellspacing="0" class="widefat">
</table>
<?php else: ?>
<p>現在登録されているウィジェットはありません。</p>
<p>ウィジェットの登録は<a href="<?php
    echo $url;
?>?page=uf-widget-add">ウィジェットの追加</a>から行えます。</p>
<?php endif; ?>

</div>
<?php
    }


    /**
     * management widget
     *
     * @access public
     */
    public function manage_widget()
    {
        $id = $_GET["id"];
?>
<div class="wrap">
<?php screen_icon(); ?><h2>ウィジェットの追加</h2>
<p>ウィジェットの追加を行います。</p>

<div class="metabox-holder">
<div class="postbox-container" style="width: 49%;">
<div class="meta-box-sortables ui-sortable">
<?php
    $fields = array(
        "name" => array(
            "name" => "name",
            "var"  => null,
            "label" => "ウィジェット名",
            "description" => "ウィジェット名を入力します",
        ),
        "id" => array(
            "name" => "id",
            "var" => null,
            "label" => "ウィジェットID",
            "description" => 'ウィジェットのIDを入力します'
        )
    );
    $this->render_text_fields("ウィジェット設定", $fields);
?>
<?php
    $fields = array(
        "description" => array(
            "name" => "description",
            "var" => null,
            "label" => "説明",
            "description" => "ウィジェットの説明を入力します"
        )
    );
    $this->render_text_fields("ウィジェット説明", $fields);
?>
<!-- End meta box sortable --></div>
<!-- End postbox container --></div>


<div class="postbox-container" style="width: 49%;">
<div class="meta-box-sortables ui-sortable">
<?php
    $fields = array(
        "title_tag" => array(
        ),
        "title_class" => array(
        )
    );
    $this->render_text_fields("ウィジェットタイトルの設定", $fields);
?>


<?php
    $fields = array(
        "widget_tag" => array(
        ),
        "widget_class" => array(
        )
    );

    $this->render_text_fields("ウィジェット枠の設定", $fields);
?>
<!-- End meta box sortable --></div>
<!-- End postbox container --></div>
<!-- End metabox holder --></div>

</div>
<?php
    }
}

$uf_widget = new UF_Widget();
add_action("admin_menu", array($uf_widget, "admin_menu"));
