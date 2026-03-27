<?php

namespace SmashBalloon\Reviews\Common\Services\Upgrade\Routines;

use Smashballoon\Customizer\V2\Feed_Saver;
use Smashballoon\Customizer\V2\Feed_Locator;
use Smashballoon\Customizer\V2\DB;
use SmashBalloon\Reviews\Common\Services\FeedCacheUpdateService;
use SmashBalloon\Reviews\Common\SinglePostCache;

class V1Routine extends UpgradeRoutine {
	protected $target_version = 1.0;

	/**
	 * @var SBR_Feed_Saver
	 */
	private $feed_saver;

	/**
	 * @var Feed_Locator
	 */
	private $feed_locator;

	/**
	 * @var DB
	 */
	private $db;

	public function __construct(Feed_Saver $feed_saver, DB $DB, Feed_Locator $feed_locator) {
		$this->feed_saver = $feed_saver;
		$this->feed_locator = $feed_locator;
		$this->db = $DB;
	}

	public function run() {
		$this->create_tables();
		SinglePostCache::create_resizing_table_and_uploads_folder();
	}

	private function create_tables() {
		$this->feed_locator->create_table();
		$this->db->create_tables(true, true);
	}

	private function start_cron() {
		FeedCacheUpdateService::schedule_cron_job();
	}


}
