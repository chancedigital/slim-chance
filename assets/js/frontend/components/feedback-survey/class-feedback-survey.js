import React, { Component } from 'react';
import { startCase, snakeCase, get, isNil } from 'lodash';
import NavButton from './components/nav-button';
import FeedbackForm from './components/feedback-form';
import FeedbackDefault from './components/feedback-default';
import fetch from 'isomorphic-unfetch';
import getQuestions from './data/questions';
import {
	formFields,
	initialFormValues,
	initialFormValidation,
	validateField,
} from './data/form-fields';
import { sortLocations, mapLocations } from './utils';
import { WP_API_BASE_URL, DEV } from '../../lib/constants';

/**
 * @typedef {object} MouseEvent
 * @typedef {object} KeyEvent
 * @typedef {object} SubmitEvent
 */

/**
 * React class to render the Feedback survey.
 *
 * @class FeedbackSurvey
 * @extends Component
 */
class FeedbackSurvey extends Component {
	/**
	 * Component state.
	 *
	 * @memberof FeedbackSurvey
	 */
	state = {
		fetchError: false,
		loading: false,
		locations: [],
		currentCategory: null,
		currentQuestion: null,
		formValidation: initialFormValidation,
		formValues: initialFormValues,
		nextQuestion: null,
		previousQuestion: null,
		questionHistory: [],
		selectedAnswers: {},
		submitAttempted: false,
		submitted: false,
		submitError: false,
	};

	/**
	 * Object to store event listener references.
	 *
	 * @type {Object}
	 * @memberof FeedbackSurvey
	 */
	_listeners = {};

	/**
	 * List of DOM selectors this component will use to trigger updates.
	 * We do this because the buttons exist outside the context of React.
	 * It works well for this use case. Don't @ me.
	 *
	 * @type {Array.<string>}
	 * @memberof FeedbackSurvey
	 */
	_selectors = [
		'order-experience',
		'menu-information',
		'press-marketing-inquiries',
		'tech-support',
	];

	/**
	 * Shortcut to get the button DOM elements.
	 *
	 * @param {string} selector - The selector string minus the namespace.
	 * @returns {HTMLElement} - The DOM element if it exists.
	 * @memberof FeedbackSurvey
	 */
	getButtonElement = selector =>
		document.getElementById( 'feedback-button-' + selector );

	/**
	 * Generates a callback reference to use in our event listeners.
	 *
	 * @param {string} selector - The selector string.
	 * @returns {Function} - The event listener callback.
	 * @memberof FeedbackSurvey
	 */
	listenToButtonBySelector = selector => () => {
		this.handleCategoryChange( selector );
	};

	/**
	 * Update the selected answer.
	 *
	 * @param {Object} question - The question object.
	 * @param {number|string} id - The ID of the selected answer.
	 * @memberof FeedbackSurvey
	 */
	handleAnswerSelect = ( question, id ) => {
		const answers = get( question, 'answers' );
		if ( answers ) {
			const answer = answers.find( a => a.id === id );
			this.setState( state => {
				return {
					selectedAnswers: {
						...state.selectedAnswers,
						[ question.value ]: answer,
					},
				};
			} );
		}
	};

	/**
	 * Generate the questions based on the selected category and fetched locations.
	 *
	 * @returns {Array.<Object>} - List of question objects.
	 * @memberof FeedbackSurvey
	 */
	getQuestions = () => {
		const { currentCategory, locations } = this.state;
		return getQuestions( currentCategory, locations );
	};

	/**
	 * Fetch locations from the WordPress custom post type.
	 *
	 * @async
	 * @memberof FeedbackSurvey
	 */
	fetchLocations = async () => {
		this.setState( { loading: true } );
		try {
			const res = await fetch( `${ WP_API_BASE_URL }/wp/v2/location` );
			const posts = await res.json();
			const locations = posts.map( mapLocations ).sort( sortLocations );
			this.setState( { locations, loading: false } );
		} catch ( err ) {
			console.error( err );
			this.setState( { fetchError: true, loading: false } );
		}
	};

