<?php
/**
 * UnifyFramework Admin page scripts
 *
 */
/**
 * display UnifyFramework admin page style
 *
 * @access protected
 */
function uf_admin_head() {
    wp_enqueue_style("uf_admin_css", get_bloginfo("template_url"). "/css/admin.css", array(), UF_VERSION, "all");
}
add_action("admin_init", "uf_admin_head");



/**
 * register Admin menu.
 *
 * @access protected
 * @return Void
 */
function uf_add_admin_menu() {
    if(function_exists("add_menu_page"))
        add_menu_page(__("UnifyFramework Setting page"), __("UnifyFramework"), 10, "uf_settings", "uf_admin_options");

    if(function_exists("add_submenu_page")) {
        add_submenu_page("uf_settings", __("Custom post setting"), __("Custom Posts"), 10, "uf-custom-posts", "uf_admin_custom_post");
        add_submenu_page("uf_settings", __("Post thumbnail setting"), __("Post thumbnail"), 10, "uf-post-thumbnail", "uf_admin_post_thumbnail");
    }
}
add_action("admin_menu", "uf_add_admin_menu");



class UF_Admin_Abstract {
    /**
     * header text
     *
     * @access protected
     * @abstract
     */
    var $contentTitle  = __CLASS__;


    /**
     * display option page content data
     *
     * @access public
     * @return Void
     */
    function display() {
        return __("This method ". __METHOD__. " is required overload.");
    }


    /**
     * did render the 'display' method
     */
    function render() {
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e($this->contentTitle, "unify_framework"); ?></h2>
    <?php $this->display(); ?>
<!-- End uf_admin --></div>
<?php
    }
}



/**
 * UnifyFramework theme options page class
 *
 */
class UF_Admin_Options extends UF_Admin_Abstract {
    var $contentTitle = "UnifyFramework setting page";
}



/**
 * UnifyFramework theme supported custom post
 *
 */
class UF_Admin_CustomPost extends UF_Admin_Abstract {
    var $contentTitle = "Custom post setting page";
}



/**
 * UnifyFramework theme supported custom image header
 *
 */
class UF_Admin_CustomImageHeader extends UF_Admin_Abstract {
    var $contentTitle = "";
}




/**
 * Admin menu display callback
 *
 * @access protected
 * @return Void
 */
function uf_admin_options() {
    if(isset($_POST["uf_save_options"]) && !empty($_POST["uf_save_options"])) {
    }

?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("UnifyFramework Setting page", "unify_framework"); ?></h2>
    <p><?php _e("setting UnifyFramework theme options.", "unify_framework"); ?></p>
    <div class="uf-settings">
        <form action="action" method="post">
            <?php wp_nonce_field(); ?>
            <div id="uf_option_editor_style">
                <h3><?php _e("Editor style setting"); ?></h3>
                <dl>
                    <dt><?php _e("Editor style setting.", "unify_framework"); ?></dt>
                    <dd><input type="hidden" name="uf[allow_editor_css]" value="0" />
                        <input id="uf_allow_editor_css" type="checkbox" name="uf[allow_editor_css]" value="1" />
                        <label for="uf_allow_editor_css"><?php _e("Allow custom editor style", "unify_framework"); ?></label><br />
                        <span class="caution"><?php _e("* custom editor style file path: "); ?><?php echo bloginfo("template_directory"); ?>/editor-style.css</span></dd>
                </dl>
            <!-- End uf_option_editor_style --></div>


            <div id="uf_option_comment" class="settings-comment">
                <h3><?php _e("Comment post setting.", "unify_framework"); ?></h3>
                <dl>
                    <dt><?php _e("Comment", "unify_framework"); ?></dt>
                    <dd><input type="hidden" name="uf[comment_for_page]" value="0" />
                        <input id="uf_comment_for_page" type="checkbox" name="uf[comment_for_page]" value="1"<?php if($options["comment_for_page"]) ?> />
                        <label for="uf_comment_for_page"><?php _e("Comment allwod page ?", "unify_framework"); ?></label><br />

                        <input id="uf_comment_allowd_pages" type="text" name="uf[comment_allowd_pages]" value="<?php echo $options["comment_allowd_pages"] ?>" /><br />
                        <label for="uf_comment_allowd_pages" class="caution"><?php _e("* separated 'comma' for page ID", "unify_framework"); ?></label></dd>
                </dl>
            <!-- End uf_option_comment --></div>

            <div id="uf_option_custom_image_header">
                <dl>
                    <dt><?php _e("Custom image header", "unify_framework"); ?></dt>
                    <dd>
                        <input type="hidden" name="uf_custom_image_header[display_in_front]" value="0" />
                        <input type="checkbox" id="uf_custom_image_header_in_front" name="uf_custom_image_header[display_in_front]" value="1" />
                        <label for="uf_custom_image_header_in_front"><?php _e("display custom header in the home page or front page ?", "unify_framework"); ?></label></dd>
                </dl>
            <!-- End uf_option_custom_image_header --></div>
            <p><input type="submit" name="uf_save_options" value="<?php _e("Save as theme options"); ?>" class="button-primary" /></p>
        </form>
    <!-- End uf-settings --></div>
<!-- End wrap --></div>
<?php
}



