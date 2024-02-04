<?php

class Sanitization {
    public static function sanitize_text( $text ) {
        $text = strip_tags( $text );
        return $text;
    }
    
    public static function is_valid_email( $email ) {
        if ( ! empty( $email ) ) {
            $email = filter_var( $email, FILTER_VALIDATE_EMAIL );
        }
    
        return $email;
    }
}
