<!DOCTYPE html>
<html lang="ja">
<head>
<?php include( get_include('analyticstracking') ); // Google Analytics ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title><?= get_page_title(); ?></title>
<meta name="description" content="<?= get_description(); ?>">
<meta name="author" content="<?= get_site_url(); ?>">
<link rel="canonical" href="<?= get_author(); ?>">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="<?= get_absolute_path(); ?>/assets/css/style.css"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/yakuhanjp@3.4.1/dist/css/yakuhanjp.min.css">
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<link rel="stylesheet" href="./assets/css/style.css">
<?php // 追加したい CSS ファイル
  addition_files('css');
?>
</head>