	/**
	 * Get parameters needed to send the email request.
	 *
	 * @returns {Object} - Object containing the parameters and the query string.
	 * @memberof FeedbackSurvey
	 */
	getMailParams = () => {
		const { selectedAnswers, currentCategory, formValues } = this.state;
		const { comments, email } = formValues;
		const formData = {
			submittedBy: { value: email },
			feedbackCategory: { value: currentCategory },
			...selectedAnswers,
			comments: { value: comments },
		};
		const emailBody = Object.keys( formData ).reduce( ( acc, question ) => {
			if ( formData[ question ].value ) {
				return `${ acc }<p><strong>${ startCase( question ) }:</strong> ${
					formData[ question ].value
				}</p>`;
			}
			return acc;
		}, '' );
		const params = {
			contactFromEmail: get( window, 'slimChance.customerFeedbackFrom' ) || 'noreply@slimandhuskys.com',
			contactFromName: 'S+H Admin',
			contactToEmail: get( window, 'slimChance.customerFeedbackTo' ) || 'info@slimandhuskys.com',
			emailBody,
			emailSubject: 'New feedback submission from slimandhuskys.com',
			replyToEmail: email,
		};
		const queryString = Object.keys( params ).reduce( ( acc, key ) => {
			if ( params[ key ] ) {
				return `${ acc }&${ snakeCase( key ) }=${ encodeURIComponent(
					params[ key ],
				) }`;
			}
			return acc;
		}, '' );

		return { ...params, queryString };
	};

	/**
	 * Makes the mail API request and updates the state accordingly.
	 *
	 * @async
	 * @returns {boolean} - Whether or not the request is successful.
	 * @memberof FeedbackSurvey
	 */
	handleMailRequest = async () => {
		// const headers = new Headers();
		// headers.append( 'X-WP-Nonce', window.wpApiSettings.nonce );
		const { queryString, ...params } = this.getMailParams();
		try {
			const res = await fetch(
				`${ WP_API_BASE_URL }/mail/v1/send?${ queryString }`,
				{ method: 'POST' },
			);
			const response = await res.json();
			DEV && console.log( { params, response } );
			if ( response.status === 200 ) {
				this.setState( { submitted: true, submitError: false } );
				return true;
			}
			this.setState( { submitError: true } );
			return false;
		} catch ( e ) {
			console.error( e );
			this.setState( { submitError: true } );
			return false;
		}
	};

	/**
	 * Updates the active category.
	 *
	 * @param {string} category - The category to make active.
	 * @memberof FeedbackSurvey
	 */
	handleCategoryChange = category => {
		const questions = this.getQuestions();
		let startingQuestionId;
		switch ( category ) {
			case 'order-experience':
				startingQuestionId = 0;
				break;
			case 'menu-information':
				startingQuestionId = 5;
				break;
			case 'press-marketing-inquiries':
				startingQuestionId = 5;
				break;
			case 'tech-support':
				startingQuestionId = 6;
				break;
			default:
				startingQuestionId = 0;
				break;
		}
		const startingQuestion = questions.find( q => q.id === startingQuestionId );
		if ( startingQuestion ) {
			this.setState( {
				formValidation: initialFormValidation,
				formValues: initialFormValues,
				currentCategory: category,
				currentQuestion: startingQuestion,
				nextQuestion: this.getNextQuestion( startingQuestion ),
				previousQuestion: null,
				questionHistory: [],
				selectedAnswers: {},
				submitAttempted: false,
				submitted: false,
			} );
		} else {
			console.error(
				`Invalid starting question for the selected category. Debug required.`,
			);
		}
	};

