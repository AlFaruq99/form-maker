<template>
    <AuthenticatedLayoutAdmin>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <div class="card bg-white p-4 shadow grid grid-cols-1 gap-6">
                    <span>{{ invoice.no_invoice }}</span>
                    <span>{{ invoice.transaction_date }}</span>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutAdmin>
</template>
<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    components:{
        AuthenticatedLayoutAdmin,Head
    },
    props:{
        invoice: Object
    }
}
</script>