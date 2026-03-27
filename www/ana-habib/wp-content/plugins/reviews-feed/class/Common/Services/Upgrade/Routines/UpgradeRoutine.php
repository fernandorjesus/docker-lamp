<?php

namespace SmashBalloon\Reviews\Common\Services\Upgrade\Routines;

use Smashballoon\Stubs\Services\ServiceProvider;

class UpgradeRoutine extends ServiceProvider{
    protected $target_version = 0;

    public function register()
    {
        if ($this->will_run()) {
            $this->run();
            $this->update_db_version();
        }
    }

    protected function will_run()
    {
        $current_schema = (float)get_option('sbr_db_version', 0);

        return $current_schema < (float)$this->target_version;
    }

    protected function update_db_version()
    {
        update_option('sbr_db_version', $this->target_version);
    }

    public function run()
    {
    //implement your own version
    }
}