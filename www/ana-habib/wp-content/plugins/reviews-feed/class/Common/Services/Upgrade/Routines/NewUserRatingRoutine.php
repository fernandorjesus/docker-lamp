<?php
namespace SmashBalloon\Reviews\Common\Services\Upgrade\Routines;

use Smashballoon\Stubs\Services\ServiceProvider;

class NewUserRatingRoutine extends ServiceProvider{
    protected $target_version = 1.3;

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
	    $sbr_statuses_option = get_option( 'sbr_statuses', array() );
		$sbr_rating_notice = get_option( 'sbr_rating_notice', '' );

		if ( $sbr_rating_notice !== 'dismissed' ) {
			$sbr_statuses_option['first_install'] = empty( $sbr_statuses_option['first_install'] ) ? time() : $sbr_statuses_option['first_install'];
			$sbr_rating_notice_option = get_option( 'sbr_rating_notice', false );
			$sbr_rating_notice_waiting = get_transient( 'reviews_feed_rating_notice_waiting' );
			if ( $sbr_rating_notice_waiting === false && $sbr_rating_notice_option === false ) {
				$time = 2 * WEEK_IN_SECONDS;
				set_transient( 'reviews_feed_rating_notice_waiting', 'waiting', $time );
				update_option( 'sbr_rating_notice', 'pending', false );
			}
			update_option( 'sbr_statuses', $sbr_statuses_option, false );
		}
		update_option( 'sbr_db_version', $this->target_version );
	}
}