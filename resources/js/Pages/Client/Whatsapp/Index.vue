<template>
    <Head title="Layanan Whatsapp" />
      <AuthenticatedLayout>
        <Toast 
            ref="toast"
        />
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <p class="font-semibold text-lg">Whatsapp</p>
                <div class="card bg-white p-6 grid grid-cols-1 gap-4">
                    <p>
                        Untuk mendapatkan ID dan Token silahkan mendaftar di TIBOT. Link <a class="link font-semibold text-blue-500" href="https://app.tibot.biz.id" target="_blank">https://app.tibot.biz.id</a>
                    </p>
                    <div class="form-group container w-full grid grid-cols-1 gap-2">
                        <label for="accessToken" class="text-sm font-semibold">Access Token</label>
                        <input id="accessToken" v-model="accessToken" type="text" class="input input-bordered " placeholder="isi access token anda dari tibot">
                    </div>
                    <div class="form-group container w-full grid grid-cols-1 gap-2">
                        <label for="instanceId" class="text-sm font-semibold">Instance Id</label>
                        <input id="instanceId" v-model="instanceId" type="text" class="input input-bordered " placeholder="isi access token anda dari tibot">
                    </div>
                    <button @click="tautkanHandler" class="btn btn-primary"> 
                        <svg xmlns="http://www.w3.org/2000/svg" v-show="status == 'idle'" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 0 0-7.071-7.071L9.878 7.05L8.464 5.636l1.414-1.414a7 7 0 0 1 9.9 9.9zm-2.829 2.828l-1.414 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 0 0 7.07 7.071l1.415-1.414zm-.707-10.607l1.415 1.415l-7.072 7.07l-1.414-1.414z"/></svg>
                        <svg v-show="state.action == 'wa' && state.status == 'loading'" xmlns="http://www.w3.org/2000/svg" class="w-8" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                        Tautkan
                    </button>
                </div>

            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <p class="font-semibold text-lg">Mailketing</p>
                <div class="card bg-white p-6 grid grid-cols-1 gap-4">
                    <p>
                        Untuk mendapatkan token silahkan masuk ke Mailketing. Link <a class="link font-semibold text-blue-500" href="https://be.mailketing.co.id/login" target="_blank">https://be.mailketing.co.id/login</a>
                    </p>
                    <div class="form-group container w-full grid grid-cols-1 gap-2">
                        <label for="mailToken" class="text-sm font-semibold">Access Token</label>
                        <input id="mailToken" v-model="mailToken" type="text" class="input input-bordered " placeholder="isi access token anda dari mailketing">
                    </div>
                    <button @click="tautkanEmailHandler" class="btn btn-primary"> 
                        <svg xmlns="http://www.w3.org/2000/svg" v-show="status == 'idle'" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 0 0-7.071-7.071L9.878 7.05L8.464 5.636l1.414-1.414a7 7 0 0 1 9.9 9.9zm-2.829 2.828l-1.414 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 0 0 7.07 7.071l1.415-1.414zm-.707-10.607l1.415 1.415l-7.072 7.07l-1.414-1.414z"/></svg>
                        <svg v-show="state.action == 'email' && state.status == 'loading'" xmlns="http://www.w3.org/2000/svg" class="w-8" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                        Tautkan
                    </button>
                </div>

            </div>
        </div>
        
      </AuthenticatedLayout>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import Toast from '@/Components/Toast.vue';

export default {
    components:{
        AuthenticatedLayout,Toast
    },
    props:{
        accessTokenParam : String,
        instanceIdParam : String
    },
    data() {
        return {
            accessToken:null,
            instanceId:null,
            mailToken:null,
            state: {
                action: 'null',
                status: 'idle'
            },
            error:Object
        }
    },
    mounted() {
        this.accessToken = this.accessTokenParam;
        this.instanceId = this.instanceIdParam;
    },
    watch: {
        error(newVal){
            console.log(newVal)
        }
    },
    methods: {
        async tautkanHandler(){
            try {
                this.state = {
                    'action' : 'wa',
                    'status' : 'loading'
                }

                setTimeout(async () => {
                    const response = await axios.get(
                        route('client.wa.setWebhook',{
                            _query:{
                                access_token : this.accessToken,
                                instance_id : this.instanceId
                            }
                        })
                    )
                    .then((result) => {
                        this.state = {
                            'action' : 'wa',
                            'status' : 'idle'
                        }
                        this.$refs.toast.show('success','Berhasil menyambungkan whatsapp','anda dapat menggunakan pesan whatsapp pada web ini')
                        setTimeout(() => {
                            this.$refs.toast.hide();
                        }, 3000);
                        
                    }).catch((err) => {
                        this.state = {
                            'action' : 'wa',
                            'status' : 'idle'
                        }
                        this.error = {
                            message: err.response.data.message
                        }
                        this.$refs.toast.show('error','Gagal menyambungkan whatsapp')
                        setTimeout(() => {
                            this.$refs.toast.hide();
                        }, 3000);
                    });

                  
                    
                }, 3000)
                
            } catch (error) {
                this.$refs.toast.show('error','Gagal menyambungkan whatsapp')
                setTimeout(() => {
                    this.$refs.toast.hide();
                }, 3000);
            }
        },
        async tautkanEmailHandler(){
            try {
                this.state = {
                    'action' : 'email',
                    'status' : 'loading'
                }

                setTimeout(async () => {
                    const response = await axios.post(
                        route('client.mail.register'),
                        {
                            token:this.mailToken
                        }
                    )
                    .then((result) => {
                        this.state = {
                            'action' : 'email',
                            'status' : 'idle'
                        }
                        this.$refs.toast.show('success','Berhasil menyambungkan email','anda dapat menggunakan email pada web ini')
                        setTimeout(() => {
                            this.$refs.toast.hide();
                        }, 3000);
                        
                    }).catch((err) => {
                        this.state = {
                            'action' : 'email',
                            'status' : 'idle'
                        }
                        this.error = {
                            message: err.response.data.message
                        }
                        this.$refs.toast.show('error','Gagal menyambungkan email')
                        setTimeout(() => {
                            this.$refs.toast.hide();
                        }, 3000);
                    });

                  
                    
                }, 3000)
            } catch (error) {
                this.$refs.toast.show('error','Gagal menyambungkan email')
                setTimeout(() => {
                    this.$refs.toast.hide();
                }, 3000);
            }
        }
    },
    
}
</script>