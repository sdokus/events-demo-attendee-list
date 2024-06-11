<?php

namespace Sdokus\Demo_Attendee_List\Shortcodes;

interface Shortcode_Irterface {
    public static function get_wp_slug(): string;

    public static function make_for_wp( array $attributes, string $content = '' ): string;

}