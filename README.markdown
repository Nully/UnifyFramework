# WordPress Theme 'UnifyFramework' Version 1.0-DEV

========================= !! 現在は開発バージョンです !! ==========================


## UnifyFrameworkとは

UnifyFramework は WordPress (http://wordpress.org/) の専用テーマです。

テーマをもっと統合的に（Unify）作成しよう！をモットーに作成されているテーマです。

レイアウトに利用しているCSSは960 GridSystemを利用しているので、カラム割はもちろん、多彩なレイアウトを表現できると思います。

最新のリビジョンを閲覧、取得する場合は、

>
>    URL: http://github.com/Nully/UnifyFramework
>

から御覧ください。


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

UnifyFramework は WordPress バージョン2.9以降から利用出来ます。

将来的に下位バージョンとなる WordPress のサポートを撃ち切る可能性がありますので予めご理解ください。


## フィルタ、アクションフックポイントについて

UnifiFramework はフィルタ、及びアクションフックポイントを多数盛り込んでいます。

そのフックポイントを以下に示します。

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


## オリジナル提供関数

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


## お問い合わせ等

メールにて連絡を受け付けています。

nully.nl < at > gmail.com
