<script setup>
import { Link,usePage } from "@inertiajs/vue3";
import { ref } from "vue";
const page = usePage();
const props = defineProps(["name"]);
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("-translate-x-full");
    document.getElementById("top-nav").classList.toggle("ml-0");
}
</script>

<template>
    <div id="header" class="h-[60px]  md:hidden transition duration-300 fixed top-0 left-0 right-0 z-50">
        <button  @click="toggleSidebar" id="menu-toggle" class=" p-2 ml-1 mt-1 bg-gray-200 rounded-md "> <span class="material-icons">menu</span></button>
    </div>

    <!-- Sidebar -->
    <aside
        id="sidebar"
        class="w-64 bg-white shadow-lg flex flex-col fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 md:translate-x-0 z-10"
    >
        <div class="p-4">
            <h1 class="text-lg font-bold text-gray-700">Dashboard</h1>
        </div>
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li>
                    <Link
                        href="/dashboard-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">dashboard</span>
                        <span class="ml-3">Dashboard</span>
                    </Link>
                </li>
                <li v-if="page.props.user.role == 'superadmin'">
                    <Link
                        href="/user-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">person</span>
                        <span class="ml-3">Users</span>
                    </Link>
                </li>


                <li>
                    <Link
                        href="/customer-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">person</span>
                        <span class="ml-3">Party's</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/product-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">inventory</span>
                        <span class="ml-3">Products</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/invoice-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">receipt</span>
                        <span class="ml-3">Orders</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/sale-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">shopping_cart</span>
                        <span class="ml-3">Create Sale</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/delivery-history-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">history</span>
                        <span class="ml-3">Delivery History</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/report-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">report</span>
                        <span class="ml-3">Report</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/profile-page"
                        class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-200 hover:text-gray-900"
                    >
                        <span class="material-icons">account_circle</span>
                        <span class="ml-3">Profile</span>
                    </Link>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t">
            <Link
                href="/user-logout"
                class="w-full px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600"
            >
                Logout
            </Link>
        </div>
    </aside>
    <main class="flex-1 p-6 ml-0 md:ml-64">

        <slot></slot>
    </main>
</template>

<style scoped></style>
