<?php
/**
 * UnifyFramework theme support CustomToxonomies
 *
 */
/**
 * uf_ct_admin_init
 *
 * CustomTaxonomies admin_init action hook
 *
 * @access protected
 * @return Void
 */
function uf_ct_admin_init() {
}
add_action("admin_init", "uf_ct_admin_init");



/**
 * uf_ct_options_save
 *
 * CustomTaxonomies admin_init action hook.
 * do save CustomTaxonomy.
 *
 * @access protected
 * @return Void
 */
function uf_ct_options_save() {
    global $pagenow, $plugin_page;
    if(empty($_POST))
        return;

    $base_url = get_admin_url(null, $pagenow);
    /**
     * Save CustomTaxonomy post
     *
     */
    if($_POST["save_custom_tax"]) {
        $options = uf_ct_get_post_option();

        // failuer empty data.
        if(empty($options["taxonomy_type"]) || empty($options["taxonomy_name"])) {
            return;
        }

        $options = apply_filters("uf_ct_filter_options", $options);

        if(uf_update_custom_tax($options, $_POST["id"])) {
            $base_url .= "?page={$plugin_page}&save=true";
            wp_redirect($base_url);
            die();
        }

        return;
    }
}
add_action("admin_init", "uf_ct_options_save");



/**
 * do filter UnifyFramework options
 *
 * @access public
 * @param  $options   Array
 * @return Array
 */
function uf_ct_filter_labels($options) {
    $labels = $options["labels"];
    $name = $options["taxonomy_name"];

    $labels["name"]          = isset($labels["name"]) && !empty($labels["name"]) ? $labels["name"]: $name;
    $labels["singular_name"] = isset($labels["singular_name"]) && !empty($labels["singular_name"]) ? $labels["singular_name"]: $name;
    $labels["search_items"]  = isset($labels["search_items"]) && !empty($labels["search_items"]) ? $labels["search_items"]: "Search {$name}";
    $labels["popular_items"] = isset($labels["popular_items"]) && !empty($labels["popular_items"]) ? $labels["popular_items"]: "popular {$name}";
    $labels["all_items"]     = isset($labels["all_items"]) && !empty($labels["all_items"]) ? $labels["all_items"]: "All {$name}";
    $labels["parent_item"]   = isset($labels["parent_item"]) && !empty($labels["parent_item"]) ? $labels["parent_item"]: "Parent of {$name}";
    $labels["parent_item_colon"] = isset($labels["parent_item_colon"]) && !empty($labels["parent_item_colon"]) ? $labels["parent_item_colon"]: $name;
    $labels["edit_item"]     = isset($labels["edit_item"]) && !empty($labels["edit_item"]) ? $labels["edit_item"]: "Edit {$name}";
    $labels["update_item"]   = isset($labels["update_item"]) && !empty($labels["update_item"]) ? $labels["update_item"]: "Update {$name}";
    $labels["add_new_item"]  = isset($labels["add_new_item"]) && !empty($labels["add_new_item"]) ? $labels["add_new_item"]: "Add new {$name}";
    $labels["new_item_name"] = isset($labels["new_item_name"]) && !empty($labels["new_item_name"]) ? $labels["new_item_name"]: "New {$name}";
    $labels["separate_items_with_commas"] = isset($labels["separate_items_with_commas"]) && !empty($labels["separate_items_with_commas"]) ? $labels["separate_items_with_commas"]: "{$name}";
    $labels["add_or_remove_items"]   = isset($labels["add_or_remove_items"]) && !empty($labels["add_or_remove_items"]) ? $labels["add_or_remove_items"]: "Add or Remove {$name}";
    $labels["choose_from_most_used"] = isset($labels["choose_from_most_used"]) && !empty($labels["choose_from_most_used"]) ? $labels["choose_from_most_used"]: "{$name}";

    $options["labels"] = $labels;

    return $options;
}
add_filter("uf_ct_filter_options", "uf_ct_filter_labels");


/**
 * uf_ct_admin_init
 *
 * CustomTaxonomies admin_menu action hook
 *
 * @access protected
 * @return Void
 */
