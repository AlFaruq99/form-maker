<template>
    <Head :title="formulir.title" />
      <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <div class="bg-white card overflow-hidden p-4 grid grid-cols-1 gap-6">
                   
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