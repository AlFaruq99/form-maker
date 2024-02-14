<script setup>
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import { Head } from '@inertiajs/vue3';
import TableVue from '@/Components/Table.vue'
defineProps({
    totalClient : Number,
    totalFormulir : Number,
    clientBilling : Array
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayoutAdmin>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                    <div class="p-6 text-gray-900">You're logged in as admin!</div>
                </div>
                <div class="container bg-white shadow rounded-md">
                    <div class="stats w-full">
                        <div class="stat">
                            <div class="stat-figure text-slate-500 shadow p-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24"><path fill="currentColor" d="M14 7V5h8v2zm0 4V9h8v2zm0 4v-2h8v2zm-6-1q-1.25 0-2.125-.875T5 11q0-1.25.875-2.125T8 8q1.25 0 2.125.875T11 11q0 1.25-.875 2.125T8 14m-6 6v-1.9q0-.525.25-1t.7-.75q1.125-.675 2.388-1.012T8 15q1.4 0 2.663.338t2.387 1.012q.45.275.7.75t.25 1V20z"/></svg>
                            </div>
                            <div class="stat-title">Total User</div>
                            <div class="stat-value">{{ totalClient }}</div>
                        </div>
                        
                        <div class="stat">
                            <div class="stat-figure text-slate-500 shadow p-1 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24"><path fill="currentColor" d="M4 17q-.425 0-.712-.288T3 16V8q0-.425.288-.712T4 7h8q.425 0 .713.288T13 8v8q0 .425-.288.713T12 17zm1-2h6V9H5zM4 5q-.425 0-.712-.288T3 4q0-.425.288-.712T4 3h16q.425 0 .713.288T21 4q0 .425-.288.713T20 5zm12 4q-.425 0-.712-.288T15 8q0-.425.288-.712T16 7h4q.425 0 .713.288T21 8q0 .425-.288.713T20 9zm0 4q-.425 0-.712-.288T15 12q0-.425.288-.712T16 11h4q.425 0 .713.288T21 12q0 .425-.288.713T20 13zm0 4q-.425 0-.712-.288T15 16q0-.425.288-.712T16 15h4q.425 0 .713.288T21 16q0 .425-.288.713T20 17zM4 21q-.425 0-.712-.288T3 20q0-.425.288-.712T4 19h16q.425 0 .713.288T21 20q0 .425-.288.713T20 21z"/></svg>
                            </div>
                            <div class="stat-title">Total Form</div>
                            <div class="stat-value">{{ totalFormulir }}</div>
                        </div>
                    </div>  
                    <TableVue>
                        <template v-slot:header>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Expired At</th>
                                </tr>
                            </thead>
                        </template>
                        <template v-slot:body>
                            <tbody>
                                <tr v-for="(item, index) in clientBilling" :key="index">
                                    <th>{{ index + 1 }}</th>
                                    <td>{{ item?.name }}</td>
                                    <td>{{ item?.email }}</td>
                                    <td>{{ item?.expired_at }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </TableVue>        
                </div>
            </div>
        </div>
    </AuthenticatedLayoutAdmin>
</template>