import React, { Component } from 'react';

export default class Example extends Component {
	constructor( props ) {
		super( props );
		this.state = { active: true };
	}
	render() {
		const { active } = this.state;
		return (
			<div className={ active ? 'example active' : 'example' }>
				<p>Amazing component.</p>
			</div>
		);
	}
}
