<?php
/**
*** Root Config
*** @since 2021.10.18
**/



// Display Errors
ini_set( 'display_errors', 'On' ); error_reporting( E_ALL );



/**
*** Variables
*** ---------- ---------- --------- ---------- ---------- */

// サイトのURL
define ( 'SITE_URL',  'http://framework/' );

// サイトの名称
define ( 'SITE_NAME', 'Framework' );

// 製作者の名前
define ( 'AUTHOR',    '株式会社 寿エンタープライズ' );

/**
*** ページタイトルとディスクリプションのデフォルト変数
*** @return ページタイトル 空白の場合はサイト名称だけになる
*** @return 共通のディスクリプション
*/
$PAGE_ARGS_DEFAULT = [
  'title'       => '共通のタイトル',
  'description' => '共通のディスクリプション',
];



/**
*** パスを設定する
*** ---------- ---------- --------- ---------- ---------- */

// ROOT PATH
define( 'ROOT_PATH', __DIR__ );

// ROOT ABSOLUTE PATH
$ROOT_ABS_PATH = str_replace( $_SERVER['DOCUMENT_ROOT'], '', __DIR__ );
define( 'ROOT_ABS_PATH', $ROOT_ABS_PATH );

// ROOT INCLUDE DIRECTORY PATH
$ROOT_INCLUDE_PATH = ROOT_PATH . '/includes';
define( 'ROOT_INCLUDE_PATH', $ROOT_INCLUDE_PATH );

// ROOT ASSETS DIRECTORY PATH
$ROOT_ASSETS_PATH = ROOT_PATH . '/assets';
define( 'ROOT_ASSETS_PATH', $ROOT_ASSETS_PATH );



/**
*** Functions
*** ---------- ---------- --------- ---------- ---------- */

// 開発用
function devcode( $data )
{
  echo '<pre><code>'; var_dump($data); echo '</code></pre>';
}

// HTML エスケープ
function hsc( $strings )
{
  return htmlspecialchars( $strings, ENT_QUOTES, 'UTF-8' );
}

/**
*** 空判定
*** NULL or EMPTY
**/
if( ! function_exists('is_nullorempty') ) {
  function is_nullorempty($obj)
  {
    if($obj === 0 || $obj === '0'){
      return false;
    }
    return empty($obj);
  }
}



/**
***  ページタイトルの表記
***  @return ページタイトル
 */

function get_page_title()
{
  global $PAGE_ARGS;

  if ( ! $PAGE_ARGS['title'] ) {
    return htmlspecialchars( SITE_NAME, ENT_QUOTES, 'UTF-8' );
  } else {
    return htmlspecialchars( $PAGE_ARGS['title'], ENT_QUOTES, 'UTF-8' ) . '｜' . htmlspecialchars( SITE_NAME, ENT_QUOTES, 'UTF-8' );
  }
  return false;
}



/**
***  ディスクリプションの表記
***  @return ディスクリプション
 */
function get_description()
{
  global $PAGE_ARGS;
  global $PAGE_ARGS_DEFAULT;

  if( $PAGE_ARGS['description'] === '' || !isset($PAGE_ARGS['description']) || empty($PAGE_ARGS['description']) ){
    return $PAGE_ARGS_DEFAULT['description'];
  }
  return $PAGE_ARGS['description'];
}



/**
***  INCLUDE ディレクトリにある指定されたファイルのパスを出力する
***  @param ファイル名（拡張子は省略）
***  @return string
 */
function get_include( $file )
{
  global $PAGE_ARGS;

  // 拡張子があるかチェックする
  $extension = pathinfo( $file, PATHINFO_EXTENSION );
  // 拡張子がない場合は .php をつける
  if( !$extension ){
    $file = $file . '.php';
  }
  // 指定されたファイルのパスを出力する
  return ROOT_INCLUDE_PATH . '/' . $file;
}



// SITE_URL
function get_site_url()
{
  return SITE_URL;
}

// AUTHOR
function get_author()
{
  return AUTHOR;
}



/**
***  ルートディレクトリのフルパスを出力
***  @return string
 */

function get_full_path()
{
  return ROOT_PATH;
}



/**
***  ルートディレクトリの相対パスを出力
***  @return string
 */

function get_absolute_path()
{
  // ルートディレクトリの相対パス
  $path = ROOT_ABS_PATH;
  // root.config.php のあるフルパスから DOCUMENT ROOT を差し引いたときに何もない場合は '/' のみを返す
  if ( empty( $path ) ) { $path = '/'; }
  return $path;
}



function addition_files($str)
{
  global $PAGE_ARGS;

  // 引数の文字列をチェック
  if( $str !== 'css' && $str !== 'js' ){ return null; }

  // 挿入元の文字列を作成
  if( $str === 'css' ){
    $string = '<link rel="stylesheet" href="#">';
  }
  elseif( $str === 'js' ){
    $string = '<script src="#"></script>';
  }

  foreach( $PAGE_ARGS[$str] as $value ){
    // 空白の場合はなにもしない
    if( is_nullorempty($value) ){ return null; }
    //var_dump(strpos( $value, '/' ));
    // 値に「/」がない場合(ファイル名)
    if( strpos( $value, '/' ) === false ){
      $path = get_absolute_path() . 'assets/' . $str . '/' . $value;
    } else {
      $path = $value;
    }

    echo str_replace('#', $path, $string) . "\r\n";
  }

  return;
}
