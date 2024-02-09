<template>
    <head title="Invoice" />
       <AuthenticatedLayoutAdmin>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice</h2>
            </template>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                    <div class="card bg-white p-4 shadow grid grid-cols-1 gap-6">
                        <div class="grid grid-cols-2 gap-4">
                            <label for="dropzone-file" class="cursor-pointer flex flex-col items-center rounded-xl border-2 border-dashed border-blue-400 bg-white py-5 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 448 512" stroke="blue" stroke-width="6">
                                    <path d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z"/>
                                </svg>
                                <p class="mt-5 text-gray-500 tracking-wide">Upload logo Anda di sini <br> (format jpg, jpeg, png, svg)</p>
                                <input id="dropzone-file" type="file" class="hidden" />
                            </label>
                            <input type="text" placeholder="Nama Invoice" class="input input-bordered w-1/2 justify-self-end" />
                        </div>
                        <div class="grid grid-cols-2 grid-flow-col-dense gap-4">
                            <div class="flex">
                                <p class="w-1/4 pt-3">Dari</p>
                                <div class="w-3/4">
                                    <input type="text" placeholder="Nama Perusahaan Anda *" class="input input-bordered w-full mb-2" />
                                    <input type="text" placeholder="Alamat Perusahaan Anda *" class="input input-bordered w-full mb-2" />
                                    <input type="text" placeholder="No telepon *" class="input input-bordered w-full mb-2" />
                                    <input type="text" placeholder="Alamat Email *" class="input input-bordered w-full mb-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 grid-rows-4">
                                <p class="my-auto">No Invoice</p>
                                <input type="text" placeholder="001/INV/01/2021" class="input input-bordered">
                                <p class="my-auto">Tanggal Transaksi</p>
                                <vue-date-picker id="date" v-model="transaksiDate" placeholder="dd/mm/yyyy"></vue-date-picker>
                                <p class="my-auto">Tanggal Jatuh Tempo</p>
                                <vue-date-picker id="date" v-model="dueDate" placeholder="dd/mm/yyyy"></vue-date-picker>
                            </div>
                        </div>
                        <hr>
                        <div class="grid grid-cols-2 grid-flow-col-dense gap-4">
                            <div class="flex">
                                <p class="w-1/4 pt-3">Kepada</p>
                                <div class="w-3/4">
                                    <input type="text" placeholder="Nama Perusahaan *" class="input input-bordered w-full mb-2" />
                                    <input type="text" placeholder="Alamat Perusahaan *" class="input input-bordered w-full mb-2" />
                                </div>
                            </div>
                            <div class="w-3/4 justify-self-end grid grid-rows-2 grid-flow-row-dense">
                                <input type="text" placeholder="No Telepon *" class="input input-bordered" />
                                <input type="text" placeholder="Alamat Email *" class="input input-bordered" />
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
                                            <textarea class="textarea textarea-bordered rounded-lg max-h-5 mt-2"  v-model="row[1]"  placeholder="Ketik deskripsi di sini"></textarea>
                                        </td>
                                        <td><input class="max-w-12 rounded-lg text-center border-inherit" type="text" v-model="row[2]" placeholder="0"></td>
                                        <td><input class="max-w-14 rounded-lg text-center border-inherit" type="text" v-model="row[3]" placeholder="pcs"></td>
                                        <td>
                                            <div class="flex">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-l-lg my-auto">Rp </label>
                                                <input type="text" class="max-w-40 border-inherit rounded-r-lg text-end" v-model="row[4]" placeholder="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex">
                                                <input  class="max-w-14 border-inherit rounded-l-lg text-end" type="text" v-model="row[5]" placeholder="0">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-r-lg my-auto">%</label>
                                            </div>
                                        </td>
                                        <td class="flex pt-3">
                                            <div class="flex">
                                                <input class="max-w-14 border-inherit rounded-l-lg text-end" type="text" v-model="row[6]" placeholder="0">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-r-lg my-auto">%</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex">
                                                <label class="min-w-10 p-2 min-h-15 text-black border rounded-l-lg my-auto">Rp </label>
                                                <input type="text" class="max-w-40 border-inherit rounded-r-lg text-end" v-model="row[7]" placeholder="0" disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <button @click="deleteRow(index)" class="rounded-full btn btn-outline min-w-4 max-w-4 min-h-1 max-h-7"><span>-</span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button @click="addRow" class="btn btn-outline btn-primary w-1/6">+ Tambah Baris</button>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <b>Catatan :</b><br>
                                <textarea class="textarea text-black textarea-bordered min-h-5 max-h-24 w-full" placeholder="Ketik catatan Anda di sini"></textarea>
                            </div>
                            <div class="grid grid-rows">
                                <div class="grid grid-cols-2 pr-3">
                                    <b>Subtotal</b>
                                    <span class="text-right"><b>Rp 0,00</b></span>
                                    <p>Diskon</p>
                                    <span class="text-right">(Rp 0,00)</span>
                                    <p>Pajak</p>
                                    <span class="text-right">Rp 0,00</span>
                                </div>
                                <div class="justify-between flex mb-2">
                                    <span class="my-auto">Pemotongan</span>
                                    <div class="border rounded-lg px-2">
                                        <b>Rp</b>
                                        <input class="text-right border-none" type="text" placeholder="0" disabled>
                                    </div>
                                </div>
                                <div class="justify-between flex mb-2">
                                    <span class="my-auto">Deposit</span>
                                    <div class="border rounded-lg px-2">
                                        <b>Rp</b>
                                        <input class="text-right border-none" type="text" placeholder="0" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="grid grid-cols-2 mt-2">
                                    <b>Total</b>
                                    <span class="text-right"><b>Rp 0,00</b></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="flex justify-end">
                            <button class="btn btn-outline btn-primary">Preview</button>
                            <button class="btn btn-primary">Unduh Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
       </AuthenticatedLayoutAdmin> 
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import moment from 'moment';
export default{
    components:{
        AuthenticatedLayoutAdmin,Head
    },
    data(){
        return{
            transaksiDate: new Date(),
            dueDate: new Date(),
            columns: ['No', 'Deskripsi', 'Qty', 'Unit', 'Harga per unit', 'Diskon', 'Pajak', 'Total'],
            rows: [[]]
        }
    },
    methods: {
        async date() {
            transaksiDate = moment(this.transaksiDate).format('DD/MM/YYYY');
            dueDate = moment(this.dueDate).format('DD/MM/YYYY'); 
        },
        addRow() {
            this.rows.push([]);
        },
        deleteRow(index) {
            if(this.rows.length>1){
                this.rows.splice(index, 1);
            }
        }
    }
}
</script>