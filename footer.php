<?php defined( 'App' ) or die( 'BoidCMS' ); global $App ?>
<footer id="footer" class="ss-bottom ss-center">
  <hr class="ss-hr">
  <div class="ss-container ss-large ss-my-2 ss-py-5">
    <p><?= $App->get_filter( noir_site_config( 'footer', false ), 'default' ) ?></p>
    <?php if ( noir_config( 'attribution', false ) ): ?>
    <p><?= $App->get_filter( 'Proudly powered by', 'noir', 'proudly-powered-by' ) ?> <a href="https://boidcms.github.io" target="_blank" rel="nofollow" class="ss-hvr-no-underline">BoidCMS</a></p>
    <?php endif ?>
    <?php if ( $footer = $App->get_action( 'site_footer' ) ): ?>
    <hr class="ss-hr ss-w-2 ss-auto">
    <?= $footer ?>
    <?php endif ?>
  </div>
</footer>
