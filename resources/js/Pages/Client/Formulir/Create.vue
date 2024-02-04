<template>
     <Head title="Buat Form" />
      <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-6 grid grid-cols-1 gap-2">
                    <div class="container form-group grid grid-cols-1 gap-2">
                        <label for="judul" class="text-sm">Judul Formulir</label>
                        <input type="text" v-model="title" class="input input-bordered w-full max-w-xs" placeholder="judul formulir">
                    </div>

                    <p>Isi formulir</p>
                   <div  v-for="(item, index) in content" :key="index">
                        <div class="container formulir-body grid grid-cols-1 gap-2">
                            <div class="grid grid-flow-row grid-cols-3">
                                <input v-model="item.kolom" type="text" class="input input-bordered max-w-xs" placeholder="nama kolom">
                                <select v-model="item.tipe" class="select select-bordered w-full max-w-xs">
                                    <option selected>Text</option>
                                    <option>Option</option>
                                    <option>Multiple</option>
                                    <option>File</option>
                                    <option>Email</option>
                                </select>
                                <div class="inline-flex ">
                                    <label class="label space-x-4 cursor-pointer">
                                        <input type="checkbox" v-model="item.required" class="checkbox" />
                                        <span class="label-text w-fit">Wajib diisi</span> 
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="container inline-flex justify-between">
                    <button class="btn" @click="()=>{
                        content.push({
                            kolom:'nama kolom',
                            tipe:'Text',
                            required:false
                        })
                        console.log(content);
                    }"> Tambah kolom</button>
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

                window.location.href = route('client.form.index');

            } catch (error) {
                
            }
            
        }
    },
    
}
</script>