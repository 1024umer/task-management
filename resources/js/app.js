import { createApp } from 'vue'
import routes from '@/routes/index'
// Vuetify
import { createRouter, createWebHistory } from 'vue-router'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as labsComponents from 'vuetify/labs/components'
import store from '@/store/index'
import loginservice from "@services/auth/login";
import newbar from "@/components/sidebars/newbar.vue";
import notifications from "@/components/sidebars/notifications.vue";
import headercomponent from "@/components/sidebars/headercomponent.vue";
import CKEditor from '@ckeditor/ckeditor5-vue';
import service from "@services/auth/default";
import css from '../css/app.css';
// const dropdownsService = new service('m-flags')
const vuetify = createVuetify({
    // components,
    theme: {
        // defaultTheme: 'dark'
    },
    directives,
    components: {
        ...components,
        ...labsComponents
    }
})
const router = createRouter({
    history: createWebHistory(),
    routes,
})
router.beforeEach(async (to, from, next) => {
    if (to.meta.guest) {
        //for guests and payments
        next()
    }
    else {
        var isAuthenticated = localStorage.getItem('auth_token') ? true : false;
        if (to.name !== 'auth.login' && !isAuthenticated){
            next({ name: 'auth.login' })   
        }else if (to.name === 'auth.login' && isAuthenticated) {
            next({ name: 'auth.panel' })
        }
        else{
            next()
        }
    }
})
createApp({
    async created() {
        var token = localStorage.getItem('auth_token') ? localStorage.getItem('auth_token') : '';
        if (token) {
            this.$store.commit('setAuthToken', token);
            this.$store.commit('setLoginStatus', true);
            var user = await loginservice.me()
            this.$store.commit('setloggedInUser', user);
        }
    },
    computed: {
        sideBarStatus() {
            return this.$store.getters.sideBarStatus;
        },
        notificaitontext() {
            return this.$store.getters.notificationText;
        },
        notificaitonstatus() {
            return this.$store.getters.notificationStatus;
        },
        isPanelFull() {
            return this.$store.getters.isPanelFull;
        },
        loggedIn() {
            return this.$store.getters.loggedIn;
        },
        goPrint() {
            return this.$store.getters.goPrint
        }
    },
    watch: {
        $route() {
            this.$store.commit('setPanelFull', false);
            if (this.$route.meta.showsidebar) {
                this.$store.commit('setSideBarStatus', true);
            } else {
                this.$store.commit('setSideBarStatus', false);
            }
        },
    },
    components: {
        newbar,
        headercomponent,
        notifications,
    },
}).use(store).use(CKEditor).use(router).use(vuetify).mount('#app')