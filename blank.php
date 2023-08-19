<?php defined( 'App' ) or die( 'BoidCMS' ); global $App, $layout ?>
<!DOCTYPE html>
<html lang="<?= noir_site_config( 'lang' ) ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $App->esc( $layout[ 'descr' ] ?? '' ) ?>">
    <meta name="keywords" content="<?= $App->esc( $layout[ 'keywords' ] ?? '' ) ?>">
    <meta name="author" content="<?= $App->esc( noir_config( 'author', false )[ 'name' ] ) ?>">
    <meta name="theme-color" content="#000000">
    <meta name="generator" content="BoidCMS">
    <title><?= $App->esc( ( $layout[ 'title' ] ?? '' ) . ' ' . noir_config( 'seperator' ) . ' ' . noir_site_config( 'title' ) ) ?></title>
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
        <h1 class="ss-center"><?= $App->esc( $layout[ 'title' ] ?? '' ) ?></h1>
        <?= $App->get_action( 'site_under_title' ) ?>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <div class="article ss-container ss-large">
          <?= ( $layout[ 'content' ] ?? '' ) ?>
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