function uf_ct_admin_menu() {
    add_submenu_page("uf-options", __("Add Custom Taxonomies", "unify_framework"), __("Add Custom Taxonomies", "unify_framework"), 10, "uf-ct-add", "uf_ct_register_panel");
    add_submenu_page("uf-options", __("Edit Custom Taxonomies", "unify_framework"), __("Edit Custom Taxonomies", "unify_framework"), 10, "uf-ct-edit", "uf_ct_edit_panel");
    uf_admin_add_page_nav(__("Add Custom Taxonomies", "unify_framework"), "uf-ct-add");
    uf_admin_add_page_nav(__("Edit Custom Taxonomies", "unify_framework"), "uf-ct-edit");
}
add_action("admin_menu", "uf_ct_admin_menu");



/**
 * uf_ct_admin_notices
 *
 * CustomTaxonomy admin_notices action hook
 *
 * @access public
 * @return Void
 */
function uf_ct_admin_notices() {
}
add_action("admin_notices", "uf_ct_admin_notices");



/**
 * CustomTaxonomies Taxonomy register panel
 *
 * @access protected
 * @return Void
 */
function uf_ct_register_panel() {
?>
<div class="wrap" id="uf_admin">
<?php uf_admin_page_tab_nav(); ?>
<?php if(!uf_ct_enable_custom_post()): ?>
    <div class="error">
        <p><?php _e("do set first CustomPost extension enable.", "unify_framework"); ?></p>
    </div>
<?php else: ?>
<?php if(!empty($_POST) && $_POST["save_custom_tax"] && !$_GET["save"]): ?>
    <div class="error">
        <p><?php _e("Error: checking for required input fields.", "unify_framework"); ?></p>
    </div>
<?php endif; ?>

    <?php
        if($_GET["id"])
            $options = uf_get_custom_tax($_GET["id"]);
        else
            $options = uf_ct_get_post_option();
    ?>
    <p><?php _e("Custom Taxonomy settings.", "unify_framework"); ?></p>
    <form action="" method="post">
        <?php wp_nonce_field(); ?>
        <?php if($_GET["id"]): ?><?php uf_form_input("hidden", $_GET["id"], array( "name" => "id" )); ?><?php endif; ?>
        <?php uf_admin_postbox(__("Taxonomy base setting", "unify_framework"), array(
            array(
                "label" => __("Taxonomy name", "unify_framework"),
                "field" => uf_form_input("text", $options["taxonomy_name"], array(
                    "id" => "uf_tax_taxonomy_name", "name" => "taxonomy_name"
                ), false),
                "extra" => __("* Required field", "unify_framework")
            ),
            array(
                "label" => __("Custom Query var", "unify_framework"),
                "field" => uf_form_input("text", $options["query_var"], array(
                    "id" => "uf_tax_query_var", "name" => "query_var",
                ), false),
                "extra" => __("* Custom query var no set use Taxonomy name.", "unify_framework")
            ),
            array(
                "label" => __("Custom rewrite slug", "unify_framework"),
                "field" => uf_form_input("text", $options["rewrite"], array(
                    "id" => "uf_tax_rewrite", "name" => "rewrite",
                ), false),
                "extra" => __("* Custom rewrite slug is no set use to Taxonomy name.", "unify_framework")
            ),
            array(
                "label" => __("Public", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_tax_public", "name" => "public",
                    "label" => __("Publically in this taxonomy ?", "unify_framework"),
                    "checked" => !!$options["public"]
                ), false),
            ),
            array(
                "label" => __("Hierarchical", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_tax_hierarchical", "name" => "hierarchical",
                    "checked" => !!$options["hierarchical"],
                    "label" => __("Custom Taxonomy has hierarchical ?", "unify_framework")
                ), false)
            ),
            array(
                "label" => __("Show UI", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_tax_shou_ui", "name" => "show_ui",
                    "checked" => !!$options["show_ui"],
                    "label" => __("Custom Taxonomy show UI ?", "unify_framework"),
                    "checked" => !!$options["show_ui"]
                ), false)
            ),
            array(
                "label" => __("Show in nav menus", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_tax_show_in_nav_menus", "name" => "show_in_nav_menus",
                    "label" => __("Show in custom Nav Menus ?", "unify_framework"),
                    "checked" => !!$options["show_in_nav_menus"]
                ), false),
            ),
            array(
                "label" => __("Tag Cloud", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_tax_tag_cloud", "name" => "show_tagcloud",
                    "label" => __("Show this taxonomy in Tag Cloud ?", "unify_framework"),
                    "checked" => !!$options["show_tagcloud"]
                ), false),
            ),
        )); ?>

        <?php
            $radios = "";
            $options["taxonomy_type"] = isset($options["taxonomy_type"]) ? $options["taxonomy_type"]: "";
            $post_types = get_post_types(array( "public" => true ), "objects");
            foreach($post_types as $name => $post_type) {
                if($name == "attachment")
                    continue;

                $radios .= uf_form_input("radio", $name, array(
                    "id" => "uf_custom_post_type-{$name}", "name" => "taxonomy_type",
                    "label" => $post_type->label, "checked" => !!($name == $options["taxonomy_type"])
                ), false). "<br />";
            }
        ?>


        <?php uf_admin_postbox(__("Uses Post type", "unify_framework"), array(
            array(
                "label" => __("select this custom taxonomy uses post type."),
                "field" => $radios,
                "extra" => __("* Required field", "unify_framework")
            )
        )); ?>


        <?php uf_admin_postbox(__("Labels", "unify_framework"), array(
            array(
                "label" => __("Label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["name"], array(
                    "id" => "uf_tax_labels_name", "name" => "label[name]"
                ), false)
            ),
            array(
                "label" => __("Singular label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["singular_name"], array(
                    "id" => "uf_tax_labels_singular", "name" => "label[singular_name]"
                ), false)
            ),
            array(
                "label" => __("Search items label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["search_items"], array(
                    "id" => "uf_tax_labels_search_items", "name" => "label[search_items]"
                ), false)
            ),
            array(
                "label" => __("Pupular items label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["popular_items"], array(
                    "id" => "uf_tax_labels_popular_items", "name" => "label[popular_items]"
                ), false)
            ),
            array(
                "label" => __("All items label name"),
                "field" => uf_form_input("text", $options["labels"]["all_items"], array(
                    "id" => "uf_tax_labels_all_items", "name" => "label[all_items]"
                ), false)
            ),
            array(
                "label" => __("Parent item label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["parent_item"], array(
                    "id" => "uf_tax_labels_parent_item", "name" => "label[parent_item]"
                ), false)
            ),
            array(
                "label" => __("Parent item colon label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["parent_item_colon"], array(
                    "id" => "uf_tax_labels_parent_item_colon", "name" => "label[parent_item_colon]"
                ), false)
            ),
            array(
                "label" => __("Edit item label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["edit_item"], array(
                    "id" => "uf_tax_labels_edit_item", "name" => "label[edit_item]"
                ), false)
            ),
            array(
                "label" => __("Update item label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["update_item"], array(
                    "id" => "uf_tax_labels_update_item", "name" => "label[update_item]"
                ), false)
            ),
            array(
                "label" => __("Add new item label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["add_new_item"], array(
                    "id" => "uf_tax_labels_add_new_item", "name" => "label[add_new_item]"
                ), false)
            ),
            array(
                "label" => __("New item name label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["new_item_name"], array(
                    "id" => "uf_tax_labels_new_item_name", "name" => "label[new_item_name]"
                ), false)
            ),
            array(
                "label" => __("Separate items width commas label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["separate_items_with_commas"], array(
                    "id" => "uf_tax_labels_separate_items_with_commas", "name" => "label[separate_items_with_commas]"
                ), false)
            ),
            array(
                "label" => __("Add or remove items label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["add_or_remove_items"], array(
                    "id" => "uf_tax_labels_add_or_remove_items", "name" => "label[add_or_remove_items]"
                ), false)
            ),
            array(
                "label" => __("Choose from most used label name", "unify_framework"),
                "field" => uf_form_input("text", $options["labels"]["choose_from_most_used"], array(
                    "id" => "uf_tax_labels_choose_from_most_used", "name" => "label[choose_from_most_used]"
                ), false)
            ),
        )); ?>
        <p class="clearfix"><input type="submit" id="save_custom_tax" name="save_custom_tax" value="<?php _e("Save taxonomy", "unify_framework"); ?>" class="button-primary" /></p>
    </form>
