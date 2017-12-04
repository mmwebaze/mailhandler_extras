<?php

/**
 * Implements hook_drush_command().
 */
function mailhandler_extras_drush_command() {
    $items = array();
    $items['mail-extras'] = [
        'description' => 'Test run some code.@',
        'aliases' => ['mx'],
    ];

    return $items;
}

function drush_mailhandler_extras_mail_extras(){

    $body = 'mwebaze commented on admin post in General discussion: Demo for Elias – --f403043d0f7c732b41055f4914f9 Content-Type: text/plain; charset="UTF-8" Content-Transfer-Encoding: quoted-printable This is a reply to comment ‘Now I need to see what the comment looks like with multiple responses’ – https://cop-rhho.pantheonsite.io/node/46#comment-38';
    $filteredBody = explode('quoted-printable', $body);
    print_r($filteredBody);
    print_r(explode('--', $filteredBody[0])[0].$filteredBody[1]);
}