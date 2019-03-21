import React from 'react';

const Alert = ( { message = 'This field is invalid' } ) => {
	return (
		<span role="alert" className="form__field-alert">
			{ message }
		</span>
	);
};

export default Alert;
