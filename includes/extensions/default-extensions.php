<?php
/**
 * UnifyFramework CustomPost extension
 *
 */
class UF_CustomPost extends UF_Extension {
    var $supports = array(
        'Title',
        'Editor',
        'Excerpt',
        'Author',
        'Comments',
        'Custom Fields',
        'Revisions',
        'Thumbnail',
        'Page Attributes'
    );
    function UF_CustomPost() {
        $this->UF_Extension("UF_CustomPost", __("CustomPost", "unify_framework"), __("UnifyFramewrok theme supported CustomPost", "unify_framework"));
    }


    /**
     * Initialize action hooks
     *
     * @access public
     * @return Void
     */
    function init() {
        add_action("admin_menu", array(&$this, "register_menu"));
        add_action("admin_init", array(&$this, "register_options"));
        add_action("admin_notices", array(&$this, "display_notice"));
        add_filter("uf_custom_post_options", array(&$this, "_filter_custom_post_options"));
    }



    /**
     * Register admin themes submenu
     *
     * @access public
     * @return Void
     */
    function register_menu() {
        #if(function_exists("add_submenu_page") && !defined("CPT_VERSION")) {
            add_submenu_page("themes.php", __("UnifyFramework CutomPost register", "unify_framework"), __("Add Custom Post", "unify_framework"), 10, "uf-add-custom-post", array(&$this, "add_new"));
            add_submenu_page("themes.php", __("UnifyFramework CutomPost editor", "unify_framework"), __("Edit Custom Post", "unify_framework"), 10, "uf-edit-custom-post", array(&$this, "edit"));
        #}
    }



