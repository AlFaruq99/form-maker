<template>
    <Head title="Manajemen User" />

    <AuthenticatedLayoutAdmin>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-8">

                <div class="bg-white card p-8">
                    <p class="font-semibold text-lg">Buat User</p>

                    <div class="grid grid-cols-1 gap-6 py-12">
                        <div class="form-group w-full flex flex-col space-y-2">
                            <label for="" class="text-sm">Nama Lengkap</label>
                            <input  v-model="nama" type="text" class="input input-bordered max-w-screen-sm" placeholder="John Doe">
                            <small class="italic text-red-500">*wajib</small>
                        </div>

                        <div class="form-group w-full flex flex-col space-y-2">
                            <label for="" class="text-sm">Email</label>
                            <input v-model="email" type="email" class="input input-bordered max-w-screen-sm" placeholder="john.doe@email.com">
                            <small class="italic text-red-500">*wajib</small>
                        </div>

                        <div class="form-group w-full flex flex-col space-y-2">
                            <label for="" class="text-sm">Password</label>
                            <input v-model="password" type="password" class="input input-bordered max-w-screen-sm" placeholder="********">
                            <small class="italic text-red-500">*wajib</small>
                        </div>

                        <div class="form-group w-full flex flex-col space-y-2">
                            <label for="" class="text-sm">Masukkan ulang password</label>
                            <input v-model="confirmPassword" type="password" class="input input-bordered max-w-screen-sm" placeholder="********">
                            <small class="italic text-red-500">*wajib</small>
                        </div>

                        <div class="form-group w-full flex flex-col space-y-2">
                            <label for="" class="text-sm">Level user</label>
                            <select v-model="level" class="select select-bordered w-full max-w-screen-sm">
                                <option value="admin">Superadmin</option>
                                <option value="client" selected>Client</option>
                            </select>
                        </div>


                        <div class="form-group w-full flex flex-col space-y-2 max-w-screen-sm">
                            <label for="" class="text-sm">Tanggal Kadaluwarsa</label>
                            <vue-date-picker id="date" v-model="tglKadaluwarsa" placeholder="dd/mm/yyyy"></vue-date-picker>
                        </div>

                        <div class="form-group w-full flex flex-col space-y-2">
                            <button @click="postHandler" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M473 39.05a24 24 0 0 0-25.5-5.46L47.47 185h-.08a24 24 0 0 0 1 45.16l.41.13l137.3 58.63a16 16 0 0 0 15.54-3.59L422 80a7.07 7.07 0 0 1 10 10L226.66 310.26a16 16 0 0 0-3.59 15.54l58.65 137.38c.06.2.12.38.19.57c3.2 9.27 11.3 15.81 21.09 16.25h1a24.63 24.63 0 0 0 23-15.46L478.39 64.62A24 24 0 0 0 473 39.05"/></svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayoutAdmin>
    <dialog id="errorModal" class="modal">
        <div class="modal-box bg-rose-500">
            <span class="font-bold text-white text-2xl">Error</span>
            <div class="py-4" v-for="(item, index) in errorMessage" :key="index">
                <span class="text-white">{{ item }}</span>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <dialog id="successModal" class="modal">
        <div class="modal-box bg-emerald-500">
            <span class="font-bold text-white text-2xl">Success</span>
            <div class="py-4" v-for="(item, index) in errorMessage" :key="index">
                <span class="text-white">{{ item }}</span>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import moment from 'moment';
import axios from 'axios';


export default {
    components:{
        Head, AuthenticatedLayoutAdmin
    },
    data() {
        return {
            nama:null,
            email:null,
            password:null,
            confirmPassword: null,
            level:'client',
            tglKadaluwarsa: moment().add(3, 'days').format('YYYY-MM-DD hh:mm:ss'),
            errorMessage:Array
        }
    },
    mounted() {
        
    },
    methods: {
       async postHandler(){
            const form = new FormData();

            if (this.nama) {
                form.append('nama',this.nama);
            }
            if (this.email) {
                form.append('email',this.email);
            }
            if (this.password) {
                form.append('password',this.password);
            }
            if (this.confirmPassword) {
                form.append('confirm_password',this.confirmPassword);
            }

            form.append('level',this.level);
            form.append('tgl_exp',this.tglKadaluwarsa);

            try {
                
                var response = await axios.post(
                    route('panel.user.store'),
                    form
                )
                .then((result) => {
                   return result 
                }).catch((err) => {
                    const response = err.response
                    if (response.status == 422) {
                        
                        const errorData = err.response.data.errors
                        let errorList = []
                        Object.keys(errorData).forEach(element => {
                            errorList.push(errorData[element][0]);
                        });

                        this.errorMessage = errorList;
                        errorModal.show()
                    }
                });
                
                if(response.status == 200){
                    successModal.show()
                    setTimeout(() => {
                        window.location.href = route('panel.user.index');
                    }, 3000);
                }


            } catch (error) {
                console.log(error)
            }
        }
    },
}
</script>