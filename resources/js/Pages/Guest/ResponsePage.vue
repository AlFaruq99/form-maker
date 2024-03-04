<template>
    <Head :title="formulir.title" />
    <div class="bg-emerald-700 py-12 min-h-screen">
        <div class="max-w-7xl  mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
            <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-2 shadow-md">
                {{ formulir.message }}
            </div>
        </div>
    </div>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
export default {
    components:{Head},
    props:{
        formulir:Array,
        answer:Array
    },
    data() {
        return {
            responseArray:[]
        }
    },
    mounted() {
        
        this.getVariableResponse(this.formulir.message,this.answer);
    },
    methods: {
        getVariableResponse(input, object) {
            this.formulir.message = input.replace(/\[([^\]]+)\]/g, (_, match) => {

                let answerVar = null
                object.forEach(element => {
                    if (element.kolom == match) {
                        answerVar = element.answer
                    }
                });

                return answerVar;
            });
        }

    },  
}
</script>