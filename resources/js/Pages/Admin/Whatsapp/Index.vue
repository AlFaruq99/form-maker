<template>
    <ToastVue ref="toast"></ToastVue>
    <AuthenticatedLayoutAdmin>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <p class="font-semibold text-lg">Whatsapp</p>
                <div class="card bg-white p-6 grid grid-cols-1 gap-4">
                    <p>
                        Untuk mendapatkan ID dan Token silahkan mendaftar di TIBOT. Link <a class="link font-semibold text-blue-500" href="https://app.tibot.biz.id">https://app.tibot.biz.id</a>
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
                        <svg v-show="state.action == 'wa' && state.status == 'loading'"  xmlns="http://www.w3.org/2000/svg" class="w-8" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
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
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <p class="font-semibold text-lg">Web Config</p>
                <div class="card bg-white p-6 grid grid-cols-1 gap-4">
                    
                    <div class="form-group container w-full grid grid-cols-1 gap-2">
                        <label for="accessToken" class="text-sm font-semibold">Web Logo</label>
                        <img ref="imageLogoPreview" class="w-36" src="#" alt="Logo image" />
                        <input type="file" @change="changeLogoHandler($event)" class="file-input file-input-bordered w-full max-w-xs" />
                    </div>
                    <div class="form-group container w-full grid grid-cols-1 gap-2">
                        <label for="webName" class="text-sm font-semibold">Web Name</label>
                        <input id="webName" v-model="web.name" type="text" class="input input-bordered " placeholder="your app name">
                    </div>
                    <button @click="updateWebConfigHandler" class="btn btn-outline btn-primary w-fit"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4" viewBox="0 0 48 48"><defs><mask id="ipSCheckOne0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M24 44a19.937 19.937 0 0 0 14.142-5.858A19.937 19.937 0 0 0 44 24a19.938 19.938 0 0 0-5.858-14.142A19.937 19.937 0 0 0 24 4A19.938 19.938 0 0 0 9.858 9.858A19.938 19.938 0 0 0 4 24a19.937 19.937 0 0 0 5.858 14.142A19.938 19.938 0 0 0 24 44Z"/><path stroke="#000" stroke-linecap="round" d="m16 24l6 6l12-12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSCheckOne0)"/></svg>
                        Ganti
                    </button>
                </div>

            </div>
        </div>
    </AuthenticatedLayoutAdmin>
</template>

<script>

import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue'
import axios from 'axios';
import ToastVue from '@/Components/Toast.vue';

export default {
    components:{
        AuthenticatedLayoutAdmin,ToastVue
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
            web:{
                logo:null,
                name:''
            },
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
                        route('panel.whatsapp.setWebhook',{
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
                        this.$refs.toast.show('success','Berhasil menyambungkan aplikasi','anda dapat menggunakan pesan whatsapp pada web ini')
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
                        this.$refs.toast.show('error','Gagal menyambungkan aplikasi',err.response.data.message)
                        setTimeout(() => {
                            this.$refs.toast.hide();
                        }, 3000);
                    });

                  
                    
                }, 3000)
                
            } catch (error) {
                this.$refs.toast.show('error','Gagal menyambungkan aplikasi',error.response.data.message)
                setTimeout(() => {
                    this.$refs.toast.hide();
                }, 3000);
            }
        },
        changeLogoHandler(event){
            const file = event.target.files[0];
            const component = this.$refs.imageLogoPreview
            component.src = URL.createObjectURL(file)
            this.web.logo = file
        },
        async updateWebConfigHandler(){
            try {
                const response = await axios.post(
                    route('panel.config.update',{}),
                    this.web,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                if (response.status == 200) {
                    await axios.post(route('logout'))
                    .then((result) => {
                        window.location.href = '/login'
                    })
                }

            } catch (error) {
                console.log(error)
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
                        route('panel.mail.register'),
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