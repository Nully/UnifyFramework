<?php
/**
 * class-posttype.php
 */
class UF_Posttype extends UF_Plugin
{
	/**
	 * post type labels options fields
	 *
	 * @access protected
	 * @var    Array
	 */
    protected $_labels = array(
        "name" => array(
            "name" => "name",
            "label" => "投稿タイプ名",
            "description" => "投稿タイプの複数形のラベル"
        ),
        "singular_name" => array(
            "name" => "singular_name",
            "label" => "単一記事名",
            "description" => "単一記事のラベル"
        ),
        "add_new" => array(
            "name" => "add_new",
            "label" => "新しく追加",
            "description" => "新しく追加するためのラベル"
        ),
        "add_new_item" => array(
            "name" => "add_new_item",
            "label" => "新規追加",
            "description" => "新規追加のラベル"
        ),
        "edit_item" => array(
            "name" => "edit_item",
            "label" => "編集",
            "description" => "編集のためのラベル"
        ),
        "new_item" => array(
            "name" => "new_item",
            "label" => "新規追加",
            "description" => "新規追加のためのラベル"
        ),
        "view_item" => array(
            "name" => "view_item",
            "label" => "表示",
            "description" => "表示するためのラベル"
        ),
        "search_items" => array(
            "name" => "search_items",
            "label" => "検索",
            "description" => "検索の為のラベル"
        ),
        "not_found" => array(
            "name" => "not_found",
            "label" => "NotFound",
            "description" => "NotFoundのラベル"
        ),
        "not_found_in_trash" => array(
            "name" => "not_found_in_trash",
            "label" => "NotFoundInTrash",
            "description" => "ゴミ箱のNotFoundのラベル"
        ),
        "parent_item_colon" => array(
            "name" => "parent_item_colon",
            "label" => "親記事",
            "description" => "親を表すためのラベル"
        )
    );


	/**
	 * post type public option
	 *
	 * @access protected
	 * @var    Array
	 */
	protected $_public = array(
		array( "var" => 1, "label" => "はい" ),
		array( "var" => 0, "label" => "いいえ" ),
	);


	/**
	 * post type query posts options.
	 *
	 * @access protected
	 * @var    Array
	 */
	protected $_query_posts = array(
		array( "var" => 1, "label" => "はい" ),
		array( "var" => 0, "label" => "いいえ" ),
	);


	/**
	 * exclude search form options
	 *
	 * @access protected
	 * @var    Array
	 */
	protected $_exclude_form_search = array(
		array( "var" => 1, "label" => "はい" ),
		array( "var" => 0, "label" => "いいえ" ),
	);


	/**
	 * show in admin page default UI options
	 *
	 * @access protected
	 * @var    Array
	 */
	protected $_show_ui = array(
		array( "var" => 1, "label" => "はい" ),
		array( "var" => 0, "label" => "いいえ" ),
	);


	/**
	 * capability options
	 *
	 * @access protected
	 * @var    Array
	 */
	protected $_capability_type = array(
		array( "var" => "post", "label" => "投稿" ),
		array( "var" => "page", "label" => "ページ" ),
	);


	/**
	 * hierarchical options
	 *
	 * @access protected
	 * @var    Array
	 */
	protected $_hierarchical = array(
		array( "var" => 1, "label" => "はい" ),
		array( "var" => 0, "label" => "いいえ" ),
	);


    /**
     * post type supports
     *
     * @access protected
     * @var    Array
     */
    protected $_supports = array(
        array( "var" => "title",           "label" => "タイトル" ),
        array( "var" => "editor",          "label" => "エディタ" ),
        array( "var" => "author",          "label" => "投稿者" ),
        array( "var" => "thumbnail",       "label" => "サムネイル" ),
        array( "var" => "excerpt",         "label" => "抜粋" ),
        array( "var" => "trackbacks",      "label" => "トラックバック" ),
        array( "var" => "custom-fields",   "label" => "カスタムフィールド" ),
        array( "var" => "comments",        "label" => "コメント" ),
        array( "var" => "revisions",       "label" => "リビジョン" ),
        array( "var" => "page-attributes", "label" => "属性" )
    );


    /**
     * taxonomies options
     *
     * @access protected
     * @var    Array
     */
    protected $_taxonomies = array(
        array( "var" => "category", "label" => "カテゴリー" ),
        array( "var" => "tag",      "label" => "タグ" ),
    );

