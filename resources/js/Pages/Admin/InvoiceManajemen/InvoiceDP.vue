<template>
    <div class=" grid grid-cols-1 w-full gap-6 col-span-3">
         <div class="card bg-white p-6 grid grid-cols-1 gap-6">
             <p class="font-semibold">DP</p>
             <div class="container">
                 <Link :href="route('panel.invoice.create',{_query:{
                     status: 'dp'
                 }})" class="btn btn-md btn-primary float-end">
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"/></svg>
                     Buat Invoice
                 </Link>
             </div>
 
             <div class="container filter-container flex flex-row justify-between">
                 <div class="inline-flex space-x-1">
                     <select class="select select-bordered w-fit max-w-xs" v-model="length">
                         <option value="10">10</option>
                         <option :value="item" :hidden="item % 25 != 0" v-for="(item, index) in 100" :key="index" >{{ item }}</option>
                     </select>
                 </div>
                 <div class="w-full inline-flex px-2 space-x-4" v-if="selectedInvoice.length > 0">
                     <button class="btn tooltip" @click="massDeleteHandler" data-tip="hapus data" >
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                     </button>
                     <div class="divider divider-horizontal"></div> 
                     <div class="inline-flex space-x-2">
                         <select v-model="selectedStatus" class="select select-bordered w-full max-w-xs" >
                             <option value="lunas">Lunas</option>
                         </select>
                         <button @click="updateStatusHandler" class="btn bg-emerald-500 text-white">Ubah status</button>
 
                     </div>
                 </div>
                 <div class="inline-flex space-x-2">
                     <input v-model="search" type="text" name="" class="input input-bordered input-md w-full max-w-xs" placeholder="Search...">
                 </div>
             </div>
 
             <div class="container grid grid-cols-1 gap-6">
                 <TableVue>
                     <template v-slot:header>
                         <thead>
                             <tr>
                                 <th></th>
                                 <th>No.</th>
                                 <th>Nomor Invoice</th>
                                 <th></th>
                                 <th>Dari</th>
                                 <th></th>
                                 <th>Kepada</th>
                                 <th>Tanggal Dibuat</th>
                                 <th>Jumlah Item</th>
                                 <th>Total Harus Dibayar</th>
                                 <th></th>
                             </tr>
                         </thead>
                     </template>
                     <template v-slot:body>
                         <tbody>
                             <tr class=" whitespace-nowrap" v-for="(item, index) in invoiceData.data" :key="index">
                                 <td><input v-model="selectedInvoice" :value="item.id" type="checkbox" class="checkbox checkbox-primary"></td>
                                 <td>{{ invoiceData.from + index }}</td>
                                 <td>{{ item?.no_invoice }}</td>
                                 <td>
                                     <div class="inline-flex space-x-2">
                                         <button @click="sendWhastappMedia(item)" class="tooltip" data-tip="Bagikan Whatsapp">
                                             <svg xmlns="http://www.w3.org/2000/svg" v-show="status.type =='loading' && status.itemId == item.id" class="w-6 text-primary" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                                             <svg xmlns="http://www.w3.org/2000/svg" v-show="status.type == 'idle'" class="w-6 text-primary" viewBox="0 0 24 24"><path fill="currentColor" d="M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.264 8.264 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.183 8.183 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07c0 1.22.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28"/></svg>
                                         </button>
                                         <button class="tooltip" data-tip="Bagikan Email">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-primary" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z"/></svg>
                                         </button>
                                         <a :href="route('panel.invoice.download',item.id)" class="tooltip" data-tip="Unduh">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-primary" viewBox="0 0 24 24"><path fill="currentColor" d="M5 20h14v-2H5zM19 9h-4V3H9v6H5l7 7z"/></svg>
                                         </a>
                                     </div>
                                 </td>
                                 <td >
                                     <div class=" flex flex-col">
                                         <span class=" font-semibold">{{ item?.s_company_name }}</span>
                                         <span class=" text-gray-500">{{ item?.s_company_address+' - '+item?.s_phone_number }}</span>
                                     </div>
                                 </td>
                                 <td>
                                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 50 50"><path fill="currentColor" d="M25 42c-9.4 0-17-7.6-17-17S15.6 8 25 8s17 7.6 17 17s-7.6 17-17 17m0-32c-8.3 0-15 6.7-15 15s6.7 15 15 15s15-6.7 15-15s-6.7-15-15-15"/><path fill="currentColor" d="m24.7 34.7l-1.4-1.4l8.3-8.3l-8.3-8.3l1.4-1.4l9.7 9.7z"/><path fill="currentColor" d="M16 24h17v2H16z"/></svg>
                                 </td>
                                 <td>
                                     <div class=" flex flex-col">
                                         <span class=" font-semibold text-blue-600">{{ item?.d_company_name }}</span>
                                         <span class=" text-gray-500">{{ item?.d_company_address+' - '+item?.d_phone_number }}</span>
                                     </div>
                                 </td>
                                 <td>{{ item?.tanggal_invoice }}</td>
                                 <td>{{ item?.item.length }}</td>
                                 <td>{{ item?.total }}</td>
                                 <td>
                                     <Link :href="route('panel.user.userActivation',{
                                         id: item.id
                                     })" v-if="item.status == 'Inactive'"
                                     class="btn btn-sm text-white bg-blue-500 ">Activate</Link>
                                 </td>
                             </tr>
                         </tbody>
                     </template>
                 </TableVue>
                 <div class="w-full flex flex-row justify-between">
                     <p>
                         Show {{invoiceData.from}} - {{ invoiceData.to }} form total {{ invoiceData.total }} data
                     </p>
                     <div class="join">
                         <div v-for="(item, index) in invoiceData.links" :key="index">
                             <button @click="()=>{
                                 changePageHandler(item.url);
                             }" class="join-item btn btn-sm" :class="{
                                 'bg-primary text-white' : item.active
                             }" v-html="item.label"></button>
                         </div>
                         
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <Toast 
     ref="toast"
     />
 </template>
 
 <script>
 import {Head, Link} from '@inertiajs/vue3'
 import TableVue from '@/Components/Table.vue'
 import axios from 'axios'
 import moment from 'moment'
 import Toast from '@/Components/Toast.vue'
 export default {
     components:{
         TableVue, Head, Link,Toast
     },
     props:{
        userId:Number
    },
     data() {
         return {
             invoiceData:[],
             length:10,
             selectedInvoice:[],
             search:null,
             selectedStatus:null,
             status:{
                 itemId:null,
                 type:'idle'
             }
         }
     },
     mounted() {
         this.fetchInvoice()
         
     },
     watch: {
         length(){
             this.fetchInvoice()
         },
         search(newVal){
             if (newVal != null && newVal != '') {
                 this.fetchInvoice()
             }
         }
     },
     methods: {
         changePageHandler(urlParam){
            let url = new URL(urlParam);
            url.searchParams.set('length', this.length);
            url.searchParams.set('user_id', this.userId);
            this.fetchInvoice(url.href);
         },
         async fetchInvoice(urlParam){
 
             let url;
             if (urlParam) {
                 url =urlParam
             }else{
                 url  = route('panel.invoice.fetchInvoice',{_query:{
                     status : 'dp',
                     length : this.length,
                     search : this.search,
                     user_id: this.userId
                 }})
             }
 
             try {
                 const response = await axios.get(url)
                 .then((result) => {
                     return result
                 }).catch((err) => {
                     console.log(err)
                 })
 
                 if (response.status == 200) {
                     this.invoiceData = response.data
 
                     this.invoiceData.data = this.invoiceData.data.map((item) => {
                         item.total = parseFloat(item.total).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                         item.tanggal_invoice = moment(item.created_at).format('DD-MM-YYYY')
                         console.log(item)
                         return item;
                     })
                 }
             } catch (error) {
                 
             }
         },
         async massDeleteHandler(){
             try {
 
                 const response = await axios.post(
                     route('panel.invoice.destroy'),
                     {
                         list : this.selectedInvoice
                     }
                 )
                 .catch((err) => {
                     console.log(err)
                 });
 
                 if (response.status == 200) {
                     this.fetchInvoice()
                     this.selectedInvoice = []
                     this.$refs.toast.show('success','Behasil menghapus faktur yang dipilih','')
                     setTimeout(() => {
                         this.$refs.toast.hide()
                     }, 5000);
                 }
                 
             } catch (error) {
                 this.$refs.toast.show('error','Gagal menghapus faktur yang dipilih','')
                 setTimeout(() => {
                     this.$refs.toast.hide()
                 }, 5000);
             }
         },
         async updateStatusHandler(){
             try {
                 const response = await axios.post(
                     route('panel.invoice.update'),
                     {
                         listId: this.selectedInvoice,
                         status: this.selectedStatus
                     }
                 )
                 
                 if (response.status == 200) {
                     this.selectedInvoice = []
                     this.fetchInvoice()
                     this.$refs.toast.show('success','Behasil mengubah status faktur','buka tab status')
                     setTimeout(() => {
                         this.$refs.toast.hide()
                     }, 5000);
                 } else {
                     this.$refs.toast.show('error','Gagal mengubah status faktur','coba beberapa saat lagi atau hubungi cs')
                     setTimeout(() => {
                         this.$refs.toast.hide()
                     }, 5000);
                 }
                 
             } catch (error) {
                 this.$refs.toast.show('error','Gagal mengubah status faktur','coba beberapa saat lagi atau hubungi cs')
                 setTimeout(() => {
                     this.$refs.toast.hide()
                 }, 5000);
             }
         },
         async sendWhastappMedia(item){
             try {
 
                 this.status = {
                     itemId:item.id,
                     type:'loading'
                 };
                 
                 await axios.get(
                     route('panel.invoice.sendMedia',{
                         id: item.id,
                         number : item.d_phone_number
                     })
                 )
                 .then((result) => {
                     console.log(result)
                     this.status = {
                         itemId:null,
                         type:'idle'
                     };
                     this.$refs.toast.show('success','Behasil mengirim faktur ke wa tujuan','konfirmasi pada nomor tujuan bahwa faktur telah dikirimkan')
                     setTimeout(() => {
                         this.$refs.toast.hide()
                     }, 5000);
                 }).catch((err) => {
                     console.log(err)
                     this.status = {
                         itemId:null,
                         type:'idle'
                     };
                     this.$refs.toast.show('error','Gagal mengirim faktur ke wa tujuan','coba beberapa saat lagi atau hubungi cs')
                     setTimeout(() => {
                         this.$refs.toast.hide()
                     }, 5000);
                 });
             } catch (error) {
                 this.$refs.toast.show('error','Gagal mengirim faktur ke wa tujuan','coba beberapa saat lagi atau hubungi cs')
                 setTimeout(() => {
                     this.$refs.toast.hide()
                 }, 5000);
             }
         }
     },
 }
 </script>