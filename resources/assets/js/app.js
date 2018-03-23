
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
window.flash = function(message){
    window.events.$emit('flash', message);
};

window.Vue.prototype.authorize = function (handler){
    //Additional admin privileges.
    let user = window.App.user;
    
    return user ? handler(user) : false;
}

/**Common Components */
Vue.component('flash', require('./components/commons/Flash.vue'));
Vue.component('paginator', require('./components/commons/Paginator.vue'));
// Vue.component('favorite', require('./components/common/Favorite.vue'));

/**Thread Components */
// Vue.component('reply', require('./components/threads/Reply.vue'));
// Vue.component('replies', require('./components/threads/Replies.vue'));

/**Pages Components */
Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