	/**
	 * Creates the change event handler based on the field to be updated.
	 *
	 * @param {(string|number)} field - The field name identifier.
	 * @returns {Function} - The field change handler.
	 * @memberof FeedbackSurvey
	 */
	handleFormChange = field => ( /** @type {KeyEvent} */ e ) => {
		const { value } = e.target;
		this.setState( state => {
			const newValues = { ...state.formValues, [ field ]: value };
			const fieldObject = formFields.find( f => f.name === field );
			const isValid = validateField( fieldObject, newValues[ field ] );
			if ( state.formValues.hasOwnProperty( field ) ) {
				return {
					...state,
					formValidation: {
						...state.formValidation,
						[ field ]: isValid,
					},
					formValues: {
						...state.formValues,
						...newValues,
					},
				};
			}
		} );
	};

	/**
	 * Form submit handler.
	 *
	 * @param {SubmitEvent} e - Submission event.
	 * @memberof FeedbackSurvey
	 */
	handleSubmit = e => {
		const { formValidation } = this.state;
		const hasInvalidField = !! Object.keys( formValidation ).find(
			field => formValidation[ field ] !== true,
		);
		e.preventDefault();
		this.setState( { submitAttempted: true } );
		if ( hasInvalidField ) {
			// error UI is handled in the Form component, so do nothing here.
			return;
		} else if ( this.handleMailRequest() ) {
			window.alert(
				`Thanks for giving us feedback! Your message has been sent.`,
			);
		} else {
			window.alert(
				`There was error trying to submit your feedback. Please try again later.`,
			);
		}
	};

	/**
	 * Warn the user that an answer must be selected.
	 *
	 * @memberof FeedbackSurvey
	 */
	handleAnswerError = () => {
		window.alert( 'Please select an answer.' );
	};

	/**
	 * Advances to the next question in the survey.
	 *
	 * @param {(number|string)} questionId - The next question ID, if provided explicitly.
	 * @memberof FeedbackSurvey
	 */
	handleAdvance = ( questionId = null ) => {
		const { currentQuestion, selectedAnswers } = this.state;
		if ( ! currentQuestion ) {
			return;
		}

		// If no answer is selected, fire alert.
		if (
			currentQuestion.answers && // answers key exists with some truthy value
			currentQuestion.answers.length > 0 && // answers array has stuff
			! selectedAnswers[ currentQuestion.value ]
		) {
			this.handleAnswerError();
			return;
		}

		// get the next question.
		const nextQuestion = this.getNextQuestion( currentQuestion, questionId );

		// if it exists, we'll update the state.
		if ( nextQuestion ) {
			this.setState( state => ( {
				currentQuestion: nextQuestion,
				nextQuestion: this.getNextQuestion( nextQuestion, questionId ),
				previousQuestion: currentQuestion,
				questionHistory: [ ...state.questionHistory, currentQuestion ],
			} ) );
		}
	};

	/**
	 * Sends the user back to the previous question.
	 *
	 * @memberof FeedbackSurvey
	 */
	handleGoBack = () => {
		this.setState( state => {
			const { questionHistory, previousQuestion: currentQuestion } = state;
			const nextQuestion = this.getNextQuestion( currentQuestion );
			const previousQuestion =
				questionHistory.find(
					( x, i, arr ) => i === arr.indexOf( currentQuestion ) - 1,
				) || null;
			return {
				currentQuestion,
				nextQuestion,
				previousQuestion,
				questionHistory: questionHistory.slice( 0, questionHistory.length - 1 ),
			};
		} );
	};

	/**
	 * Gets the next question in the survey.
	 *
	 * @param {Object} currentQuestion - Current active question object.
	 * @param {(number|string)} questionId - The next question ID, if provided explicitly.
	 * @returns {!Object} - The next question object, if it exists.
	 * @memberof FeedbackSurvey
	 */
	getNextQuestion = ( currentQuestion, questionId = null ) => {
		const { selectedAnswers } = this.state;
		const questions = this.getQuestions();
		const currentQuestionId = get( currentQuestion, 'id' );

		// Check if we passed a specific question ID to jump to.
		if ( ! isNil( questionId ) ) {
			const question = questions.find( q => q.id === questionId );
			if ( question ) {
				return question;
			}
			console.error( 'Non-existant question ID passed to `handleAdvance`' );
			return null;
		}

		// check if current selected answer has a `skip` option to determine next question.
		const answerWithSkip = get(
			selectedAnswers[ currentQuestion.value ],
			'skipToQuestion',
		);

		// Set the next question.
		const nextQuestion = questions.find( q => {
			if ( typeof currentQuestionId !== 'undefined' ) {
				// if there is a skip option, get that value.
				if ( answerWithSkip ) {
					return q.id === answerWithSkip;
				}
				// next question is the first one after the current question so long
				// as `skipIf` for that question doesn't evaluate to true
				return q.id > currentQuestionId && q.skipIf !== true;
			}
		} );
		return isNil( nextQuestion ) ? null : nextQuestion;
	};

