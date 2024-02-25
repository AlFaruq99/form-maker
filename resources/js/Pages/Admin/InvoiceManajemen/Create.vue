<template>
    <head title="Invoice" />
       <AuthenticatedLayoutAdmin>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice</h2>
            </template>
            <div class=" relative py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                    <div class="card bg-white p-4 shadow grid grid-cols-1 gap-6">
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div class="w-full">
                                <label v-if="!url_file_path" for="dropzone-file" class="lg:order-first sm:order-last cursor-pointer flex flex-col items-center rounded-xl border-2 border-dashed border-blue-400 bg-white py-5 text-center min-h-40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 448 512" stroke="blue" stroke-width="6">
                                        <path d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z"/>
                                    </svg>
                                    <p class="mt-5 text-gray-500 tracking-wide">Upload logo Anda di sini <br> (format jpg, jpeg, png, svg)</p>
                                    <input id="dropzone-file" type="file" class="hidden" @change="onFileChange"/>
                                </label>
                                <div id="preview" class="flex gap-4">
                                    <img class="max-h-40" v-if="url_file_path" :src="url_file_path" />
                                    <button class="rounded-lg btn btn-outline btn-error" v-if="url_file_path" @click="clearUrl">x</button>
                                </div>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 lg:grid-flow-col-dense gap-4">
                            <div class="lg:flex">
                                <p class="lg:w-1/4 pt-3">Dari</p>
                                <div class="lg:w-3/4">
                                    <input type="text" v-model="s_company_name" placeholder="Nama Perusahaan Anda *" class="input input-bordered w-full mb-2" />
                                    <input type="text" v-model="s_company_address" placeholder="Alamat Perusahaan Anda *" class="input input-bordered w-full mb-2" />
                                    <input type="text" v-model="s_phone_number" placeholder="No telepon *" class="input input-bordered w-full mb-2" />
                                    <input type="text" v-model="s_email" placeholder="Alamat Email *" class="input input-bordered w-full mb-2" />
                                </div>
                            </div>
                            <div class="grid lg:grid-cols-2 gap-2 lg:grid-rows-4">
                                <p class="my-auto">No Invoice</p>
                                <input type="text" v-model="no_invoice" placeholder="001/INV/01/2021" class="input input-bordered" >
                                <p class="my-auto">Tanggal Transaksi</p>
                                <vue-date-picker id="date" v-model="transaksiDate" placeholder="dd/mm/yyyy"></vue-date-picker>
                                <p class="my-auto">Tanggal Jatuh Tempo</p>
                                <vue-date-picker id="date" v-model="dueDate" placeholder="dd/mm/yyyy"></vue-date-picker>
                            </div>
                        </div>
                        <hr>
                        <div class="grid lg:grid-cols-2 lg:grid-flow-col-dense sm:gap-2 lg:gap-4">
                            <div class="lg:flex">
                                <p class="lg:w-1/4 pt-3">Kepada</p>
                                <div class="lg:w-3/4">
                                    <input type="text" v-model="d_company_name" placeholder="Nama Perusahaan *" class="input input-bordered w-full mb-2" />
                                    <input type="text" v-model="d_company_address" placeholder="Alamat Perusahaan *" class="input input-bordered w-full mb-2" />
                                </div>
                            </div>
                            <div class="lg:w-3/4 lg:justify-self-end grid lg:grid-rows-2 lg:grid-flow-row-dense gap-2">
                                <input type="text" v-model="d_phone_number" placeholder="No Telepon *" class="input input-bordered" />
                                <input type="text" v-model="d_email" placeholder="Alamat Email *" class="input input-bordered" />
                            </div>
                        </div>
                        <div class="overflow-x-auto border p-2 rounded">
                            <table class="border-separate border-spacing-2">
                                <thead>
                                    <tr>
                                        <th v-for="(column, colIndex) in columns" :key="colIndex">
                                            {{ column }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in rows" :key="index" class="divide-y">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <textarea class="textarea textarea-bordered rounded-lg max-h-5 mt-2"  v-model="row.produk"  placeholder="Ketik produk di sini"></textarea>
                                        </td>
                                        <td>
                                            <textarea class="textarea textarea-bordered rounded-lg max-h-5 mt-2"  v-model="row.description"  placeholder="Ketik deskripsi di sini"></textarea>
                                        </td>
                                        <td><input class="max-w-24 rounded-lg text-center border-inherit" type="number" v-model.number="row.quantity"  placeholder="0"></td>
                                        <td><input class="max-w-24 rounded-lg text-center border-inherit" type="text" v-model="row.unit" placeholder="pcs"></td>
                                        <td>
                                            <div class="flex">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-l-lg my-auto">Rp </label>
                                                <input type="number" class="max-w-40 border-inherit rounded-r-lg text-end" v-model.number="row.price" placeholder="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex">
                                                <input  class="max-w-24 border-inherit rounded-l-lg text-end" type="number" v-model="row.discount" placeholder="0">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-r-lg my-auto">%</label>
                                            </div>
                                        </td>
                                        <td class="flex pt-3">
                                            <div class="flex">
                                                <input class="max-w-24 border-inherit rounded-l-lg text-end" type="number" v-model.number="row.tax" placeholder="0">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-r-lg my-auto">%</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-l-lg my-auto">Rp </label>
                                                <input type="number" class="max-w-40 border-inherit rounded-r-lg text-end" v-model.number="row.total" placeholder="0" disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <button @click="deleteRow(index)" class="rounded-full btn btn-outline min-w-4 max-w-4 min-h-1 max-h-7"><span>-</span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button @click="addRow" class="btn btn-outline btn-primary lg:w-1/6">+ Tambah Baris</button>
                        <div class="grid lg:grid-cols-2 gap-2">
                            <div>
                                <b>Catatan :</b><br>
                                <textarea v-model="note" class="textarea text-black textarea-bordered min-h-5 max-h-24 w-full" placeholder="Ketik catatan Anda di sini"></textarea>
                            </div>
                            <div class="grid grid-rows">
                                <div class="grid grid-cols-2 pr-3">
                                    <b>Subtotal</b>
                                    <span class="text-right font-bold">{{ grandTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</span>
                                    <p>Diskon</p>
                                    <span class="text-right">( {{ grandTotalDisc.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }} )</span>
                                    <p>Pajak</p>
                                    <span class="text-right">{{ grandTotalTax.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</span>
                                </div>
                                <hr>
                                <div class="grid grid-cols-2 mt-2">
                                    <b>Total</b>
                                    <span class="text-right"><b>{{ grandTotalAll.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}</b></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="flex justify-end gap-4">
                            <button type="button" class="btn btn-primary" @click="createHandler">Simpan</button>
                        </div>
                    </div>
                </div>
                <Toast
                    class="bottom-0"
                    ref="toast"
                    status="error"
                    title="Tidak ada layanan!"
                    :message="errors?.message??null"
                />
            </div>
       </AuthenticatedLayoutAdmin> 
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import moment from 'moment';
import axios from 'axios';
import Toast from '@/Components/Toast.vue';

export default {
    components: {
        AuthenticatedLayoutAdmin,Head,Toast
    },
    props:{
        status:String,
        no_invoice:String
    },
    data() {
        return {
            url_file_path: null,
            file:null,
            no_invoice: this.no_invoice,
            transaksiDate: moment(),
            dueDate: moment().add(3,'day'),
            s_company_name:null,
            s_company_address: null,
            s_phone_number: null,
            s_email: null,
            d_company_name:null,
            d_company_address:null,
            d_phone_number:null,
            d_email : null,
            note:null,
            columns: ['No', 'Produk', 'Deskripsi', 'Qty', 'Unit', 'Harga per unit', 'Diskon', 'Pajak', 'Total'],
            rows: [{ description: '', quantity: 0, unit: null, price: 0, discount: 0, tax: 0 }],

            
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
            this.url_file_path = null;
            const fileInput = document.getElementById('dropzone-file');
            fileInput.value = '';
        },
        formatDate() {
            this.transaksiDate = moment(this.transaksiDate).format('YYYY-MM-DD');
            this.dueDate = moment(this.dueDate).format('YYYY-MM-DD'); 
        },
        addRow() {
            this.rows.push({ description: null, quantity: 0, unit: null, price: 0, discount: 0, tax: 0 });
        },
        deleteRow(index) {
            if (this.rows.length > 1) {
                this.rows.splice(index, 1);
            }
        },
        async createHandler() {
            try {
                const invoiceData = {
                    status:this.status.value,
                    file: this.file,
                    no_invoice: this.no_invoice,
                    transaksiDate: this.transaksiDate,
                    dueDate: this.dueDate,
                    s_company_name:this.s_company_name,
                    s_company_address: this.s_company_address,
                    s_phone_number: this.s_phone_number,
                    s_email: this.s_email,
                    d_company_name: this.d_company_name,
                    d_company_address: this.d_company_address,
                    d_phone_number: this.d_phone_number,
                    d_email: this.d_email,
                    note: this.note,
                    rows: this.rows,
                    subtotal: this.grandTotal,
                    discount: this.grandTotalDisc,
                    tax: this.grandTotalTax,
                    total: this.grandTotalAll
                };


                const response = await axios.post(
                    route('panel.invoice.store'), 
                    invoiceData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then((result) => {
                    return result;
                })
                console.log(response.status)
                if (response.status == 200) {
                    this.$refs.toast.show('success','Berhasil membuat faktur!','Data yang anda telah disimpan')
                    window.location.href = route('panel.invoice.index');
                    return

                }else{
                    this.$refs.toast.show('error','Gagal membuat faktur!','Terjadi kesalahan membuat faktur')
                }
                

                setTimeout(() => {
                    this.$refs.toast.hide()
                }, 3000);
                return;
                
            } catch (error) {

                this.$refs.toast.show('error','Gagal membuat faktur!','Terjadi kesalahan membuat faktur')
                setTimeout(() => {
                    this.$refs.toast.hide()
                }, 3000);
            }
        },
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
            return (this.grandTotal - this.grandTotalDisc) + this.grandTotalTax;
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
                row.total = (row.quantity * row.price - ( row.price * (row.discount / 100) )) + ( row.price * (row.tax / 100) );
            }
        }
        }
    }
}
</script>