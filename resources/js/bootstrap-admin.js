//window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $( 'meta[name="csrf-token"]' ).attr( 'content' );

// NPM packages
import 'popper.js';
import 'bootstrap';
import 'jquery-sortable-lists';
// Local scripts
import './components/alert';
import './components/axios-request';
import './components/init-animations';
import './components/menu';
import './components/modals';
import './components/pretty-print';
// Local admin scripts
import './admin/components/alert';
import './admin/components/articles';
import './admin/components/categories'
import './admin/components/comments';
import './admin/components/pages';
import './admin/components/tiny-mce';
import './admin/components/users';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
