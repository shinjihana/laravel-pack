
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**setting event by hoachan */
window.events = new Vue();  // vue.$on or Vue.$emit excute

/**setting global function ( it can easily call everywher that you need) */
window.flash = function(message, level = 'success'){
    window.events.$emit('flash', {message, level});
};

let authorizations = require('./authorizations');

window.Vue.prototype.authorize = function (...params){

    if (! window.App.signedIn) return false;
    
    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
}

Vue.prototype.signedIn = window.App.signedIn;

/**Common Components */
Vue.component('flash', require('./components/commons/Flash.vue'));
Vue.component('paginator', require('./components/commons/Paginator.vue'));
Vue.component('user-notifications', require('./components/commons/UserNotifications.vue'));

Vue.component('avatar-form', require('./components/commons/AvatarForm.vue'));
// Vue.component('favorite', require('./components/common/Favorite.vue'));

/**Thread Components */
// Vue.component('reply', require('./components/threads/Reply.vue'));
// Vue.component('replies', require('./components/threads/Replies.vue'));

/**Pages Components */
Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
