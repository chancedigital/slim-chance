import React from 'react';
import NavButton from '../nav-button';

function FeedbackNav( {
	previousQuestion,
	nextQuestion,
	handleSubmit,
	handleAdvance,
	handleGoBack,
	submitted,
} ) {
	return (
		<nav className="feedback-survey__nav-wrapper">
			{ previousQuestion && (
				<NavButton
					buttonText="Go Back"
					className="feedback-survey__nav-button feedback-survey__nav-button--prev"
					handleNav={ handleGoBack }
				/>
			) }
			{ nextQuestion ? (
				<NavButton
					buttonText="Next"
					className="feedback-survey__nav-button feedback-survey__nav-button--next"
					handleNav={ handleAdvance }
				/>
			) : (
				<NavButton
					buttonText="Submit"
					className="feedback-survey__nav-button feedback-survey__nav-button--submit"
					onClick={ handleSubmit }
					disabled={ submitted }
				/>
			) }
		</nav>
	);
}

export default FeedbackNav;
