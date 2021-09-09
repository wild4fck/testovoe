import Vue from 'vue';

import MainApp from './components/MainApp.vue'
import AppPanel from './components/AppPanel.vue'
import MyLoader from './components/MyLoader.vue'

import 'vue-multiselect/dist/vue-multiselect.min.css';
import Notifications from 'vue-notification'
import VModal from 'vue-js-modal'
import vuetify from './vuetify'

Vue.use(Notifications);
Vue.use(VModal, {dynamic: true, injectModalsContainer: true});

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {MainApp, AppPanel, vuetify, MyLoader}
});
