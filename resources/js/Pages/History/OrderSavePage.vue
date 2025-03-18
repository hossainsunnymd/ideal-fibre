<script setup>
import SideNavLayout from '../../Layout/SideNavLayout.vue';
import { useForm,usePage,router } from '@inertiajs/vue3';
import {createToaster} from "@meforma/vue-toaster";
const toaster = createToaster({});
const page = usePage();

let params=new URLSearchParams(window.location.search);
let id=params.get('id');
let list = page.props.order;
const form = useForm({
    delivered_work_order: list.delivered_work_order,
    pending_work_order: list.pending_work_order,
    id: id

})

const submitForm = () => {
    if(form.complete_work_order==''){
        toaster.error("Complete Work Order is required");
    }else if(form.incomplete_work_order==''){
        toaster.error("Incomplete Work Order is required");
    }else{
    form.post('/update-work-order',{
        preserveScroll: true,
        onSuccess: () => {
            if(page.props.flash.status===true){
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/delivery-history-page");
                },500);
            }
            else {
                toaster.error(page.props.flash.message)
            }
        }
    });
}
}
</script>

<template>
    <SideNavLayout>
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Update Work Order</h1>
    <form @submit.prevent="submitForm"  class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
      <input type="text" v-model="form.id" hidden  name="id">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="delivered-work-order">Delivered Work Order</label>
        <input v-model="form.delivered_work_order" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="pending-work-order">Pending Work Order</label>
        <input v-model="form.pending_work_order" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" >
      </div>
      <button type="submit"
        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2.5 rounded-lg transition-colors"
        > Update </button>
    </form>
  </div>
</SideNavLayout>
</template>

<style scoped>

</style>
