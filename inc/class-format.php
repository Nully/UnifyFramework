<?php
/**
 * class-format.php
 */
class UF_Format extends UF_Plugin
{
    protected $_defaults = array(
        "aside", "gallery",
    );


    protected $_formats = array(
        array( "var" => "aside",   "label" => "アサイド"),
        array( "var" => "gallery", "label" => "ギャラリー" ),
        array( "var" => "link",    "label" => "リンク" ),
        array( "var" => "image",   "label" => "画像" ),
        array( "var" => "quote",   "label" => "引用" ),
        array( "var" => "status",  "label" => "ステータス" ),
        array( "var" => "video",   "label" => "ビデオ" ),
        array( "var" => "audio",   "label" => "オーディオ" ),
        array( "var" => "chat",    "label" => "チャット" )
    );


    /**
     * initialize formats
     */
    public function init_formats()
    {
        $formats = get_option("uf_formats", array());
        if(empty($formats))
            $formats = $this->_defaults;

        add_theme_support("post-formats", $formats);
    }


    /**
     * save post formats
     */
    public function save_formats()
    {
        if(!$_POST["save_formats"]) return;

        if(!wp_verify_nonce($_POST["_wpnonce"])) return;

        $formats = $_POST["formats"];
        if(empty($formats))
            $formats = $this->_defaults;

        if(update_option("uf_formats", $formats))
            $message = 1;
        else
            $message = 99;

        $url = admin_url("themes.php?page=uf-formats&message{$message}");
        wp_redirect($url);
    }


    /**
     * init admin menu
     */
    public function admin_menu()
    {
        add_theme_page("投稿フォーマット", "投稿フォーマット",
                10, "uf-format", array( $this, "manage_formats" ));
    }


    /**
     * manage post formats
     */
    public function manage_formats()
    {
        $selects = get_option("uf_formats", array());
        if(empty($selects))
            $selects = $this->_defaults;
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿フォーマット</h2>
<p>サポートする投稿フォーマットを指定します。</p>
<p>投稿フォーマットについての詳しい情報は<a href="http://codex.wordpress.org/Post_Formats">WordPress.com</a>を参考にしてください。</p>

<form action="" method="post">
<div class="metabox-holder">
<div class="postbox-container" style="width: 99%;">
<div class="meta-box-sortables ui-sortable">
<?php
    $this->render_checkbox_fields(
        "投稿フォーマット", $this->_formats, "formats", $selects,
        "サポートする投稿フォーマットを選択します。"
    );
?>
<!-- End meta box sortables --></div>
<!-- End postbox container --></div>
<!-- End metabox holder --></div>
<p>
<input type="submit" name="save_formats" value="保存" class="button-primary" />
</p>
</form>
<!-- End wrap --></div>
<?php
    }
}

$uf_format = new UF_Format();
add_action("init", array($uf_format, "init_formats"));
add_action("admin_init", array($uf_format, "save_formats"));
add_action("admin_menu", array($uf_format, "admin_menu"));