    /**
     * menu positions
     *
     * @access protected
     * @var    Array
     */
    protected $_menu_positions = array(
        array( "var" => 5, "label" => "投稿の下" ),
        array( "var" => 10, "label" => "メディアの下" ),
        array( "var" => 15, "label" => "リンクの下" ),
        array( "var" => 20, "label" => "ページの下" ),
        array( "var" => 25, "label" => "コメントの下" ),
        array( "var" => 60, "label" => "最初の区切りの下" ),
        array( "var" => 65, "label" => "プラグインの下" ),
        array( "var" => 70, "label" => "ユーザーの下" ),
        array( "var" => 75, "label" => "ツールの下" ),
        array( "var" => 80, "label" => "設定の下" ),
        array( "var" => 100, "label" => "2番目の区切りの下" ),
    );


    /**
     * can export support.
     *
     * @access protected
     * @var    Array
     */
    protected $_can_export = array(
        array( "var" => "1", "label" => "はい" ),
        array( "var" => "0", "label" => "いいえ" ),
    );


    /**
     * post type default values
     *
     * @access protected
     * @var    Array
     */
    protected $_defaults = array(
        "post_type" => null,
        "label"     => null,
        "labels"    => array(
            "name"          => null,
            "singular_name" => "単一記事",
            "add_new"       => "新規追加",
            "add_new_item"  => "新規追加",
            "edit_item"     => "編集",
            "new_item"      => "新規追加",
            "view_item"     => "表示",
            "search_items"  => "検索",
            "not_found"     => "見つかりませんでした",
            "not_found_in_trash" => "ゴミ箱で見つかりませんでした",
            "parent_item_colon"  => "Panret: ",
        ),
        "description" => null,
        "public"    => 1,
        "publicly_queryable" => 1,
        "exclude_form_search" => 0,
        "show_ui"   => 1,
        "capability_type" => "post",
        "hierarchical" => 0,
        "supports"    => array( "title", "editor", "page-attributes" ),
        "register_meta_box_cb" => false,
        "taxonomies" => array(),
        "menu_position" => 25,
        "can_export"    => 1,
    );


    /**
     * initialize theme plugin
     *
     * @access public
     */
    public function init()
    {
    }


    /**
     * registerd post types register.
     *
     * @access public
     */
    public function register_post_types()
    {
        $types = get_option("uf_posttypes", array());
        foreach($types as $type) {
            $post_type = $type["post_type"];
            if(empty($post_type)) { continue; } 

            unset($type["post_type"]);
            if(!is_callable($type["register_meta_box_cb"]))
                $type["register_meta_box_cb"] = null;

            $type["public"] = $type["public"] == 1 ? true: false;
            $type["publicly_queryable"] = $type["publicly_queryable"] == 1 ? true: false;
            $type["exclude_form_search"] = $type["exclude_form_search"] == 1 ? true: false;
            $type["show_ui"] = $type["show_ui"] == 1 ? true: (
                $type["public"] == true ? true: false
            );
            $type["hierarchical"] = $type["hieralchical"] == 1 ? true: false;
            $type["menu_position"] = (int)$type["menu_position"];
            $type["can_export"] = $type["can_export"] == 1 ? true: false;


            register_post_type($post_type, $type);
        }
    }


    /**
     * save post type
     *
     * @access protected
     */
    public function save_post_type()
    {
        if(!$_GET["page"] || $_GET["page"] !== "uf-posttype-add") return;

        if(empty($_POST)) return;

        if(!wp_verify_nonce($_POST["_wpnonce"])) return;

        if(!$_POST["post_type"])
            return wp_die("投稿タイプ名を入力してください。");

        if(strlen($_POST["post_type"]) > 20)
            return wp_die("投稿タイプは英数字で20字以内にしてください。");

        $posttype = array(
            "post_type" => $_POST["post_type"],
            "label"     => $_POST["label"],
            "labels"    => $_POST["labels"],
            "description" => $_POST["description"],
            "public"    => $_POST["public"],
            "publicly_queryable" => $_POST["publicly_queryable"],
            "exclude_form_search" => $_POST["exclude_form_search"],
            "show_ui"   => $_POST["show_ui"],
            "capability_type" => $_POST["capability_type"],
            "hierarchical" => $_POST["hierarchical"],
            "supports"    => $_POST["supports"],
            "register_meta_box_cb" => $_POST["register_meta_box_cb"],
            "taxonomies" => $_POST["taxonomies"],
            "menu_position" => $_POST["menu_position"],
            "can_export"    => $_POST["can_export"],
        );


        $posttype = wp_parse_args($posttype, $this->_defaults);
        $posttype = array_filter($posttype, "esc_attr");
        $posttypes = get_option("uf_posttypes", array());

        if($_GET["id"]) {
            $posttypes[$_GET["id"]] = $posttype;
        }
        else {
            array_push($posttypes, $posttype);
        }

        if(update_option("uf_posttypes", $posttypes)) {
            $url = admin_url("themes.php?page=uf-posttype&message=1");
            wp_redirect($url);
            exit;
        }
    }


