import React from 'react';
import classNames from 'classnames';
import { noop } from 'lodash';
import Alert from './components/alert';

const FormField = ( {
	className,
	field = {},
	isInvalid,
	labelClassName,
	onChange = noop,
	submitAttempted,
	value = '',
} ) => {
	const { label, name, options, placeholder, required, type: htmlType } = field;
	let Element;
	switch ( htmlType ) {
		case 'textarea':
			Element = 'textarea';
			break;
		default:
			Element = 'input';
			break;
	}
	const validationMessage =
		required && ! value ? 'This field is required' : field.validationMessage;
	const props = {
		className: classNames( 'form__field', `form__field--${ name }`, className ),
		onChange,
		value,
		placeholder,
		'aria-invalid': submitAttempted && isInvalid,
		'aria-required': required,
	};
	return (
		<label className={ classNames( 'form__label', labelClassName ) }>
			{ label && <p>{ label }</p> }
			<span className="form__field-wrapper">
				{ htmlType === 'select' ? (
					<select { ...props }>
						{ options &&
							options.length &&
							options.map( option => (
								<option key={ option.value } value={ option.value }>
									{ option.label }
								</option>
							) ) }
					</select>
				) : (
					<Element { ...props } />
				) }
				{ submitAttempted && isInvalid && (
					<Alert message={ validationMessage } />
				) }
			</span>
		</label>
	);
};

export default FormField;
