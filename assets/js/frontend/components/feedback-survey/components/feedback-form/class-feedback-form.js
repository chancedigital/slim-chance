import React from 'react';
import classNames from 'classnames';
import { noop, kebabCase } from 'lodash';
import Question from '../question';
import { initialFormValues, initialFormValidation } from '../../data/form-fields';
import FormField from '../../../form-field';

const FeedbackForm = ( {
	onFormChange = noop,
	onSubmit = noop,
	formFields = [],
	formValidation = initialFormValidation,
	formValues = initialFormValues,
	heading,
	description,
	submitAttempted,
} ) => {
	return (
		<Question heading={ heading } description={ description }>
			<form className="feedback-survey__form form" onSubmit={ onSubmit }>
				{ formFields.map( field => {
					const { name } = field;
					return (
						<FormField
							key={ name }
							className={ classNames(
								'feedback-survey__field',
								`feedback-survey__${ kebabCase( name ) }`,
							) }
							field={ field }
							labelClassName="feedback-survey__label"
							isInvalid={ ! formValidation[ name ] }
							onChange={ onFormChange( name ) }
							submitAttempted={ submitAttempted }
							value={ formValues[ name ] }
						/>
					);
				} ) }
			</form>
		</Question>
	);
};

export default FeedbackForm;
