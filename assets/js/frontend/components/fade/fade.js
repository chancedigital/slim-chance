import React from 'react';
import PropTypes from 'prop-types';
import { Transition } from 'react-transition-group';

function Fade( { duration = 500, in: inProp = true, children, ...rest } ) {
	const durationNumber =
		typeof duration === 'number' ? duration : duration.enter;
	const defaultStyle = {
		WebkitTransition: `opacity ${ durationNumber }ms ease-in-out`,
		transition: `opacity ${ durationNumber }ms ease-in-out`,
		opacity: 0,
	};
	const transitionStyles = {
		entering: { opacity: 0 },
		entered: { opacity: 1 },
	};
	return (
		<Transition in={ inProp } timeout={ duration } { ...rest }>
			{ state => (
				<div
					style={ {
						...defaultStyle,
						...transitionStyles[ state ],
					} }
				>
					{ children }
				</div>
			) }
		</Transition>
	);
}

Fade.propTypes = {
	duration: PropTypes.oneOfType( [
		PropTypes.number,
		PropTypes.shape( {
			enter: PropTypes.number,
			exit: PropTypes.number,
		} ),
	] ).isRequired,
};

export default Fade;
