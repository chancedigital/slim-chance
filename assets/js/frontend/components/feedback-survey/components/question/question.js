import React from 'react';

function Question( { heading, description, children } ) {
	return (
		<section className="feedback-survey__question-wrapper">
			<header className="feedback-survey__header">
				<h2 className="feedback-survey__heading">{ heading }</h2>
				<p className="feedback-survey__description">{ description }</p>
			</header>
			<div className="feedback-survey__options">{ children }</div>
		</section>
	);
}

export default Question;
