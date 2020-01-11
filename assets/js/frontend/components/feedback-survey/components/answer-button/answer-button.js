import React from 'react';
import classNames from 'classnames';

function AnswerButton( {
	active,
	onClick = e => e,
	setActive = ( q, i ) => ( { q, id: i } ),
	children,
	question = null,
	id = null,
} ) {
	return (
		<button
			className={ classNames( 'feedback-survey__answer-button', {
				'feedback-survey__answer-button--active': active,
			} ) }
			onClick={ e => {
				setActive( question, id );
				onClick( e );
			} }
		>
			{ children }
		</button>
	);
}

export default AnswerButton;
