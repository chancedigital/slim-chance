import gulp from 'gulp';
import env from 'gulp-env';
import { baseDir, nodeEnv } from '../index';

const task = 'env';

const file = `${ baseDir }/${ nodeEnv ? `.env.${ nodeEnv }` : '.env' }`;

gulp.task( task, cb => {
	env( { file, type: 'ini' } );
	cb();
} );
