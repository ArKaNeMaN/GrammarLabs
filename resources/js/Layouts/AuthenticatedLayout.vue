<script setup>
import {computed, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Navigation/Dropdown.vue';
import DropdownLink from '@/Components/Navigation/DropdownLink.vue';
import NavLink from '@/Components/Navigation/NavLink.vue';
import ResponsiveNavLink from '@/Components/Navigation/ResponsiveNavLink.vue';
import {isEmpty} from "lodash";
import {usePage} from "@inertiajs/inertia-vue3";

const showingNavigationDropdown = ref(false);

const props = defineProps({
    header: {
        type: String,
        required: false,
        default: null,
    }
});

const RAW_MAIN_MENU_ITEMS = [
    {
        title: 'Главная',
        route: 'dashboard',
        // checkRoute: '',
    },
    {
        title: 'Админка',
        route: 'admin.main',
        forAdmin: true,
    },
];

const MAIN_MENU_ITEMS = computed(() =>
    RAW_MAIN_MENU_ITEMS.filter((item) =>
        !item.forAdmin || usePage().props.value.auth.user.role === 'admin'
    )
);

const USER_MENU_ITEMS = [
    {
        title: 'Ред. профиля',
        route: 'user.profile.edit.show',
        // checkRoute: '',
    },
    {
        title: 'Выход',
        route: 'logout',
        method: 'post',
    },
];
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <nav-link :href="route('dashboard')">
                                    <application-logo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </nav-link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <nav-link
                                    v-for="item in MAIN_MENU_ITEMS"
                                    :key="item.route"
                                    :href="route(item.route)"
                                    :active="route().current(item.checkRoute ?? item.route)"
                                >
                                    {{ item.title }}
                                </nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <span>{{ $page.props.auth.user.name }}</span>
                                                <span v-if="$page.props.auth.user.role === 'admin'"> (админ)</span>

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
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
                                        <dropdown-link
                                            v-for="item in USER_MENU_ITEMS"
                                            :key="item.route"
                                            :href="route(item.route)"
                                            :active="route().current(item.checkRoute ?? item.route)"
                                            :method="item.method ?? 'get'"
                                            as="button"
                                        >
                                            {{ item.title }}
                                        </dropdown-link>
                                    </template>
                                </dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
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
                        <responsive-nav-link
                            v-for="item in MAIN_MENU_ITEMS"
                            :key="item.route"
                            :href="route(item.route)"
                            :active="route().current(item.checkRoute ?? item.route)"
                        >
                            {{ item.title }}
                        </responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.login }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <responsive-nav-link
                                v-for="item in USER_MENU_ITEMS"
                                :key="item.route"
                                :href="route(item.route)"
                                :active="route().current(item.checkRoute ?? item.route)"
                                :method="item.method ?? 'get'"
                                as="button"
                            >
                                {{ item.title }}
                            </responsive-nav-link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="!isEmpty($slots.header) || !isEmpty(header)">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot
                        v-if="isEmpty(header)"
                        name="header"
                    />
                    <h2
                        v-else
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        {{ header }}
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto">
                <slot/>
            </main>
        </div>
    </div>
</template>
