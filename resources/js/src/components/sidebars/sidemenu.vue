<template>
    <v-navigation-drawer expand-on-hover
        rail>
        <!-- <template v-slot:prepend>
            <v-list-item lines="two" :prepend-avatar="user.image_url"
                :title="user.name" :subtitle="user.email"></v-list-item>
        </template> -->
        <v-list>
          <v-list-item @click="openUserProfile"
          :prepend-avatar="user.image_url"
                :title="user.name" :subtitle="user.email"
          ></v-list-item>
        </v-list>
        <v-list density="compact" nav>
            <v-list-item exact :to="{ name: 'auth.panel' }" :link="true" prepend-icon="mdi-home-city" title="Dashboard" ></v-list-item>
            <v-list-item :to="{ name: 'auth.roles.listing' }" :link="true" prepend-icon="mdi-crown" title="Roles" ></v-list-item>
            <v-list-item :to="{ name: 'auth.users.listing' }" :link="true" prepend-icon="mdi-account" title="Users" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.emailtemplates.listing' }" :link="true" prepend-icon="mdi-email-edit" title="Email Templates" ></v-list-item>
            <!-- <v-list-item exact :to="{ name: 'auth.leads.listing' }" :link="true" prepend-icon="mdi-leaf" title="Leads" ></v-list-item> -->
            <v-list-item exact :to="{ name: 'auth.leads.grid' }" :link="true" prepend-icon="mdi-grid" title="Leads Grid" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.leads.followups' }" :link="true" prepend-icon="mdi-folder-account-outline" title="Followups" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.leads.appointments' }" :link="true" prepend-icon="mdi-calendar-account" title="My Appointments" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.clients.listing' }" :link="true" prepend-icon="mdi-account" title="Clients" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.payments.listing', query: {start_date: today_date} }" :link="true" prepend-icon="mdi-cash" title="Upcoming Payments" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.payments.listing', query: {end_date: today_date} }" :link="true" class="bg-red lighten-200" prepend-icon="mdi-cash-clock" title="Overdue Payments" ></v-list-item>
            <v-list-item exact :to="{ name: 'auth.reports.leads' }" :link="true" prepend-icon="mdi-domain" title="Lead Reports" ></v-list-item>
            <!-- <v-list-item :to="{ name: 'auth.homevideos.listing' }" :link="true" prepend-icon="mdi-video" title="Home Videos" ></v-list-item>
            <v-list-item :to="{ name: 'auth.otherpages.listing' }" :link="true" prepend-icon="mdi-window-closed-variant" title="Public Pages" ></v-list-item>
            <v-list-item :to="{ name: 'auth.contributorrequests.listing' }" :link="true" prepend-icon="mdi-read" title="Contributor Requests" ></v-list-item> -->
        </v-list>
    </v-navigation-drawer>
</template>
<script>
export default {
    data: () => ({
        isNightMode: false,
        drawer: false,
        today_date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)
    }),
    mounted() {
        var isDarkTheme = localStorage.getItem('is_theme_dark')
        if (isDarkTheme === 'true') {
            this.isNightMode = true
        } else {
            this.isNightMode = false
        }
    },
    props: {

    },
    watch: {
        drawerState() {
            if (this.drawerState === true) {
                this.drawer = this.drawerState
                setTimeout(() => {
                    this.$store.commit("updateDrawer", false);
                }, 100)
            }
        }
    },
    methods: {
        async toggleDarkTheme() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark
            this.isNightMode = this.$vuetify.theme.dark;
            await this.$nextTick()
            localStorage.setItem('is_theme_dark', this.$vuetify.theme.dark === false ? 'false' : 'true')
        },
        logoutauthparent() {
            this.$store.commit("setLoginStatus", false);
            this.$store.commit("setAuthToken", "");
            this.$store.commit("setloggedInUser", {});
            this.$router.push({ name: "auth.login" });
        },
        openUserProfile() {
            this.$router.push({ name: 'auth.profiles' });
        },
    },
    computed: {
        drawerState() {
            return this.$store.getters.drawerState;
        },
        themeMode() {
            return this.$vuetify.theme.dark
        },
        user() {
            return this.$store.getters.loggedInUser;
        },
        loggedIn() {
            return this.$store.getters.loggedIn;
        },
        permissions() {
            return this.$store.getters.getPermissions;
        },
    },
}
</script>