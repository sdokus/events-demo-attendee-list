<?php
namespace Sdokus\Demo_Attendee_List\Templates;

/**
 * Class Attendee_List_Template.
 *
 * @since   1.0.0
 */
class Attendee_List_Template {

    /**
     * Render the HTML for the Attendee List shortcode.
     *
     * @since 1.0.0
     *
     * @param array $attributes Shortcode attributes.
     * @param string $content   Content enclosed by the shortcode.
     *
     * @return string
     */
    public static function render( array $attributes, string $content = '' ): string {
        // Sanitize attributes
        $id = isset( $attributes['id'] ) ? sanitize_text_field( $attributes['id'] ) : '';

        ob_start();
        ?>
        <div class="test" data-id="<?php echo esc_attr( $id ); ?>">
            <h2><?php esc_html_e( 'All Attendees', 'sdokus-demo-attendee-list' ); ?></h2>
            <div class="attendee-list">
                <!-- Attendee items will be dynamically appended here -->
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
