
var calendar = {

	init: function(ajax) {

      calendar.startCalendar();

	},

  startCalendar: function() {
    var mon = 'Mon';
		var tue = 'Tue';
		var wed = 'Wed';
		var thur = 'Thur';
		var fri = 'Fri';
		var sat = 'Sat';
		var sund = 'Sun';

		/**
		 * Get current date
		 */
		var d = new Date();
		var strDate = yearNumber + "/" + (d.getMonth() + 1) + "/" + d.getDate();
		var yearNumber = (new Date).getFullYear();
		/**
		 * Get current month and set as '.current-month' in title
		 */
		var monthNumber = d.getMonth() + 1;

		function GetMonthName(monthNumber) {
			var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
			return months[monthNumber - 1];
		}

		setMonth(monthNumber, mon, tue, wed, thur, fri, sat, sund);

		function setMonth(monthNumber, mon, tue, wed, thur, fri, sat, sund) {
			jQuery('.month').text(GetMonthName(monthNumber) + ' ' + yearNumber);
			jQuery('.month').attr('data-month', monthNumber);
			jQuery('.month').attr('data-year', yearNumber);
			printDateNumber(monthNumber, mon, tue, wed, thur, fri, sat, sund);
		}



		jQuery('.btn-next').on('click', function(e) {
			var monthNumber = jQuery('.month').attr('data-month');
			if (monthNumber > 11) {
				
				jQuery('.month').attr('data-month', '0');
				var monthNumber = jQuery('.month').attr('data-month');
				yearNumber = yearNumber + 1;
				setMonth(parseInt(monthNumber) + 1, mon, tue, wed, thur, fri, sat, sund);
			} else {
				
				setMonth(parseInt(monthNumber) + 1, mon, tue, wed, thur, fri, sat, sund);

			};
			var next_month = parseInt(monthNumber) + 1;
			var event_day = jQuery('td.event').attr('date-day');
			jQuery('div.day-event[data-number="1"]').css({ 'display': "none" });
			jQuery('.day-event[date-year="' + yearNumber + '"][date-month="' + next_month + '"][date-day="' + event_day + '"]').css({ 'display': "block" });


		});

		jQuery('.btn-prev').on('click', function(e) {
			var monthNumber = jQuery('.month').attr('data-month');
			if (monthNumber < 2) {
				jQuery('.month').attr('data-month', '13');
				var monthNumber = jQuery('.month').attr('data-month');
				yearNumber = yearNumber - 1;
				setMonth(parseInt(monthNumber) - 1, mon, tue, wed, thur, fri, sat, sund);
				
			} else {
				setMonth(parseInt(monthNumber) - 1, mon, tue, wed, thur, fri, sat, sund);
				
			};
			jQuery('div.day-event[data-number="1"]').css({ 'display': "none" });
			var prev_month = parseInt(monthNumber) - 1;
			var event_day_prev = jQuery('td.event').attr('date-day');
			jQuery('.day-event[date-year="' + yearNumber + '"][date-month="' + prev_month + '"][date-day="' + event_day_prev + '"]').css({ 'display': "block" });



		});



		/**
		 * Get all dates for current month
		 */

		function printDateNumber(monthNumber, mon, tue, wed, thur, fri, sat, sund) {

			jQuery(jQuery('tbody.event-calendar tr')).each(function(index) {
				jQuery(this).empty();
			});

			jQuery(jQuery('thead.event-days tr')).each(function(index) {
				jQuery(this).empty();
			});
			
			

			function getDaysInMonth(month, year) {

				// Since no month has fewer than 28 days
				var date = new Date(year, month, 1);
				var days = [];
				while (date.getMonth() === month) {
					days.push(new Date(date));
					date.setDate(date.getDate() + 1);
				}
				return days;
			}

			i = 0;

			setDaysInOrder(mon, tue, wed, thur, fri, sat, sund);

			function setDaysInOrder(mon, tue, wed, thur, fri, sat, sund) {

				var monthDay = getDaysInMonth(monthNumber - 1, yearNumber)[0].toString().substring(0, 3);
				 jQuery('thead.event-days tr').append('<td>' + sund + '</td><td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td>');
			
			};

            var first_monthDay = getDaysInMonth(monthNumber - 1, yearNumber)[0].toString().substring(0, 3);
            var day_count = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            days_offset = day_count.indexOf(first_monthDay);
            var offset_elements = '<tr class="event-weeks">';
            if(days_offset > 0 ){
                for (d_offset = 0; d_offset < days_offset; d_offset++) { 
                    offset_elements += '<td class="blank-space">&nbsp;</td>';
                }
            }

			jQuery(getDaysInMonth(monthNumber - 1, yearNumber)).each(function(index) {
                var month_day = index + 1;
                offset_elements += '<td class="red" date-month="' + monthNumber + '" date-day="' + month_day + '" date-year="' + yearNumber + '"><span>' + month_day + '</span></td>';
                days_offset++;
                if(days_offset % 7 == 0) {
                    offset_elements += '<tr/><tr class="event-weeks ">' ;
                }
				i++;
			});
			
			offset_elements += '<tr/>';

            jQuery('tbody.event-calendar').append(offset_elements);
			
			


			var date = new Date();
			var month = date.getMonth() + 1;;
			var thisyear = new Date().getFullYear();
			setCurrentDay(month, thisyear);
			setEvent();
			upcoming(month, thisyear);
			displayEvent();
			unbind_click();
			
		}

		/**
		 * Get current day and set as '.current-day'
		 */
		function setCurrentDay(month, year) {
			var viewMonth = jQuery('.month').attr('data-month');
			if (parseInt(year) === yearNumber) {
				if (parseInt(month) === parseInt(viewMonth)) {
					jQuery('tbody.event-calendar td[date-day="' + d.getDate() + '"]').addClass('current-day');

				}
			}
		};
		function upcoming(month, year){
			// debugger;
			var currentMonth =jQuery('.month').attr('data-month');

			var currentyear =jQuery('.month').attr('data-year');

			var firstevent =jQuery('tbody.event-calendar td.event').attr('date-day');
			jQuery('.day-event[date-year="' + currentyear + '"][date-month="' + currentMonth + '"][date-day="' + firstevent + '"]').css({ 'display': "block" });

			// to display type of event

			if(currentMonth < 10)
 				currentMonth = "0" + currentMonth;
 			if( firstevent < 10 )
 				firstevent = "0" + firstevent;

 			var next_date = String(currentyear) + String(currentMonth) + String(firstevent);

 			var current_year = parseInt(year);
 			var current_day = jQuery('tbody.event-calendar td.current-day').attr('date-day');
 			if(monthNumber < 10)
 				monthNumber = "0" + monthNumber;
 			if(current_day < 10)
 				current_day = "0" + current_day;
 			
 			var current_date = String(current_year) + String(monthNumber) + String(current_day);
 			
 			var upcoming = document.getElementById('upcoming');
    		var past = document.getElementById('past');
    		var current = document.getElementById('current');

    		if( upcoming != null && past != null && current != null ) {

	 			if (current_date < next_date){
	 				past.setAttribute('class', 'hidden');
	        		upcoming.setAttribute('class', 'visible');
	        		current.setAttribute('class', 'hidden');
	 				
	 			}
				else if( current_date > next_date){
	 				past.setAttribute('class', 'visible');
	        		upcoming.setAttribute('class', 'hidden');
	        		current.setAttribute('class', 'hidden');
	 			}
	 			else {
	 				past.setAttribute('class', 'hidden');
	        		upcoming.setAttribute('class', 'hidden');
	        		current.setAttribute('class', 'visible');
	 				
				}
				
			}
			// to display type of event
		};

		function unbind_click(){
			jQuery('tbody.event-calendar td').not('.event').unbind("click");
		}



		/**
		 * Add class '.active' on calendar date
		 */
		jQuery('tbody td').on('click', function(e) {
			if (jQuery(this).hasClass('event')) {
				jQuery('tbody.event-calendar td').removeClass('active');
				jQuery(this).addClass('active');

			} else {

				jQuery('tbody.event-calendar td').removeClass('active');
			};
		});

		/**
		 * Add '.event' class to all days that has an event
		 */
		function setEvent() {
			jQuery('.day-event').each(function(i) {
				var eventMonth = jQuery(this).attr('date-month');
				var eventDay = jQuery(this).attr('date-day');
				var eventYear = jQuery(this).attr('date-year');
				var eventClass = jQuery(this).attr('event-class');
				if (eventClass === undefined) eventClass = 'event';
				else eventClass = 'event ' + eventClass;

				if (parseInt(eventYear) === yearNumber) {
					jQuery('tbody.event-calendar tr td[date-month="' + eventMonth + '"][date-day="' + eventDay + '"]').addClass(eventClass);
				
				
				}
			});

			// to display message of no event

			 if (!jQuery('tbody.event-calendar td').hasClass('event')) {
			 	
			 	jQuery('div#no-event').css({ 'display': "block" });

			 } 
			 else {
				jQuery('div#no-event').css({ 'display': "none" });
			}

			// to display message of no event
		};

		/**
		 * Get current day on click in calendar
		 * and find day-event to display
		 */
		function displayEvent() {
			jQuery('tbody.event-calendar td').on('click', function(e) {
				jQuery('.day-event').slideUp('fast');
				var monthEvent = jQuery(this).attr('date-month');
				var yearEvent = jQuery(this).attr('date-year');
				var dayEvent = jQuery(this).text();
				jQuery('.day-event[date-year="' + yearEvent + '"][date-month="' + monthEvent + '"][date-day="' + dayEvent + '"]').slideDown('fast');
				var clicked_event_day = this.getAttribute("date-day") ;
				if(clicked_event_day < 10)
 				clicked_event_day = "0" + clicked_event_day;
				
				var current_event_day = jQuery('td.current-day').attr('date-day');
				if(current_event_day < 10)
 				current_event_day = "0" + current_event_day;
				
	 			var upcoming = document.getElementById('upcoming');
    			var past = document.getElementById('past');
    			var current = document.getElementById('current');
				if( clicked_event_day < current_event_day )
				{
					past.setAttribute('class', 'visible');
	        		upcoming.setAttribute('class', 'hidden');
	        		current.setAttribute('class', 'hidden');
				}
				else if( clicked_event_day > current_event_day )
				{
					past.setAttribute('class', 'hidden');
	        		upcoming.setAttribute('class', 'visible');
	        		current.setAttribute('class', 'hidden');
				}
				else if( clicked_event_day == current_event_day )
				{
					past.setAttribute('class', 'hidden');
	        		upcoming.setAttribute('class', 'hidden');
	        		current.setAttribute('class', 'visible');
				}
			});

		};

		
  },

};

jQuery(document).ready(function(jQuery) {
	calendar.init('ajax');
});
