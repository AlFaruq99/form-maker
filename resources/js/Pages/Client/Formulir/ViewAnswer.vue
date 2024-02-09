<template>
    <Head title="View Answer" />
      <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                
                <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-4">
                    <div class="form-content border-b py-2" v-for="(item, index) in answer" :key="index">
                        <p class=" text-neutral-300">{{ item.kolom }}</p>
                        <div v-if="item.tipe == 'file'">
                            <div class="">
                                <img :src="`${item.path}`" class="rounded-lg  shadow-lg" alt="" srcset="">
                            </div>
                        </div>
                        <p v-else class="font-semibold">{{ item.answer }}</p>
                    </div>
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
        Head, Link,AuthenticatedLayout
    },
    props:{
        answerProp: Array
    },
    data() {
        return {
            answer:Object
        }
    },
    mounted() {
        this.answer = JSON.parse(this.answerProp.answer)
    },
}
</script>