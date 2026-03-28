<?php

$context         = Timber::context();
$context['post'] = Timber::get_post();
Timber::render( '/templates/front-page.twig', $context );