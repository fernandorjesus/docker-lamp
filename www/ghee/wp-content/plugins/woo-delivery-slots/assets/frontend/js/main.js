(function($, document) {

    var jckwds = {

        cache: function() {
            jckwds.els = {};
            jckwds.vars = {};

            // common elements
            jckwds.els.document                           = $(document);
            jckwds.els.document_body                      = $(document.body);
            jckwds.els.reservation_table                  = $('.jckwds-reserve');
            jckwds.els.reservation_table_rows             = jckwds.els.reservation_table.find('tr');
            jckwds.els.reservation_table_prev             = $('.jckwds-prevday');
            jckwds.els.reservation_table_next             = $('.jckwds-nextday');

            jckwds.els.date_picker                        = $("#jckwds-delivery-date");
            jckwds.els.date_ymd                           = $("#jckwds-delivery-date-ymd");
            jckwds.els.timeslot_select                    = $('#jckwds-delivery-time');
            jckwds.els.timeslot_select_wrapper            = $('#jckwds-delivery-time-wrapper');
            jckwds.els.timeslot_field_row                 = $('#jckwds-delivery-time_field');

            jckwds.els.checkout_fields                    = $('#jckwds-fields');
            jckwds.els.ship_to_different_address_checkbox = $('#ship-to-different-address-checkbox');
            jckwds.els.shipping_postcode_field            = $('#shipping_postcode');
            jckwds.els.billing_postcode_field             = $('#billing_postcode');

            jckwds.els.multi_step_checkout                = $('#wizard');

            // common vars
            jckwds.vars.is_checkout                       = jckwds.els.document_body.hasClass('woocommerce-checkout');
            jckwds.vars.has_multi_step                    = jckwds.els.multi_step_checkout.length > 0 ? true : false;
            jckwds.vars.inactive_class                    = 'jckwds-fields-inactive';
            jckwds.vars.chosen_shipping_method          = false;
            jckwds.vars.default_date                      = false;

        },

        on_load: function() {

            // on load stuff here
            jckwds.cache();

            jckwds.setup_reservation_table();
            jckwds.setup_checkout();
            jckwds.setup_multi_step_checkout();

        },

        /**
         * Reservation Table: Functions to run for the reservation table
         */
        setup_reservation_table: function() {

            if( jckwds.els.reservation_table.length <= 0 ) {
                return;
            }

            jckwds.setup_prev_next();
            jckwds.setup_reserve_button();

        },

        /**
         * Checkout: Functions to run on checkout
         */
        setup_checkout: function() {

            if( !jckwds.vars.is_checkout || jckwds.vars.has_multi_step ) { return; }

            jckwds.setup_checkout_fields();
            jckwds.watch_checkout_fields();
            jckwds.watch_update_checkout();

        },

        /**
         * Checkout: If multi step checkout is enabled
         */
        setup_multi_step_checkout: function() {

            if( !jckwds.vars.is_checkout || !jckwds.vars.has_multi_step ) { return; }

            jckwds.els.multi_step_checkout.init(function(){

                jckwds.cache();
                jckwds.setup_checkout_fields();
                jckwds.watch_checkout_fields();
                jckwds.watch_update_checkout();

            });

        },

        /**
         * Reservation Table: Setup Prev/Next buttons on reservation table
         */
        setup_prev_next: function() {

            jckwds.els.reservation_table_prev.on('click', function(){

                $.each( jckwds.els.reservation_table_rows, function(){

                    var $firstVisIndex = $(this).find('.colVis:first').index();

                    if($firstVisIndex !== 1){

                        $(this).children().eq($firstVisIndex-1).addClass('colVis');
                        $(this).find('.colVis:last').removeClass('colVis');

                    }

                });

                return false;

            });

            jckwds.els.reservation_table_next.on('click', function(){

                var $lastVisIndex = $('.jckwds-reserve thead tr .colVis:last').index(),
                    $firstVisIndex = $('.jckwds-reserve thead tr .colVis:first').index();

                $.each( jckwds.els.reservation_table_rows, function(){

                    var $lastVisIndex = $(this).find('.colVis:last').index();

                    if($lastVisIndex+1 < $(this).children().length){

                        $(this).children().eq($lastVisIndex+1).addClass('colVis');
                        $(this).find('.colVis:first').removeClass('colVis');

                    }

                });

                return false;

            });

        },

        /**
         * Reservation Table: Setup reservation table reserve button
         */
        setup_reserve_button: function(){

            jckwds.els.document.on('click', '.jckwds-reserve-slot', function(){

                jckwds.activate_slot( $(this) );
                return false;

            });

        },

        /**
         * Reservation Table: Activate the clicked slot
         */
        activate_slot: function( $the_slot ){

            var $slot_parent = $the_slot.parent(),
                cell_data = $slot_parent.html(),
                slot_id = $slot_parent.attr('data-timeslot-id'),
                slot_date = $slot_parent.attr('data-timeslot-date'),
                slot_start_time = $slot_parent.attr('data-timeslot-start-time'),
                slot_end_time = $slot_parent.attr('data-timeslot-end-time'),
                $table_wrap = $the_slot.closest('.jckwds-reserve-wrap'),
                loader = '<div class="jckwds_loading"><i class="jckwds-icn-loading animate-spin"></i></div>',
                remove_reserved_data = {
                    action: 'iconic_wds_remove_reserved_slot',
                    nonce: jckwds_vars.ajax_nonce
                };

            $the_slot.hide().after( loader );

            jQuery.post( jckwds_vars.ajax_url, remove_reserved_data, function( response ) {

                if( response.success ){

                    jckwds.els.document_body.trigger('reservation_removed');

                    var reserve_data = {
                        action: 'iconic_wds_reserve_slot',
                        nonce: jckwds_vars.ajax_nonce,
                        slot_id: slot_id,
                        slot_date: slot_date,
                        slot_start_time: slot_start_time,
                        slot_end_time: slot_end_time
                    };

                    jQuery.post(jckwds_vars.ajax_url, reserve_data, function( response ) {

                        if(response.success){

                            jckwds.els.document_body.trigger('reservation_added');

                            $('td.jckwds-reserved').removeClass('jckwds-reserved');
                            $slot_parent.addClass('jckwds-reserved').html( cell_data );

                        }

                    });

                }

            });

        },

        /**
         * Checkout: Setup date/time fields
         */
        setup_checkout_fields: function() {
            jckwds.setup_date_picker();
            jckwds.setup_timeslot_select();
        },

        /**
         * Checkout: Setup date_picker
         */
        setup_date_picker: function(){

            /* Prepare holidays in an easier to read, simple array */

            var holidays = jckwds_vars.settings.holidays_holidays_holidays,
                holiday_array = [];

            $.each(holidays, function(index, value){

                holiday_array.push(value.date.date);

            });

            /* Initiate Date picker */

            jckwds.els.date_picker.datepicker({
                minDate: "+"+jckwds_vars.settings.datesettings_datesettings_minimum+"D",
                maxDate: "+"+jckwds_vars.settings.datesettings_datesettings_maximum+"D",
                beforeShowDay: function(date){

                    var formatted_date = $.datepicker.formatDate('dd/mm/yy', date);

                    if( $.inArray(formatted_date, jckwds_vars.bookable_dates) !== -1 ) {

                        if( !jckwds.vars.default_date ) { jckwds.vars.default_date = date; }

                        return [true, "", "Available"];
                    } else {
                        return [false, "", "unAvailable"];
                    }

                },
                dateFormat: jckwds_vars.settings.datesettings_datesettings_dateformat,
                onSelect: function( dateText, inst ) {

                    /* Trigger change event */
                    $(this).trigger('change');

                    if( this.value === "" ) { return; }

                    var selected_year = jckwds.pad_left(inst.selectedYear, 4),
                        selected_month = jckwds.pad_left(inst.selectedMonth+1, 2),
                        selected_day = jckwds.pad_left(inst.selectedDay, 2),
                        selected_date_ymd = [selected_year, selected_month, selected_day].join('');

                    /* Add selected date to hidden date ymd field for processing */
                    jckwds.els.date_ymd.val( selected_date_ymd );

                    // if time slots are enabled
                    if(jckwds_vars.settings.timesettings_timesettings_setup_enable){

                        /* timeslot lookup after date selection */
                        jckwds.update_timeslot_options( selected_date_ymd );

                    }

                },
                monthNames: jckwds_vars.strings.months,
                monthNamesShort: jckwds_vars.strings.months_short,
                dayNames: jckwds_vars.strings.days,
                dayNamesMin: jckwds_vars.strings.days_short,
                firstDay: jckwds.get_first_day_of_the_week()
            });

            /* Set default date to first available date */

            if( jckwds.vars.default_date ) {

                jckwds.els.date_picker.datepicker( "setDate", jckwds.vars.default_date);

            }

        },

        /**
         * Helper: Get all timeslots available on a specific date,
         *         and update the timeslots dropdown
         *
         * @param [str] [date] [format?]
         * @param [func] [callback]
         */
        update_timeslot_options: function( date, callback ){

            var $first_timeslot_option = jckwds.els.timeslot_select.find("option:eq(0)"),
                currently_selected = jckwds.els.timeslot_select.val(),
                postcode = ( jckwds.els.ship_to_different_address_checkbox.is(":checked") ? $('#shipping_postcode').val() : $('#billing_postcode').val() );

            jckwds.els.timeslot_select.find("option:gt(0)").remove();
            $first_timeslot_option.text(jckwds_vars.strings.loading);

            jckwds.els.timeslot_select.trigger('change', [ 'update_timeslots' ]);

            var ajaxData = {
                action: 'iconic_wds_get_slots_on_date',
                nonce: jckwds_vars.ajax_nonce,
                date: date,
                postcode: postcode
            };

            jQuery.post(jckwds_vars.ajax_url, ajaxData, function(response) {

                if(response.success === true){

                    $first_timeslot_option.text(jckwds_vars.strings.selectslot);
                    jckwds.els.timeslot_select.append(response.html);
	                jckwds.els.timeslot_select.val( currently_selected );

                    if( response.reservation ) {
                        if( jckwds.els.timeslot_select.find("option[value='"+response.reservation+"']").length > 0 ) {
                            jckwds.els.timeslot_select.val(response.reservation);
                        }
                    }

                } else {

                    $first_timeslot_option.text(jckwds_vars.strings.noslots);

                }

                jckwds.els.document_body.trigger('timeslots_loaded').trigger('update_checkout');
                jckwds.els.timeslot_select.trigger('change', [ 'update_timeslots' ]);

                if(callback !== undefined) {
        			callback(response);
        		}

            });

        },

        /**
         * Checkout: Refresh time slots
         *
         * @param bool force
         */
        refresh_timeslots: function( force ) {

            force = typeof force !== 'undefined' ? force : false;

            // if a reservation is in place, don't refresh timeslots

            if(
                jckwds.els.timeslot_field_row.hasClass('jckwds-delivery-time--has-reservation') &&
                force === false
            ) {
                jckwds.els.timeslot_field_row.removeClass('jckwds-delivery-time--has-reservation');
                return;
            }

            // refresh timeslots, based on date

            var date = jckwds.els.date_ymd.val();

            if( typeof date !== "undefined" && date !== "" ) {
                jckwds.update_timeslot_options( date );
            } else {
                jckwds.els.document_body.trigger('timeslots_refreshed').trigger('update_checkout');
            }

        },

        /**
         * Checkout: Watch postcode fields for changes
         */
        watch_checkout_fields: function() {

            jckwds.els.ship_to_different_address_checkbox.on('change', function(){
                jckwds.refresh_timeslots( true );
            });

            jckwds.els.billing_postcode_field.on('change', function(){
                if(
                    !jckwds.els.ship_to_different_address_checkbox.is(":checked") ||
                    jckwds.els.shipping_postcode_field.length <= 0
                ) {
                    jckwds.refresh_timeslots( true );
                }
            });

            jckwds.els.shipping_postcode_field.on('change', function(){
                jckwds.refresh_timeslots( true );
            });

        },

        /**
         * Checkout: Setup timeslot field
         *
         * Don't update checkout if we've triggered the select change ourselves
         */
        setup_timeslot_select: function() {

            // update checkout on time selection

            jckwds.els.timeslot_select.on('change', function( event, type ) {

                type = typeof type !== "undefined" ? type : false;

                if( type === "update_timeslots" ) { return; }

                jckwds.els.document_body.trigger('update_checkout');

            });

        },


        /**
         * Checkout: Watch for the update_checkout trigger
         */
        watch_update_checkout: function() {

            jckwds.els.document_body.on( 'updated_checkout', function( e, data ){

                /**
                 * If shipping method has changed
                 */

                if( data.fragments.iconic_wds.chosen_shipping_method === jckwds.vars.chosen_shipping_method ) { return; }

                /**
                 * Re-cache the selected shipping method
                 */

                jckwds.vars.chosen_shipping_method = data.fragments.iconic_wds.chosen_shipping_method;

                /**
                 * Toggle and update fields
                 */

                jckwds.toggle_date_time_fields();
                jckwds.refresh_datepicker(function() {

                    jckwds.refresh_timeslots( true );

                });

            });

            if( jckwds.els.checkout_fields.hasClass( jckwds.vars.inactive_class ) ) {

                jckwds.hide_date_time_fields();

            }

        },

        /**
         * Refresh datepicker
         *
         * Fetch new bookable dates based on shipping method selected
         * and update the cached bookable_dates variable. Then, refresh
         * the datepicker
         */
        refresh_datepicker: function( callback ) {

            bookable_dates_data = {
                action: 'iconic_wds_get_upcoming_bookable_dates',
                selected_shipping_method: jckwds.vars.chosen_shipping_method
            };

            jQuery.post( jckwds_vars.ajax_url, bookable_dates_data, function( response ) {

                jckwds_vars.bookable_dates = response.bookable_dates;
                jckwds.els.date_picker.datepicker( "refresh" );

                /**
                 * Set date if one is reserved and it is bookable
                 */
                if( jckwds_vars.reserved_slot ) {
                    if( $.inArray(jckwds_vars.reserved_slot.date.formatted, jckwds_vars.bookable_dates) !== -1 ) {

                        jckwds.els.date_picker.datepicker("setDate", jckwds_vars.reserved_slot.date.formatted);

                    }
                }

                if( typeof callback !== "undefined" ) {
                    callback( response );
                }

            });

        },

        /**
         * Clear date and time fields
         */
        clear_date_time_fields: function() {

            jckwds.els.date_ymd.val('');
            jckwds.els.date_picker.datepicker('setDate', null);
            jckwds.els.timeslot_select.children().not(':first').remove();

        },

        /**
         * Checkout: Toggle date/time fields
         */
        toggle_date_time_fields: function() {

            var activate_date_time_fields = jckwds.check_if_activated_for_shipping_method();

            if( activate_date_time_fields === false ) {

                jckwds.hide_date_time_fields();

            } else {

                jckwds.show_date_time_fields();

            }

        },

        /**
         * Checkout: Hide date/time fields
         */
        hide_date_time_fields: function() {

            var $fields_placeholder = $('.jckwds-fields-placeholder');

            if( $fields_placeholder.length <= 0 ) {

                jckwds.els.checkout_fields
                .removeClass( jckwds.vars.inactive_class )
                .hide()
                .after('<div class="jckwds-fields-placeholder"></div>')
                .appendTo('body');

                jckwds.clear_date_time_fields();

            }

        },

        /**
         * Checkout: Show date/time fields
         */
        show_date_time_fields: function() {

            var $fields_placeholder = $('.jckwds-fields-placeholder');

            if( $fields_placeholder.length > 0 ) {
                $fields_placeholder.replaceWith( jckwds.els.checkout_fields.show() );
            }

        },

        /**
         * Checkout: Check if date/time is activated for selected shipping method
         *
         * @return bool
         */
        check_if_activated_for_shipping_method: function() {

            if( jckwds.els.checkout_fields.hasClass( jckwds.vars.inactive_class ) ) {
                return false;
            }

            if( jckwds_vars.settings.general_setup_shipping_methods[0] === "any" ) {
                return true;
            }

            if(
                typeof jckwds_vars.settings.general_setup_shipping_methods === "undefined" ||
                $.isEmptyObject( jckwds_vars.settings.general_setup_shipping_methods ) ||
                $('.shipping_method').length <= 0
            ) {
                return false;
            }

            var method_found = false;

            $.each( jckwds_vars.settings.general_setup_shipping_methods, function( key, shipping_method ) {

                shipping_method = shipping_method.replace("wc_shipping_", "");

                if( jckwds.vars.chosen_shipping_method === shipping_method || jckwds.vars.chosen_shipping_method.match("^"+shipping_method) ) {
                    method_found = true;
                }
            });

            return method_found;

        },

        /**
         * Get last day of the week
         *
         * @return int
         */
        get_last_day_of_the_week: function() {

            var days = {
                'monday': 1,
                'tuesday': 2,
                'wednesday': 3,
                'thursday': 4,
                'friday': 5,
                'saturday': 6,
                'sunday': 0
            };

            if( typeof jckwds_vars.settings.datesettings_datesettings_last_day_of_week === "undefined" || typeof days[ jckwds_vars.settings.datesettings_datesettings_last_day_of_week ] === "undefined" ) { return 6; }

            return days[ jckwds_vars.settings.datesettings_datesettings_last_day_of_week ];

        },

        /**
         * Get first day of the week
         *
         * @return int
         */
        get_first_day_of_the_week: function() {

            var last_day = jckwds.get_last_day_of_the_week();

            if( last_day === 6 ) {

                return 0;

            } else {

                return last_day+1;

            }

        },

        /**
         * Pad left
         *
         * @param int number
         * @param int count
         * @param str string
         * @return str
         */
        pad_left: function(number, count, string){
            return new Array(count-String(number).length+1).join(string||'0')+number;
        }

    };

	$(window).load( jckwds.on_load );

}(jQuery, document));