    /**
     * Register or Update, update custom post options
     *
     * @access protected
     * @return Void
     */
    function register_options() {
        if($_GET["delete"] && $_GET["id"]) {
            if(uf_delete_custom_post($_GET["id"])) {
                add_action("admin_notices", array(&$this, "delete_notice"));
            }
        }

        if(!$_POST["save_custom_post"])
            return;

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

            if(empty($options["custom_post_type_name"])) {
                add_action("admin_notices", array(&$this, "validate_error_notice"));
                return;
            }

            $options = apply_filters("uf_custom_post_options", $options);
            if($_POST["id"]) {
                uf_update_custom_post_option($options, $_POST["id"]);
                $base_url .= "&page=uf-edit-custom-post";
            }
            else {
                uf_update_custom_post_option($options);
                $base_url .= "&page=uf-add-custom-post";
            }
            
            $base_url .= "&save=true";
        }
        wp_redirect($base_url);
    }



    /**
     * uf_custom_post_options Filter hook.
     *
     * @access private
     * @param  $options   Array   CustomPost options
     * @return Array
     */
    function _filter_custom_post_options($options) {
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



    /**
     * Display add new CustomPost form.
     *
     * @access public
     */
    function add_new() {
        $options = array();
        if($_GET["id"]) {
            $options = uf_get_custom_post_option($_GET["id"]);
        }
    ?>
        <div class="wrap" id="uf_admin">
            <?php screen_icon("options-general"); ?>
            <h2><?php _e("Add new CustomPost", "unify_framework"); ?></h2>
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
                        <?php foreach($this->supports as $field): ?>
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
     * Display editable Customposts
     *
     * @access public
     * @return Void
     */
    function edit() {
        global $pagenow, $plugin_page;
        $options = uf_get_custom_post_options();
        $url = get_admin_url(null, "{$pagenow}?");
    ?>
        <div class="wrap" id="uf_admin">
            <?php screen_icon("options-general"); ?>
            <h2><?php _e("Edit CustomPosts", "unify_framework"); ?></h2>
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
                                <span class="edit"><a href="<?php echo wp_nonce_url($url. "?page=uf-add-custom-post&id={$id}"); ?>"><?php _e("Edit"); ?></a></span> |
                                <span class="delete"><a href="<?php echo wp_nonce_url($url. "?page=uf-edit-custom-post&id={$id}&delete=true"); ?>"><?php _e("Delete"); ?></a></span>
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



    /**
     * Display validate error messages
     *
     * @access  protected
     * @return Void
     */
    function validate_error_notice() {
        echo '<div class="error fade">'. PHP_EOL;
            echo '<p>'. __("Error. not empty custom post type name."). '</p>'. PHP_EOL;
        echo '</div>'. PHP_EOL;
    }


    function delete_notice() {
        echo '<div class="updated fade">'. PHP_EOL,
            '<p>'. __("Delete. remove selected custom post type") .'</p>',
        '</div>';
    }


    /**
     * Display notice messages
     *
     * @access protected
     * @return Void
     */
    function display_notice() {
        if(!empty($_POST)) // fix not saved display notice messages.
            return;

        if($_GET["save"]) { // add new custom post
            echo '<div class="updated fade">'. PHP_EOL;
                echo '<p>'. __("Success. add a new custom post."). '</p>';
            echo '</div>'. PHP_EOL;
        }
    }
}



/**
 * UnifyFramework PostThumbnail extension
 *
 */
class UF_PostThumbnail extends UF_Extension {
    function UF_PostThumbnail() {
        $this->UF_Extension("UF_PostThumbnail", __("PostThumbnail"), __("UnifyFramework theme supported PostThumbnail"));
    }


    /**
     * Initialize action hooks
     *
     * @access public
     * @return Void
     */
    function init() {
        add_action("admin_menu", array(&$this, "register_menu"));
        add_action("after_setup_theme", array(&$this, "init_post_thumbnail"));
    }



    /**
     * Register admin themes submenu
     *
     * @access public
     * @return Void
     * @action admin_menu
     */
    function register_menu() {
        add_submenu_page("themes.php", __("UnifyFramework PostThumbnail settings", "unify_framework"), __("PostThumbnail", "unify_framework"), 10, "uf-post-thumbnail", array(&$this, "edit_option"));
    }



    /**
     * Edit PostThumbnail support options
     *
     * @access public
     * @return Void
     */
    function edit_option() {
        if(isset($_POST["save_post_thumb_options"])) {
            uf_update_option("post_thumbnail", array(
                "post_thumb_enable" => $_POST["post_thumb_enable"],
                "post_thumb_support_type" => $_POST["post_thumb_support_type"],
                "post_thumb_width"  => $_POST["post_thumb_width"],
                "post_thumb_height" => $_POST["post_thumb_height"]
            ));
        }
        $options = uf_get_option("post_thumbnail");
    ?>
        <div class="wrap" id="uf_admin">
            <?php screen_icon("options-general"); ?>
            <h2><?php _e("Edit PostThumbnail settings", "unify_framework"); ?></h2>
            <p><?php _e("post thumbnail setting edit.", "unify_framework"); ?></p>
            <form action="" method="post">
                <dl>
                    <dt><?php _e("Enable PostThumbnail", "unify_framework"); ?></dt>
                    <dd><?php uf_form_checkbox(1, array(
                        "id" => "uf_post_thumb_enable", "name" => "post_thumb_enable",
                        "label" => __("Enable PostThumbnail support.", "unify_framework"), "checked" => $options["post_thumb_enable"]
                    )); ?></dd>

                    <dt><?php _e("Support post type", "unify_framework"); ?></dt>
                    <dd><?php uf_form_select(array( "page" => __("Page"), "post" => __("Post"), "all" => __("All")), array(
                        "id" => "uf_post_thumb_support_type", "name" => "post_thumb_support_type",
                        "label" => __("Choice a support post type"), "value" => $options["post_thumb_support_type"]
                    )); ?></dd>

                    <dt><?php _e("Thumbnail width", "unify_framework"); ?></dt>
                    <dd><?php uf_form_input("text", $options["post_thumb_width"] ? $options["post_thumb_width"] : 200, array(
                        "id" => "uf_post_thumb_width", "name" => "post_thumb_width", "label" => __("set image width is 'px'.")
                    )); ?></dd>

                    <dt><?php _e("Thumbnail height", "unify_framework"); ?></dt>
                    <dd><?php uf_form_input("text", $options["post_thumb_height"] ? $options["post_thumb_height"] : 200, array(
                        "id" => "uf_post_thumb_height", "name" => "post_thumb_height", "label" => __("set image height is 'px'.")
                    )); ?></dd>
                </dl>
                <p><input type="submit" name="save_post_thumb_options" value="<?php _e("Save post thumbnail options"); ?>" class="button-primary" /></p>
            </form>
        </div>
    <?php
    }



    /**
     * initialize PostThumbnail theme support
     *
     * @access public
     * @return Void
     * @action init
     */
    function init_post_thumbnail() {
        $options = uf_get_option("post_thumbnail");

        // no have a options
        if(empty($options)) return;

        // disable PostThumbnail
        if(!$options["post_thumb_enable"]) return;

        $supports = array();
        switch(strtolower($options["post_thumb_support_type"])) {
            case "page":
                $supports[] = "page";
                break;
            case "post":
                $supports[] = "post";
                break;
            case "all":
                $supports = array( "page", "post" );
                break;
        }

        add_theme_support("post-thumbnails", $supports);
        set_post_thumbnail_size($options["post_thumb_width"], $options["post_thumb_height"], false);
    }
}


