<?php
/**
 * UnifyFramework CustomPost support
 * 
 */
global $uf_custom_post_supports;
$uf_custom_post_supports = array(
    'Title', 'Editor', 'Excerpt', 'Author', 'Comments',
    'Custom Fields', 'Revisions', 'Thumbnail', 'Page Attributes'
);



/**
 * uf_cp_admin_head
 *
 * CustomPost admin panel header
 *
 * @access protected
 * @return Void
 */
function uf_cp_admin_head() {
    global $pagenow, $plugin_page;
    if($pagenow != "admin.php" && $plugin_page != "uf-cp-edit" && $plugin_page != "uf-cp-add")
        return;

    wp_enqueue_style("uf-admin", get_bloginfo("template_url"). "/css/admin.css");
}
add_action("init", "uf_cp_admin_head");



/**
 * uf_cp_register_menus
 *
 * CustomPost admin panel Submenu
 *
 * @access protected
 * @return Void
 */
function uf_cp_register_menus() {
    if(function_exists("add_submenu_page")) {
        add_submenu_page("uf-options", __("Add Custom Post", "unify_framework"), __("Add Custom Post", "unify_framework"), 10, "uf-cp-add", "uf_cp_options_register_panel");
        add_submenu_page("uf-options", __("Edit Custom Post", "unify_framework"), __("Edit Custom Post", "unify_framework"), 10, "uf-cp-edit", "uf_cp_options_edit_panel");

        uf_admin_add_page_nav(__("Add Custom Post", "unify_framework"), "uf-cp-add");
        uf_admin_add_page_nav(__("Edit Custom Post", "unify_framework"), "uf-cp-edit");
    }
}
add_action("admin_menu", "uf_cp_register_menus");



/**
 * uf_cp_options_hook
 *
 * CustomPost options (save|update|delete) action method
 *
 * @access protected
 * @return Void
 */
function uf_cp_options_hook() {
    global $pagenow, $plugin_page;

    $base_url = get_admin_url(null, "{$pagenow}?");
    if($_POST["save_custom_post"]) {
        $options = array(
            "custom_post_type_name" => $_POST["custom_post_type_name"],
            "labels"    => $_POST["labels"],
            "public"    => $_POST["public"],
            "exclude_from_search" => $_POST["exclude_from_search"],
            "show_ui"   => $_POST["show_ui"],
            "capability_type" => $_POST["capability_type"],
            "hierarchical"    => $_POST["hierarchical"],
            "supports"        => $_POST["supports"],
            "can_export"      => $_POST["can_export"],
            "show_in_nav_menus" => $_POST["show_in_nav_menus"],
        );

        if(!$options["custom_post_type_name"]) {
            add_action("admin_notic", "uf_cp_options_notices");
            return;
        }

        $options = apply_filters("uf_cp_options_filter", $options);
        if($_POST["id"]) {
            uf_update_custom_post_option($options, $_POST["id"]);
            $base_url .= "page=uf-cp-edit";
        }
        else {
            uf_update_custom_post_option($options);
            $base_url .= "page=uf-cp-add";
        }

        $base_url .= "&save=true";
        wp_redirect($base_url);
    }
}
add_action("init", "uf_cp_options_hook");



/**
 * uf_cp_options_notices
 *
 * display CustomPost admin notices
 *
 * @access protected
 * @return Void
 */
function uf_cp_options_notices() {
    if($_GET["save"]) {
        echo '<div class="updated fade">',
            "<p>". __("Success. CustomPost saved"). "</p>",
        "</div>";
    }
}
add_action("admin_notices", "uf_cp_options_notices");



/**
 * uf_cp_options_filter
 *
 * CustomPost options filter action hook
 * @access protected
 * @param  $options   Array
 * @return Array
 */
