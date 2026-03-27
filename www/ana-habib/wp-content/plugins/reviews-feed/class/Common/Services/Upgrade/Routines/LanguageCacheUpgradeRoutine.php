<?php

namespace SmashBalloon\Reviews\Common\Services\Upgrade\Routines;

use Smashballoon\Stubs\Services\ServiceProvider;

class LanguageCacheUpgradeRoutine extends ServiceProvider{
    protected $target_version = 1.1;
	public const POSTS_TABLE_NAME = 'sbr_reviews_posts';

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
	    global $wpdb;

	    $table_name = esc_sql( $wpdb->prefix . self::POSTS_TABLE_NAME );

	    $wpdb->query( "ALTER TABLE $table_name ADD COLUMN lang VARCHAR(1000) DEFAULT '' NOT NULL" );
	    $wpdb->query( "ALTER TABLE $table_name ADD INDEX provider_lang (provider(140),lang(51))" );
	}
}