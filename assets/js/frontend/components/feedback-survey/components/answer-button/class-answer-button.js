import React from 'react';
import classNames from 'classnames';

const AnswerButton = ( {
	active,
	onClick = e => e,
	setActive = ( q, id ) => ( { q, id } ),
	children,
	question = null,
	id = null,
} ) => {
	const handleClick = e => {
		setActive( question, id );
		onClick( e );
	};
	return (
		<button
			className={ classNames( 'feedback-survey__answer-button', {
				'feedback-survey__answer-button--active': active,
			} ) }
			onClick={ handleClick }
		>
			{ children }
		</button>
	);
};

export default AnswerButton;
