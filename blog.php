<?php defined( 'App' ) or die( 'BoidCMS' ); global $App ?>
<!DOCTYPE html>
<html lang="<?= noir_site_config( 'lang' ) ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= noir_site_config( 'descr' ) ?>">
    <meta name="keywords" content="<?= noir_site_config( 'keywords' ) ?>">
    <meta name="author" content="<?= $App->esc( noir_config( 'author', false )[ 'name' ] ) ?>">
    <meta name="theme-color" content="#000000">
    <meta name="generator" content="BoidCMS">
    <title><?= noir_blog_title() ?></title>
    <?php include ( __DIR__ . '/parts/head.php' ) ?>
    <?= $App->get_action( 'site_head' ) ?>
  </head>
  <body>
    <?= $App->get_action( 'site_top' ) ?>

    <!-- Header -->
    <?php include ( __DIR__ . '/parts/header.php' ) ?>
    <!-- /Header -->

    <!-- Content -->
    <main id="content" class="ss-m-5 ss-mx-auto">
      <div class="ss-container">
        <?= $App->get_action( 'home_top' ) ?>
        <h1 class="ss-hide"><?= noir_site_config( 'title' ) ?></h1>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <h2 class="ss-center"><?= $App->get_filter( 'Recent Posts', 'noir', 'recent-posts' ) ?></h2>
        <hr class="ss-hr ss-mobile ss-w-8 ss-auto">
        <?php $recent_posts = noir_recent_posts() ?>
        <?php if ( empty( $recent_posts ) ): ?>
          <p class="ss-xlarge ss-center">
            <?= $App->get_filter( 'No recent posts!', 'noir', 'no-recent-posts' ) ?>
          </p>
        <?php endif ?>
        <?php foreach ( $recent_posts as $slug => $post ): ?>
        <article class="article ss-container ss-large">
          <?= $App->get_action( 'post_list_top', $slug ) ?>
          <h3 class="ss-h2 ss-center ss-bold"><a href="<?= $App->url( $slug ) ?>" class="ss-hvr-no-underline"><?= $App->esc( $post[ 'title' ] ) ?></a></h3>
          <p class="ss-center ss-medium"><?= $App->get_filter( 'By', 'noir', 'by' ) ?> <a href="<?= $App->esc( noir_config( 'author', false )[ 'link' ] ) ?>" class="ss-hvr-no-underline ss-bold"><?= $App->esc( noir_config( 'author', false )[ 'name' ] ) ?></a> &bull; <time datetime="<?= $post[ 'date' ] ?>"><?= date( 'F j, Y', strtotime( $post[ 'date' ] ) ) ?></time></p>
          <p><?= noir_post_excerpt( $slug ) ?></p>
          <p class="ss-center ss-medium"><b><a href="<?= $App->url( $slug ) ?>"><?= $App->get_filter( 'Read more &rarr;', 'noir', 'read-more' ) ?></a></b></p>
          <?= $App->get_action( 'post_list_end', $slug ) ?>
        </article>
        <hr>
        <?php endforeach ?>
        <div class="ss-my-5">
          <p class="ss-h3 ss-center ss-wide">
            <?php $page = noir_pagination_page() ?>
            <?php $total = noir_pagination_total() ?>
            <?php for ( $i = 1; $i <= $total; $i++ ): ?>
            <a href="?page=<?= $i ?>"<?= $page === $i ? '' : ' rel="' . ( $page < $i ? 'next' : 'prev' ) . '" class="ss-no-underline"' ?>><?= $i ?></a>
            <?php endfor ?>
          </p>
        </div>
        <?= $App->get_action( 'home_end' ) ?>
      </div>
    </main>
    <!-- /Content -->

    <!-- Footer -->
    <?php include ( __DIR__ . '/parts/footer.php' ) ?>
    <!-- /Footer -->

    <?= $App->get_action( 'site_end' ) ?>
  </body>
</html>
