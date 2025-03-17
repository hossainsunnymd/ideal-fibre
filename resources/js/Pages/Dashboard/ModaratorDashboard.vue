<script setup>
import ModaratorSideNav from '../../Layout/ModaratorSideNav.vue';
import { ref,reactive } from "vue";
import { Link,usePage,useForm, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ });

const page = usePage();

const searchValue = ref();
const searchField = ref(["name","invoice_id"]);
const headers = [
    { text: "No", value: "id" },
    { text: "Party Name", value: "invoice.customer.name", sortable: true },
    { text: "Description", value: "product.decription", sortable: true },
    { text: "Invoice no", value: "invoice_id", sortable: true },
    { text: "Work Order", value: "qty", sortable: true },
    { text: "Incomplete Work Order", value: "incomplete_work_order", sortable: true },
    { text: "Complete Work Order", value: "complete_work_order", sortable: true },
    { text: "Action", value: "action" },
];
console.log(page.props.invoice);

const items = ref(page.props.invoice);
const showModal = ref(false);
const invoiceProductid=ref();
const orderQty=ref();
const delivered_by=ref();

delivered_by.value=page.props.user.name

if(page.props.flash.status===true){
  toaster.success(page.props.flash.message);
}

const openModal = (id) => {
    invoiceProductid.value=id
    showModal.value = !showModal.value;

}


const updateOrder = () => {
    router.get(`/delivered-work-order?id=${invoiceProductid.value}&orderQty=${orderQty.value}&delivered_by=${delivered_by.value}`);

    showModal.value = !showModal.value;
}


</script>

<template>
 <ModaratorSideNav>

    <!-- Main modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add Qty
                </h3>

            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="space-y-4" action="#">
                    <div>
                        <label for="qty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add Quantity</label>
                        <input v-model="orderQty" type="text" name="text" id="qty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  />
                    </div>

                    <button @click="updateOrder()" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>

                </div>
            </div>
        </div>
    </div>
</div>

    <div class="p-4 bg-[#f8f8f8]">
        <h1 class="text-2xl font-bold mb-4">Product List</h1>
        <input
            v-model="searchValue"
            type="text"
            class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            placeholder="Search...."
        />
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
                    @click="openModal(id)"
                    class="bg-green-500 ml-1 text-white font-bold py-2 px-4 rounded"
                >
                    Complete
                </button>
            </template>
        </EasyDataTable>
    </div>

 </ModaratorSideNav>
</template>

<style scoped>

</style>

