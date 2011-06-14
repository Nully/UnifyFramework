<?php
/**
 * class-post_thumbnail.php
 */
class UF_PostThumbnail extends UF_Plugin
{
    /**
     * post thumbnail paramater defaults
     *
     * @access protected
     * @var    Array
     */
    protected $_defaults = array(
        "post_type" => "post",
        "width" => 150,
        "height" => 150,
        "crop" => 0
    );


    /**
     * initialize post thumbnails
     *
     * @access public
     */
    public function setup_thumbnails()
    {
        $thumbnails = (array)get_option("uf_thumbnails", array());
        $types = array();
        foreach($thumbnails as $type => $thumb) {
            $types[] = $type;
            $width = $thumb["width"];
            $height = $thumb["height"];
            $crop = (bool)(int)$thumb["crop"];
            add_image_size($type, $width, $height, $crop);
        }
        add_theme_support("post-thumbnails", $types);
    }


    /**
     * register or update registerd post thumbnail size
     */
    public function save_size()
    {
        if(!isset($_POST["save_size"])) return;

        if(!wp_verify_nonce($_POST["_wpnonce"])) return;

        $post_type = esc_attr($_POST["post_type"]);
        if(!$post_type) wp_die("投稿タイプを選択してください。");


        $thumbnails = get_option("uf_thumbnails", array());
        if(!isset($thumbnails[$post_type])) {
            $thumbnails[$post_type] = array();
        }

        $thumbnails[$post_type] = array(
            "width"  => $_POST["width"],
            "height" => $_POST["height"],
            "crop"   => $_POST["crop"]
        );

        array_filter($thumbnails[$post_type], "esc_attr");

        if(update_option("uf_thumbnails", $thumbnails)) {
            $message = 1;
        }
        else {
            $message = 99;
        }

        $url = admin_url("themes.php?page=uf-post-thumbnail&message={$message}");
        wp_redirect($url);
    }


    /**
     * delete registerd post thumbnail size
     *
     * @access public
     */
    public function delete_size()
    {
        if(!isset($_GET["page"]) || $_GET["page"] != "uf-post-thumbnail") return;

        if($_GET["action"] != "delete") return;

        if(!wp_verify_nonce($_GET["_wpnonce"])) return;

        $post_type = $_GET["type"];
        if(empty($post_type)) return;

        $thumbnails = get_option("uf_thumbnails", array());
        if(empty($thumbnails)) return;
        if(!isset($thumbnails[$post_type])) return;

        unset($thumbnails[$post_type]);
        if(update_option("uf_thumbnails", $thumbnails)) {
            $message = 2;
        }
        else {
            $message = 99;
        }

        $url = admin_url("themes.php?page=uf-post-thumbnail&message={$message}");
        wp_redirect($url);
    }


    /**
     * display notice messages
     *
     * @access public
     */
    public function admin_notices()
    {
        if(!isset($_GET["page"]) || $_GET["page"] != "uf-post-thumbnail") return;

        $html = "";
        switch($_GET["message"]) {
            case 1:
                $html = '<div class="success updated fade">'.
                        '<p>投稿サムネイルを保存しました。</p>'.
                        '</div>';
                break;
            case 2:
                $html = '<div class="success updated fade">'.
                        '<p>投稿サムネイルを削除しました。</p>'.
                        '</div>';
                break;
            case 99:
                $html = '<div class="error">'.
                        '<p>投稿サムネイルの保存に失敗しました。</p>'.
                        '</div>';
                break;
        }
        echo $html;
    }


    /**
     * register admin menu
     *
     * @access public
     */
    public function admin_menu()
    {
        add_theme_page(
            "投稿サムネイル管理",
            "投稿サムネイル管理",
            "manage_options",
            "uf-post-thumbnail",
            array( $this, "list_sizes" )
        );
        add_theme_page(
            "投稿サムネイルの追加",
            "投稿サムネイルの追加",
            "manage_options",
            "uf-post-thumbnail-add",
            array( $this, "manage_size" )
        );
    }


