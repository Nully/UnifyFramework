<?php
require_once dirname(__FILE__). "/constants.php";

require_once UF_LIB_PATH. "/actions.php";
require_once UF_LIB_PATH. "/templates.php";
#require_once UF_LIB_PATH. "";

if(is_admin()) {
    require_once UF_LIB_PATH. "/admin.php";
    require_once UF_LIB_PATH. "/admin/Abstract.php";
    require_once UF_LIB_PATH. "/admin/General.php";
    require_once UF_LIB_PATH. "/admin/Widgets.php";
    require_once UF_LIB_PATH. "/admin/Widgets.php";
    require_once UF_LIB_PATH. "/admin/Widgets.php";
    require_once UF_LIB_PATH. "/admin/Widgets.php";
}
