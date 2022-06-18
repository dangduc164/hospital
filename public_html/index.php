<?php
// Loading Root Config File
// include_once( $_SERVER['DOCUMENT_ROOT'] . '/root.config.php' );
include_once('root.config.php' );

// ページタイトルとディスクリプション
$PAGE_ARGS = [
  'title'       => '',
  'description' => '',
  'css'         => [], // 追加したい CSS ファイル（ファイル名を配列で記述）
  'js'          => []  // 追加したい JavaScript ファイル（ファイル名を配列で記述）
];
// Loading META
include( get_include('metasrc') );
?> 

<body id="index">

<?php include( get_include('header') ); // Loading header ?>

<?php
    $page_layout = isset($_GET['page_layout'])?$_GET['page_layout']:'';

    switch($page_layout){
        case 'home': include_once('home.php');
        break;
        
    
    default: include_once('home.php');
    }
?>


<script src="./assets/js/jquery.slim.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/main.js"></script>

<?php include( get_include('footer') ); // Loading footer ?>
