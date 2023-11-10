<template>
    <v-chip pill>
        <v-avatar start>
            <v-img :src="user.image_url"></v-img>
        </v-avatar>
        {{ user.name }}
    </v-chip>
</template>
<script>
export default {
    props: {
        user: {
            default: {},
            type: Object
        }
    }
}
</script>