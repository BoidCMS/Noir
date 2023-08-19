<?php defined( 'App' ) or die( 'BoidCMS' ); global $App ?>
<header class="ss-top">
  <div class="ss-bg-black ss-white ss-large">
    <div id="menu" class="ss-container ss-bar ss-py-2">
      <nav class="ss-dropdown-hvr ss-white ss-pull-left ss-bar-item ss-p-0 ss-m-4">
        <button class="ss-button ss-bg-black ss-xlarge ss-border">&bull;&bull;&bull;</button>
        <ul class="ss-dropdown-content ss-list ss-card">
          <?php foreach ( noir_config( 'menu', false ) as $menu ): ?>
          <li><a href="<?= $App->esc( $menu[ 'link' ] ) ?>" class="ss-button"><?= $App->esc( $menu[ 'text' ] ) ?></a></li>
          <?php endforeach ?>
          <?= $App->get_action( 'site_nav', '<li><a href="%s" class="ss-button">%s</a></li>' ) ?>
        </ul>
      </nav>
      <div class="ss-pull-right ss-bar-item ss-p-0 ss-m-3 ss-mt-4">
        <a href="<?= $App->url() ?>" class="ss-button ss-xlarge ss-border">
          <?= $App->get_filter( noir_site_config( 'title' ), 'noir', 'site-title' ) ?>
        </a>
      </div>
    </div>
  </div>
</header>
