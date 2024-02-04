<template>
      <Head title="Manajemen User" />
      <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-4">
                    <div class="container">
                        <Link :href="route('client.form.CreateForm')" class="btn btn-md btn-primary float-end">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"/></svg>
                            Tambah Formulir
                        </Link>
                    </div>    
                    <div class="container filter-container flex flex-row justify-between">
                        <div class="inline-flex space-x-2">
                            <select class="select select-bordered w-fit max-w-xs" v-model="length">
                                <option value="10">10</option>
                                <option :value="item" :hidden="item % 25 != 0" v-for="(item, index) in 100" :key="index" >{{ item }}</option>
                            </select>
                        </div>
                        <div class="inline-flex space-x-2">
                            <input v-model="search" type="text" name="" class="input input-bordered input-md w-full max-w-xs" placeholder="Search...">
                        </div>
                    </div>
                    <div class="container grid grid-cols-1 gap-6">
                            <TableVue>
                                <template v-slot:header>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Judul</th>
                                            <th>Tanggal dibuat</th>
                                            <th>Status</th>
                                            <th>Link</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </template>
                                <template v-slot:body>
                                    <tbody>
                                        <tr v-for="(item, index) in formulir.data" :key="index">
                                            <th>{{ formulir.from + index }}</th>
                                            <td>{{ item?.title }}</td>
                                            <td>{{ item?.tanggal_dibuat }}</td>
                                            <td>{{ item?.status }}</td>
                                            <td>
                                                <Link :href="item?.url">{{ item?.url }}</Link>
                                            </td>
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
                            <div class="w-full flex flex-row justify-between">
                                <p>
                                    Show {{formulir.from}} - {{ formulir.to }} form total {{ formulir.total }} data
                                </p>
                                <div class="join">
                                    <div v-for="(item, index) in formulir.links" :key="index">
                                        <button @click="()=>{
                                            changePageHandler(item.url);
                                        }" class="join-item btn btn-sm" :class="{
                                            'bg-primary text-white' : item.active
                                        }" v-html="item.label"></button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
      </AuthenticatedLayout>

</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import TableVue from '@/Components/Table.vue'
import TextInput from '@/Components/TextInput.vue';
import moment from 'moment';
export default {
    components:{
        AuthenticatedLayout,Head,TableVue, Link
    },
    data() {
        return {
            formulir:Array,
            length: 10
        }
    },
    mounted() {
        this.getFormulirData()
    },
    methods: {
        async getFormulirData(){
            let data = await axios.get(route('client.form.FormulirData'))
            .then((result) => {
               let data = result.data;

               let response = data.data.map((item) => {
                    item.tanggal_dibuat = moment(item.created_at).format('LLL');
                    return item;
               });
               data.data = response;


               return data;
            }).catch((err) => {
                
            });

            this.formulir = data;
        }
    },
}
</script>