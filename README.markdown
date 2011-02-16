# WordPress Theme 'UnifyFramework' Version 1.0-DEV

========================= !! 現在は開発バージョンです !! ==========================

## UnifyFrameworkとは

UnifyFramework は [WordPress](http://wordpress.org/) の専用テーマです。

テーマをもっと統合的に（Unify）作成しよう！をモットーに作成されているテーマです。

基本レイアウトは[978.gs](http://978.gs/)の978pxグリッドシステムを利用しています。

カラム割も多彩に表現できると思います。

ダウンロードは以下のリンクから取得できます。

* [最新版](http://github.com/Nully/UnifyFramework)
* [開発版](http://github.com/Nully/UnifyFramework/tree/dev)

## ライセンスについて

基本的に画像やCSSファイル以外については、WordPress と同じ GPL ライセンスを適用しています。

詳しくは LICENSE.txt をお読みください。

## 免責事項

UnifyFramework を利用したことで発生した損害や、障害などにつきましては一切の責任を負いかねます。

自己責任で利用してください。

## インストール

UnifyFramework のインストールは以下のとおりです。

    * ダウンロードしたファイルを解凍する
    * 解凍したファイルを 「WordPressInstallDir/wp-content/themes/」 にコピー又は移動する
    * WordPress 管理画面にログインし、「外観」 -> 「テーマ」から UnifyFramework を有効化してください。

## サポートするWordPressバージョン

UnifyFramework は WordPress バージョン3.1以上で利用出来ます。

将来的に下位バージョンとなるWordPressのサポートを打ち切る可能性がありますので予めご理解ください。

## 現在サポートしているテーマ管理画面機能一覧

UnifyFrameworkが現在サポートしているテーマ管理画面の機能は以下のとおりです。

### ジェネラル設定

テーマの基本挙動の設定を行います。タイトルのセパレータや投稿フォーマットのサポートなどを設定できます。

### ウィジェット設定

ウィジェット表示エリアの追加・削除を行えます。

### カスタムメニュー設定

カスタムメニュー表示領域の追加・削除を行えます。

## ディレクトリ構成

UnifyFrameworkのファイル構成は以下のとおりです。

## フィルタ、アクションフックポイントについて

UnifiFramework はフィルタ、及びアクションフックポイントを多数盛り込んでいます。

そのフックポイントを以下に示します。

### フィルタフック一覧

UnifyFrameworkが提供している[フィルタフック一覧](https://github.com/Nully/UnifyFramework/wiki/%E3%83%95%E3%82%A3%E3%83%AB%E3%82%BF%E3%83%95%E3%83%83%E3%82%AF%E4%B8%80%E8%A6%A7)です。

 * uf_pagenavi_formats
   * uf_pagenavi関数で定義されているリンクテキストフォーマットのフィルタフック
 * uf_override_mce_css
   * エディタスタイルが有効に鳴っている場合にエディタCSSファイルのURLをフィルタするフック

### アクションフック一覧

UnifyFrameworkが提供している[アクションフック一覧](https://github.com/Nully/UnifyFramework/wiki/%E3%82%A2%E3%82%AF%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%95%E3%83%83%E3%82%AF%E4%B8%80%E8%A6%A7)です。

 * uf_theme_activated
   * UnifyFramework テーマが有効化されたときに呼び出されるアクションフック
 * get_template_part_(slug)
   * テンプレートパーシャルを呼び出す際に起動するアクションフック
   * (slug)は呼び出すパーシャル名に置き換わり、アクションが起動する

 * uf_get_current_page_to_string : uf_get_current_page_to_string() 関数のフィルタフックです
 * uf_title : uf_title() 関数のフィルタフックです
 * uf_body_class : uf_body_class() 関数のフィルタフックです
 * uf_css : uf_css() 関数のフックポイントです
 * uf_javascript : uf_javascript() 関数のフックポイントです
 * uf_content_more_link : uf_content_more_link() 関数のフック及び、フィルタフックです uf_content_more_link() 関数は、the_content_more_link() 関数のフィルタから呼び出されます
 * uf_comment_count : uf_get_comment_count() 関数のフィルタフックです
 * uf_pagenavi : uf_pagenavi() 関数のフック及びフィルタフックです wp_pagenavi() 関数（別途プラグインが必要）が利用出来る場合は、フィルタは実行されません
 * uf_nav_menu : uf_nav_menu() 関数のフィルタフックです
 * overload_mce_css : overload_mce_css() 関数のフィルタフックです
 * uf_custom_header : uf_custom_header() 関数のフックポイントです


## テーマが提供する関数一覧

UnifyFrameworkが提供する[関数一覧](https://github.com/Nully/UnifyFramework/wiki/UnifyFramework%E3%81%A7%E5%88%A9%E7%94%A8%E3%81%A7%E3%81%8D%E3%82%8B%E9%96%A2%E6%95%B0%E4%B8%80%E8%A6%A7)です。



UnifyFramework は独自で定義した関数がいくつか存在します。

この関数を利用することで下位バージョンの WordPress を極力サポートすることが出来ます。

 * uf_get_current_page_to_string 関数 : 現在ユーザーが閲覧しているページを文字列として返却します
 * uf_title 関数 : ページタイトルを取得します　また、AllinOneSEOPackプラグインなどが導入されていると、優先的にSEOプラグインを実行するようになります
 * uf_body_class 関数 : body タグに付加するクラス属性を取得します
 * uf_css 関数 : head 内で利用するCSSファイルを wp_enqueue_style 関数を利用し、出力制御を行ないます
 * uf_javascript 関数 : head 内又は、 body タグ終了直前に出力する script タグをwp_enqueue_script 関数を利用し出力制御を行ないます。
 * uf_content_more_link 関数 : 「もっと読む」などのリンクの出力制御を行ないます
 * uf_comment_count 関数 : 記事に対するコメントの件数を取得する関数です
 * uf_pagenavi 関数 : ページナビゲーションを表示する関数です wp_pagenavi プラグインがインストールされていると優先的に wp_pagenavi プラグインを利用します
 * uf_nav_menu 関数 : グローバルナビゲーションで利用するメニューリストを出力します また、カスタムメニューが登録されていると、登録されたカスタムメニューを表示します
 * overload_mce_css 関数 : エディタスタイルを定義するCSSファイルへのURLの出力制御を行ないます
 * uf_custom_header 関数 : カスタムヘッダを出力します

