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
    <?php if ( $post_thumb = noir_page_data( 'thumb', false ) ): ?>
    <?php $post_thumb_link = $App->url( 'media/' . $post_thumb ) ?>
    <?php $post_thumb_size = getimagesize( $App->root( 'media/' . $post_thumb ) ) ?>
    <link rel="preload" as="image" href="<?= $post_thumb_link ?>">
    <?php endif ?>
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
        <?= $App->get_action( 'post_top' ) ?>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <h1 class="ss-center"><?= noir_page_data( 'title' ) ?></h1>
        <p class="ss-center"><?= $App->get_filter( 'By', 'noir', 'by' ) ?> <a href="<?= $App->esc( noir_config( 'author', false )[ 'link' ] ) ?>" class="ss-hvr-no-underline ss-bold"><?= $App->esc( noir_config( 'author', false )[ 'name' ] ) ?></a> &bull; <time datetime="<?= noir_page_data( 'date', false ) ?>"><?= date( 'F j, Y', strtotime( noir_page_data( 'date', false ) ) ) ?></time></p>
        <?= $App->get_action( 'site_under_title' ) ?>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <div class="article ss-container ss-large">
          <?php if ( $post_thumb ): ?>
          <div class="ss-center">
            <img src="<?= $post_thumb_link ?>" alt="<?= noir_page_data( 'title' ) ?>" <?= $post_thumb_size[3] ?>>
            <hr class="ss-hr">
          </div>
          <?php endif ?>
          <?= $App->get_action( 'post_content_top' ) ?>
          <?= noir_page_data( 'content', false ) ?>
          <?= $App->get_action( 'post_content_end' ) ?>
        </div>
        <?= $App->get_action( 'post_end' ) ?>
      </div>
    </main>
    <!-- End Content -->

    <!-- Footer -->
    <?php include ( __DIR__ . '/parts/footer.php' ) ?>
    <!-- End Footer -->

    <?= $App->get_action( 'site_end' ) ?>
  </body>
</html>
