<template>
    <v-snackbar v-model="snackbar">
        {{ notificaitontext }}
        <template v-slot:action="{ attrs }">
            <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>
<script>
export default {
    name: "notifications",
    props: {
        notificaitontext: String,
        notificaitonstatus: Boolean,
    },
    data() {
        return {
            snackbar: false,
        };
    },
    watch: {
        notificaitonstatus() {
            this.snackbar = true;
            setTimeout(() => {
                this.snackbar = false;
            }, 2000);
        },
        notificaitontext() {
            // this.snackbar = true
        },
    },
};
</script>