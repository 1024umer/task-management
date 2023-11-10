<template>
    <!-- <sidemenu v-if="loggedIn" /> -->
</template>
<script>
import sidemenu from './sidemenu.vue';
export default {
    name: "sidebar",
    props: ["showsidebar"],
    components: {
        sidemenu,
    },
    data: () => ({
        drawer: false,
        overlay: false,
        collapseOnScroll: true,
    }),
    methods: {
        logoutauthparent() {
            this.$store.commit("setLoginStatus", false);
            this.$store.commit("setAuthToken", "");
            this.$store.commit("setloggedInUser", {});
            this.$router.push({ name: "auth.login" });
        },
        updateDrawer() {
            this.$store.commit("updateDrawer", true);
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
    },
    watch: {
        
    },
    mounted() {
    },
};
</script>