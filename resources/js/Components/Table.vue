<template>
   <div class="overflow-x-auto">
        <table class="table table-zebra">
            <!-- head -->
            <slot name="header"></slot>
            <slot name="body"></slot>
           
        </table>
    </div>
</template>

<script>
export default {
    
}
</script>