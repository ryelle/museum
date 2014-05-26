/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function( $ ) {
	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container )
		return;

	button = container.getElementsByTagName( 'h1' )[0];
	if ( 'undefined' === typeof button )
		return;

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( -1 === menu.className.indexOf( 'nav-menu' ) )
		menu.className += ' nav-menu';

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) )
			container.className = container.className.replace( ' toggled', '' );
		else
			container.className += ' toggled';
	};

	$( menu ).find( '.menu-item-has-children' ).each(function(i, el){
		var link = $( el.getElementsByTagName('a')[0] );
		if ( typeof link === undefined ){
			return;
		}
		$( el ).on({
			focus: function(){
				console.log("test-focus");
				$( el ).find('ul').addClass( 'hover' );
			},
			blur: function(){
				console.log("test-blur");
				$( el ).find('ul').removeClass( 'hover' )
			}
		})
	});


} )( jQuery );
