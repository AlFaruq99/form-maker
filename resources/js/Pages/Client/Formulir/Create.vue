<template>

    <Head title="Buat Form" />
    <AuthenticatedLayout>
        <div class="py-12 min-h-screen" :style="backgroundStyle">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <div class="bg-white shadow-lg py-12 border card overflow-hidden p-6 grid grid-cols-1 gap-6">
                    <ul class="steps">
                        <li class="step" :class="{
                            'step-primary' : page >= 0
                        }">Buat formulir</li>
                        <li class="step" :class="{
                            'step-primary' : page >= 1
                         }">Pesan tanggapan</li>
                    </ul>

                    <!-- create form column -->
                    <CreateForm v-if="page == 0" 
                    @change-background="(item) => {imageChangeHandler(item)}"
                    @change-description="(item) => {description = item}"
                    @content-change="(item) => { content = item }"></CreateForm>


                    <!-- create response form -->
                    <CreateResponse 
                    :content="content"
                    @response-change="(value)=>{
                        this.response = value
                    }"
                    v-if="page == 1"
                    ></CreateResponse>


                    <div class="grid grid-flow-row grid-cols-2 gap-4">
                        <button class="btn btn-primary" @click="()=>{
                        if (page > 0) {
                            page = page - 1
                        }
                    }">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4"  viewBox="0 0 64 64"><path fill="currentColor" d="M32 2C15.432 2 2 15.432 2 32c0 16.568 13.432 30 30 30s30-13.432 30-30C62 15.432 48.568 2 32 2m17 35.428H30.307V48L15 32l15.307-16v11.143H49z"/></svg>
                        Kembali
                    </button>

                    <button class="btn btn-primary" v-if="page < 1" @click="()=>{
                        if (page < 1) {
                            page += 1
                        }
                    }">


                        Selanjutnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4" viewBox="0 0 64 64">
                            <path fill="currentColor"
                                d="M32 2C15.432 2 2 15.432 2 32c0 16.568 13.432 30 30 30s30-13.432 30-30C62 15.432 48.568 2 32 2m1.693 46V37.428H15V27.143h18.693V16L49 32z" />
                        </svg>
                    </button>
                    <button @click="simpanHandler" class="btn btn-primary" v-if="page == 1">
                        Simpan
                    </button>
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
import CreateForm from '@/Pages/Client/Formulir/CreateForm.vue'
import CreateResponse from '@/Pages/Client/Formulir/CreateResponse.vue';

export default {
    components: {
        AuthenticatedLayout, Head, Link, CreateForm, CreateResponse
    },
    props: {
        defaultImage: String
    },
    data() {
        return {
            title: 'Draf Formulir',
            content: [],
            response:'',
            page:0,
            backgroundStyle: {
                'background': `url(${this.defaultImage})`,
                'background-size': 'cover'
            },
            imageFile: null,
            description:''
        }
    },
    methods: {
        imageChangeHandler(event){
            const file = event.target.files[0];
            this.imageFile = file;
            const reader = new FileReader();
            var background = this.backgroundStyle;
            reader.onload = function(e) {
                background.background = `url(${e.target.result})`;
                // previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        },
        async simpanHandler() {

            try {

                const formData = new FormData();
                formData.append('message', this.response);
                formData.append('description', this.description);
                formData.append('title', this.title);
                formData.append('content', JSON.stringify(this.content));
                formData.append('image_background', this.imageFile)
                
                const response = await axios.post(
                    route('client.form.create'),
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )

                if (response.status == 200) {
                    window.location.href = route('client.form.index');
                }

            } catch (error) {
                console.log(error)
            }
        },

    },

}
</script>