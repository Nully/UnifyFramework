<?php
/**
 * UnifyFramework theme admin Widgets scripts
 * 
 */

/**
 * UnifyFramework widget register notice
 * 
 * @return Void
 * @action admin_init
 */
add_action("admin_init", "uf_admin_widgets_init");
function uf_admin_widgets_init() {
    if($_GET["widget_success"] == 1)
        add_action("admin_notices", "uf_admin_notice_update");
    elseif($_GET["widget_error"] == 1)
        add_action("admin_notices", "uf_admin_notice_error");
}


/**
 * save User original widget item
 * 
 * @return Void
 * @action admin_init
 */
add_action("admin_init", "uf_admin_widgets_save_widget");
function uf_admin_widgets_save_widget() {
    global $plugin_page;

    if(!isset($_POST["save_widget_item"]))
        return;

    $widgets = get_option("uf_widgets", array());
    if(empty($widgets))
        $max = 1;
    else
        $max = max(array_keys($widgets)) + 1;

    $widget = $_POST["widget"];
    $widget["name"] ? $widget["name"] : "sidebar-{$max}";
    $widget["description"] ? $widget["description"]: "for ". $widget["name"];

    $widgets[] = $widget;
    if(update_option("uf_widgets", $widgets))
        $state = "success";
    else
        $state = "error";

    $uri = admin_url("admin.php?page={$plugin_page}&widget_{$state}=1");

    wp_redirect($uri);
    exit;
}


/**
 * delete user original widget item(s)
 * 
 * @return Void
 * @action admin_init
 */
add_action("admin_init", "uf_admin_widget_delete_widget");
function uf_admin_widget_delete_widget() {
    global $plugin_page;

    if(!isset($_GET["id"]))
        return;

    $id = $_GET["id"];
    $widgets = get_option("uf_widgets", array());

    if(!isset($widgets[$id]))
        $state = "error";

    unset($widgets[$id]);

    if(update_option("uf_widgets", $widgets))
        $state = "success";
    else
        $state = "error";

    $uri = admin_url("admin.php?page={$plugin_page}&widget_{$state}=1");
    wp_redirect($uri);
    exit;
}


/**
 * display Widgets admin page
 * 
 * @return Void
 */
function uf_admin_widgets_admin() {
    global $plugin_page;
    $widgets = get_option("uf_widgets", array());
?>
<div class="wrap">
<?php screen_icon("themes"); ?>
<h2><?php _e("Widgets"); ?></h2>
<p><?php _e("UnifyFramework supported widget manager.", UF_TEXTDOMAIN); ?></p>
<form action="" method="post">
<?php wp_nonce_field(); ?>
<div class="metabox-holder">
<div class="uf-admin postbox">
    <h3 class="hndle"><?php _e("Register widget field.", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <dl>
            <dt><?php _e("Widget field name", UF_TEXTDOMAIN); ?></dt>
            <dd><input type="text" name="widget[name]" value="" /></dd>
            <dt><?php _e("Widget wrap tag", UF_TEXTDOMAIN); ?></dt>
            <dd><select name="widget[container_tag]">
                <option value="li">li</option>
                <option value="div" selected="selected">div</option>
            </select></dd>
            <dt><?php _e("Widget title tag", UF_TEXTDOMAIN); ?></dt>
            <dd><select name="widget[title_tag]">
                <option value="p">p</option>
                <option value="h2">h2</option>
                <option value="h3" selected="selected">h3</option>
                <option value="h4">h4</option>
                <option value="h5">h5</option>
                <option value="h6">h6</option>
            </select></dd>
            <dt><?php _e("Widget description", UF_TEXTDOMAIN); ?></dt>
            <dd><input type="text" name="widget[description]" value="" class="widefat" /></dd>
        </dl>
        <p><input type="submit" name="save_widget_item" value="<?php _e("Register widget", UF_TEXTDOMAIN); ?>" class="button-primary" /></p>
    <!-- End inside --></div>
<!-- End postbox --></div>
<!-- End metabox-holder --></div>
</form>

<?php if(empty($widgets)): ?>
<p><?php _e("Not registerd widgets", UF_TEXTDOMAIN); ?></p>
<?php else: ?>
<table class="widefat">
    <thead>
        <tr>
            <th><?php _e("Widget field name", UF_TEXTDOMAIN); ?></th>
            <th><?php _e("Widget wrap tag", UF_TEXTDOMAIN); ?></th>
            <th><?php _e("Widget title tag", UF_TEXTDOMAIN); ?></th>
            <th><?php _e("Widget description", UF_TEXTDOMAIN); ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th><?php _e("Widget field name", UF_TEXTDOMAIN); ?></th>
            <th><?php _e("Widget wrap tag", UF_TEXTDOMAIN); ?></th>
            <th><?php _e("Widget title tag", UF_TEXTDOMAIN); ?></th>
            <th><?php _e("Widget description", UF_TEXTDOMAIN); ?></th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($widgets as $id => $widget): ?>
        <tr>
            <td><?php echo esc_attr($widget["name"]); ?><br />
                <a href="<?php echo wp_nonce_url(admin_url("admin.php?page={$plugin_page}&id={$id}")); ?>"><?php _e("Delete"); ?></a></td>
            <td><?php echo esc_attr($widget["container_tag"]); ?></td>
            <td><?php echo esc_attr($widget["title_tag"]); ?></td>
            <td><?php echo esc_attr($widget["description"]); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<!-- End wrap --></div>
<?php
}

