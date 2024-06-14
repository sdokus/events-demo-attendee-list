/**
 *  Script for outputting the attendees for a given user using the TEC REST API.
 *
 *  @since 1.0.0
 */
jQuery(document).ready(function($) {
	// Encode username and password for basic authentication. This is just for testing that authentication is working,
	// eventually this will be changed to a dynamic call for the current user.
	var username = 'sam';
	var password = 'pass';
	var basicAuth = 'Basic ' + btoa(username + ':' + password);

	// Ajax call to fetch attendee data
	$.ajax({
		url: 'https://stable.dev.lndo.site/wp-json/tribe/tickets/v1/attendees/',
		type: 'GET',
		dataType: 'json',
		headers: {
			'Authorization': basicAuth,
			'X-WP-Nonce': attendee_list_demo_shortcode_script_vars.nonce,
		},
		success: function(response) {
			if (response && response.attendees && response.attendees.length > 0) {
				// Iterate through each attendee and append to the attendee list
				$.each(response.attendees, function(index, attendee) {
					var attendeeHTML = '<div class="attendee">' +
						'<div class="attendee-avatar">' +
						'<img src="avatar.jpg" alt="Attendee Avatar">' +
						'</div>' +
						'<div class="attendee-details">' +
						'<h3 class="attendee-name">' + attendee.title + '</h3>' +
						'<p class="attendee-email">' + attendee.email + '</p>' +
						'<p class="attendee-role">Role: ' + attendee.ticket.title + '</p>' +
						'</div>' +
						'</div>';

					$('.attendee-list').append(attendeeHTML);
				});
			} else {
				console.log('No attendees found.');
			}
		},
		error: function(xhr, status, error) {
			console.error('Error fetching attendees:', error);
		}
	});
});