function uf_cp_options_filter($options) {
    $options = uf_parse_to_bool_deep($options);

    $options["labels"]["name"]          = empty($options["labels"]["name"]) ? $options["custom_post_type_name"]: $options["labels"]["name"];
    $options["labels"]["singular_name"] = empty($options["labels"]["singular_name"]) ? $options["custom_post_type_name"]: $options["labels"]["singular_name"];
    $options["labels"]["add_new"]       = empty($options["labels"]["add_new"]) ? "Add new ". $options["custom_post_type_name"]: $options["labels"]["add_new"];
    $options["labels"]["add_new_item"]  = empty($options["labels"]["add_new_item"]) ? "Add for ". $options["custom_post_type_name"]: $options["labels"]["add_new_item"];
    $options["labels"]["edit"]          = empty($options["labels"]["edit"]) ? "Edit ". $options["custom_post_type_name"]: $options["labels"]["edit"];
    $options["labels"]["edit_item"]     = empty($options["labels"]["edit_item"]) ? "Edit for ". $options["custom_post_type_name"]: $options["labels"]["edit_item"];
    $options["labels"]["new_item"]      = empty($options["labels"]["new_item"]) ? "New ". $options["custom_post_type_name"]: $options["labels"]["new_item"];
    $options["labels"]["view"]          = empty($options["labels"]["view"]) ? "View ". $options["custom_post_type_name"]: $options["labels"]["view"];
    $options["labels"]["view_item"]     = empty($options["labels"]["view_item"]) ? "View for ". $options["custom_post_type_name"]: $options["labels"]["view_item"];
    $options["labels"]["search_items"]  = empty($options["labels"]["search_items"]) ? "search ". $options["custom_post_type_name"]: $options["labels"]["search_items"];
    $options["labels"]["not_found"]     = empty($options["labels"]["not_found"]) ? "Not Found". $options["custom_post_type_name"]: $options["labels"]["not_found"];
    $options["labels"]["not_found_in_trush"] = empty($options["labels"]["not_found_in_trush"]) ? "Not Found in Trush". $options["labels"]["custom_post_type_name"]: $options["labels"]["not_found_in_trush"];
    $options["labels"]["parent"]        = empty($options["labels"]["parent"]) ? "parent to ". $options["labels"]["custom_post_type_name"]: $options["labels"]["parent"];

    $options["supports"] = empty($options["supports"]) ? array(): $options["supports"];

    $options["pubic"]               = empty($options["public"]) ? false: true;
    $options["exclude_form_search"] = empty($options["exclude_form_search"]) ? false: true;
    $options["show_ui"]           = empty($options["show_ui"]) ? false: true ;
    $options["hierarchical"]      = empty($options["hierarchical"]) ? false: true;
    $options["can_export"]        = empty($options["can_export"]) ? false: true;
    $options["show_in_nav_menus"] = empty($options["show_in_nav_menus"]) ? false: true;

    return $options;
}
add_filter("uf_cp_options_filter", "uf_cp_options_filter");



/**
 * uf_cp_options_register_panel
 *
 * display CustomPost register panel
 *
 * @access protected
 * @return Void
 */
