
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// uncomment this to enable vue-sortable once they have merged PR 
// https://github.com/sagalbot/vue-sortable/pull/17
// import Sortable from 'vue-sortable'
// Vue.use(Sortable)

const app = new Vue({
    el: '#app',
    components: {
    	'example': require('./components/Example.vue'),
    	'exhibitionsmenu': require('./components/Exhibitionsmenu.vue'),
    	'editabletext': require('./components/EditableText.vue'),
    	'deletebutton': require('./components/DeleteButton.vue'),
    	'newsectionbutton': require('./components/NewSectionButton.vue'),
    	'addtextbutton': require('./components/AddTextButton.vue'),
        'deletetextbutton': require('./components/DeleteTextButton.vue'),
        'addfilebutton': require('./components/AddFileButton.vue'),
    	'addcolorbutton': require('./components/AddColorButton.vue')
    }
});