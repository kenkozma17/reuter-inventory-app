<template>
        <div class="max-w-7xl mx-auto" data-app>
            <v-card>
                <v-card-title>
                    Products
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
                    <template v-slot:item.trans="{ item }">
                        <a class="btn btn-primary text-white" :href="'/admin/transactions/add/' + item.id">Create Transaction</a>
                    </template>
                    <template v-slot:item.name="{ item }">
                        <a :href="'/admin/products/' + item.id + '/edit'">{{item.name}}</a>
                    </template>
                    <template v-slot:item.price="{ item }">
                        <p>{{ item.price}}</p>
                    </template>
                    <template v-slot:item.has_notification="{ item }">
                        <v-chip class="ma-2 text-white v-chip--active"
                                :class="item.has_notification ? 'bg-green-500' : 'bg-red-500'">
                            {{ item.has_notification ? 'Yes' : 'No'}}
                        </v-chip>
                    </template>
                    <template v-slot:item.action="{item}">
                        <a @click="deleteProduct(item.id)" class="btn btn-danger text-white">Delete</a>
                    </template>
                </v-data-table>
            </v-card>
        </div>
</template>

<script>
    import axios from 'axios';
    var debounce = require('lodash.debounce');
    export default {
        props: ['data'],
        data () {
            return {
                search: '',
                loading: false,
                options: {
                    groupBy: [],
                    groupDesc: [],
                    itemsPerPage: this.data.per_page ? this.data.per_page : 5,
                    multiSort:false,
                    mustSort:false,
                    page:1,
                    sortBy: [],
                    sortDesc: []
                },
                headers: [
                    { text: 'Actions', value: 'trans',},
                    { text: 'Product Name', value: 'name',},
                    { text: 'Quantity', value: 'quantity' },
                    { text: 'Price', value: 'price',},
                    { text: 'Size', value: 'size' },
                    { text: 'Color', value: 'color' },
                    { text: 'Notifications Enabled?', value: 'has_notification' },
                    { text: 'Actions', value: 'action' },
                ],
                items: this.data.data ? this.data.data : [],
                totalItems: this.data.total ? this.data.total : [],
                dataLoaded: false
            }
        },
        watch: {
            search() {
                this.options.page = 1;
                this.searchProducts();
            },
            options: {
                handler () {
                    this.getProducts();
                }
            },
        },
        methods: {
            formatCurrency() {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'PHP',
                });
            },
            deleteProduct(id) {
                if(confirm('Are you sure you want to delete this product?')) {
                    axios.delete(`/admin/products/${id}`)
                        .then(response => {
                            if(response.data.success) {
                                this.getProducts();
                            }
                        })
                        .finally(() => {
                            alert('Product Deleted Successfully!');
                        });
                }
            },
            getProducts() {
                if(this.dataLoaded) {
                    this.loading = true;
                    axios.get('/admin/products/all', {params: {query: this.search, page: this.options.page}})
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
                this.getProducts();
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
