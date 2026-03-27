<?php

/**
 * Class ActionScheduler_Action
 */
class ActionScheduler_Action {
	protected $hook = '';
	protected $args = array();
	/** @var ActionScheduler_Schedule */
	protected $schedule = NULL;
	protected $group = '';

	public function __construct( $hook, array $args = array(), ActionScheduler_Schedule $schedule = NULL, $group = '' ) {
		$schedule = empty( $schedule ) ? new ActionScheduler_NullSchedule() : $schedule;
		$this->set_hook($hook);
		$this->set_schedule($schedule);
		$this->set_args($args);
		$this->set_group($group);
	}

	/**
	 * Executes the action.
	 *
	 * If no callbacks are registered, an exception will be thrown and the action will not be
	 * fired. This is useful to help detect cases where the code responsible for setting up
	 * a scheduled action no longer exists.
	 *
	 * @throws Exception If no callbacks are registered for this action.
	 */
	public function execute() {
		$hook = $this->get_hook();

		if ( ! has_action( $hook ) ) {
			throw new Exception(
				sprintf(
					/* translators: 1: action hook. */
					__( 'Scheduled action for %1$s will not be executed as no callbacks are registered.', 'action-scheduler' ),
					$hook
				)
			);
		}

		do_action_ref_array( $hook, array_values( $this->get_args() ) );
	}

	/**
	 * @param string $hook
	 */
	protected function set_hook( $hook ) {
		$this->hook = $hook;
	}

	public function get_hook() {
		return $this->hook;
	}

	protected function set_schedule( ActionScheduler_Schedule