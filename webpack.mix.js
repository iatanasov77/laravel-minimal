let mix		= require( 'laravel-mix' );
let argv	= require( 'minimist' )( process.argv.slice( 2 ) );

//console.dir( argv.env.theme );

if ( argv.env.theme !== undefined )
{
    require( `${__dirname}/resources/views/${argv.env.theme}/webpack.mix.js` );
}
