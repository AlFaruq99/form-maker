<template>
    
    <AuthenticatedLayout v-if="userRole === 'client'">
        <slot></slot>
    </AuthenticatedLayout>
    <AuthenticatedLayoutAdmin v-if="userRole === 'admin'">
        <slot></slot>
    </AuthenticatedLayoutAdmin>

</template>

<script>
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    components:{
    AuthenticatedLayout,
    AuthenticatedLayoutAdmin
},
    props:{
        userRole: String
    }
}
</script>