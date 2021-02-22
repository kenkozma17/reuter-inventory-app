<template>
        <div class="max-w-7xl mx-auto" data-app>
            <v-card>
                <v-card-title>
                    Categories
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
                    <template v-slot:item.name="{ item }">
                        <a :href="'/admin/categories/' + item.id + '/edit'">{{item.name}}</a>
                    </template>
                    <template v-slot:item.action="{item}">
                        <a @click="deleteCategory(item.id)" class="btn btn-danger text-white">Delete</a>
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
                    {text: 'Category Name', value: 'name'},
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
                    this.getCategories();
                }
            },
        },
        methods: {
            deleteCategory(id) {
                if(confirm('Are you sure you want to delete this category?')) {
                    axios.delete(`/admin/categories/${id}`)
                        .then(response => {
                            if(response.data.success) {
                                this.getCategories();
                            }
                        })
                        .finally(() => {
                            alert('Category Deleted Successfully!');
                        })
                }
            },
            getCategories() {
                if(this.dataLoaded) {
                    this.loading = true;
                    axios.get('/admin/categories/all', {params: {query: this.search, page: this.options.page}})
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
                this.getCategories();
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
