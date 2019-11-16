<?php

namespace giffgaff\StopForumSpam\Util;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;
use giffgaff\StopForumSpam\StopForumSpam;

class Processor
{
    protected $sfs;
    protected $settings;

    public function __construct(StopForumSpam $sfs, SettingsRepositoryInterface $settings)
    {
        $this->sfs = $sfs;
        $this->settings = $settings;
    }

    public function processRegistration($user):void
    {
        if ($this->isKnownSpammer($user->username, $user->email)) {
            // Handle spammer...
        }
    }

    private function isKnownSpammer(string $username, string $email): bool
    {
        $ipAddress = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

        $body = null;

        try {
            $body = $this->sfs->check([
                'ip'       => $ipAddress,
                'email'    => $email,
                'username' => $username,
            ]);
        } catch (\Throwable $e) {
            return false;
         }

        if ($body->success === 1) {
            unset($body->success);
            $frequency = 0;

            foreach ($body as $key => $value) {
                if ((int) $this->settings->get("giffgaff-stopforumspam.$key")) {
                    $frequency += $value->frequency;
                }
            }

            if ($frequency !== 0 && $frequency >= (int) $this->settings->get('giffgaff-stopforumspam.frequency')) {
                //this is a known spammer
                return true;
            }
        }

        return false;
    }
}
