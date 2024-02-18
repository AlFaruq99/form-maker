
<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-rose-600 border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <!-- <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link> -->
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink class="text-white" :href="route('panel.dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-transparent text-white hover:bg-rose-200 hover:text-rose-600 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                       
                        <!-- <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink> -->
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex flex-row">

            <!-- Page Content -->
            <div class="drawer drawer-open w-fit">
                    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
                    
                    <div class="drawer-side">
                        <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label> 
                        <ul class="menu p-4 space-y-2 w-80 min-h-full bg-white shadow text-neutral-900">
                        <!-- Sidebar content here -->
                            <li>
                                <Link :href="route('client.dashboard')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-neutral-600" viewBox="0 0 24 24"><path fill="currentColor" d="M5.615 20q-.666 0-1.14-.475Q4 19.051 4 18.385V12.25h6.5V20zm5.885 0v-7.75H20v6.135q0 .666-.475 1.14q-.474.475-1.14.475zM4 11.25V5.615q0-.666.475-1.14Q4.949 4 5.615 4h12.77q.666 0 1.14.475q.475.474.475 1.14v5.635z"/></svg>
                                    Dashboard
                                </Link>
                            </li>
                            <hr>
                            <li>
                                <Link :href="route('client.form.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-neutral-600"  viewBox="0 0 24 24"><path fill="currentColor" d="M8.25 10a.75.75 0 1 0 0 1.5a.75.75 0 0 0 0-1.5m-.75 6.25a.75.75 0 1 1 1.5 0a.75.75 0 0 1-1.5 0M3 6.25A3.25 3.25 0 0 1 6.25 3h11.5A3.25 3.25 0 0 1 21 6.25v11.5A3.25 3.25 0 0 1 17.75 21H6.25A3.25 3.25 0 0 1 3 17.75zm3 4.5a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0M8.25 14a2.25 2.25 0 1 0 0 4.5a2.25 2.25 0 0 0 0-4.5M12 10.75c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-4.5a.75.75 0 0 0-.75.75m.75 4.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5zM6 6.25c0 .414.336.75.75.75h10.5a.75.75 0 0 0 0-1.5H6.75a.75.75 0 0 0-.75.75"/></svg>
                                    Manajemen Formulir
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('client.invoice.clientIndex')">
                                    <svg xmlns="http://www.w3.org/2000/svg"  class="w-6 text-neutral-600" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M19 21.5H6A3.5 3.5 0 0 1 2.5 18V4.943c0-1.067 1.056-1.744 1.985-1.422c.133.046.263.113.387.202l.175.125a2.51 2.51 0 0 0 2.912-.005a3.52 3.52 0 0 1 4.082 0a2.51 2.51 0 0 0 2.912.005l.175-.125c.993-.71 2.372 0 2.372 1.22V12.5H21a.75.75 0 0 1 .75.75v5.5A2.75 2.75 0 0 1 19 21.5M17.75 14v4.75a1.25 1.25 0 0 0 2.5 0V14zM13.5 9.75a.75.75 0 0 0-.75-.75h-6a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 .75-.75m-1 3a.75.75 0 0 0-.75-.75h-5a.75.75 0 1 0 0 1.5h5a.75.75 0 0 0 .75-.75m.25 2.25a.75.75 0 1 1 0 1.5h-6a.75.75 0 0 1 0-1.5z" clip-rule="evenodd"/></svg>
                                    Manajemen Faktur
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('client.wa.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-neutral-600" viewBox="0 0 24 24"><path fill="currentColor" d="M12.001 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.005 22l1.352-4.968A9.953 9.953 0 0 1 2.001 12c0-5.523 4.477-10 10-10M8.593 7.3l-.2.008a.961.961 0 0 0-.372.1a1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.73 2.73 0 0 0 6.9 9.62c.002.49.13.967.33 1.413c.409.902 1.082 1.857 1.97 2.742c.214.213.424.427.65.626a9.448 9.448 0 0 0 3.84 2.046l.568.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231a4.83 4.83 0 0 0 .383-.22s.043-.028.125-.09c.135-.1.218-.171.33-.288c.083-.086.155-.187.21-.302c.078-.163.156-.474.188-.733c.024-.198.017-.306.014-.373c-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.402-.621a.497.497 0 0 0-.176-.041a.482.482 0 0 0-.378.127c-.005-.002-.072.055-.795.931a.35.35 0 0 1-.368.13a1.43 1.43 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.108a6.025 6.025 0 0 1-1.575-1.003c-.126-.11-.243-.23-.363-.346a6.297 6.297 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41c.11-.14.203-.276.263-.373c.118-.19.155-.385.093-.536c-.28-.684-.57-1.365-.868-2.041c-.059-.134-.234-.23-.393-.249c-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z"/></svg>
                                    Layanan Whatsapp
                                </Link>
                            </li>
                        
                        </ul>
                    
                    </div>
                </div>
                
                <div class="w-full">

                    <Toast/>
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';

export default {
    components:{
        ApplicationLogo,
        Dropdown,
        DropdownLink,
        NavLink,
        ResponsiveNavLink,
        Link,Toast
    },
    data() {
        return {
            showingNavigationDropdown: false,
            errors:null
        }
    },
    watch: {
        errors: {
            handler(newVal, oldVal) {
                if (Object.keys(newVal).length > 0) {
                    this.$refs.toast.show('success','Tidak ada layanan!',errors?.message)
                }
            },
            deep: true  // Aktifkan jika Anda ingin memantau perubahan secara rekursif
        }
    },  
    props:{
        message:String,
    },
    mounted() {
        if (this.$page.props.errors) {
            this.errors = this.$page.props.errors;
            setTimeout(() => {
                if (this.$refs.toast) {
                    this.$refs.toast.hide()
                }
            }, 6000);
        }
    },
    
    
}
</script>
