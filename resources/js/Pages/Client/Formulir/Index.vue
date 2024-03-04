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
                                            <td>
                                                <Link :href="item?.short_link.original_url">{{ item?.url }}</Link>
                                            </td>
                                            <td class="inline-flex space-x-2">
                                                <Link :href="route('client.form.responderPage',{id:item.id})" class="btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-neutral-900" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5h8m-8 4h5m-5 6h8m-8 4h5M3 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1zm0 10a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
                                                    Responder
                                                </Link>
                                                <a :href="route('client.form.exportExcel',{_query:{id:item.id}})" class="btn btn-ghost text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" class="text-emerald-500" viewBox="0 0 24 24"><path fill="currentColor" d="m2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.494v20.848a.5.5 0 0 1-.57.494L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99M17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4zm-6.8 9L13 8h-2.4L9 10.286L7.4 8H5l2.8 4L5 16h2.4L9 13.714L10.6 16H13z"/></svg>
                                                </a>
                                                <button class="btn  bg-rose-600 text-white"
                                                @click="()=>{
                                                    hapusHandler(item.id)
                                                }"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/></svg></button>
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
            length: 10,
            search:''
        }
    },
    watch: {
        length(){
            this.getFormulirData()
        },
        search(){
            this.getFormulirData()
        }
    },
    mounted() {
        this.getFormulirData()
    },
    methods: {
        async getFormulirData(urlParam){
            let url;
            if(urlParam){
                url = urlParam;
            }else{
                url = route('client.form.FormulirData'),{
                    params:{
                        length:this.length,
                        search:this.search
                    }
                }
            }

            let data = await axios.get(url)
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
        },
        changePageHandler(urlParam){
            this.getFormulirData(urlParam)
        },
        async hapusHandler(id){
            try {
                const response = await axios.delete(
                    route('client.form.delete',{
                        form_id: id
                    })
                )

                if (response.status == 200){
                    this.getFormulirData()
                }
            } catch (error) {
                
            }
        }
    },
}
</script>