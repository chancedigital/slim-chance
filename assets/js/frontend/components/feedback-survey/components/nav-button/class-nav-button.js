import React from 'react';
import classNames from 'classnames';
import { noop } from 'lodash';

const NavButton = ( {
	handleNav = noop,
	onClick = noop,
	className,
	buttonText = 'Next',
	...rest
} ) => {
	return (
		<button
			className={ classNames( 'button', className ) }
			onClick={ e => {
				e.preventDefault();
				onClick( e );
				handleNav();
			} }
			{ ...rest }
		>
			{ buttonText }
		</button>
	);
};

export default NavButton;
