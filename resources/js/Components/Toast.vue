<template>
    <div ref="toast" class="hidden container p-6 absolute w-fit right-0">
        <div role="alert" class="alert shadow-lg animate-shake"
        :class="{
            'bg-white text-neutral-900' : status == 'none',
            'bg-red-100 text-neutral-900' : status == 'error',
            'bg-success text-neutral-900' : status == 'success',
        }">
            <svg v-show="status == 'none'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <svg v-show="status == 'error'" xmlns="http://www.w3.org/2000/svg" class="stroke-white text-red-500 shrink-0 w-6 h-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17q.425 0 .713-.288T13 16q0-.425-.288-.712T12 15q-.425 0-.712.288T11 16q0 .425.288.713T12 17m-1-4h2V7h-2zm1 9q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22"/></svg>
            <svg v-show="status == 'success'" xmlns="http://www.w3.org/2000/svg" class="stroke-black text-white shrink-0 w-6 h-6" width="1em" height="1em" viewBox="0 0 1024 1024"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z"/></svg>
            
            
            <div>
                <h3 class="font-bold">{{ title }}</h3>
                <div class="text-xs">{{ message }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:{ 
        status:{
            type:String,
            default:'none'
        },
        title:String,
        message:String
    },
    mounted() {
        
    },
    methods: {
        show(){
            const classList = this.$refs.toast.classList;
            classList.remove('hidden');
        },
        hide(){
            const classList = this.$refs.toast.classList;
            classList.add('hidden');
        }
    },
}
</script>