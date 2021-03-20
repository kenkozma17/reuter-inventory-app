<template>
    <div class="list-group">
        <template v-if="notifications.length">
            <div class="list-group-item list-group-item-action"
                 :class="notification.read_at ? '' : 'unread'"
                 v-for="(notification, index) in notifications">
                <div class="d-flex w-100 justify-content-between">
                    <h4 class="mb-1 font-weight-bold">{{ notification.data['product']['name'] }}</h4>
                <small>{{daysAgo(notification.created_at)}}</small>
                </div>
                <p class="mb-1 font-weight-bold">Current Quantity: {{ notification.data['product']['quantity'] }}</p>
                <p class="mb-1 font-weight-bold">Low Quantity: {{ notification.data['product']['notification_quantity'] }}</p>
                <p class="mb-1">
                    {{ notification.data['details'] }}
                </p>
                <a class="text-white btn btn-primary mr-2" :href="'/admin/transactions/add/' + notification.data['product']['id']">
                    Increase Quantity
                </a>
                <a class="text-white btn btn-dark mr-2" @click="markAsRead(notification.id, index)" v-if="!notification.read_at">
                    <span v-if="loading === index" class="spinner-border"><span class="sr-only">Loading...</span></span>
                    <span v-else>Mark As Read</span>
                </a>
<!--                <a class="text-white btn btn-danger mr-2" :href="'/admin/transactions/add/' + notification.data['product']['id']">-->
<!--                    Delete-->
<!--                </a>-->
            </div>
        </template>
        <p v-else>No Notifications!</p>
    </div>
</template>
<script>
    let { DateTime } = require('luxon');
    import axios from 'axios';
    export default {
        props: {
            notificationsData: Array
        },
        data() {
            return {
                loading: null,
                notifications: []
            }
        },
        methods: {
            daysAgo(date) {
                return DateTime.fromISO(date).toRelative()
            },
            markAsRead(notification, index) {
                this.loading = index;
                axios.post('/admin/notifications/mark', {id: notification})
                    .then(response => {
                        this.notifications = response.data.notifications;
                    })
                    .finally(() => this.loading = null);
            }
        },
        mounted() {
            this.notifications = this.notificationsData;
        }
    }
</script>