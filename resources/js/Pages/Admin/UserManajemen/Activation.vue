<template>
    <Head title="Activation" />
    <AuthenticatedLayoutAdmin>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Activation</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <div class="card bg-white p-4 shadow grid grid-cols-1 gap-6">
                    <p class="text-xl">Aktifkan Langganan Client</p>
                    
                    
                        <div class="grid grid-cols-1 gap-4">
                            <span>Email : {{ user.email }}</span>
                            <div class="group-form">
                                <label for="date">Tanggal berakhir</label>
                                <vue-date-picker id="date" v-model="date"></vue-date-picker>
                            </div>
                            <div class="container w-fit">
                                <button @click="sendActivation" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </AuthenticatedLayoutAdmin>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue'
import axios from 'axios';
import moment from 'moment'
export default {
    components:{
        AuthenticatedLayoutAdmin,Head
    },
    props:{
        user:Array
    },
    data() {
        return {
            date:Date.now(),
        }
    },
    methods: {
        async sendActivation(){
            const response = await axios.post(route('panel.user.activate',{
                'user_id' : this.user.id,
                date : moment(this.date).format('YYYY-MM-D')
            }))
        }
    },
}
</script>