<template>
   <div class=" grid grid-cols-1 w-full gap-6 col-span-3">
        <div class="card bg-white p-6 grid grid-cols-1 gap-6">
            <p class="font-semibold">Belum bayar</p>
            <div class="container">
                <Link :href="route('panel.invoice.create',{_query:{
                    status: 'belum_bayar'
                }})" class="btn btn-md btn-primary float-end">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"/></svg>
                    Buat Invoice
                </Link>
            </div>

            <div class="container filter-container flex flex-row justify-between">
                <div class="inline-flex space-x-2">
                    <select class="select select-bordered w-fit max-w-xs" v-model="length">
                        <option value="10">10</option>
                        <option :value="item" :hidden="item % 25 != 0" v-for="(item, index) in 100" :key="index" >{{ item }}</option>
                    </select>
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
                                <th>No.</th>
                                <th>Dari</th>
                                <th>Kepada</th>
                                <th>Tanggal Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                    </template>
                    <template v-slot:body>
                        <tbody>
                            <!-- <tr v-for="(item, index) in client.data" :key="index">
                                <th>{{ client.from + index }}</th>
                                <th>
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-12">
                                            <span>{{ item.initialName }}</span>
                                        </div>
                                    </div> 
                                </th>
                                <td>{{ item?.name }}</td>
                                <td>{{ item?.email }}</td>
                                <td>{{ item?.status }}</td>
                                <td>{{ item?.jatuh_tempo }}</td>
                                <td>
                                    <Link :href="route('panel.user.userActivation',{
                                        id: item.id
                                    })" v-if="item.status == 'Inactive'"
                                    class="btn btn-sm text-white bg-blue-500 ">Activate</Link>
                                </td>
                            </tr> -->
                        </tbody>
                    </template>
                </TableVue>
            </div>
        </div>
    </div>
</template>

<script>
import {Head, Link} from '@inertiajs/vue3'
import TableVue from '@/Components/Table.vue'
export default {
    components:{
        TableVue, Head, Link
    }
}
</script>