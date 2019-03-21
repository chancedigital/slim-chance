export default () => {
	function toggleChecked( box, wrapper ) {
		if ( ! box.checked ) {
			wrapper.classList.replace( 'checkbox--checked', 'checkbox--unchecked' );
		} else {
			wrapper.classList.replace( 'checkbox--unchecked', 'checkbox--checked' );
		}
	}

	function simulateClick( box ) {
		if ( box.clicked ) {
			box.clicked === false;
		} else {
			box.clicked === true;
		}
	}

	const checkboxes = document.querySelectorAll( 'input[type="checkbox"]' );

	checkboxes.forEach( box => {
		const classNames = box.className;
		const label = box.closest( 'label' );
		const wrapper = document.createElement( 'div' );
		const clickEvents = [ 'click', 'keyup' ];
		box.style.display = 'none';
		wrapper.setAttribute( 'tabindex', 0 );
		wrapper.setAttribute( 'id', box.id );
		wrapper.setAttribute(
			'class',
			classNames.includes( 'checkbox' )
				? classNames
				: `checkbox ${ classNames }`.trim(),
		);
		box.addEventListener( 'change', () => {
			toggleChecked( box, wrapper );
		} );
		clickEvents.forEach( ev => {
			wrapper.addEventListener( ev, e => {
				if ( ev === 'keyup' ) {
					if ( e.keyCode === 32 || e.keyCode === 13 ) {
						simulateClick( box );
					}
				} else {
					simulateClick( box );
				}
			} );
		} );
		if ( box.checked ) {
			wrapper.classList.add( 'checkbox--checked' );
		} else {
			wrapper.classList.add( 'checkbox--unchecked' );
		}
		box.parentNode.insertBefore( wrapper, box );
		if ( label ) {
			label.classList.add( 'checkbox__label' );
		}
	} );
};