/**
 * Display custom post form for Admin
 *
 * @access public
 * @return Void
 */
function uf_admin_custom_post() {
    $id = null;
    if(isset($_GET["uf_edit_id"]) && !empty($_GET["uf_edit_id"])) {
        $id = (int)$_GET["uf_edit_id"];
    }
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("Custom post setting", "unify_framework"); ?></h2>
    <h3><?php _e("Custom post type register field.", "unify_framework"); ?></h3>
    <?php uf_admin_get_custom_post_form($id); ?>
    <hr />
    <h3><?php _e("Registerd custom post types", "unify_framework"); ?></h3>
    <?php uf_admin_get_registerd_custom_posts($id); ?>
<!-- End wrap --></div>
<?php
}



/**
 * insert new custom post type
 *
 * @access public
 * @param  $data   Array|String    paramater is serializable data
 * @return Bool
 */
function uf_add_custom_post($custom_post_type_name, $data) {
    if(empty($custom_post_type_name) || empty($data["labels"]["name"])) {
        echo '<div class="error fade"><p>'. __("required field 'Unique custom post name' and 'Labels unique name'") .'</p></div>';
        return false;
    }

    $custom_posts = get_option("uf_custom_posts");
    if(empty($custom_posts))
        $custom_posts = array();

    $cnt = array_pop(array_keys($custom_posts)) + 1;
    uf_esc_attr_deep($data, "esc_attr");
    $custom_posts[$cnt] = array(
        "post_type_name" => $custom_post_type_name,
        "params" => $data
    );

    return update_option("uf_custom_posts", $custom_posts);
}



/**
 * Dsiplay Custom post type form for Admin
 *
 * @access public
 * @param  $id    Int   current editable target custom post ID.
 * @return Void
 */