    /**
     * display registerd post thumbnail sizes
     *
     * @access public
     */
    public function list_sizes()
    {
        $thumbnails = get_option("uf_thumbnails", array());
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿サムネイル管理</h2>

<?php if(!empty($thumbnails)): ?>
<table border="0" cellpadding="0" cellspacing="0" class="widefat">
<thead>
<tr>
<th>投稿タイプ名</th>
<th>画像幅</th>
<th>画像高さ</th>
<th>切り抜き</th>
</tr>
</thead>
<tfoot>
<tr>
<th>投稿タイプ名</th>
<th>画像幅</th>
<th>画像高さ</th>
<th>切り抜き</th>
</tr>
</tfoot>
<?php foreach($thumbnails as $post_type => $thumbnail): ?>
<tbody>
<tr>
<td><?php echo $post_type; ?>
<div class="row-actions">
<span class="edit"><a href="<?php
    echo $url;
?>?page=uf-post-thumbnail-add&type=<?php
    echo $post_type;
?>">編集</a></span> |
<span class="trash"><a href="<?php
    echo $url;
?>?page=uf-post-thumbnail&action=delete&type=<?php
    echo $post_type;
?>&_wpnonce=<?php
    echo wp_create_nonce();
?>" onclick="javascript: return confirm('投稿タイプ: <?php
    echo $post_type;
?> の投稿サムネイルを削除します。');">削除</a></span>
</div></td>
<td><?php echo $thumbnail["width"]; ?></td>
<td><?php echo $thumbnail["height"]; ?></td>
<td><?php echo $thumbnail["crop"] == 0 ? "いいえ": "はい"; ?></td>
</tr>
</tbody>
<?php endforeach; ?>

</table>
<?php else: ?>
<p>現在投稿サムネイルは登録されていません。</p>
<p>投稿サムネイルの追加は<a href="<?php
    echo $url;
?>?page=uf-post-thumbnail-add">投稿サムネイルの追加</a>から行えます。</p>
<?php endif; ?>

</div>
<?php
    }


    /**
     * post thumbnail size management
     *
     * @access public
     */
    public function manage_size()
    {
        $id = $_GET["type"];
        $thumbnail = array();
        if(!empty($id)) {
            $thumbnails = get_option("uf_thumbnails", array());
            $thumbnail = $thumbnails[$id];
        }

        $thumbnail = wp_parse_args($thumbnail, $this->_defaults);
        extract($thumbnail);
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿サムネイルの追加</h2>
<form action="" method="post">
<?php echo wp_nonce_field(); ?>

<div class="metabox-holder">
<div class="postbox-container" style="width: 99%;">
<div class="meta-box-sortables ui-sortable">
<?php
    $vars = get_post_types();
    $types = array();
    foreach($vars as $key => $type) {
        $types[] = array( "var" => $key, "label" => __($type) );
    }

    $this->render_select_fields(
        "投稿タイプの指定", $types, "post_type",
        $id, 
        "サムネイルを登録する投稿タイプを選択してください。<br />".
        "既に登録済みの投稿サイズは上書きされます。"
    );

?>

<?php
    $fields = array(
        "width" => array(
            "label" => "画像幅",
            "name"  => "width",
            "var"   => $width,
            "description" => "ピクセルで画像幅を入力してください。"
        ),
        "height" => array(
            "label" => "画像高",
            "name"  => "height",
            "var"   => $height,
            "description" => "ピクセルで画像高さを指定してください。",
        )
    );

    $this->render_text_fields("サムネイルサイズ", $fields);
?>


<?php
    $fields = array(
        array( "var" => "1", "label" => "はい" ),
        array( "var" => "0", "label" => "いいえ" ),
    );

    $this->render_radio_fields(
        "切り抜き設定", $fields, "crop",
        $crop,
        "投稿サムネイルのサイズが指定の大きさ超えた際に切り抜くかの設定<br />".
        "初期値は 切り抜きません。"
    );
?>
<!-- End meta box sortables --></div>
<!-- End postbox container --></div>
<!-- End metabox holder --></div>
<p>
<input type="submit" value="保存" name="save_size" class="button-primary" />
</p>
</form>

</div>
<?php
    }
}

$uf_post_thumbnail = new UF_PostThumbnail();
add_action("init", array($uf_post_thumbnail, "setup_thumbnails"));
add_action("admin_init", array($uf_post_thumbnail, "save_size"));
add_action("admin_init", array($uf_post_thumbnail, "delete_size"));
add_action("admin_notices", array($uf_post_thumbnail, "admin_notices"));
add_action("admin_menu", array($uf_post_thumbnail, "admin_menu"));
