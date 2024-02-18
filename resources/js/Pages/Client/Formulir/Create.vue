<template>
     <Head title="Buat Form" />
      <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-6 grid grid-cols-1 gap-6">
                    <div class="container form-group grid grid-cols-1 gap-2">
                        <label for="judul" class="text-sm">Judul Formulir</label>
                        <input type="text" v-model="title" class="input input-bordered w-full max-w-xs" placeholder="judul formulir">
                    </div>
                    <p class="font-semibold">Isi formulir</p>
                    <div v-if="content.length < 1">
                        <p class=" font-thin">Tambah kolom untuk data dengan tombol tambah kolom.</p>
                    </div>
                   <div  v-for="(item, index) in content" :key="index">
                        <div class="container formulir-body grid grid-cols-1 border-b pb-4">
                            <div class="grid grid-flow-row grid-cols-3">
                                <div class="form-group inline-flex space-x-6 items-center">
                                    <span class=" font-semibold">{{ index + 1 }}.</span>
                                    <input v-model="item.kolom" type="text" class="input input-bordered" placeholder="nama kolom">
                                </div>
                                <select v-model="item.tipe" class="select select-bordered w-full max-w-xs">
                                    <option selected value="text">Text</option>
                                    <option value="option">Option</option>
                                    <option value="multiple">Multiple</option>
                                    <option value="file">File</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone Number</option>
                                </select>
                                <div class="inline-flex space-x-2">
                                    <button class="btn btn-circle text-rose-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" @click="removeFormItem(index)" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/></svg>
                                    </button>
                                    <div class=" divider divider-vertical"></div>
                                    <label class="label space-x-4 cursor-pointer border px-4 rounded bg-neutral-100">
                                        <input type="checkbox" v-model="item.required" class="checkbox checkbox-primary" />
                                        <span class="label-text w-fit">Kolom wajib diisi</span> 
                                    </label>
                                    
                                </div>
                                
                                <div class="p-6 col-span-3 space-y-2 border my-4" v-if="item.tipe == 'option' || item.tipe == 'multiple'">
                                    <p class="text-sm font-semibold inline-flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40"><g fill="currentColor"><path d="M23.112 9.315a3.113 3.113 0 1 1-6.226.002a3.113 3.113 0 0 1 6.226-.002"/><circle cx="20" cy="19.999" r="3.112"/><circle cx="20" cy="30.685" r="3.112"/></g></svg>
                                        <span>Opsi jawaban</span>
                                    </p>
                                    <div class="grid grid-cols-1 gap-2">
                                        <input type="text" v-for="(itemOpsi, indexOpsi) in item.opsi" :key="indexOpsi" v-model="itemOpsi.text" class="input input-bordered max-w-xs" placeholder="opsi">
                                    </div>
                                </div>
                                
                                <button v-if="item.tipe == 'option' || item.tipe == 'multiple'" 
                                @click="()=>{
                                    item.opsi.push({
                                        text:''
                                    })
                                }"
                                class="btn w-fit py-2 text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12m10-8a8 8 0 1 0 0 16a8 8 0 0 0 0-16"/><path d="M13 7a1 1 0 1 0-2 0v4H7a1 1 0 1 0 0 2h4v4a1 1 0 1 0 2 0v-4h4a1 1 0 1 0 0-2h-4z"/></g></svg>
                                    Tambah opsi jawaban
                                </button>
                            </div>
                        </div>
                    </div>

                   <div class="container inline-flex justify-between">
                    <button class="btn" @click="()=>{
                        content.push({
                            kolom:'nama kolom',
                            tipe:'Text',
                            required:false,
                            opsi:[]
                        })
                    }"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5" viewBox="0 0 21 21"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M17 4a2.121 2.121 0 0 1 0 3l-9.5 9.5l-4 1l1-3.944l9.504-9.552a2.116 2.116 0 0 1 2.864-.125zM9.5 17.5h8m-2-11l1 1"/></svg>
                        Tambah kolom
                    </button>
                    <button class="btn btn-primary"
                    @click="simpanHandler">Simpan</button>
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
export default {
    components:{
        AuthenticatedLayout,Head, Link
    },
    data() {
        return {
            title: 'Draf Formulir',
            content:[],
        }
    },
    methods: {
        async simpanHandler(){
            try {
                const response = await axios.post(route('client.form.create',{
                    title:this.title,
                    content: this.content
                }))

                if (response.status == 200) {
                    window.location.href = route('client.form.index');
                }

            } catch (error) {
                console.log(error)
            }
        },
        removeFormItem(index){
            if (index >= 0 && index < this.content.length) {
                this.content.splice(index, 1); // Remove 1 element at the specified index
            } else {
                console.log("Invalid index");
            }   
        }
    },
    
}
</script>