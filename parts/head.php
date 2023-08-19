<?php defined( 'App' ) or die( 'BoidCMS' ); global $App ?>
<link rel="canonical" href="<?= $App->url( ( $App->page === 'home' && ! $App->get( 'blog' ) ) ? '' : $App->page ) ?>">
<link rel="preload" as="font" href="<?= $App->theme( 'style/poppins_latin.woff2', false ) ?>" type="font/woff2" crossorigin>
<link rel="preload" as="font" href="<?= $App->theme( 'style/poppins_latin_ext.woff2', false ) ?>" type="font/woff2" crossorigin>
<link rel="preload stylesheet" as="style" href="https://cdn.jsdelivr.net/npm/sysacss@0.1.0/sysa.min.css">
<link rel="preload stylesheet" as="style" href="<?= $App->theme( 'style/style.css', false ) ?>">
<?= $App->get_filter( '<link rel="shortcut icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA2NDAgNjQwIj48cGF0aCBmaWxsPSIjMDBiY2Q0IiBkPSJNMzIwIDExYTMwOSAzMDkgMCAxIDEgMCA2MTggMzA5IDMwOSAwIDAgMSAwLTYxOHoiLz48cGF0aCBmaWxsPSIjZmZmIiBkPSJNNDcxIDM1MHYtMjJoLTQ1di0yM2gyM3YtMjNoMjJ2LTkxaC0yMnYtMjJoLTIzdi0yM0gxNDZ2NjhoMjN2MjIwaC0yM3Y2MGgzMDN2LTIzaDIydi0yMmgyM3YtOTloLTIzem0tNzUgNjFoLTIzdjIzSDI0NHYtNjloMTI5djIzaDIzdjIzem0wLTE1OWgtMjN2MjNIMjQ0di02OWgxMjl2MjNoMjN2MjN6Ii8+PC9zdmc+Cg==">', 'favicon' ) ?>