    /**
     * delete registerd post type
     *
     * @access public
     * @return Void
     */
    public function delete_post_type()
    {
        if($_GET["action"] !== "delete") return;

        if(!isset($_GET["id"])) return;

        if(!wp_verify_nonce($_GET["_wpnonce"])) return;

        $id = $_GET["id"];
        $posttypes = get_option("uf_posttypes");

        if(!isset($posttypes[$id])) return;

        unset($posttypes[$id]);
        if(update_option("uf_posttypes", $posttypes)) {
            $url = admin_url("themes.php?page=uf-posttype&message=2");
            wp_redirect($url);
            exit;
        }
    }


    /**
     * shown admin notice
     *
     * @access public
     */
    public function notices()
    {
        if($_GET["page"] != "uf-posttype") return;

        $html = "";
        switch($_GET["message"]) {
            case 1:
                $html = '<div class="success fade updated">'.
                        '<p>投稿タイプを保存しました。</p>'.
                        '</div>';
            break;
            case 2:
                $html = '<div class="success fade updated">'.
                        '<p>投稿タイプを削除しました。</p>'.
                        '</div>';
            break;
        }

        echo $html;
    }


    /**
     * hook by admin_menu
     */
    public function admin_menu()
    {
        add_theme_page("投稿タイプ", "投稿タイプ", 10, "uf-posttype", array( $this, "list_posttype" ));
        add_theme_page("投稿タイプの追加", "投稿タイプの追加", 10, "uf-posttype-add", array( $this, "manage_posttype" ));
    }


