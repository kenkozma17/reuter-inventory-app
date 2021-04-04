<template>
    <div class="max-w-7xl mx-auto" data-app>
        <v-card>
            <v-card-title>
                Transactions
                <v-spacer></v-spacer>
                <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="items"
                    :loading="loading"
                    :options.sync="options"
                    :server-items-length="totalItems">
                <template v-slot:item.transaction_number="{item}">
                    <template v-if="item.transaction_number">
                        <a class="text-white btn btn-primary" :href="'/admin/transactions/show/' + item.id">View</a>
                        <span>{{item.transaction_number}}</span>
                    </template>
                </template>
                <template v-slot:item.product_id="{item}">
                    <template v-if="item.product">
                        <a :href="'/admin/products/' + item.product.id + '/edit'">{{item.product.name}}  {{item.product.size}} {{item.product.color}}</a>
                    </template>
                </template>
                <template v-slot:item.product_quantity="{item}">
                    <template v-if="item.product">
                        {{item.product.quantity}}
                    </template>
                </template>
                <template v-slot:item.type="{ item }">
                    <v-chip class="ma-2 text-white v-chip--active"
                            :class="item.type === 'increase' ? 'bg-green-500' : 'bg-red-500'">
                        {{ item.type }}
                    </v-chip>
                </template>
                <template v-slot:item.quantity="{item}">
                    <v-chip class="ma-2 text-white v-chip--active"
                            :class="item.type === 'increase' ? 'bg-green-500' : 'bg-red-500'">
                        {{ item.quantity }}
                    </v-chip>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    var debounce = require('lodash.debounce');
    export default {
        props:['data', 'product'],
        data () {
            return {
                search: '',
                loading: false,
                options: {
                    groupBy: [],
                    groupDesc: [],
                    itemsPerPage: this.data.per_page ? this.data.per_page : 5,
                    multiSort:true,
                    mustSort:true,
                    page:1,
                    sortBy: [],
                    sortDesc: [],
                },
                headers: [
                    { text: 'Transaction #', value: 'transaction_number'},
                    { text: 'Product', value: 'product_id' },
                    { text: 'Transaction Type', value: 'type' },
                    { text: 'Amount (Increased/Decreased)', value: 'quantity' },
                    { text: 'Customer Name', value: 'customer_name' },
                    { text: 'Date', value: 'date', sortable: true, sort: (e) => {console.log('sup')} },
                ],
                items: this.data.data ? this.data.data : [],
                totalItems: this.data.total ? this.data.total : [],
                dataLoaded: false,
                productId: this.product ? this.product : 0
            }
        },
        watch: {
            search() {
                this.options.page = 1;
                this.searchProducts();
            },
            options: {
                handler () {
                    this.getTransactions();
                }
            },
        },
        methods: {
            getTransactions() {
                if(this.dataLoaded) {
                    this.loading = true;
                    let path = this.productId ? 'by-product' : 'all';
                    axios.get(`/admin/transactions/${path}`, {params: {query: this.search, page: this.options.page, product: this.productId}})
                        .then(response => {
                            const results = response.data.results;
                            this.items = results.data;
                            this.totalItems = results.total;
                            this.options.page = results.current_page;
                        })
                        .finally(() => this.loading = false);
                }
            },
            searchProducts: _.debounce(function(){
                this.getTransactions();
            }, 750),
        },
        mounted() {
            this.$nextTick(function() { //with this we skip the first change
                this.dataLoaded = true
            })
        }
    }
</script>
<style lang="scss">
    .v-application--wrap {
        display: block !important;
    }
    .theme--light.v-application {
        background: transparent !important;
    }
</style>
