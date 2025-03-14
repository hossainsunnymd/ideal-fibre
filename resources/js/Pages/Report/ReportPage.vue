<script setup>
import SideNavLayout from '../../Layout/SideNavLayout.vue'
import { reactive } from 'vue';

const data = reactive({
    fromDate: '',
    toDate: '',
})

const salesReport=()=>{
    window.open(`/sales-report?fromDate=${data.fromDate}&toDate=${data.toDate}`);
}
</script>

<template>
<SideNavLayout>
    <div class="min-h-[400px] max-w-[500px] border rounded-md shadow-md bg-white ">

       <div class="p-5">
        <div>
            <label class="text-2xl font-bold" for="fromDate">From Date:</label>
            <input v-model="data.fromDate" class="block w-full border rounded-md border-gray-200 p-2" type="date" name="fromDate" id="fromDate">
        </div>
        <div class="mt-10">
            <label class="text-2xl font-bold" for="toDate">To Date:</label>
            <input v-model="data.toDate" class="block w-full p-2 border rounded-md border-gray-200" type="date" name="toDate" id="toDate">
        </div>
        <button @click="salesReport" class="p-2 bg-indigo-600 text-white rounded-md mt-4 hover:bg-indigo-700 font-bold">Confirm</button>
       </div>


    </div>
</SideNavLayout>
</template>

<style scoped>

</style>