<?php endif; ?>
<!-- End uf_admin --></div>
<?php
}



/**
 * CustomTaxonomies Edit panel
 *
 * @access public
 * @return Void
 */
function uf_ct_edit_panel() {
    if($_GET["delete"] == true && $_GET["id"]) {
        uf_delete_custom_tax($_GET["id"]);
    }
    $options = uf_get_custom_taxes();
?>
<div class="wrap" id="uf_admin">
    <?php uf_admin_page_tab_nav(); ?>
<?php if(empty($options)): ?>
    <p><?php _e("Custom taxonomies not registerd.", "unify_framework"); ?></p>
<?php else: ?>
    <p><?php _e("registerd custom taxonomies.", "unify_framework"); ?></p>
    <table border="0" cellpadding="0" cellspacing="0" class="widefat">
        <thead>
            <tr>
                <th><?php _e("ID", "unify_framework"); ?></th>
                <th><?php _e("Taxonomy name", "unify_framework"); ?></th>
                <th><?php _e("Taxonomy type", "unify_framework"); ?></th>
                <th><?php _e("Query var", "unify_framework"); ?></th>
                <th><?php _e("Rewrite", "unify_framework"); ?></th>
                <th><?php _e("Public", "unify_framework"); ?></th>
                <th><?php _e("Hierarchical", "unify_framework"); ?></th>
                <th><?php _e("Show UI", "unify_framework"); ?></th>
                <th><?php _e("Show in Nav Menus", "unify_framework"); ?></th>
                <th><?php _e("Show tag cloud", "unify_framework"); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e("ID", "unify_framework"); ?></th>
                <th><?php _e("Taxonomy name", "unify_framework"); ?></th>
                <th><?php _e("Taxonomy type", "unify_framework"); ?></th>
                <th><?php _e("Query var", "unify_framework"); ?></th>
                <th><?php _e("Rewrite", "unify_framework"); ?></th>
                <th><?php _e("Public", "unify_framework"); ?></th>
                <th><?php _e("Hierarchical", "unify_framework"); ?></th>
                <th><?php _e("Show UI", "unify_framework"); ?></th>
                <th><?php _e("Show in Nav Menus", "unify_framework"); ?></th>
                <th><?php _e("Show tag cloud", "unify_framework"); ?></th>
            </tr>
        </tfoot>
        <?php foreach($options as $id => $option): ?>
        <tbody>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $option["taxonomy_name"]; ?><br />
                    <span class="edit"><a href="<?php echo wp_nonce_url(get_admin_url(null, "admin.php?page=uf-ct-add&id={$id}")); ?>"><?php _e("Edit"); ?></a></span> |
                    <span class="delete"><a href="<?php echo wp_nonce_url(get_admin_url(null, "admin.php?page=uf-ct-edit&delete=true&id={$id}")); ?>"><?php _e("Delete"); ?></a></span></td>
                <td><?php echo $option["taxonomy_type"]; ?></td>
                <td><?php echo empty($option["query_var"]) ? __("No set Query var"): $option["query_var"]; ?></td>
                <td><?php echo empty($option["rewrite"]) ? __("No set rewrite slug."): $options["rewrite"]; ?></td>
                <td><?php echo ($option["public"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo ($option["hierarchical"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo ($option["show_ui"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo ($option["show_in_nav_menus"] == true) ? __("Yes"): __("No"); ?></td>
                <td><?php echo ($option["show_tag_cloud"] == true) ? __("Yes"): __("No"); ?></td>
            </tr>
        </tbody>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<!-- End uf_admin --></div>
<?php
}



/**
 * checking custom post enabled ?
 *
 * @access public
 * @return Bool
 */
function uf_ct_enable_custom_post() {
    $options = uf_get_option("theme_options");

    return isset($options["extensions"]["custom_post"]) && $options["extensions"]["custom_post"] === true;
}



/**
 * get CustomTaxonomy $_POST data array.
 *
 * @access public
 * @return Array
 */
function uf_ct_get_post_option() {
    $options = array(
        "taxonomy_type" => $_POST["taxonomy_type"],
        "taxonomy_name" => $_POST["taxonomy_name"],
        "query_var"     => $_POST["query_var"],
        "rewrite"       => $_POST["rewrite"],
        "public"        => isset($_POST["public"]) ? $_POST["public"]: true,
        "hierarchical"  => isset($_POST["hierarchical"]) ? $_POST["hierarchical"]: true,
        "show_ui"       => isset($_POST["show_ui"]) ? $_POST["show_ui"]: true,
        "show_in_nav_menus" => isset($_POST["show_in_nav_menus"]) ? $_POST["show_in_nav_menus"]: false,
        "show_tagcloud" => isset($_POST["show_tagcloud"]) ? $_POST["show_tagcloud"]: false,
        "labels" => $_POST["label"],
    );

    $options = uf_deep_esc_attr($options);
    $options = uf_parse_to_bool_deep($options);
    return $options;
}

