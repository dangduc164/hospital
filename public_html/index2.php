<?php
// Loading Root Config File
// include_once( $_SERVER['DOCUMENT_ROOT'] . '/root.config.php' );
include_once('root.config.php');

// ページタイトルとディスクリプション
$PAGE_ARGS = [
    'title'       => '',
    'description' => '',
    'css'         => [], // 追加したい CSS ファイル（ファイル名を配列で記述）
    'js'          => []  // 追加したい JavaScript ファイル（ファイル名を配列で記述）
];
// Loading META
include(get_include('metasrc'));
?>

<body class="page-content">
    <div class="box-content">
        <?php include(get_include('header-2')); // Loading header 
        ?>

        <?php
        $page_layout = isset($_GET['page_layout']) ? $_GET['page_layout'] : '';
        switch ($page_layout) {
            case 'access':
                include_once('access.php');
                break;

            case 'contact':
                include_once('contact.php');
                break;

            case 'info':
                include_once('info.php');
                break;

            case 'link':
                include_once('link.php');
                break;

            case 'privacy':
                include_once('privacy.php');
                break;

            case 'stay':
                include_once('stay.php');
                break;

<<<<<<< HEAD
            case 'rule1':
                include_once('stay/rule1.php');
                break;

=======
>>>>>>> 87d38f6fea2910e7c98c8ec5e6f8ea1b0b2bb1fc
            case 'rule2':
                include_once('stay/rule2.php');
                break;

<<<<<<< HEAD
            case 'req':
                include_once('stay/req.php');
                break;
=======

>>>>>>> 87d38f6fea2910e7c98c8ec5e6f8ea1b0b2bb1fc
            default:
                include_once('access.php');
        }
        ?>

        <script src="./assets/js/jquery.slim.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/main.js"></script>

        <?php include(get_include('footer-2')); // Loading footer 
        ?>
    </div>
</body>