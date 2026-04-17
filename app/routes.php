<?php
// [PHASE 2] ToutLike — Table de routing centralisée
// Chaque route définit : auth requise (true/false), et si c'est une route admin

return [
    // === Routes publiques (pas besoin d'être connecté) ===
    'auth'           => ['auth' => false],
    'signup'         => ['auth' => false],
    'resetpassword'  => ['auth' => false],
    'confirm_email'  => ['auth' => false],
    'services'       => ['auth' => false],
    'service'        => ['auth' => false],
    'blog'           => ['auth' => false],
    'about-us'       => ['auth' => false],
    'about'          => ['auth' => false],
    'contact-us'     => ['auth' => false],
    'contactus'      => ['auth' => false],
    'faq'            => ['auth' => false],
    'terms'          => ['auth' => false],
    'how-it-works'   => ['auth' => false],
    'news'           => ['auth' => false],
    'api'            => ['auth' => false],  // API doc page (GET) et API endpoint (POST)
    'payment'        => ['auth' => false],  // callbacks paiement
    '404'            => ['auth' => false],
    'logout'         => ['auth' => false],
    'giveaways'      => ['auth' => false],
    'install'        => ['auth' => false],
    'cur'            => ['auth' => false],

    // === Routes authentifiées (utilisateur connecté) ===
    'neworder'       => ['auth' => true],
    'orders'         => ['auth' => true],
    'order'          => ['auth' => true],
    'massorder'      => ['auth' => true],
    'addfunds'       => ['auth' => true],
    'tickets'        => ['auth' => true],
    'account'        => ['auth' => true],
    'dripfeeds'      => ['auth' => true],
    'subscriptions'  => ['auth' => true],
    'refer'          => ['auth' => true],
    'affiliates'     => ['auth' => true],
    'refill'         => ['auth' => true],
    'child-panels'   => ['auth' => true],
    'transferfunds'  => ['auth' => true],
    'earn'           => ['auth' => true],
    'kupon'          => ['auth' => true],
    'integrations'   => ['auth' => true],
    'broadcast'      => ['auth' => true],
    'updates'        => ['auth' => true],
    'update'         => ['auth' => true],
    'dashboard'      => ['auth' => true],
    'success'        => ['auth' => true],
    'ajax_data'      => ['auth' => true],

    // === Route admin ===
    'admin'          => ['auth' => true, 'admin' => true],
];
