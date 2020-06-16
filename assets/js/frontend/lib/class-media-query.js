import { throttle } from 'lodash';

export const breakpoints = {
	small: 0,
	medium: 768,
	large: 992,
	xlarge: 1200,
	xxlarge: 1440,
};

export class MediaQuery {
	constructor( bp = {} ) {
		const initialState = this.getInitialState();
		this._state = {
			...this._state,
			...initialState,
		};
		this.breakpoints = {
			...this.breakpoints,
			...bp,
		};
	}

	breakpoints = breakpoints;

	_state = {
		screenWidth: null,
		screenHeight: null,
		mqSize: null,
		prevMqSize: null,
	};

	getInitialState = () => {
		const { innerWidth: screenWidth, innerHeight: screenHeight } = window;
		return Object.keys( this.breakpoints ).find( ( size, index, arr ) => {
			const lastBp = index === arr.length - 1;
			const nextBp = lastBp ? null : this.breakpoints[ arr[ index + 1 ] ];
			return {
				screenWidth,
				screenHeight,
				mqSize: lastBp
					? screenWidth >= this.breakpoints[ size ]
					: screenWidth >= this.breakpoints[ size ] && screenWidth < nextBp,
			};
		} );
	};

	listener = throttle( () => {
		const { innerWidth: width, innerHeight: height } = window;
		const prevMqSize = this._state.mqSize;
		const mqSize = Object.keys( this.breakpoints ).find(
			( size, index, arr ) => {
				const lastBp = index === arr.length - 1;
				const nextBp = lastBp ? null : this.breakpoints[ arr[ index + 1 ] ];
				return lastBp
					? width >= this.breakpoints[ size ]
					: width >= this.breakpoints[ size ] && width < nextBp;
			},
		);
		// console.log( mqSize );
		this._state.height = height;
		this._state.width = width;
		if ( mqSize !== prevMqSize ) {
			this._state.mqSize = mqSize;
			this._state.prevMqSize = prevMqSize;
			window.dispatchEvent( this.changeEvent() );
		}
		return;
	}, 100 );

	changeEvent = () => {
		return new CustomEvent( 'mqChanged', {
			detail: {
				newSize: this._state.mqSize,
				oldSize: this._state.prevMqSize,
			},
		} );
	};
}
