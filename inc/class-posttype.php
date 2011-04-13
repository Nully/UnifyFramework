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
        array(
            "name" => "name",
            "label" => "投稿タイプ名",
            "description" => "投稿タイプの複数形のラベル"
        ),
        array(
            "name" => "singular_name",
            "label" => "単一記事名",
            "description" => "単一記事のラベル"
        ),
        array(
            "name" => "add_new",
            "label" => "新しく追加",
            "description" => "新しく追加するためのラベル"
        ),
        array(
            "name" => "add_new_item",
            "label" => "新規追加",
            "description" => "新規追加のラベル"
        ),
        array(
            "name" => "edit_item",
            "label" => "編集",
            "description" => "編集のためのラベル"
        ),
        array(
            "name" => "new_item",
            "label" => "新規追加",
            "description" => "新規追加のためのラベル"
        ),
        array(
            "name" => "view_item",
            "label" => "表示",
            "description" => "表示するためのラベル"
        ),
        array(
            "name" => "search_items",
            "label" => "検索",
            "description" => "検索の為のラベル"
        ),
        array(
            "name" => "not_found",
            "label" => "NotFound",
            "description" => "NotFoundのラベル"
        ),
        array(
            "name" => "not_found_in_trash",
            "label" => "NotFoundInTrash",
            "description" => "ゴミ箱のNotFoundのラベル"
        ),
        array(
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
        array( "pos" => 5, "label" => "投稿の下" ),
        array( "pos" => 10, "label" => "メディアの下" ),
        array( "pos" => 15, "label" => "リンクの下" ),
        array( "pos" => 20, "label" => "ページの下" ),
        array( "pos" => 25, "label" => "コメントの下" ),
        array( "pos" => 60, "label" => "最初の区切りの下" ),
        array( "pos" => 65, "label" => "プラグインの下" ),
        array( "pos" => 70, "label" => "ユーザーの下" ),
        array( "pos" => 75, "label" => "ツールの下" ),
        array( "pos" => 80, "label" => "設定の下" ),
        array( "pos" => 100, "label" => "2番目の区切りの下" ),
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
     * initialize theme plugin
     *
     * @access public
     */
    public function init()
    {
        #$this->loadPosttypes();
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
        $types = array();
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿タイプの設定</h2>
<p>カスタム投稿タイプの設定を行います。</p>

<?php if(!empty($types)): ?>

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
        $id = $_GET["posttype_id"];
?>
<div class="wrap">
<?php screen_icon(); ?><h2>投稿タイプの<?php
    echo (!empty($id) ? "編集": "追加");
?></h2>

<form action="" method="post">
<div class="metabox-holder">


<?php
    $this->render_text_fields("投稿タイプ名", array(array(
        "name" => "post_type",
        "var"  => null,
        "label" => "投稿タイプ",
        "description" => "英数字20文字以下で構成してください"
    )));
?>

<?php
    $this->render_text_fields("ラベル", array(array(
        "name" => "label",
        "var"  => null,
        "label" => "ラベル",
        "description" => "投稿タイプの複数形の名前を入力してください"
    )));
?>


<?php
    $this->render_text_fields("ラベルの設定", $this->_labels, "labels");
?>


<?php
    $this->render_text_fields("説明", array(array(
        "name" => "description",
        "var" => null,
        "label" => "投稿タイプの説明",
    )));
?>


<?php
    $this->render_radio_fields(
        "パブリック", $this->_public, "public", null,
        "ユーザーインターフェースの表示/非表示"
    );
?>


<?php
    $this->render_radio_fields(
        "query_postsの実行権", $this->_query_posts, "publicly_queryable",
        null, "フロントエンドでpost_typeのクエリの発行可否"
    );
?>


<?php
    $this->render_radio_fields(
        "検索結果の指定", $this->_exclude_form_search, "exclude_form_search",
        null, "この投稿タイプを検索結果から除外するかを指定します"
    );
?>


<?php
    $this->render_radio_fields(
        "UIの表示", $this->_show_ui, "show_ui",
        null, "この投稿タイプを管理画面で表示/非表示の設定"
    );
?>

<?php
    $this->render_radio_fields(
        "投稿タイプのチェック", $this->_capability_type, "capability_type",
        null, "投稿タイプの閲覧・編集・削除権限をチェックするのに使用します"
    );
?>


<?php
    $this->render_radio_fields(
        "投稿タイプの階層", $this->_hierarchical, "hierarchical",
        null, "投稿タイプの階層化可否"
    );
?>


<?php
    $this->render_checkbox_fields(
        "サポート", $this->_supports, "supports",
        array()
    );
?>

<?php
    $this->render_text_fields("メタボックスの設定",array(array(
        "name" => "register_meta_box_cb",
        "var" => null,
        "label" => "メタボックスコールバック",
        "description" => "メタボックスのコールバックを指定します。<br />".
                         '特に指する必要がない場合は空のままにしてください。'
    )));
?>


<?php
    $this->render_checkbox_fields(
        "タクソノミー", $this->_taxonomies, "taxonomies", array()
    );
?>


<p><label for="menu_position">メニュー位置</label>
<select id="menu_position" name="menu_position">
<?php foreach($this->_menu_positions as $pos): ?>
<option value="<?php echo $pos["pos"]; ?>"><?php
    echo $pos["label"];
?></option>
<?php endforeach; ?>
</select>
</p>


<?php
    $this->render_radio_fields(
        "エクスポートの可否", $this->_can_export, "can_export",
        null, "この投稿タイプもエクスポートにふくませるか"
    );
?>

<!-- End metabox holder --></div>

<p><input type="submit" value="保 存" class="button-primary" /></p>

</form>

</div>
<?php
    }
}


$uf_posttype = new UF_Posttype();
add_action("init", array($uf_posttype, "init"));
add_action("admin_menu", array($uf_posttype, "admin_menu"));