function uf_cp_options_register_panel() {
    global $uf_custom_post_supports;
?>
<div class="wrap" id="uf_admin">
    <?php uf_admin_page_tab_nav(); ?>
    <p><?php _e("", "unify_framework"); ?></p>
    <h3><?php _e("Custom post type register field.", "unify_framework"); ?></h3>
    <form action="" method="post">
        <?php if($_GET["id"]): ?><input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" /><?php endif; ?>
        <?php wp_nonce_field(); ?>
        <?php uf_form_input("hidden", wp_create_nonce(), array( "name" => "uf_admin_nonce" )); ?>
        <dl>
            <dt><?php _e("Custom post type name", "unify_framework"); ?></dt>
            <dd><?php uf_form_input("text", $options["custom_post_type_name"], array(
                "id" => "uf_custom_posts_post_type_name", "name" => "custom_post_type_name", "label" => __("unique custom post name")
            )); ?></dd>

            <dt><?php _e("Description", "unify_framework"); ?></dt>
            <dd><textarea id="uf_custom_posts_description" name="description" cols="30" rows="10"></textarea><br />
                <?php uf_form_label(__("shorty custom post type description", "unify_framework")); ?></dd>

            <dt><?php _e("Labels", "unify_framework"); ?></dt>
            <dd><?php uf_form_input("text", $options["labels"]["name"], array( "id" => "uf_custom_posts_name", "name" => "labels[name]")); ?>
                <?php uf_form_label(__("custom post type unique name.", "unify_framework"), "uf_custom_posts_name") ?><br />

                <?php uf_form_input("text", $options["labels"]["singular_name"], array( "id" => "uf_custom_psots_singular_name", "name" => "labels[singular_name]",)); ?>
                <?php uf_form_label(__("singular name.", "unify_framework"), "uf_custom_psots_singular_name") ?><br />

                <?php uf_form_input("text", $options["labels"]["add_new"], array( "id" => "uf_custom_posts_add_new", "name" => "labels[add_new]" )); ?>
                <?php uf_form_label(__("add new label.", "unify_framework"), "uf_custom_posts_add_new"); ?><br />

                <?php uf_form_input("text", $options["labels"]["add_new_item"], array( "id" => "uf_custom_posts_add_new_item", "name" => "labels[add_new_item]")); ?>
                <?php uf_form_label(__("add new item label.", "unify_framework"), "uf_custom_posts_add_new_item"); ?><br />

                <?php uf_form_input("text", $options["labels"]["edit"], array( "id" => "uf_custom_posts_edit", "name" => "labels[edit]" )); ?>
                <?php uf_form_label(__("edit label.", "unify_framework"), "uf_custom_posts_edit") ?><br />

                <?php uf_form_input("text", $options["labels"]["edit_item"], array( "id" => "uf_custom_posts_edit_item", "name" => "labels[edit_item]" )); ?>
                <?php uf_form_label(__("edit item label.", "unify_framework"), "uf_custom_posts_edit_item"); ?><br />

                <?php uf_form_input("text", $options["labels"]["new_item"], array( "id" => "uf_custom_posts_new_item", "name" => "labels[new_item]" )); ?>
                <?php uf_form_label(__("new item label.", "unify_framework"), "uf_custom_posts_new_item") ?><br />

                <?php uf_form_input("text", $options["labels"]["view"], array( "id" => "uf_custom_posts_view", "name" => "labels[view]" )); ?>
                <?php uf_form_label(__("view label.", "unify_framework"), "uf_custom_posts_view"); ?><br />

                <?php uf_form_input("text", $options["labels"]["view_item"], array( "id" => "uf_custom_posts_view_item", "name" => "labels[view_item]" )); ?>
                <?php uf_form_label(__("view item label.", "unify_framework"), "uf_custom_posts_view_item") ?><br />

                <?php uf_form_input("text", $options["labels"]["search_items"], array( "id" => "uf_custom_posts_search_item", "name" => "labels[search_items]" )); ?>
                <?php uf_form_label(__("search items label.", "unify_framework"), "uf_custom_posts_search_items"); ?><br />

                <?php uf_form_input("text", $options["labels"]["not_found"], array( "id" => "uf_custom_posts_not_found", "name" => "labels[not_found]" )); ?>
                <?php uf_form_label(__("not found label.", "unify_framework"), "uf_custom_posts_not_found"); ?><br />

                <?php uf_form_input("text", $options["labels"]["not_found_in_trush"], array( "id" => "uf_custom_posts_not_found_in_trush", "name" => "labels[not_found_in_trash]" )); ?>
                <?php uf_form_label(__("not found in trush label.", "unify_framework"), "uf_custom_posts_not_found_in_trash"); ?><br />

                <?php uf_form_input("text", $options["labels"]["parent"], array( "id" => "uf_custom_posts_parent", "name" => "labels[parent]" )); ?>
                <?php uf_form_label(__("parent label.", "unify_framework"), "uf_custom_posts_parent") ?></dd>

            <dt><?php _e("Public", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array( "id" => "uf_custom_posts_public", "name" => "public", "checked" => $options["public"] )); ?>
                <?php uf_form_label(__("shown admin UI.", "unify_framework"), "uf_custom_posts_public") ?></dd>

            <dt><?php _e("Search form", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array( "id" => "uf_custom_posts_exclude_form_search", "name" => "exclude_from_search", "checked" => $options["public"] )); ?>
                <?php uf_form_label(__("exclude custom post type in search form.", "unify_framework"), "uf_custom_posts_exclude_form_search"); ?></dd>

            <dt><?php _e("Show UI", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array( "id" => "uf_custom_posts_show_ui", "name" => "show_ui", "checked" => $options["show_ui"] )); ?>
                <?php uf_form_label(__("Whether to generate a default UI for managing this post type.", "unify_framework"), "uf_custom_posts_show_ui"); ?></dd>

            <dt><?php _e("Capability Type", "unify_framework"); ?></dt>
            <dd><?php uf_form_select(array( "page" => __("Page"), "post" => __("Post")), array(
                "id" => "uf_custom_posts_capability_type", "name" => "capability_type", "label" => __("The post type to use for checking read, edit, and delete capabilities.", "unify_framework"),
                "value" => ""
            )); ?></dd>

            <dt><?php _e("Hierarchical", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array( "id" => "uf_custom_posts_herarchical", "name" => "hierarchical", "checked" => $options["hierarchical"] )); ?>
                <?php uf_form_label(__("this post type have a hieralchical."), "uf_custom_posts_herarchical") ?></dd>

            <dt><?php _e("Supports", "unify_framework"); ?></dt>
            <dd>
                <?php uf_form_input("hidden", "", array( "name" => "supports" )); ?>
                <?php foreach($uf_custom_post_supports as $field): ?>
                    <?php uf_form_checkbox($field, array(
                        "id" => "uf_custom_posts_supports_". strtolower($field), "name" => "supports[]",
                        "label" => __($field), "show_hidden" => false, "checked" => !!in_array($field, empty($options["supports"]) ? array(): $options["supports"])
                    )); ?>
                <?php endforeach; ?>
            </dd>

            <dt><?php _e("Export", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array( "id" => "uf_custom_posts_can_export", "name" => "can_export", "checked" => $options["can_export"])); ?>
                <?php uf_form_label(__("this post type including WPExport ?", "unify_framework"), "uf_custom_posts_can_export"); ?></dd>

            <dt><?php _e("Nav Menus", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array( "id" => "uf_custom_posts_show_in_nav_menus", "name" => "show_in_nav_menus", "checked" => $options["show_in_nav_menus"])); ?>
                <?php uf_form_label(__("this custom post type including custom nav menus ?"), "uf_custom_posts_show_in_nav_menus"); ?></dd>
        </dl>
        <p><input type="submit" name="save_custom_post" value="<?php _e("Save as custom post"); ?>" class="button-primary" /></p>
    </form>
<!-- End wrap --></div>
<?php
}



