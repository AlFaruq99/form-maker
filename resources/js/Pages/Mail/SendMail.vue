<template>
    <LayoutMailVue :user-role="userRole">
        <div class="grid grid-cols-1 gap-6 bg-white card p-6 m-6">
            <span>Kirim Email</span>
            <hr>
            <label class="input input-bordered flex items-center gap-2 max-w-sm">
                Kepada
                <input v-model="emailTo" type="text" class="grow outline-none border-none focus:border-none focus:outline-none" placeholder="daisy@site.com" />
            </label>
            <div class="form-group w-full">
                <input v-model="subject" type="text" class="input input-bordered w-full" placeholder="Subjek">
            </div>
            <div class="form-group w-full">
                <textarea v-model="content" class="textarea w-full bg-neutral-50" id="" cols="30" rows="10" placeholder="Konten"></textarea>
            </div>
            <div class="button-container">
                <button @click="postMailHandler" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L21 3m0 0l-6.5 18a.55.55 0 0 1-1 0L10 14l-7-3.5a.55.55 0 0 1 0-1z"/></svg>
                    Kirim
                </button>
            </div>
        </div>
        <BottomPopUp v-if="state != 'init'">
            <div v-html="statusMessage"></div>
        </BottomPopUp>
    </LayoutMailVue>
</template>

<script>

import axios from 'axios';
import LayoutMailVue from './Layout.vue';
import BottomPopUp from '@/Components/BottomPopUp.vue';

export default {
    components:{
        LayoutMailVue,BottomPopUp
    },
    props:{
        data: Array,
        file_path: String,
        userRole: String
    },
    data() {
        return {
            emailTo: '',
            subject: '',
            content: '',
            state:'init',
            statusMessage : ''
        }
    },
    watch: {
        state(newVal){
            if (newVal == 'loading') {
                this.statusMessage = `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-blue-500" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"><path stroke-dasharray="2 4" stroke-dashoffset="6" d="M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3"><animate attributeName="stroke-dashoffset" dur="0.6s" repeatCount="indefinite" values="6;0"/></path><path stroke-dasharray="30" stroke-dashoffset="30" d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.1s" dur="0.3s" values="30;0"/></path><path stroke-dasharray="10" stroke-dashoffset="10" d="M12 16v-7.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.5s" dur="0.2s" values="10;0"/></path><path stroke-dasharray="6" stroke-dashoffset="6" d="M12 8.5l3.5 3.5M12 8.5l-3.5 3.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="6;0"/></path></g></svg>Loading`;
            } 
            else if(newVal == 'error'){
                this.statusMessage = `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-red-500" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17q.425 0 .713-.288T13 16q0-.425-.288-.712T12 15q-.425 0-.712.288T11 16q0 .425.288.713T12 17m-1-4h2V7h-2zm1 9q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22"/></svg>Error, Gagal mengirim email`;
            }
            else {
                this.statusMessage = null;
            }
        }
    },
    methods: {
        async postMailHandler(){
            let url;
            switch (this.userRole) {
                case 'admin':
                        url = route('panel.mail.sendInvoice');
                    break;
            
                default:
                    break;
            }
            const formData = new FormData();
            formData.append('id',this.data['id']);
            formData.append('from_name', this.data['s_company_name']);
            formData.append('from_email',this.data['s_email']);
            formData.append('recipient',this.emailTo);
            formData.append('subject',this.subject);
            formData.append('content',this.content);
            // console.log(formData);return;

            try {
                let response;

                response = await axios.post(url,formData);

                
                this.state = 'loading'
                setTimeout(() => {
                    window.location.href = route(this.userRole == 'admin'? 'panel.invoice.index' : 'client.invoice.index');
                }, 3000);
                
            } catch (error) {
                this.state = 'error'
                setTimeout(() => {
                    this.state = 'init'
                }, 3000);
                
            }

        }
    },
}
</script>