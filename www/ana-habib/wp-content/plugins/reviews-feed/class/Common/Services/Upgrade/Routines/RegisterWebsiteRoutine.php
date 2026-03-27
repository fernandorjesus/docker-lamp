<?php

namespace SmashBalloon\Reviews\Common\Services\Upgrade\Routines;

use SmashBalloon\Reviews\Common\Integrations\SBRelay;
use SmashBalloon\Reviews\Common\Services\SettingsManagerService;
use Smashballoon\Stubs\Services\ServiceProvider;

class RegisterWebsiteRoutine extends ServiceProvider
{
    protected $target_version = 0;

    public function register()
    {
        if ($this->will_run()) {
            $this->run();
        }
    }

    protected function will_run()
    {
        $settings = get_option('sbr_settings', []);
        return !isset( $settings['access_token'] ) || $settings['access_token'] === '';
    }


    public function run()
    {
        $args = [
            'url' => get_home_url()
        ];

        $relay = new SBRelay( new SettingsManagerService() );
        $response = $relay->call(
            'auth/register' ,
            $args,
            'POST',
            false
        );
        if( isset($response['data']) && $response['data'] && isset( $response['data']['token'] ) ){
            $settings = get_option('sbr_settings', []);
            $settings['access_token'] = $response['data']['token'];
		    update_option('sbr_settings', $settings);
        }

    }
}