<template>
    <!-- <v-system-bar>
    <span class="float-left">Credit CRM - V1.2</span>
    <v-spacer></v-spacer>
    <span class="ms-2">3:13PM</span>
    </v-system-bar> -->
    <div class="no-print" v-if="loggedIn">
        <v-app-bar>
            <template v-slot:prepend>
                <v-btn icon :to="{ name: 'auth.panel' }" :link="true">
                    <v-avatar  image="/images/logo.png"></v-avatar>
                </v-btn>
            </template>
            
            
            <v-spacer></v-spacer>
            <!-- <v-btn v-if="user.role_id==2" color="error" :to="{name: 'auth.uploadvideo'}" link >Upload Video</v-btn> -->
            <v-menu
                min-width="200px"
                rounded
            >
                <template v-slot:activator="{ props }">
                <v-btn icon v-bind="props">
                    <v-avatar :image="user.image_url">
                    </v-avatar>
                </v-btn>
                </template>
                <v-card>
                <v-card-text>
                    <div class="mx-auto text-center">
                    <v-avatar :image="user.image_url"></v-avatar>
                    <h3>{{ user.name }}</h3>
                    <p class="text-caption mt-1">
                        {{ user.email }}
                    </p>
                    <v-divider class="my-3"></v-divider>
                    <v-btn
                        rounded
                        link
                        :to="{name:'auth.profiles'}"
                        variant="text"
                    >
                        Edit Account
                    </v-btn>
                    <v-divider class="my-3"></v-divider>
                    <v-btn
                        rounded
                        @click="logoutauthparent"
                        variant="text"
                    >
                        Sign Out
                    </v-btn>
                    </div>
                </v-card-text>
                </v-card>
            </v-menu>
        </v-app-bar>
    </div>
</template>
<script>
export default {
    name: "headercomponent",
    components: {
    },
    data: () => ({
        drawer: false,
        overlay: false,
        collapseOnScroll: true,
        items: [
            { title: '+ User', link: 'auth.users.add' },
            { title: '+ Brand', link: 'auth.brands.add' },
            { title: '+ Brief Form', link: 'auth.briefforms.add' },
            { title: '+ Setting', link: 'auth.settings.add', permission_name: 'm_flag-create' },
            { title: '+ Payment Link', link: 'auth.payments.add', permission_name: 'payment-create' },
        ],
        today_date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)
    }),
    methods: {
        logoutauthparent() {
            this.$store.commit("setLoginStatus", false);
            this.$store.commit("setAuthToken", "");
            this.$store.commit("setloggedInUser", {});
            this.$router.push({ name: "auth.login" });
        },
    },
    computed: {
        user() {
            return this.$store.getters.loggedInUser;
        },
        loggedIn() {
            return this.$store.getters.loggedIn;
        },
        permissions() {
            return this.$store.getters.getPermissions;
        },
        leadStatuses(){
            // return this.$store.getters.getLeadStatuses;
            return [{
                name: 'All',
                id: 0,
                bgClass: '',
                forGrid: false,
            },...this.$store.getters.getLeadStatuses]
        },
    },
    watch: {

    },
    mounted() {
    },
};
</script>