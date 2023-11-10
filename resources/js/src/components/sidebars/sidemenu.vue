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
            <v-list-item :to="{ name: 'auth.skills.listing' }" :link="true" prepend-icon="mdi-account" title="Skills" ></v-list-item>

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