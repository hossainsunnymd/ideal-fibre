<script setup>
import { ref } from "vue";
import InvoiceDetails from "./InvoiceDetails.vue";
import { Link, usePage, useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";


const toaster = createToaster({ });



const show = ref(false);
const customer=ref();
const page = usePage();

const searchValue = ref();
const searchField = ref(["customer.name"]);
const headers = [
    { text: "No", value: "id" },
    { text: "Party Name", value: "customer.name" },
    { text: "Moblie", value: "customer.mobile" },
    { text: "Total Work Order", value: "total_work_order" },
    { text: "Total Amount", value: "total" },
    { text: "Created By", value: "created_by" },
    { text: "Created Date", value: "created_at" },
    { text: "Action", value: "action" },
];



const items = ref(page.props.list);

const deleteInvoice = (id) => {
    if (confirm("Are you sure you want to delete this Invoice?")) {
        router.get(`/delete-invoice?id=${id}`);
    }
};

if(page.props.flash.status===true){
    toaster.success(page.props.flash.message);
}

const showDetails = (id) => {
    show.value =! show.value
    customer.value=items.value.find((item) => item.id === id);
}

const searchForm=ref({
     fromDate: '',
     toDate: '',
})

const search = () => {
router.get(`/invoice-page?fromDate=${searchForm.value.fromDate}&toDate=${searchForm.value.toDate}`);

}


const formatDate = (date) => {
    return new Date(date).toISOString().split("T")[0];
};

</script>

<template>

    <div class="p-4 bg-[#f8f8f8]">
        <h1 class="text-2xl font-bold mb-4">Invoices</h1>
        <InvoiceDetails v-model:show="show" :customer="customer"/>
        <div class="flex justify-between mb-5">
            <div>
                <input
            v-model="searchValue"
            type="text"
            class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            placeholder="Search...."
        />
            </div>
            <div class="flex gap-2 items-center justify-center">
                <p>
                    <label for="fromDate">Search From: </label>
                    <input v-model="searchForm.fromDate"  type="date"  class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                </p>
                <p>
                    <label for="toDate" >To: </label>
                    <input v-model="searchForm.toDate" type="date"  class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                </p>
                <button @click="search()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 m-2 text-center mb-4">Search</button>
            </div>
        </div>
        <EasyDataTable
            buttons-pagination
            alternating
            :headers="headers"
            :items="items"
            :search-value="searchValue"
            :search-field="searchField"
            :rows-per-page="5"
        >
            <template #item-action="{ id }">

                <button
                    @click="showDetails(id)">
                    <span class="material-icons">visibility</span>
                </button>
                <button @click="deleteInvoice(id)">
                    <span class="material-icons">delete</span>
                </button>

            </template>
            <template #item-created_at="{ created_at }">
                {{ formatDate(created_at) }}
            </template>

        </EasyDataTable>
        <p class="font-bold mt-3">Total: {{ page.props.total }}</p>

    </div>
</template>

<style scoped></style>
