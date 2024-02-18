<template>
    <Head title="Activation" />
    <Toast ref="toast"></Toast>
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
import Toast from '@/Components/Toast.vue';

export default {
    components:{
        AuthenticatedLayoutAdmin,Head,Toast
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
            try {
                
                if (moment(this.date).isAfter(moment.now()) !== true) {
                    this.$refs.toast.show('error','Gagal menambah langganan','tanggal yang dipilih tidak sesuai')
                    setTimeout(() => {
                        this.$refs.toast.hide()
                    }, 3000);
                    return;
                }
                const response = await axios.post(route('panel.user.activate',{
                    'user_id' : this.user.id,
                    date : moment(this.date).format('YYYY-MM-D')
                }))
                .then(async (result) => {

                    return result;
                    
                }).catch((err) => {
                    this.$refs.toast.show('error','Gagal menambah langganan','silakan hubungi cs')
                    setTimeout(() => {
                        this.$refs.toast.hide()
                    }, 3000);
                });

                if (response.status == 200) {
                    this.$refs.toast.show('success','Berhasil menambah langganan','')
                    setTimeout(() => {
                        this.$refs.toast.hide()
                        window.location.href = route('panel.user.index');
                    }, 3000);

                }
            } catch (error) {
                this.$refs.toast.show('error','Gagal menambah langganan','silakan hubungi cs')
                setTimeout(() => {
                    this.$refs.toast.hide()
                }, 3000);
            }
        }
    },
}
</script>