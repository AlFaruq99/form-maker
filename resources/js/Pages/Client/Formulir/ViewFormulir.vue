<template>
    <Head :title="formulir.title" />
      <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-6">
                    <p>{{ formulir.title }}</p>
                    <hr>
                    <div class="mt-2" v-for="(item, index) in formulir.content" :key="index">
                        
                        <div class="container form-group space-y-1">
                            <!-- {{ item }} -->
                            <Label>{{item.kolom}}</Label>
                            <div v-if="item.tipe == 'text'">
                                <input type="text"  class="input input-bordered w-full" :placeholder="item.kolom">
                            </div>

                            <div v-if="item.tipe == 'option'">
                                <select name="" class="select select-bordered w-full" id="">
                                    <option :value="itemOption.text" v-for="(itemOption, indexOption) in item.opsi" :key="indexOption">
                                        {{ itemOption.text }}
                                    </option>
                                </select>
                            </div>

                            <div v-if="item.tipe == 'multiple'"  class="flex flex-row items-center space-x-2" v-for="(itemOption, indexOption) in item.opsi" :key="indexOption" >
                                <input class="checkbox" type="checkbox" name="" :id="indexOption">
                                <label :for="indexOption">{{ itemOption.text }}</label>
                            </div>

                            <div v-if="item.tipe == 'email'">
                                <input type="email" class="input input-bordered w-full">
                            </div>
                            <span v-if="item.required == '1'" class="text-sm italic text-blue-500">*data harus diisi</span>
                        </div>
                        
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
      </AuthenticatedLayout>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    components:{
        Link, Head, AuthenticatedLayout
    },
    props:{
        formulir:Array
    }
}
</script>