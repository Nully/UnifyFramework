<?php
abstract class UnifyFramework_Admin_Page
{
    /**
     * 各小クラスで上書き
     *
     * @access public
     * @return void
     */
    public function init()
    {
    }


    /**
     * 小クラス（書くページ）で利用するサブページを登録する
     * 子クラスで上書きする
     *
     * @access public
     * @return void
     */
    public function add_subpage()
    {
        trigger_error("override add_subpage child class !", E_USER_ERROR);
    }
}