function uf_admin_get_custom_post_form($id = null) {
    $options = array();
    if(isset($_POST) && !empty($_POST["uf_custom_post_save"])) {
        if(!uf_add_custom_post($_POST["post_type_name"], $_POST["params"])) {
            $options = $_POST;
        }
    }

    if(!empty($id)) {
        $options = uf_get_custom_post($id);
    }

    if(!empty($options["params"])) {
        extract($options["params"], EXTR_SKIP);
    }
?>
<form action="" method="post">
    <?php wp_nonce_field(); ?>
    <dl>
        <dt><?php _e("Unique custom post name", "unify_framework"); ?></dt>
        <dd><input id="uf_custom_posts_post_type_name" type="text" name="post_type_name" value="<?php echo $options["post_type_name"]; ?>" />
            <label for="uf_custom_posts_post_type_name"><?php _e("unique custom post name.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Description", "unify_framework"); ?></dt>
        <dd><input id="uf_custom_posts_description" type="text" name="params[description]" value="<?php echo $description ?>" />
            <label for="uf_custom_posts_description"><?php _e("shorty custom post type description", "unify_framework"); ?></label></dd>
        <dt><?php _e("Lables", "unify_framework"); ?></dt>
        <dd>
            <input id="uf_custom_posts_name" type="text" name="params[labels][name]" value="<?php echo $labels["name"]; ?>" />
                <label for="uf_custom_posts_name"><?php _e("custom post type unique name.", "unify_framework"); ?></label><br />
            <input id="uf_custom_psots_singular_name" type="text" name="params[labels][singular_name]" value="<?php echo $labels["singular_name"]; ?>" />
                <label for="uf_custom_psots_singular_name"><?php _e("custom post type unique singular name.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_add_new" type="text" name="params[labels][add_new]" value="<?php echo $labels["add_new"]; ?>" />
                <label for="uf_custom_posts_add_new"><?php _e("custom post type add new label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_add_new_item" type="text" name="params[labels][add_new_item]" value="<?php echo $labels["add_new_item"]; ?>" />
                <label for="uf_custom_posts_add_new_item"><?php _e("custom post type add new item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_edit_item" type="text" name="params[labels][edit_item]" value="<?php echo $optionslabels["edit_item"]; ?>" />
                <label for="uf_custom_posts_edit_item"><?php _e("custom post type edit item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_new_item" type="text" name="params[labels][new_item]" value="<?php echo $optionslabels["new_item"]; ?>" />
                <label for="uf_custom_posts_new_item"><?php _e("custom post type new item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_view_item" type="text" name="params[labels][view_item]" value="<?php echo $optionslabels["view_item"]; ?>" />
                <label for="uf_custom_posts_view_item"><?php _e("custom post type view item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_search_item" type="text" name="params[labels][search_items]" value="<?php echo $labels["search_item"]; ?>" />
                <label for="uf_custom_posts_search_item"><?php _e("custom post search item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_not_found" type="text" name="params[labels][not_found]" value="<?php echo $labels["not_found"]; ?>" />
                <label for="uf_custom_posts_not_found"><?php _e("custom post search not found label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_not_found_in_trush" type="text" name="params[labels][not_found_in_trush]" value="<?php echo $labels["not_found_in_trush"]; ?>" />
                <label for="uf_custom_posts_not_found_in_trush"><?php _e("custom post search not found in the trush.", "unify_framework"); ?></label><br />
        </dd>
        <dt><?php _e("Public", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="params[public]" value="0" />
            <input id="uf_custom_posts_public" type="checkbox" name="params[public]" value="1"<?php echo (int)$public == 1 ? ' checked="checked"': ""; ?> />
            <label for="uf_custom_posts_public"><?php _e("shown admin UI.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Search form", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="params[exclude_from_search]" value="0" />
            <input id="uf_custom_posts_exclude_form_search" type="checkbox" name="params[exclude_from_search]" value="1"<?php echo (int)$exclude_form_search == 1 ? ' checked="checked"': ""; ?> />
            <label for="uf_custom_posts_exclude_form_search"><?php _e("exclude custom post type in search form.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Show UI", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="params[show_ui]" value="0" />
            <input id="uf_custom_posts_show_ui" type="checkbox" name="params[show_ui]" value="1"<?php echo (int)$show_ui == 1 ? ' checked="checked"': ""; ?> />
            <label for="uf_custom_posts_show_ui"><?php _e("Whether to generate a default UI for managing this post type.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Capability Type", "unify_framework"); ?></dt>
        <dd><select id="uf_custom_posts_capability_type" name="params[capability_type]">
                <option<?php echo (int)$exclude_form_search == 1 ? ' selected="selected"': ""; ?> value="page"><?php _e("Page"); ?></option>
                <option value="post"><?php _e("Post"); ?></option>
            </select>
            <label for="uf_custom_posts_capability_type"><?php _e("The post type to use for checking read, edit, and delete capabilities.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Hierarchical", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="params[hierarchical]" value="0" />
            <input id="uf_custom_posts_herarchical" type="checkbox" name="params[hierarchical]" value="1"<?php echo (int)$hierarchical == 1 ? ' checked="checked"': ""; ?> />
            <label for="uf_custom_posts_herarchical"><?php _e("this post type have a hieralchical."); ?></label></dd>
        <dt><?php _e("Supports", "unify_framework"); ?></dt>
        <dd>
            <input type="hidden" name="params[supports]" value="" />
            <?php foreach(array('Title','Editor','Author','Thumbnail','Excerpt','Comments') as $field): ?>
            <input id="uf_custom_posts_supports_<?php echo $field; ?>" type="checkbox" name="params[supports][]" value="<?php echo $field; ?>"<?php echo in_array($field, (array)$supports) ? ' checked="checked"': ""; ?> />&nbsp;
                <label for="uf_custom_posts_supports_<?php echo $field; ?>"><?php _e($field); ?></label>
            <?php endforeach; ?>
        </dd>
        <dt><?php _e("Export", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="params[can_export]" value="0" />
            <input id="uf_custom_posts_can_export" type="checkbox" name="params[can_export]" value="1"<?php echo (int)$can_export == 1 ? ' checked="checked"': ""; ?> />
            <label for="uf_custom_posts_can_export"><?php _e("this post type including WPExport ?", "unify_framework"); ?></label></dd>
        <dt><?php _e("Nav Menus", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="params[show_in_nav_menus]" value="0" />
            <input id="uf_custom_posts_show_in_nav_menus" type="checkbox" name="params[show_in_nav_menus]" value="1"<?php echo (int)$show_in_nav_menus == 1 ? ' checked="checked"': ""; ?> />
            <label for="uf_custom_posts_show_in_nav_menus"><?php _e("this custom post type including custom nav menus ?"); ?></label></dd>
    </dl>
    <p><input type="submit" name="uf_custom_post_save" value="<?php _e("Save as custom post"); ?>" class="button-primary" /></p>
</form>
<?php
}



/**
 * Display registerd custom posts
 *
 * @access public
 * @param  $id   Int   current editable target custom post ID.
 * @return Void
 */
function uf_admin_get_registerd_custom_posts($id = null) {
    global $pagenow, $plugin_page;

    $custom_posts = uf_get_custom_posts();
    if(empty($custom_posts)):
?>
<p><?php _e("No in registerd", "unify_framework"); ?></p>
<?php else: ?>
<table border="0" cellpadding="0" cellspacing="0" class="widefat">
    <thead>
        <tr>
            <th>ID</th>
            <th><?php _e("Custom post name", "unify_framework"); ?></th>
            <th><?php _e("Custom post actions", "unify_framework"); ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th><?php _e("Custom post name", "unify_framework"); ?></th>
            <th><?php _e("Custom post actions", "unify_framework"); ?></th>
        </tr>
    </tfoot>
<?php foreach($custom_posts as $custom_post_id => $args): ?>
    <tbody>
        <tr<?php echo ($custom_post_id === $id) ? ' class="current-edit"': ""; ?>>
            <td><?php echo esc_attr($custom_post_id); ?></td>
            <td><?php echo $args["params"]["labels"]["name"]; ?><br />
                <span><?php echo $args["params"]["description"] ? $args["params"]["description"]: __("No description.", "unify_framework"); ?></span></td>
            <td><a href="<?php echo get_admin_url(null, $pagenow); ?>?page=<?php echo $plugin_page; ?>&uf_edit_id=<?php echo $custom_post_id; ?>"><?php _e("Edit"); ?></a></td>
        </tr>
    </tbody>
<?php endforeach; ?>
</table>
<?php
    endif;
}



/**
 * display theme support post-thumbnail
 *    post-thumbnail support WordPress version 2.9.x
 *
 * @access protected
 * @return Void
 */
function uf_admin_post_thumbnail() {
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("Post thumbnail setting", "unify_framework"); ?></h2>
    <form action="" method="post">
        <dl>
            <dt><?php _e("Post thumbnail support", "unify_framework"); ?></dt>
            <dd><input type="hidden" name="uf_post_thumb[enable]" value="0" />
                <input id="uf_post_thumb_enable" type="checkbox" name="uf_post_thumb[enable]" value="1" />
                <label for="uf_post_thumb_enable"><?php _e("theme support post thumbnail ?"); ?></label></dd>

            <dt><?php _e("Post thumbnail support types", "unify_framework"); ?></dt>
            <dd><?php foreach(array("1" => "Post", "2" => "Page", "3" => "All") as $flug => $type): ?>
                <input type="radio" id="uf_post_thumb_support_type-<?php echo strtolower($type); ?>" name="uf_post_thumb[support_type]" value="<?php echo $flug; ?>" />
                    <label for="uf_post_thumb_support_type-<?php echo strtolower($type); ?>"><?php _e($type); ?></label>
                <?php endforeach; ?><br />
                <span class="caution"><?php _e("* post thumbnail is 'Eyecatch'."); ?></span></dd>

            <dt><?php _e("Thumbnail size", "unify_framework"); ?></dt>
            <dd><?php _e("Width"); ?><input type="text" id="uf_post_thumb_width" name="uf_post_thumb[thumb_width]" value="" /> px
                <?php _e("Height"); ?><input type="text" id="uf_post_thumb_height" name="uf_post_thumb[thumb_height]" value="" /> px</dd>

            <dt><?php _e("image croping", "unify_framework"); ?></dt>
            <dd><input type="hidden" name="uf_post_thumb[is_crop]" value="0" />
                <input id="uf_post_thumb_is_crop" type="checkbox" name="uf_post_thumb[is_crop]" value="1" />
                <label for="uf_post_thumb_is_crop"><?php _e("post thumbnail image croping ?"); ?></label></dd>
        </dl>
    </form>
<!-- End uf_admin --></div>
<?php
}








