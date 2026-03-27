<?php

namespace SmashBalloon\Reviews\Common\Services\Upgrade\Routines;

use SmashBalloon\Reviews\Common\PostAggregator;
use Smashballoon\Stubs\Services\ServiceProvider;

class ClearReviewsDuplicateRoutine extends ServiceProvider{
    protected $target_version = 1.2;

    public function register()
    {
        if ($this->will_run()) {
            $this->update_db_version();
            $this->run();
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
	    PostAggregator::remove_duplicated_posts_routine();
	}
}