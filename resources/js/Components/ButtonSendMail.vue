<template>
    <Link :href="userLevel === 'admin' ? route('panel.mail.sendMailPage',{id:dataId}):route('client.mail.sendMailPage',{_query:{id:data.id}})" class="tooltip" data-tip="Bagikan Email">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-primary" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z"/></svg>
    </Link>
</template>
<script>

import {Link} from '@inertiajs/vue3'

export default {
    components:{
        Link
    },
    props:{
        dataId:Number,
        userLevel:String
    },
}
</script>
