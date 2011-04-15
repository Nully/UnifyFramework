<?php
/**
 * class-widget.php
 */
class UF_Widget extends UF_Plugin
{
    /**
     * register or update widget data.
     *
     * @access public
     */
    public function save_widget()
    {
        if(!$_POST["add_widget"]) return;

        if(!wp_verify_nonce($_POST["_wpnonce"])) return;

        $widgets = get_option("uf_widgets", array());
        $widget_count = count($widgets) + 1;

        $widget = array(
            "name" => $_POST["name"],
            "id"   => $_POST["id"],
            "description" => $_POST["description"],
            "widget_tag" => $_POST["widget_tag"],
            "widget_class" => $_POST["widget_class"],
            "title_tag" => $_POST["title_tag"],
            "title_class" => $_POST["title_class"]
        );

        if(!$widget["name"])
            $widget["name"] = "Sidebar ". $widget_count;

        if(!$widget["id"])
            $widget["id"] = 'Sidebar-%id%';

        if(!$widget["widget_tag"])
            $widget["widget_tag"] = "li";

        if(!$widget["widget_class"])
            $widget["widget_class"] = "uf-widget";

        if(!$widget["title_tag"])
            $widget["title_tag"] = "h2";

        if(!$widget["title_class"])
            $widget["title_class"] = "widgettitle";

        array_filter($widget, "esc_attr");


        $id = $_POST["id"];
        if(!empty($id)) {
            $widgets[$id] = $widget;
        }
        else {
            array_push($widgets, $widget);
        }

        if(update_option("uf_widgets", $widgets)) {
            $message = 1;
        }
        else {
            $message = 2;
        }

        $url = admin_url("themes.php?page=uf-widget&message={$message}");
        wp_redirect($url);
    }


    /**
     * remove registerd widget
     *
     * @access public
     */
    public function delete_widget()
    {
        if($_GET["page"] != "uf-widget") return;

        if($_GET["action"] != "delete") return;

        if(!wp_verify_nonce($_GET["_wpnonce"])) return;


        $id = $_GET["id"];
        if($id === null) return;

        $widgets = get_option("uf_widgets", array());
        if(empty($widgets)) return;

        if(!isset($widgets[$id])) return;

        unset($widgets[$id]);

        if(update_option("uf_widgets", $widgets)) {
            $message = 2;
        }
        else {
            $message = 99;
        }

        $url = admin_url("themes.php?page=uf-widget&message={$message}");
        wp_redirect($url);
    }


    /**
     * init widgets
     *
     * @access public
     */
    public function init_widgets()
    {
        $widgets = get_option("uf_widgets", array());
        foreach($widgets as $widget) {
            $widget_param = $this->_format_widget_param($widget);
            // var_dump($widget_param);
            register_sidebar($widget_param);
        }
    }
    protected function _format_widget_param($widget)
    {
        $widget["id"] = str_replace("%id%", '$i', $widget["id"]);
        $widget["description"] = str_replace(
            "%id%", '$i', $widget["description"]
        );

        $before_widget = '<'. $widget["widget_tag"]. str_replace(
            "%widget_class%", $widget["widget_class"],
            ' id="%1$s" class="widget %2$s %widget_class%">'
        );
        $after_widget = '</'. $widget["widget_tag"] .'>';

        $before_title = str_replace(
            "%widget_class%", $widget["title_class"],
            sprintf(
                '<%1$s class="%%widget_class%%">', $widget["title_tag"]
            )
        );
        $after_title = '<'. $widget["title_tag"] .'>';

        $widget_param = array(
            "name" => $widget["name"],
            "id"   => $widget["id"],
            "description" => $widget["description"],
            "before_widget" => $before_widget,
            "after_widget"  => $after_widget,
            "before_title" => $before_title,
            "after_title" => $after_title,
        );

        return $widget_param;
    }


