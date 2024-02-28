<template>
    <div class="border fixed right-4 bottom-4 bg-white min-h-24 min-w-80 p-6 rounded-lg
    shadow-lg">
        <svg v-if="status == 'loading'" xmlns="http://www.w3.org/2000/svg" class="w-6 text-blue-500" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"><path stroke-dasharray="2 4" stroke-dashoffset="6" d="M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3"><animate attributeName="stroke-dashoffset" dur="0.6s" repeatCount="indefinite" values="6;0"/></path><path stroke-dasharray="30" stroke-dashoffset="30" d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.1s" dur="0.3s" values="30;0"/></path><path stroke-dasharray="10" stroke-dashoffset="10" d="M12 16v-7.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.5s" dur="0.2s" values="10;0"/></path><path stroke-dasharray="6" stroke-dashoffset="6" d="M12 8.5l3.5 3.5M12 8.5l-3.5 3.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="6;0"/></path></g></svg>
        <svg v-if="status == 'success'" xmlns="http://www.w3.org/2000/svg" class="w-6 text-emerald-500" viewBox="0 0 24 24"><defs><mask id="lineMdCheckAll0"><g fill="none" stroke="#fff" stroke-dasharray="22" stroke-dashoffset="22" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M2 13.5l4 4l10.75 -10.75"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="22;0"/></path><path stroke="#000" stroke-width="4" d="M7.5 13.5l4 4l10.75 -10.75" opacity="0"><set attributeName="opacity" begin="0.4s" to="1"/><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.4s" dur="0.4s" values="22;0"/></path><path d="M7.5 13.5l4 4l10.75 -10.75" opacity="0"><set attributeName="opacity" begin="0.4s" to="1"/><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.4s" dur="0.4s" values="22;0"/></path></g></mask></defs><rect width="24" height="24" fill="currentColor" mask="url(#lineMdCheckAll0)"/></svg>
        <svg  v-if="status == 'error'" xmlns="http://www.w3.org/2000/svg" class="w-6 text-rose-500" viewBox="0 0 24 24"><g stroke="currentColor" stroke-linecap="round" stroke-width="2"><path fill="currentColor" fill-opacity="0" stroke-dasharray="60" stroke-dashoffset="60" d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.5s" values="60;0"/><animate fill="freeze" attributeName="fill-opacity" begin="1.2s" dur="0.15s" values="0;0.3"/></path><path fill="none" stroke-dasharray="8" stroke-dashoffset="8" d="M12 7V13"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="8;0"/></path></g><circle cx="12" cy="17" r="1" fill="currentColor" fill-opacity="0"><animate fill="freeze" attributeName="fill-opacity" begin="0.8s" dur="0.4s" values="0;1"/></circle></svg>
        <slot></slot>
    </div>
</template>

<script>
export default {
    props:{
        status:String
    }   
}
</script>