    /**
     * display post types
     *
     */
    public function list_posttype()
    {
        $posttypes = get_option("uf_posttypes", array());
        $url = admin_url("themes.php");
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿タイプの設定</h2>
<p>カスタム投稿タイプの設定を行います。</p>

<?php if(!empty($posttypes)): ?>

<table border="0" cellpadding="0" cellspacing="0" class="widefat">
<thead>
<tr>
<th>投稿タイプ名</th>
<th>説明</th>
<th>パブリック</th>
<th>サポート</th>
<th>エクスポートの可否</th>
</tr>
</thead>
<tfoot>
<tr>
<th>投稿タイプ名</th>
<th>説明</th>
<th>パブリック</th>
<th>サポート</th>
<th>エクスポートの可否</th>
</tr>
</tfoot>

<?php foreach($posttypes as $key => $type): ?>
<tr>
<td><?php echo $type["post_type"]; ?>
<div class="row-actions">
<span class="edit"><a href="<?php
    echo $url;
?>?page=uf-posttype-add&id=<?php
    echo $key;
?>">編集</a></span> |
<span class="trash"><a href="<?php
    echo $url;
?>?page=uf-posttype&action=delete&id=<?php
    echo $key;
?>&_wpnonce=<?php
    echo wp_create_nonce();
?>" onclick="javascript: return confirm('投稿名: <?php
    echo $type["post_type"];
?>を削除します。');">削除</a></span>
</div></td>
<td><?php echo $type["description"]; ?></td>
<td><?php echo $type["public"] == 1 ? 'はい': "いいえ"; ?></td>
<td><?php echo implode(", ", $type["supports"]); ?></td>
<td><?php echo $type["can_export"] == 1 ? 'はい': "いいえ"; ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php else:
$url = admin_url("themes.php?page=uf-posttype-add");
?>
<p>追加した投稿タイプはありません。</p>
<p>新しく投稿タイプを追加するには<a href="<?php echo $url; ?>">投稿タイプの追加</a>から行えます。</p>
<?php endif; ?>
</div>
<?php
    }


    /**
     * manage posttypes
     */
    public function manage_posttype()
    {
        $id = $_GET["id"];
        $posttype = array();
        if(isset($id) && is_numeric($id)) {
            $posttypes = get_option("uf_posttypes");
            $posttype = $posttypes[$id];
            if(!$posttype) {
                $posttype = array();
            }
        }

        $posttype = wp_parse_args($posttype, $this->_defaults);
        extract($posttype);
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿タイプの<?php
    echo (!empty($id) ? "編集": "追加");
?></h2>

<form action="" method="post">
<?php echo wp_nonce_field(); ?>
<?php if(isset($id)): ?>
<input type="hidden" name="id" value="<?php echo (int)$id; ?>" />
<?php endif; ?>
<div class="metabox-holder">
<div class="postbox-container" style="width: 49%;">
<div class="meta-box-sortables ui-sortable">
<?php
    $this->render_text_fields("投稿タイプ名", array(array(
        "name" => "post_type",
        "var"  => $post_type,
        "label" => "投稿タイプ",
        "description" => "英数字20文字以下で構成してください"
    )));
?>

<?php
    $this->render_text_fields("ラベル", array(array(
        "name" => "label",
        "var"  => $label,
        "label" => "ラベル",
        "description" => "投稿タイプの複数形の名前を入力してください"
    )));
?>


<?php
    $field_labels = $this->_labels;
    foreach($labels as $name => $label) {
        if(isset($field_labels[$name])) {
            $field_labels[$name]["var"] = $label;
        }
    }
    $this->render_text_fields("ラベルの設定", $field_labels, "labels");
?>


<?php
    $this->render_text_fields("説明", array(array(
        "name" => "description",
        "var"  => $description,
        "label" => "投稿タイプの説明",
    )));
?>
<!-- End meta box sortables --></div>
<!-- End postbox container --></div>


<div class="postbox-container" style="width: 49%;">
<div class="meta-box-sortables ui-sortable">
<?php
    $this->render_radio_fields(
        "パブリック", $this->_public, "public", $public,
        "ユーザーインターフェースの表示/非表示"
    );
?>

<?php
    $this->render_radio_fields(
        "query_postsの実行権", $this->_query_posts, "publicly_queryable",
        $publicly_queryable, "フロントエンドでpost_typeのクエリの発行可否"
    );
?>


<?php
    $this->render_radio_fields(
        "検索結果の指定", $this->_exclude_form_search, "exclude_form_search",
        $exclude_form_search,
        "この投稿タイプを検索結果から除外するかを指定します"
    );
?>

<?php
    $this->render_radio_fields(
        "UIの表示", $this->_show_ui, "show_ui",
        $show_ui, "この投稿タイプを管理画面で表示/非表示の設定"
    );
?>

<?php
    $this->render_radio_fields(
        "投稿タイプのチェック", $this->_capability_type, "capability_type",
        $capability_type,
        "投稿タイプの閲覧・編集・削除権限をチェックするのに使用します"
    );
?>


<?php
    $this->render_radio_fields(
        "投稿タイプの階層", $this->_hierarchical, "hierarchical",
        $hierarchical, "投稿タイプの階層化可否"
    );
?>

<?php
    $this->render_checkbox_fields(
        "サポート", $this->_supports, "supports",
        $supports
    );
?>

<?php
    $this->render_text_fields("メタボックスの設定",array(array(
        "name" => "register_meta_box_cb",
        "var" => $register_meta_box_cb,
        "label" => "メタボックスコールバック",
        "description" => "メタボックスのコールバックを指定します。<br />".
                         '特に指する必要がない場合は空のままにしてください。'
    )));
?>

<?php
    $this->render_checkbox_fields(
        "タクソノミー", $this->_taxonomies, "taxonomies", $taxonomies
    );
?>

<?php
    $this->render_select_fields(
        "メニュー位置", $this->_menu_positions, "menu_position",
        $menu_position, "メニューの表示位置"
    );
?>

<?php
    $this->render_radio_fields(
        "エクスポートの可否", $this->_can_export, "can_export",
        $can_export, "この投稿タイプもエクスポートにふくませるか"
    );
?>
<!-- End meta box sortables --></div>
<!-- End postbox container --></div>
<!-- End metabox holder --></div>

<p style="clear: both;">
<input type="submit" name="uf_posttype_save" value="保 存" class="button-primary" />
</p>

</form>

</div>
<?php
    }
}


$uf_posttype = new UF_Posttype();
add_action("init", array($uf_posttype, "init"));
add_action("init", array($uf_posttype, "register_post_types"));
add_action("admin_init", array($uf_posttype, "save_post_type"));
add_action("admin_init", array($uf_posttype, "delete_post_type"));
add_action("admin_notices", array($uf_posttype, "notices"));
add_action("admin_menu", array($uf_posttype, "admin_menu"));

