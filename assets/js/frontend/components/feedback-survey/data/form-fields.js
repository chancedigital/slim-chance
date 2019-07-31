/**
 * Email validation of a string.
 *
 * @param   {string}  email Email address.
 * @returns {boolean}       Whether or not the email is valid.
 *
 *
 */
/* eslint-disable no-useless-escape */
export const validateEmail = email => {
	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test( String( email ).toLowerCase() );
};

export const formFields = [
	{
		name: 'comments',
		initialValue: '',
		required: true,
		type: 'textarea',
		placeholder: 'Comments (required)',
	},
	{
		name: 'email',
		initialValue: '',
		validationFunction: validateEmail,
		type: 'email',
		placeholder: 'Email Address',
		label: `If you would like to hear back from us, please enter your email address below.`,
		validationMessage: `The email address is invalid`,
	},
];

export const initialFormValues = formFields.reduce( ( fields, field ) => {
	return {
		...fields,
		[ field.name ]: field.initialValue,
	};
}, {} );

export const validateField = ( field, value ) => {
	const { required, validationFunction } = field;
	let isValid = true;
	if ( required && ! value ) {
		isValid = false;
	} else if ( typeof validationFunction === 'function' ) {
		isValid = ! value ? true : validationFunction( value );
	}
	return isValid;
};

export const initialFormValidation = formFields.reduce( ( fields, field ) => {
	const isValid = validateField( field, field.initialValue );
	return {
		...fields,
		[ field.name ]: isValid,
	};
}, {} );

export const initialFormFieldsTouched = formFields.reduce(
	( fields, field ) => {
		let touched = false;
		if ( Object.prototype.hasOwnProperty.call( field, 'touched' ) ) {
			touched = !! field.touched;
		}
		return {
			...fields,
			[ field.name ]: touched,
		};
	},
	{},
);

export default formFields;
