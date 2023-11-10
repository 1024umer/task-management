import { createStore } from 'vuex'
// Create a new store instance.
import axios from 'axios';
const store = createStore({
    state() {
        return {
            loading: false,
            authtoken: '',
            loggedIn: false,
            sideBarStatus: false,
            loggedInUser: {},
            notificationStatus: false,
            notificationText: '',
            permissions: [],
            isPanelFull: false,
            drawerState: false,
            cities: [
                {
                    keyt: 'karachi',
                    text: 'Karachi'
                },
                {
                    keyt: 'lahore',
                    text: 'Lahore'
                },
                {
                    keyt: 'islamabad',
                    text: 'Islamabad'
                },
                {
                    keyt: 'faisalabad',
                    text: 'Faisalabad'
                },
                {
                    keyt: 'rawalpindi',
                    text: 'Rawalpindi'
                },
                {
                    keyt: 'multan',
                    text: 'Multan'
                },
                {
                    keyt: 'gujranwala',
                    text: 'Gujranwala'
                },
                {
                    keyt: 'peshawar',
                    text: 'Peshawar'
                },
                {
                    keyt: 'quetta',
                    text: 'Quetta'
                },
                {
                    keyt: 'sialkot',
                    text: 'Sialkot'
                },
                {
                    keyt: 'sargodha',
                    text: 'Sargodha'
                },
                {
                    keyt: 'bahawalpur',
                    text: 'Bahawalpur'
                },
                {
                    keyt: 'abbottabad',
                    text: 'Abbottabad'
                },
                {
                    keyt: 'rahim-yar-khan',
                    text: 'Rahim Yar Khan'
                },
                {
                    keyt: 'jhang',
                    text: 'Jhang'
                },
                {
                    keyt: 'sheikhupura',
                    text: 'Sheikhupura'
                },
                {
                    keyt: 'mirpur-azad-kashmir',
                    text: 'Mirpur (Azad Kashmir)'
                },
                {
                    keyt: 'larkana',
                    text: 'Larkana'
                },
                {
                    keyt: 'gujrat',
                    text: 'Gujrat'
                },
                {
                    keyt: 'mardan',
                    text: 'Mardan'
                }
            ]
        }
    },
    mutations: {
        updateDrawer(state, val) {
            state.drawerState = val
        },
        setPanelFull(state, val) {
            state.isPanelFull = val
        },
        setAuthToken(state, authtoken) {
            localStorage.setItem('auth_token', authtoken);
            try {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + authtoken;
            } catch (ex) { }
            state.authtoken = authtoken
        },
        setLoginStatus(state, loggedIn) {
            state.loggedIn = loggedIn
        },
        setloggedInUser(state, loggedInUser) {
            localStorage.setItem('logged_in_role_id', loggedInUser.role_id);
            state.loggedInUser = loggedInUser
        },
        setSideBarStatus(status, sideBarStatus) {
            status.sideBarStatus = sideBarStatus
        },
        setPermissions(state, permissions) {
            state.permissions = permissions
        },
        setNotification(state, text) {
            state.notificationText = text
            state.notificationStatus = true
            setTimeout(() => {
                state.notificationStatus = false
            }, 1000)
        },
    },
    getters: {
        getCities(state){
            return state.cities
        },
        drawerState(state) {
            return state.drawerState
        },
        authtoken(state) {
            return state.authtoken
        },
        loggedIn(state) {
            return state.loggedIn
        },
        isPanelFull(state) {
            return state.isPanelFull
        },
        loggedInUser(state) {
            return state.loggedInUser
        },
        sideBarStatus(state) {
            return state.sideBarStatus
        },
        notificationStatus(state) {
            return state.notificationStatus
        },
        notificationText(state) {
            return state.notificationText
        },
        getPermissions(state) {
            return state.permissions
        },
    }
})
export default store