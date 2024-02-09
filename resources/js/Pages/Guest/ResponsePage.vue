<template>
    <Head :title="formulir.title" />
    <div class="bg-emerald-700 py-12 min-h-screen">
        <div class="max-w-7xl  mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
            
            <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-2 shadow-md">
                <span>Terimakasih, jawaban anda telah kami simpan.</span>
                <span>Kami telah mengirim pesan ke nomor anda</span>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
export default {
    components:{Head},
    props:{
        formulir:Array
    },
    mounted() {
        console.log(this.formulir)
    },
}
</script>