	/**
	 * Fetch operations and attach listeners on mount.
	 *
	 * @memberof FeedbackSurvey
	 */
	componentDidMount() {
		this.fetchLocations();
		this._selectors.forEach( ( selector, index ) => {
			const el = this.getButtonElement( selector );
			if ( el ) {
				this._listeners[ index ] = this.listenToButtonBySelector( selector );
				el.addEventListener( 'click', this._listeners[ index ] );
			}
		} );
	}

	/**
	 * Cleanup functions before unmount.
	 *
	 * @memberof FeedbackSurvey
	 */
	componentWillUnmount() {
		this._selectors.forEach( ( selector, index ) => {
			const el = this.getButtonElement( selector );
			if ( el ) {
				el.removeEventListener( 'click', this._listeners[ index ] );
			}
		} );
	}

	/**
	 * Update the error state if we get any errors.
	 *
	 * @returns {Object} - Updated error state.
	 * @memberof FeedbackSurvey
	 */
	static getDerivedStateFromError() {
		return { fetchError: true };
	}

	/**
	 * Add explicit error handling for React.
	 *
	 * @param {Object} error - Error object
	 * @param {*} info - Additional error info
	 */
	componentDidCatch( error, info ) {
		console.error( error, info );
	}

	/**
	 * Render the component.
	 *
	 * @return {React.Element} - HTML markup for the component
	 */
	render() {
		const {
			currentCategory,
			currentQuestion,
			fetchError,
			formValidation,
			formValues,
			loading,
			nextQuestion,
			previousQuestion,
			selectedAnswers,
			submitAttempted,
			submitted,
		} = this.state;
		const heading = startCase( currentCategory );
		const description = get( currentQuestion, 'text' );

		if ( fetchError ) {
			return <div>Something went wrong -- please try again later!</div>;
		}

		if ( ! currentCategory || ! currentQuestion ) {
			return '';
		}

		if ( loading ) {
			return <div>Loading...</div>;
		}

		return (
			<div className="feedback-survey">
				{ get( currentQuestion, 'value' ) === 'comments' ? (
					<FeedbackForm
						description={ description }
						formFields={ formFields }
						formValidation={ formValidation }
						formValues={ formValues }
						heading={ heading }
						onFormChange={ this.handleFormChange }
						onSubmit={ this.handleSubmit }
						submitAttempted={ submitAttempted }
					/>
				) : (
					<FeedbackDefault
						description={ description }
						heading={ heading }
						answers={ get( currentQuestion, 'answers' ) }
						selectedAnswers={ selectedAnswers }
						setActive={ this.handleAnswerSelect }
						question={ currentQuestion }
					/>
				) }
				<nav className="feedback-survey__nav-wrapper">
					{ previousQuestion && (
						<NavButton
							buttonText="Go Back"
							className="feedback-survey__nav-button feedback-survey__nav-button--prev"
							handleNav={ this.handleGoBack }
						/>
					) }
					{ nextQuestion ? (
						<NavButton
							buttonText="Next"
							className="feedback-survey__nav-button feedback-survey__nav-button--next"
							handleNav={ this.handleAdvance }
						/>
					) : (
						<NavButton
							buttonText="Submit"
							className="feedback-survey__nav-button feedback-survey__nav-button--submit"
							onClick={ this.handleSubmit }
							disabled={ submitted }
						/>
					) }
				</nav>
			</div>
		);
	}
}

export default FeedbackSurvey;
