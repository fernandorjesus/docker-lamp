<?php

/**
 * Class ActionScheduler_ActionFactory
 */
class ActionScheduler_ActionFactory {

	/**
	 * Return stored actions for given params.
	 *
	 * @param string                   $status The action's status in the data store.
	 * @param string                   $hook The hook to trigger when this action runs.
	 * @param array                    $args Args to pass to callbacks when the hook is triggered.
	 * @param ActionScheduler_Schedule $schedule The action's schedule.
	 * @param string                   $group A group to put the action in.
	 *
	 * @return ActionScheduler_Action An instance of the stored action.
	 */
	public function get_stored_action( $status, $hook, array $args = array(), ActionScheduler_Schedule $schedule = null, $group = '' ) {

		switch ( $status ) {
			case ActionScheduler_Store::STATUS_PENDING:
				$action_class = 'ActionScheduler_Action';
				break;
			case ActionScheduler_Store::STATUS_CANCELED:
				$action_class = 'ActionScheduler_CanceledAction';
				if ( ! is_null( $schedule ) && ! is_a( $schedule, 'ActionScheduler_CanceledSchedule' ) && ! is_a( $schedule, 'ActionScheduler_NullSchedule' ) ) {
					$schedule = new ActionScheduler_CanceledSchedule( $schedule->get_date() );
				}
				break;
			default:
				$action_class = 'ActionScheduler_FinishedAction';
				break;
		}

		$action_class = apply_filters( 'action_scheduler_stored_action_class', $action_class, $status, $hook, $args, $schedule, $group );

		$action = new $action_class( $hook, $args, $schedule, $group );

		/**
		 * Allow 3rd party code to change the instantiated action for a given hook, args, schedule and group.
		 *
		 * @param ActionScheduler_Action $action The instantiated action.
		 * @param string $hook The instantiated action's hook.
		 * @param array $args The instantiated action's args.
		 * @param ActionScheduler_Schedule $schedule The instantiated action's schedule.
		 * @param string $group The instantiated action's group.
		 */
		return apply_filters( 'action_scheduler_stored_action_instance', $action, $hook, $args, $schedule, $group );
	}

	/**
	 * Enqueue an action to run one time, as soon as possible (rather a specific scheduled time).
	 *
	 * This method creates a new action using the NullSchedule. In practice, this results in an action scheduled to
	 * execute "now". Therefore, it will generally run as soon as possible but is not prioritized ahead of other actions
	 * that are already past-due.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param string $group A group to put the action in.
	 *
	 * @return int The ID of the stored action.
	 */
	public function async( $hook, $args = array(), $group = '' ) {
		return $this->async_unique( $hook, $args, $group, false );
	}

	/**
	 * Same as async, but also supports $unique param.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param string $group A group to put the action in.
	 * @param bool   $unique Whether to ensure the action is unique.
	 *
	 * @return int The ID of the stored action.
	 */
	public function async_unique( $hook, $args = array(), $group = '', $unique = true ) {
		$schedule = new ActionScheduler_NullSchedule();
		$action   = new ActionScheduler_Action( $hook, $args, $schedule, $group );
		return $unique ? $this->store_unique_action( $action, $unique ) : $this->store( $action );
	}

	/**
	 * Create single action.
	 *
	 * @param string $hook  The hook to trigger when this action runs.
	 * @param array  $args  Args to pass when the hook is triggered.
	 * @param int    $when  Unix timestamp when the action will run.
	 * @param string $group A group to put the action in.
	 *
	 * @return int The ID of the stored action.
	 */
	public function single( $hook, $args = array(), $when = null, $group = '' ) {
		return $this->single_unique( $hook, $args, $when, $group, false );
	}

	/**
	 * Create single action only if there is no pending or running action with same name and params.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param int    $when Unix timestamp when the action will run.
	 * @param string $group A group to put the action in.
	 * @param bool   $unique Whether action scheduled should be unique.
	 *
	 * @return int The ID of the stored action.
	 */
	public function single_unique( $hook, $args = array(), $when = null, $group = '', $unique = true ) {
		$date     = as_get_datetime_object( $when );
		$schedule = new ActionScheduler_SimpleSchedule( $date );
		$action   = new ActionScheduler_Action( $hook, $args, $schedule, $group );
		return $unique ? $this->store_unique_action( $action ) : $this->store( $action );
	}

	/**
	 * Create the first instance of an action recurring on a given interval.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param int    $first Unix timestamp for the first run.
	 * @param int    $interval Seconds between runs.
	 * @param string $group A group to put the action in.
	 *
	 * @return int The ID of the stored action.
	 */
	public function recurring( $hook, $args = array(), $first = null, $interval = null, $group = '' ) {
		return $this->recurring_unique( $hook, $args, $first, $interval, $group, false );
	}

	/**
	 * Create the first instance of an action recurring on a given interval only if there is no pending or running action with same name and params.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param int    $first Unix timestamp for the first run.
	 * @param int    $interval Seconds between runs.
	 * @param string $group A group to put the action in.
	 * @param bool   $unique Whether action scheduled should be unique.
	 *
	 * @return int The ID of the stored action.
	 */
	public function recurring_unique( $hook, $args = array(), $first = null, $interval = null, $group = '', $unique = true ) {
		if ( empty( $interval ) ) {
			return $this->single_unique( $hook, $args, $first, $group, $unique );
		}
		$date     = as_get_datetime_object( $first );
		$schedule = new ActionScheduler_IntervalSchedule( $date, $interval );
		$action   = new ActionScheduler_Action( $hook, $args, $schedule, $group );
		return $unique ? $this->store_unique_action( $action ) : $this->store( $action );
	}

	/**
	 * Create the first instance of an action recurring on a Cron schedule.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param int    $base_timestamp The first instance of the action will be scheduled
	 *        to run at a time calculated after this timestamp matching the cron
	 *        expression. This can be used to delay the first instance of the action.
	 * @param int    $schedule A cron definition string.
	 * @param string $group A group to put the action in.
	 *
	 * @return int The ID of the stored action.
	 */
	public function cron( $hook, $args = array(), $base_timestamp = null, $schedule = null, $group = '' ) {
		return $this->cron_unique( $hook, $args, $base_timestamp, $schedule, $group, false );
	}


	/**
	 * Create the first instance of an action recurring on a Cron schedule only if there is no pending or running action with same name and params.
	 *
	 * @param string $hook The hook to trigger when this action runs.
	 * @param array  $args Args to pass when the hook is triggered.
	 * @param int    $base_timestamp The first instance of the action will be scheduled
	 *        to run at a time calculated after this timestamp matching the cron
	 *        expression. This can be used to delay the first instance of the action.
	 * @param int    $schedule A cro