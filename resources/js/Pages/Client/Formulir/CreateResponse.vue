<template>
    <div>
        <div class="grid grid-flow-row grid-cols-6 gap-2">
            <button 
            @click="selectVarHandler(index)"
            class="btn"
            v-for="(item, index) in content" :key="index">
                {{ item.kolom }}
            </button>
        </div>
        <textarea v-model="response" class="textarea textarea-bordered w-full" id="" cols="30" rows="10">

        </textarea>
    </div>
</template>

<script>
export default {
    props:{
        content:Array
    },
    data() {
        return {
            response:''
        }
    },
    watch: {
        response:{
            handler:function(newVal){
                console.log(newVal)
                this.changeResponseHandler(newVal)
            },
            deep:true
        }
    },
    methods: {
        selectVarHandler(index){
            this.response += '['+this.content[index].kolom+'] ';
        },
        changeResponseHandler(value){
            this.$emit('response-change',value);
        }
    },
}
</script>