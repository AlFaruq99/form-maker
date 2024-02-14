<template>
    <head title="Invoice" />
       <AuthenticatedLayoutAdmin>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice</h2>
            </template>
            <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8 space-y-6">
                <p class="font-semibold text-lg">Manajemen Faktur</p>
                <div class="grid grid-flow-row grid-cols-4 gap-6">
                    <ul class="menu bg-white h-fit rounded-box grid-cols-1 card w-full space-y-4 py-8">
                        
                        <li class="rounded-md text-neutral-500" :class="{
                            'bg-blue-600 !text-white' : status.value == 'belum_bayar'
                        }">
                            <Link :href="route('panel.invoice.index',{_query:{status:'belum_bayar'}})"> 
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5" viewBox="0 0 16 16"><path fill="currentColor" d="m8.746 8l3.1-3.1a.527.527 0 1 0-.746-.746L8 7.254l-3.1-3.1a.527.527 0 1 0-.746.746l3.1 3.1l-3.1 3.1a.527.527 0 1 0 .746.746l3.1-3.1l3.1 3.1a.527.527 0 1 0 .746-.746zM8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/></svg>
                                Invoice Belum Dibayar
                            </Link>
                        </li>
                        <li class="rounded-md text-neutral-500" :class="{
                            'bg-blue-600 !text-white' : status.value == 'dp'
                        }">
                            <Link :href="route('panel.invoice.index',{_query:{status:'dp'}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M15 16.69V13h1.5v2.82l2.44 1.41l-.75 1.3zM19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2L7.5 3.5L6 2L4.5 3.5L3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.58-1.58c.14.19.3.36.47.53A7.001 7.001 0 0 0 21 11.1V2zM11.1 11c-.6.57-1.07 1.25-1.43 2H6v-2zm-2.03 4c-.07.33-.07.66-.07 1c0 .34 0 .67.07 1H6v-2zM18 9H6V7h12zm2.85 7c0 .64-.12 1.27-.35 1.86c-.26.58-.62 1.14-1.07 1.57c-.43.45-.99.81-1.57 1.07c-.59.23-1.22.35-1.86.35c-2.68 0-4.85-2.17-4.85-4.85c0-1.29.51-2.5 1.42-3.43c.93-.91 2.14-1.42 3.43-1.42c2.67 0 4.85 2.17 4.85 4.85"/></svg>
                                Invoice DP
                            </Link>
                        </li>
                        <li class="rounded-md text-neutral-500" :class="{
                            'bg-blue-600 !text-white' : status.value == 'lunas'
                        }">
                            <Link :href="route('panel.invoice.index',{_query:{status:'lunas'}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2M9 17H6c-.55 0-1-.45-1-1s.45-1 1-1h3c.55 0 1 .45 1 1s-.45 1-1 1m0-4H6c-.55 0-1-.45-1-1s.45-1 1-1h3c.55 0 1 .45 1 1s-.45 1-1 1m0-4H6c-.55 0-1-.45-1-1s.45-1 1-1h3c.55 0 1 .45 1 1s-.45 1-1 1m9.7 2.12l-3.17 3.17c-.39.39-1.03.39-1.42 0l-1.41-1.42a.996.996 0 1 1 1.41-1.41l.71.71l2.47-2.47a.996.996 0 0 1 1.41 0l.01.01c.38.39.38 1.03-.01 1.41"/></svg>
                                Invoice Lunas
                            </Link>
                        </li>
                    </ul>
                    
                    <InvoiceBelumLunas v-show="status.value == 'belum_bayar'"></InvoiceBelumLunas>
                    <InvoiceDP v-show="status.value == 'dp'"></InvoiceDP>
                    <InvoiceLunas v-show="status.value == 'lunas'"></InvoiceLunas>
                </div>
            </div>
       </AuthenticatedLayoutAdmin> 
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import InvoiceBelumLunas from './InvoiceBelumLunas.vue';
import InvoiceDP from './InvoiceDP.vue';
import InvoiceLunas from './InvoiceLunas.vue';
import moment from 'moment';
import axios from 'axios';

