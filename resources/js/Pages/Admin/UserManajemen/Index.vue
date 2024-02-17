<template>
    <Head title="Manajemen User" />

    <AuthenticatedLayoutAdmin>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="pt-12 pb-24 sm:py-12">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 grid grid-cols-1 gap-6">

                <div class="stats sm:shadow w-full overflow-hidden sm:w-fit">
  
                    <div class="stat">
                        <div class="stat-title">Total Client</div>
                        <div class="stat-value text-base sm:text-4xl">{{ total_client }}</div>
                        <!-- <div class="stat-desc">21% more than last month</div> -->
                    </div>
                    <div class="stat">
                        <div class="stat-title">Active User</div>
                        <div class="stat-value text-primary text-base sm:text-4xl">{{ client_active }}</div>
                        <!-- <div class="stat-desc">21% more than last month</div> -->
                    </div>
                    <div class="stat">
                        <div class="stat-title">Inactive User</div>
                        <div class="stat-value text-error text-base sm:text-4xl">{{ client_inactive }}</div>
                        <!-- <div class="stat-desc">21% more than last month</div> -->
                    </div>
                    
                </div>

                <div class="bg-white card overflow-hidden">
                    <div class="p-2 sm:p-6 text-gray-900 grid grid-cols gap-6">
                        <div class="container">
                            <Link :href="route('panel.user.create')" class="btn btn-md btn-primary float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"/></svg>
                                Tambah
                            </Link>
                        </div>

                        <div class="container filter-container grid grid-cols-1 gap-4
                        sm:flex sm:flex-row sm:justify-between">
                            <div class="inline-flex justify-between sm:justify-start space-x-2">
                                <select class="select select-bordered w-fit max-w-xs" v-model="length">
                                    <option value="10">10</option>
                                    <option :value="item" :hidden="item % 25 != 0" v-for="(item, index) in 100" :key="index" >{{ item }}</option>
                                </select>
                                <select v-model="status" class="select select-bordered w-fit max-w-xs">
                                    <option value="all">Show all</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Expired</option>
                                </select>
                            </div>
                            <div class="inline-flex space-x-2">
                                <input v-model="search" type="text" name="" class="input input-bordered input-md w-full sm:max-w-xs" placeholder="Search...">
                            </div>
                        </div>
                        <div class="container grid grid-cols-1 gap-6">
                            <TableVue>
                                <template v-slot:header>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subscription</th>
                                            <th>Expired</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </template>
                                <template v-slot:body>
                                    <tbody>
                                        <tr v-for="(item, index) in client.data" :key="index">
                                            <th>{{ client.from + index }}</th>
                                            <th>
                                                <div class="avatar placeholder">
                                                    <div class="bg-neutral text-neutral-content rounded-full w-12">
                                                        <span>{{ item.initialName }}</span>
                                                    </div>
                                                </div> 
                                            </th>
                                            <td>{{ item?.name }}</td>
                                            <td>{{ item?.email }}</td>
                                            <td>{{ item?.status }}</td>
                                            <td>{{ item?.jatuh_tempo }}</td>
                                            <td>
                                                <Link :href="route('panel.user.userActivation',{
                                                    id: item.id
                                                })" v-if="item.status == 'Inactive'"
                                                class="btn btn-sm text-white bg-blue-500 ">Activate</Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </TableVue>
                            <div class="w-full sm:flex sm:flex-row sm:justify-between
                            grid grid-cols-1 gap-4
                            ">
                                <p>
                                    Show {{client.from}} - {{ client.to }} form total {{ client.total }} data
                                </p>
                                <div class="max-sm:hidden join w-fit">
                                    <div v-for="(item, index) in client.links" :key="index">
                                        <button @click="()=>{
                                            changePageHandler(item.url);
                                        }" class="join-item btn btn-sm" :class="{
                                            'bg-primary text-white' : item.active
                                        }" v-html="item.label"></button>
                                    </div>
                                </div>
                                <div class=" w-full join sm:hidden justify-center">
                                    <button class="join-item btn" @click="changePageHandler(client.prev_page_url)">Prev Page</button>
                                    <button class="join-item btn" @click="changePageHandler(client.next_page_url)">Next Paget</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutAdmin>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import TableVue from '@/Components/Table.vue'
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';
import moment from 'moment';
import initialName from '@/initialName';

export default {
    components:{
        AuthenticatedLayoutAdmin, Head, TableVue, TextInput, Link
    },
    props:{
        total_client: Number,
        client_active: Number,
        client_inactive: Number
    },
    data() {
        return {
            client:Array,
            length:10,
            page:this.page,
            search: null,
            status:'all'
        }
    },
    mounted() {
        this.getClientData()
    },
    watch: {
        search(){
            this.getClientData()
        },
        length(newValue){
            length = newValue
            this.getClientData()
        },
        status(){
            this.getClientData()
        }
    },
    methods: {
        changePageHandler(urlParam){
            let url = new URL(urlParam);
            url.searchParams.set('length', this.length);
            url.searchParams.set('status', this.status);
            if (this.search) {
                url.searchParams.set('search', this.search);
            }
            this.getClientData(url.href);
        },
        async getClientData(urlParam){
            const url = urlParam != null ? urlParam : route('panel.user.clientData',{
                length:this.length,
                search: this.search,
                status: this.status
            });
            const data = await axios.get(url)
            .then((result) => {
                let data = result.data;

                try {
                    data.data.map((item) => {
                        item.initialName = initialName(item.name);
                    
                        if (item.subscription == null) {
                            item.status = 'Inactive'
                        }
                        else{
                            if (moment(item.subscription.expired_at, 'YYYY-MM-DD').toDate() < moment.now()) {
                                item.jatuh_tempo = moment(item.subscription.expired_at).locale('ID').fromNow()
                                item.status = 'Inactive'
                            }else{
                                item.jatuh_tempo = moment(item.subscription.expired_at).locale('ID').fromNow()
                                item.status = 'Active'
                            }
                        }

                        return item
                    })
                    return data
                } catch (error) {
                    return []
                }
            }).catch((err) => {
               alert('gagal mengambil data') 
            });
            this.client = data;
        }
    },
    
}
</script>