/**
 * uf_cp_options_edit_panel
 *
 * display CustomPost eidt panel
 *
 * @access protected
 * @return Void
 */
function uf_cp_options_edit_panel() {
    if($_GET["delete"] && $_GET["id"]) {
        if(uf_delete_custom_post($_GET["id"])) {
            echo '<div class="updated fade">',
                "<p>". __("Delete. remove selected CustomPost", "unify_framework"). "</p>",
            "</div>";
        }
    }

    $options = uf_get_custom_post_options();
?>
<div class="wrap" id="uf_admin">
    <?php uf_admin_page_tab_nav(); ?>
    <p><?php _e("Edit custom post.", "unify_framework"); ?></p>
    <table border="0" cellpadding="0" cellspacing="0" class="widefat">
        <thead>
            <tr>
                <th><?php _e("ID", "unify_framework"); ?></th>
                <th><?php _e("CustomPost type name", "unify_framework"); ?></th>
                <th><?php _e("Public", "unify_framework"); ?></th>
                <th><?php _e("Exclude SearchForm", "unify_framework"); ?></th>
                <th><?php _e("Capability Type", "unify_framework"); ?></th>
                <th><?php _e("Hierarchical", "unify_framework"); ?></th>
                <th><?php _e("Supports", "unify_framework"); ?></th>
                <th><?php _e("Can Exports", "unify_framework"); ?></th>
                <th><?php _e("Show in Nav Menus", "unify_framework"); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e("ID", "unify_framework"); ?></th>
                <th><?php _e("CustomPost type name", "unify_framework"); ?></th>
                <th><?php _e("Public", "unify_framework"); ?></th>
                <th><?php _e("Exclude SearchForm", "unify_framework"); ?></th>
                <th><?php _e("Capability Type", "unify_framework"); ?></th>
                <th><?php _e("Hierarchical", "unify_framework"); ?></th>
                <th><?php _e("Supports", "unify_framework"); ?></th>
                <th><?php _e("Can Exports", "unify_framework"); ?></th>
                <th><?php _e("Show in Nav Menus", "unify_framework"); ?></th>
            </tr>
        </tfoot>
        <?php if(empty($options)): ?>
        <tbody>
            <tr>
                <td colspan="9"><?php _e("Not registerd CustomPosts yet."); ?></td>
            </tr>
        </tbody>
        <?php else: ?>
        <?php foreach($options as $id => $custom_post): ?>
        <tbody>
            <tr>
                <td><?php echo $id; ?></td>
                <td><span class="uf_custom_post_type_name"><?php echo $custom_post["custom_post_type_name"]; ?></span>
                    <div class="uf_inline_col">
                        <span class="edit"><a href="<?php echo wp_nonce_url($url. "?page=uf-cp-add&id={$id}"); ?>"><?php _e("Edit"); ?></a></span> |
                        <span class="delete"><a href="<?php echo wp_nonce_url($url. "?page=uf-cp-edit&id={$id}&delete=true"); ?>"><?php _e("Delete"); ?></a></span>
                    </div>
                </td>
                <td><?php echo ($custom_post["public"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo ($custom_post["exclude_form_search"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo __($custom_post["capability_type"]); ?></td>
                <td><?php echo ($custom_post["hierarchical"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo join(",", array_map("__", $custom_post["supports"])); ?></td>
                <td><?php echo ($custom_post["can_export"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo ($custom_post["show_in_nav_menus"] == true) ? __("Yes"): __("No"); ?></td>
            </tr>
        </tbody>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <script type="text/javascript">
        var msg = "<?php _e("Delete '%title%'. \\n this action can't cancel."); ?>";
        jQuery(function($){
            $(".delete").click(function(){
                var title = $(this).parents("td").find(".uf_custom_post_type_name").text();
                return confirm(msg.replace("%title%", title));
            });
        });
    </script>
<!-- End uf_admin --></div>
<?php
}




