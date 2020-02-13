import React from 'react';
import { get } from 'lodash';
import AnswerButton from '../answer-button';
import Question from '../question';

function FeedbackDefault( {
	answers = [],
	selectedAnswers = {},
	setActive,
	heading,
	description,
	question,
} ) {
	return (
		<Question heading={ heading } description={ description }>
			{ answers.map( answer => {
				const selectedAnswerId = get( selectedAnswers[ question.value ], 'id' );
				return (
					<AnswerButton
						key={ answer.id }
						id={ answer.id }
						question={ question }
						setActive={ setActive }
						active={ selectedAnswerId === answer.id }
					>
						{ answer.text }
					</AnswerButton>
				);
			} ) }
		</Question>
	);
}

export default FeedbackDefault;
