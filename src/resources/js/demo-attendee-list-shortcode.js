/**
 *  Script for outputting the attendees for a given user using the TEC REST API.
 *
 *  @since 1.0.0
 */
jQuery(document).ready(function($) {
	const { rest_endpoint, nonce, error_message, no_attendee_message, attendee_labels } = attendee_list_demo_shortcode_script_vars;

	// Construct the attendees endpoint URL
	let attendeesEndpoint = rest_endpoint.base + 'tribe/tickets/v1/attendees/';

	// Ajax call to fetch attendee data if the user is logged in.
	$.ajax({
		url: attendeesEndpoint,
		type: 'GET',
		dataType: 'json',
		headers: {
			'X-WP-Nonce': nonce,
		},
		success: renderAttendees,
		error: function(xhr, status, error) {
			$('.attendee-list').append( error_message, error);
		}
	});

	// Function to render attendees based on response
	function renderAttendees(response) {
		if (response && response.attendees && response.attendees.length > 0) {
			// Clear existing content before appending new content
			$('.attendee-list').empty();

			// Iterate through each attendee and append to the attendee list
			$.each(response.attendees, function(index, attendee) {
				let attendeeHTML = `<div class="attendee">
					<div class="attendee-details">
					<h3 class="attendee-name"> attendee.title </h3>
					<ul>
					<li class="attendee-email"> attendee_labels.email attendee.email </li>
					<li class="attendee-ticket-name"> attendee_labels.ticket_name + attendee.ticket.title </li>
					<li class="attendee-ticket-cost"> attendee_labels.ticket_cost + attendee.ticket.formatted_price </li>
					</ul>
					</div>
					</div>`;

				$('.attendee-list').append(attendeeHTML);
			});
		} else {
			$('.attendee-list').append( no_attendee_message);
		}
	}
});