export default {
    components: {
        AuthenticatedLayoutAdmin,Head,Link,InvoiceBelumLunas,InvoiceDP,InvoiceLunas
    },
    props:{
        status:String
    },
    data() {
        return {
            url_file_path: null,
            file:null,
            transaksiDate: new Date(),
            dueDate: new Date(),
            no_invoice: null,
            s_company_address: null,
            s_phone_number: null,
            s_email: null,
            d_company_address:null,
            d_phone_number:null,
            d_email : null,
            columns: ['No', 'Deskripsi', 'Qty', 'Unit', 'Harga per unit', 'Diskon', 'Pajak', 'Total'],
            rows: [{ description: '', quantity: null, unit: 'pcs', price: null, discount: null, tax: null }],

            
        }
    },
    methods: {
        onFileChange(e) {
           try {
                const filePath = e.target.files[0];
                this.file  = filePath;
                console.log(this.file)
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.fileData = event.target.result;
                };
                reader.readAsDataURL(filePath);
                this.url_file_path = URL.createObjectURL(filePath);
           } catch (error) {
            console.log(error)
           }
        },
        clearUrl() {
            this.url = null;
            const fileInput = document.getElementById('dropzone-file');
            fileInput.value = '';
        },
        formatDate() {
            this.transaksiDate = moment(this.transaksiDate).format('YYYY-MM-DD');
            this.dueDate = moment(this.dueDate).format('YYYY-MM-DD'); 
        },
        addRow() {
            this.rows.push({ description: '', quantity: 0, unit: 'pcs', price: 0, discount: 0, tax: 0 });
        },
        deleteRow(index) {
            if (this.rows.length > 1) {
                this.rows.splice(index, 1);
            }
        },
        async createHandler() {
            try {
                const invoiceData = {
                    no_invoice: this.no_invoice,
                    transaction_date: this.transaksiDate,
                    due_date: this.dueDate,
                    file: this.file,
                    invoice_name: this.invoice_name,
                    s_company_name: this.s_company_name,
                    s_company_address: this.s_company_address,
                    s_phone_number: this.s_phone_number,
                    s_email: this.s_email,
                    d_company_name: this.d_company_name,
                    d_company_address: this.d_company_address,
                    d_phone_number: this.d_phone_number,
                    d_email: this.d_email,
                    note: this.note,
                    subtotal: this.grandTotal,
                    discount: this.grandTotalDisc,
                    tax: this.grandTotalTax,
                    total: this.grandTotalAll
                };

                console.log(invoiceData);

                const response = await axios.post(
                    route('panel.invoice.create'), 
                    invoiceData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                );
                console.log(response);
                // window.location.href = route('panel.invoice.index');
            } catch (error) {
                console.log(error);
                // console.error('Gagal memasukkan data', error);
            }
        },
        generatePdf() {
            try {
                const response = axios.get(route('panel.invoice.stream',{
                }))

                if (response.status == 200) {
                    const pdfUrl = response.data.link;
                    window.open(pdfUrl, '_blank');
                }
                else{
                    console.error('Failed to generate PDF');
                }

            } catch (error) {
                console.error('Failed to generate PDF');
            }
        }
    },
    computed: {
        grandTotal() {
            return this.rows.reduce((acc, row) => acc + (row.quantity * row.price), 0);
        },
        grandTotalDisc(){
            return this.rows.reduce((acc, row) => acc + (row.quantity * row.price * (row.discount / 100)) ,0)
        },
        grandTotalTax(){
            return this.rows.reduce((acc, row) => acc + (row.quantity * row.price * (row.tax / 100)), 0)
        },
        grandTotalAll(){
            return this.grandTotal - this.grandTotalDisc + this.grandTotalTax;
        }
    },
    mounted() {
        this.formatDate();
    },
    watch: {
        rows: {
        deep: true,
        handler(newVal) {
            for (let row of newVal) {
                row.total = row.quantity * row.price - ( row.price * (row.discount / 100) );
            }
        }
        }
    }
}
</script>
