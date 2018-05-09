<?php

use Illuminate\Support\Facades\Config;

if ( ! function_exists( 'get_uploaded_file' ) )
{
    function get_uploaded_file( $table, $column, $key )
    {
        return sprintf( "%s/%s-%s-%d", Config::get( 'app.file_provider' ), $table, $column, $key );
    }
}