    /**
     * display admin notice
     *
     * @access public
     */
    public function admin_notices()
    {
        if($_GET["page"] != "uf-widget") return;

        $html = "";
        switch($_GET["message"]) {
            case 1:
                $html .= '<div class="updated success fade">'.
                         '<p>ウィジェットを保存しました。</p>'.
                         '</div>';
                break;
            case 2:
                $html .= '<div class="updated success fade">'.
                         '<p>ウィジェットを削除しました。</p>'.
                         '</div>';
                break;
            case 99:
                $html .= '<div class="error">'.
                         '<p>ウィジェットの更新に失敗しました。</p>'.
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
        $widgets = get_option("uf_widgets", array());
?>
<div class="wrap">
<?php screen_icon(); ?><h2>ウィジェット管理</h2>

<?php if(!empty($widgets)): ?>
<table border="0" cellpadding="0" cellspacing="0" class="widefat">
<thead>
<tr>
    <th>ウィジェット名</th>
    <th>説明</th>
    <th>ウィジェットタグ</th>
    <th>ウィジェットクラス</th>
    <th>タイトルタグ</th>
    <th>タイトルクラス</th>
</tr>
</thead>
<tfoot>
<tr>
    <th>ウィジェット名</th>
    <th>説明</th>
    <th>ウィジェットタグ</th>
    <th>ウィジェットクラス</th>
    <th>タイトルタグ</th>
    <th>タイトルクラス</th>
</tr>
</tfoot>
<?php foreach($widgets as $id => $widget): ?>
<tbody>
<tr>
<td><?php echo $widget["name"]; ?><br />
<?php echo $widget["id"]; ?>
<div class="row-actions">
<span class="edit"><a href="<?php
    echo $url;
?>?page=uf-widget-add&id=<?php
    echo $id;
?>">編集</a></span> |
<span class="trash"><a href="<?php
    echo $url;
?>?page=uf-widget&action=delete&id=<?php
    echo $id;
?>&_wpnonce=<?php
    echo wp_create_nonce();
?>" onclick="javascript: return confirm('ウィジェットID: <?php
    echo $widget["name"];
?>を削除します。');">削除</a></span>
</div></td>
<td><?php echo $widget["description"]; ?></td>
<td><?php echo $widget["widget_tag"]; ?></td>
<td><?php echo $widget["widget_class"]; ?></td>
<td><?php echo $widget["title_tag"]; ?></td>
<td><?php echo $widget["title_class"]; ?></td>
</tr>
</tbody>
<?php endforeach; ?>

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
<form action="" method="post">
<?php echo wp_nonce_field(); ?>

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
        "widget_tag" => array(
            "label" => "利用タグ",
            "var" => $widget_tag,
            "name" => "widget_tag",
            "description" => "ウィジェットを囲うタグを入力します。<br />".
                             "未記入の場合はliタグが利用されます。"
        ),
        "widget_class" => array(
            "label" => "追加クラス",
            "var" => $widget_class,
            "name" => "widget_class",
            "description" => "ウィジェットに追加するクラスを半角スペース区切り".
                             "で入力します。"
        )
    );

    $this->render_text_fields("ウィジェット枠の設定", $fields);
?>


<?php
    $fields = array(
        "title_tag" => array(
            "label" => "利用タグ",
            "var"   => $title_tag,
            "name" => "title_tag",
            "description" => "ウィジェットタイトルを囲むタグを入力します。".
                             "<br />".
                             "未記入の場合はh2タグを利用します。",
        ),
        "title_class" => array(
            "label" => "追加クラス",
            "var"   => $title_class,
            "name"  => "title_class",
            "description" => "ウィジェットタイトルに".
                             "追加するクラスを入力します。<br />".
                             "未入力の場合はwidgettitleを利用します。",
        )
    );
    $this->render_text_fields("ウィジェットタイトルの設定", $fields);
?>
<!-- End meta box sortable --></div>
<!-- End postbox container --></div>
<!-- End metabox holder --></div>
<p>
<input type="submit" name="add_widget" value="保 存" class="button-primary" />
</p>
</form>

</div>
<?php
    }
}

$uf_widget = new UF_Widget();
add_action("admin_init", array($uf_widget, "save_widget"));
add_action("admin_init", array($uf_widget, "init_widgets"));
add_action("admin_init", array($uf_widget, "delete_widget"));
add_action("admin_notices", array($uf_widget, "admin_notices"));
add_action("admin_menu", array($uf_widget, "admin_menu"));
