<?php

/*
 * This file is part of fof/stopforumspam.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace giffgaff\StopForumSpam;

use Flarum\Extend;
use FoF\Spamblock\Event\MarkedUserAsSpammer;
use Illuminate\Contracts\Events\Dispatcher;

return[
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),
    (new Extend\Locales(__DIR__.'/locale')),
    function (Dispatcher $events) {
        $events->listen(MarkedUserAsSpammer::class, Listeners\ReportSpammer::class);

        $events->subscribe(Listeners\UserRegistration::class);
    }
];
