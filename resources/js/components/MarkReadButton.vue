<template>
    <a class="text-white btn btn-dark mr-2" @click="markAsRead">
        <span v-if="loading" class="spinner-border"><span class="sr-only">Loading...</span></span>
        <span v-else>Mark As Read</span>
    </a>
</template>
<script>
    import axios from 'axios';
    export default {
        props: {
            notification: String,
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            markAsRead() {
                this.loading = true;
                axios.post('/admin/notifications/mark', {id: this.notification})
                    .then(response => {
                        console.log(response);
                    })
                    .finally(() => this.loading = false);
            }
        }
    }
</script>
<style lang="scss">
    .spinner-border {
        width: 1.5em;
        height: 1.5em;
    }
</style>