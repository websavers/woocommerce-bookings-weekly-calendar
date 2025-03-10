<div class="wrap woocommerce">
	<div class="icon32 icon32-woocommerce-settings" id="icon-woocommerce"><br /></div>
	<h2><?php _e('Bookings by week', 'woocommerce-bookings-weekly-calendar'); ?></h2>

	<form method="get" id="mainform" enctype="multipart/form-data" class="wc_bookings_calendar_form">
		<input type="hidden" name="post_type" value="wc_booking" />
		<input type="hidden" name="page" value="booking_calendar_weekly" />
		<input type="hidden" name="tab" value="calendar" />
		<input type="hidden" name="calendar_week" id="calendar_week" value="<?php echo date('Y-m-d', $this->time); ?>" />
		<div class="tablenav">
			<div class="filters">
				<select id="calendar-bookings-filter" name="filter_bookings" class="wc-enhanced-select" style="width:200px">
					<option value=""><?php _e('Filter Bookings', 'woocommerce-bookings-weekly-calendar'); ?></option>
					<?php if ($product_filters = $this->product_filters()) : ?>
						<optgroup label="<?php _e('By bookable product', 'woocommerce-bookings-weekly-calendar'); ?>">
							<?php foreach ($product_filters as $filter_id => $filter_name) : ?>
								<option value="<?php echo $filter_id; ?>" <?php selected($product_filter, $filter_id); ?>><?php echo $filter_name; ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endif; ?>
					<?php if ($resources_filters = $this->resources_filters()) : ?>
						<optgroup label="<?php _e('By resource', 'woocommerce-bookings-weekly-calendar'); ?>">
							<?php foreach ($resources_filters as $filter_id => $filter_name) : ?>
								<option value="<?php echo $filter_id; ?>" <?php selected($product_filter, $filter_id); ?>><?php echo $filter_name; ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endif; ?>
				</select>
			</div>
			<div class="date_selector">
			    <div>
			        <label>Week <b><?php echo date('W', $this->time); ?></b> starting:&nbsp;
			            <input class="week-picker"
			                data-datepicker.first-day="<?php echo get_option('start_of_week', 1); ?>"
			                data-datepicker.date-format="D, d M yy"
			                data-datepicker.alt-field="#calendar_week"
			                data-datepicker.alt-format="yy-mm-dd"
			                value="<?php echo date('D, j M Y', $this->time); ?> "/>
			        </label>
			        <button>Go</button>
			    </div>
			</div>
			<div class="views">
				<a class="new-booking" href="<?php echo admin_url('edit.php?post_type=wc_booking&page=create_booking'); ?>"><?php _e('New Booking', 'woocommerce-bookings-weekly-calendar'); ?></a>
				<?php
				switch ($view) :
					case self::VCUST :
						?><a class="week-product" href="<?php echo add_query_arg('view', 'week-product'); ?>"><?php _e( 'Week View by Product', 'woocommerce-bookings-weekly-calendar' ); ?></a><?php
						break;
					default:
						?><a class="week-customer" href="<?php echo add_query_arg('view', 'week-customer'); ?>"><?php _e( 'Week View by Customer', 'woocommerce-bookings-weekly-calendar' ); ?></a><?php
				endswitch;
				?>

				<a class="day" href="<?php echo add_query_arg( 'view', 'day' ); ?>"><?php _e( 'Day View', 'woocommerce-bookings' ); ?></a>
				<a class="month" href="<?php echo add_query_arg( 'view', 'month' ); ?>"><?php _e( 'Month View', 'woocommerce-bookings' ); ?></a>
			</div>
		</div>

		<table class="wc_bookings_calendar wc_bookings_calendar_weekly widefat">
			<caption>
				<a class="prev"
					href="<?php echo add_query_arg('calendar_week', date('Y-m-d', strtotime('-7 days', $this->time))); ?>">&#x21e6;</a>
				Week <b><?php echo date('W', $this->time); ?></b> starting <b><?php echo date('D, j M Y', $this->time); ?></b>
				<a class="next"
					href="<?php echo add_query_arg('calendar_week', date('Y-m-d', strtotime('+7 days', $this->time))); ?>">&#x21e8;</a>
			</caption>
			<thead>
				<tr>
					<th width="12.5%"><?php _e($view == self::VCUST ? 'Customer' : 'Product', 'woocommerce-bookings-weekly-calendar'); ?></th>
					<?php for ($ii = get_option('start_of_week', 1); $ii < get_option('start_of_week', 1) + 7; $ii ++) : ?>
						<th width="12.5%"><?php echo date_i18n(_x('l', 'date format', 'woocommerce-bookings-weekly-calendar'), strtotime("next sunday +{$ii} day")); ?></th>
					<?php endfor; ?>
				</tr>
			</thead>
			<tbody>
				<?php require("fragments/html-calendar-$view.php"); ?>
			</tbody>
		</table>
	</form>
</div>
