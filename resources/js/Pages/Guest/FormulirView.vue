<template>
    <Head :title="formulir.title" />
    <div :style="backgroundStyle"
    class="py-12 min-h-screen">
        <div class="max-w-7xl  mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
            
            <div class="bg-white border card overflow-hidden p-4 grid grid-cols-1 gap-6 shadow-lg">
                <p class="text-xl font-bold">{{ formulir.title }}</p>
                <p class=" font-thin">{{ formulir.description }}</p>
                <div class="divider"></div>
                <div class="mt-2" v-for="(item, index) in Question.content" :key="index">
                    <div class="container form-group space-y-1">
                        <!-- {{ item }} -->
                        <Label>{{item.kolom}}</Label>
                        <div v-if="item.tipe == 'text'">
                            <input type="text" :name="item.kolom" v-model="item.answer" class="input input-bordered w-full" :placeholder="item.kolom">
                        </div>

                        <div v-if="item.tipe == 'phone'">
                            <input type="text" @input="changePhoneValueHandler($event, index)" :name="item.kolom" v-model="item.answer" class="input input-bordered w-full" placeholder="8xx-xxxx-xxxx">
                        </div>
                        
                        <div v-if="item.tipe == 'option'">
                            <select :name="item.kolom" :required="item.required == '1'" v-model="item.answer" class="select select-bordered w-full" id="">
                                <option :value="itemOption.text" v-for="(itemOption, indexOption) in item.opsi" :key="indexOption">
                                    {{ itemOption.text }}
                                </option>
                            </select>
                        </div>

                        <div v-if="item.tipe == 'multiple'"  class="flex flex-row items-center space-x-2" v-for="(itemOption, indexOption) in item.opsi" :key="indexOption" >
                            <input class="checkbox" :required="item.required == '1'" :name="item.kolom" v-model="item.answer" :true-value="[]" :value="itemOption.text" type="checkbox"  :id="indexOption">
                            <label :for="indexOption">{{ itemOption.text }}</label>
                        </div>

                        <div v-if="item.tipe == 'email'">
                            <input type="email" :required="item.required == '1'" :name="item.kolom" v-model="item.answer" class="input input-bordered w-full">
                        </div>

                        <div v-if="item.tipe == 'file'">
                            <input type="file" :required="item.required == '1'" :name="item.kolom" @change="inputFileHandler($event, index)" class="input input-bordered w-full">
                        </div>
                        <span v-if="item.required == '1'" class="text-sm italic text-red-500">*data harus diisi</span>
                    </div>
                    
                </div>
                <button @click="postAnswerHandler" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    <dialog id="successModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Success!</h3>
            <p class="py-4">Berhasil menyimpan jawaban</p>
            <div class="modal-action">
            <form method="dialog">
                <button class="btn" @click="()=>{}">Oke</button>
            </form>
            </div>
        </div>
        </dialog>
        <dialog id="errorModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Error!</h3>
            <p class="py-4">Gagal mennyimpan jawaban</p>
            <span>{{ errorResponse }}</span>
            <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
            </div>
        </div>
        </dialog>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import FormValidation from '@/formValidation';
import PhoneNumber from '@/PhoneNumber';


export default {
    components:{
        Link, Head, AuthenticatedLayout
    },
    props:{
        formulir:Array
    },
    data() {
        return {
            Question:Array,
            errorResponse:String,
            backgroundStyle:{
                'background': `url(${this.formulir.image_background})`,
                'background-size': 'cover'
            },
        }
    },
    mounted() {
        this.Question = this.formulir
    },
    methods: {
        changePhoneValueHandler(component, index){
            var item = component.target;
            const numberVal = new PhoneNumber().formatPhoneNumber(item.value);
            this.Question.content[index].answer = numberVal
        },
        inputFileHandler(component,index){
            this.Question.content[index].answer = component.target.files[0]
        },
        formValidation(data){
            const validateClass = new FormValidation();
            const filteredArray = validateClass.validateForm(data);
            
            if (filteredArray.length > 0) {
                var data = filteredArray.map((item) => {
                    return item.kolom;
                });
                data.join(',')
                return data.join(', ')+' belum diisi';
            }
            else {
                return true
            }            
            
        },
        async postAnswerHandler(){

            const filteredArray = this.formValidation(this.Question.content);
            
            if (filteredArray == true) {
                const response = await axios.post(route('guest.post_formulir'),{
                    'formulir_id' : this.Question.id,
                    'content' : this.Question.content
                },
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                
                if (response.status == 200) {
                    successModal.showModal();
                    
                    const phoneNumberGuest = this.Question.content.filter((item) => {
                        return item.tipe == 'phone'
                    });
                    var responseSendWa = true;
                    if (phoneNumberGuest.length > 0) {
                        let number = phoneNumberGuest[0].answer;
                        responseSendWa = await this.sendResponseWaHandler(number);
                    }
                    
                    setTimeout(() => {
                        window.location.href = route('guest.responsePage',{
                            'form_id' : this.Question.uuid
                        });
                        
                    }, 1000);   
                }
            }else{
                this.errorResponse = filteredArray;
                errorModal.showModal()
            }
        },
        async sendResponseWaHandler(guestPhone){
            try {
                const response = await axios.post(
                route('guest.sendMessage',{
                    'form_id' : this.Question.id
                }),
                {
                    'phone' : guestPhone
                }
                )
                .then((result) => {
                  return true;  
                }).catch((err) => {
                 return false
                });

                return response;
            } catch (error) {
                return false;
            }
        }
       
    },
}
</script>