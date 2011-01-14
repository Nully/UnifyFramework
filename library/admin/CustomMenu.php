<?php
/**
 * unifyFramework theme admin CustomMenu.
 * 
 */

/**
 * register admin notice for Custom Menu
 * 
 * @return Void
 * @action admin_init
 */
add_action("admin_init", "uf_admin_custom_menu_init");
function uf_admin_custom_menu_init() {
    if($_GET["custom_menu_success"])
        add_action("admin_notices", "uf_admin_notice_update");
    elseif($_GET["custom_menu_error"])
        add_action("admin_notices", "uf_admin_notice_error");
}


/**
 * register new custom menu location
 * 
 * @return Void
 * @action admin_init
 */
add_action("admin_init", "uf_admin_custom_menu_save");
function uf_admin_custom_menu_save() {
    global $plugin_page;

    if(!isset($_POST["register_custom_menu"]))
        return;

    $menus = get_option("uf_custom_menus", array());
    if(empty($menus))
        $max = 1;
    else
        $max = max(array_keys($menus)) + 1;

    $menu = $_POST["custom_menu"];
    $menu["location"] = $menu["location"] ? $menu["location"]: "theme location {$max}";
    $menu["description"] = $menu["description"] ? $menu["description"]: "for theme location {$max}";
    $menus[] = $menu;

    if(update_option("uf_custom_menus", $menus))
        $state = "success";
    else
        $state = "error";

    $uri = admin_url("admin.php?page={$plugin_page}&custom_menu_{$state}=1");
    wp_redirect($uri);
    exit;
}


/**
 * delete user original custom menu location
 * 
 * @return Void
 * @action admin_init
 */
add_action("admin_init", "uf_admin_custom_menu_delete");
function uf_admin_custom_menu_delete() {
    global $plugin_page;

    if(!isset($_GET["id"]) || !isset($_GET["uf_custom_menu_delete"]))
        return;

    $id = $_GET["id"];
    $menus = get_option("uf_custom_menus", array());
    if(!isset($menus[$id])) {
        $state = "error";
    }
    else {
        unset($menus[$id]);
        if(update_option("uf_custom_menus", $menus))
            $state = "success";
        else
            $state = "error";
    }

    $uri = admin_url("admin.php?page={$plugin_page}&custom_menu_{$state}=1");
    wp_redirect($uri);
    exit;
}


/**
 * display UnifyFramework Custom Menu admin page
 * 
 * @return Void
 */
function uf_admin_custom_menu_admin() {
    global $plugin_page;
    $menus = get_option("uf_custom_menus", array());
?>
<div class="wrap">
<?php screen_icon("themes"); ?>
<h2><?php _e("Custom Menu"); ?></h2>
<p><?php _e("register custom menus.", UF_TEXTDOMAIN); ?></p>

<form action="" method="post">
<div class="metabox-holder">
<div class="postbox">
    <h3 class="hndle"><?php _e("Register custom menu.", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <dl>
            <dt><?php _e("Custom Menu theme location", UF_TEXTDOMAIN); ?></dt>
            <dd><input type="text" name="custom_menu[location]" value="" /></dd>
            <dt><?php _e("Custom Menu description.", UF_TEXTDOMAIN); ?></dt>
            <dd><input type="text" name="custom_menu[description]" value="" class="widefat" /></dd>
        </dl>
        <p><input type="submit" id="" name="register_custom_menu" value="<?php _e("Register Custom Menu", UF_TEXTDOMAIN); ?>" class="button-primary" /></p>
    <!-- End inside --></div>
<!-- End postbox --></div>
<!-- End metabox-holder --></div>
</form>

<?php if(empty($menus)): ?>
<p><?php _e("Not registerd custom menu locations.", UF_TEXTDOMAIN); ?></p>
<?php else: ?>
<table class="widefat">
    <thead><tr>
        <th><?php _e("Theme Location", UF_TEXTDOMAIN); ?></th>
        <th><?php _e("Location Description", UF_TEXTDOMAIN); ?></th>
    </tr></thead>
    <tfoot><tr>
        <th><?php _e("Theme Location", UF_TEXTDOMAIN); ?></th>
        <th><?php _e("Location Description", UF_TEXTDOMAIN); ?></th>
    </tr></tfoot>
    <tbody>
        <tr>
        <?php foreach($menus as $id => $menu): ?>
            <td><?php echo esc_attr($menu["location"]); ?><br />
                <a href="<?php echo wp_nonce_url(admin_url("admin.php?page={$plugin_page}&id={$id}&uf_custom_menu_delete=1")) ?>"><?php _e("Delete"); ?></a></td>
            <td><?php echo esc_attr($menu["description"]); ?></td>
        <?php endforeach; ?>
        </tr>
    </tbody>
</table>
<?php endif; ?>
<!-- End wrap --></div>
<?php
}

