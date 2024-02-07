<template>
    <Head title="Layanan Whatsapp" />
      <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-4">
                    <button @click="getInstance" class="btn btn-primary w-fit">Generate QR Code</button>

                    <img :src="qrCode" />
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
        Head, AuthenticatedLayout
    },
    data() {
        return {
            qrCode:null
        }
    },
    mounted() {
        console.log(import.meta.env.VITE_WA_ACCESS)
    },
    methods: {
        async getInstance(){
            const response = await axios.get(route('client.wa.getInstanceToken'))
            .then((result) => {
                return result.data
            }).catch((err) => {
                
            });
            this.qrCode = response.base64
            
            
        }
    },
}
</script>