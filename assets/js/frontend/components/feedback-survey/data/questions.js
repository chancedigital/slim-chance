const questions = ( selectedCategory, locations ) => [
	{
		id: 0,
		value: 'type of feedback',
		text: `First, we have a few questions. These help us understand your experience and work to improve. What type of feedback would you like to share?`,
		answers: [
			{
				id: 0,
				value: 'complaint',
				text: 'Complaint',
			},
			{
				id: 1,
				value: 'compliment',
				text: 'Compliment',
				skipToQuestion: 2,
			},
		],
	},
	{
		id: 1,
		value: 'has left feedback previously',
		text: `We are sorry to hear that! Is this experience something you’ve shared with us before?`,
		answers: [
			{
				id: 0,
				value: 'no; first time',
				text: 'No, this is my first time sharing this experience',
			},
			{
				id: 1,
				value: 'yes; spoke with the restaurant',
				text: 'Yes, I spoke with someone at the Restaurant about this experience',
			},
			{
				id: 2,
				value: 'yes; submitted survey online already',
				text: 'Yes, I filled out this web form about this experience',
			},
		],
	},
	{
		id: 2,
		value: 'how did you place your order?',
		text: `How did you place your order?`,
		answers: [
			{
				id: 0,
				value: 'in store',
				text: 'In the Store',
			},
			{
				id: 1,
				value: 'mobile app',
				text: 'Mobile App',
			},
			{
				id: 2,
				value: 'online',
				text: 'Online',
			},
			{
				id: 3,
				value: 'phone call',
				text: 'Phone Call',
			},
		],
	},
	{
		id: 3,
		value: 'how did you receive your order?',
		text: `How did you receive your order?`,
		answers: [
			{
				id: 0,
				value: 'dine-in',
				text: 'Dine In',
			},
			{
				id: 1,
				value: 'carry-out',
				text: 'Carry Out',
			},
		],
	},
	{
		id: 4,
		value: 'feedback subject',
		text: `What would you like to tell us about your experience?`,
		answers: [
			{
				id: 0,
				value: 'order',
				text: 'My Order',
			},
			{
				id: 1,
				value: 'service',
				text: 'Service and Staff',
			},
			{
				id: 2,
				value: 'restaurant environment',
				text: 'Restaurant Environment',
			},
			{
				id: 3,
				value: 'other',
				text: 'Other/Multiple',
			},
		],
	},
	{
		id: 5,
		value: 'location',
		text: `Select the location this feedback pertains to.`,
		answers: locations,
		skipIf: selectedCategory === 'tech-support',
	},
	{
		id: 6,
		value: 'comments',
		text: `What would you like to tell us about your experience?`,
		answers: [],
	},
];

export default questions;
