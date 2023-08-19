<?php defined( 'App' ) or die( 'BoidCMS' ); global $App ?>
<!DOCTYPE html>
<html lang="<?= noir_site_config( 'lang' ) ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= noir_page_description() ?>">
    <meta name="keywords" content="<?= noir_page_data( 'keywords' ) ?>">
    <meta name="author" content="<?= $App->esc( noir_config( 'author', false )[ 'name' ] ) ?>">
    <meta name="theme-color" content="#000000">
    <meta name="generator" content="BoidCMS">
    <title><?= noir_page_title() ?></title>
    <?php include ( __DIR__ . '/parts/head.php' ) ?>
    <?= $App->get_action( 'site_head' ) ?>
  </head>
  <body>
    <?= $App->get_action( 'site_top' ) ?>

    <!-- Header -->
    <?php include ( __DIR__ . '/parts/header.php' ) ?>
    <!-- End Header -->

    <!-- Content -->
    <main id="content" class="ss-m-5 ss-mx-auto">
      <div class="ss-container">
        <?= $App->get_action( 'page_top' ) ?>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <h1 class="ss-center"><?= noir_page_data( 'title' ) ?></h1>
        <?= $App->get_action( 'site_under_title' ) ?>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <div class="article ss-container ss-large">
          <?= noir_page_data( 'content', false ) ?>
        </div>
        <?= $App->get_action( 'page_end' ) ?>
      </div>
    </main>
    <!-- End Content -->

    <!-- Footer -->
    <?php include ( __DIR__ . '/parts/footer.php' ) ?>
    <!-- End Footer -->

    <?= $App->get_action( 'site_end' ) ?>
  </body>
</html>
