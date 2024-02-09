<template>
     <Head title="Manajemen User" />
      <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-4">
                    <div class="container filter-container flex flex-row justify-between">
                        <div class="inline-flex space-x-2">
                            <select class="select select-bordered w-fit max-w-xs" v-model="length">
                                <option value="10">10</option>
                                <option :value="item" :hidden="item % 25 != 0" v-for="(item, index) in 100" :key="index" >{{ item }}</option>
                            </select>
                        </div>
                    </div>


                    <div class="container grid grid-cols-1 gap-6">
                        <TableVue>
                            <template v-slot:header>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Identitas Responder</th>
                                        <th>Tanggal diisi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </template>
                            <template v-slot:body>
                                <tbody>
                                    <tr v-for="(item, index) in formulirData.data" :key="index">
                                        <th>{{ formulirData.from + index }}</th>
                                        <td>{{ item?.responder_id }}</td>
                                        <td>{{ item?.tanggal_dibuat }}</td>
                                        <td class="inline-flex space-x-2">
                                            <Link :href="route('client.formAnswer.show',{form_id:item.id})" class="btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg>
                                            </Link>
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
                                Show {{formulirData.from}} - {{ formulirData.to }} form total {{ formulirData.total }} data
                            </p>
                            <div class="join">
                                <div v-for="(item, index) in formulirData.links" :key="index">
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
        <dialog id="deleteModal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Hello!</h3>
                <p class="py-4">Press ESC key or click outside to close</p>
                <div class="inline-flex space-x-2 w-full justify-end">
                    <button class="btn btn-primary" type="button">Ya</button>
                    <button @click="()=>{
                        deleteModal.closeModal()
                    }" class="btn bg-rose-500 text-white" type="button">Tidak</button>
                    
                </div>
            </div>
        </dialog>
    </AuthenticatedLayout>
</template>
<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableVue from '@/Components/Table.vue'
import axios from 'axios';
import moment from 'moment';

export default {
    components:{
        Head,AuthenticatedLayout,TableVue, Link
    },
    data() {
        return {
            formulirData:Array,
            length:10
        }
    },
    watch: {
        length(){
            this.getReponderList()
        }
    },
    mounted() {
        this.getReponderList()
    },
    methods: {
        async getReponderList(urlParam){
            let url;
            if (urlParam) {
                url = urlParam
            }else{
                url =route('client.form.responderList')
            }

            const response = await axios.get(
                url,
                {
                    params:{
                        length:this.length
                    }
                }
            )
            .then((result) => {
                return result.data
            }).catch((err) => {
                console.log(err)
            });
            this.formulirData = response
            this.formulirData.data = this.formulirData.data.map((item) => {
                const content = JSON.parse(item.answer)
                
                item.tanggal_dibuat = moment(item.created_at).format('dddd, DD-MM-YYYY')
                
                var responderId = content.filter((contentItem) => {
                    if (contentItem.tipe == 'email' || contentItem.tipe == 'phone') {
                        return contentItem
                    }
                })

                responderId = responderId.map((contentItem) => {
                    return contentItem.answer
                });

                item.responder_id = responderId.join(', ');
                return item;
            })
        },
        async hapusHandler(id){
            try {
                await axios.delete(route('client.formAnswer.deleteAnswer',id));
                this.getReponderList()
            } catch (error) {
                console.log(error)
            }
        },
        changePageHandler(urlParam){
            this.getReponderList(urlParam);
        }
    },
}
</script>