<script setup>
import { reactive } from 'vue';
import { useForm,usePage,router } from '@inertiajs/vue3';
import {createToaster} from "@meforma/vue-toaster";
const toaster = createToaster({});
const page = usePage();
const status=reactive({
    title:'Create User',
    buttonTitle:'Create User',
})
let params=new URLSearchParams(window.location.search);
let id=params.get('id');

const form = useForm({
    name: '',
    email: '',
    mobile: '',
    role: '',
    password: '',
    id: id
})

let list = page.props.user;

let URL='/create-user';
if(id !==0 && list !== null ){
    URL='/update-user';
    form.name=list.name;
    form.email=list.email;
    form.mobile=list.mobile;
    form.password=list.password;
    form.role=list.role;
    status.title='Update User';
    status.buttonTitle='Update User';
}

const submitForm = () => {
    if(form.name==''){
        toaster.error("Name is required");
    }else if(form.email==''){
        toaster.error("Email is required");
    }else if(form.mobile==''){
        toaster.error("mobile is required");
    }else if(form.role==''){
        toaster.error("role is required");
    }else{
    form.post(URL,{
        preserveScroll: true,
        onSuccess: () => {
            if(page.props.flash.status===true){
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/user-page");
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
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">{{ status.title }}</h1>
    <form @submit.prevent="submitForm"  class="w-full max-w-sm mx-auto bg-white p-8 rounded-md shadow-md">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
        <input v-model="form.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="name" name="name">
          <input type="text" v-model="form.id" hidden  name="id">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input v-model="form.email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="email" name="email">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="mobile">Mobile</label>
        <input v-model="form.mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="mobile" name="mobile">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
        <input v-model="form.password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
          type="text" id="password" name="password">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Role</label>
        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500 bg-white" name="role" v-model="form.role">
            <option value="admin">Admin</option>
            <option value="moderator">Moderator</option>
        </select>
      </div>

      <button type="submit"
        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2.5 rounded-lg transition-colors"
        > {{ status.buttonTitle }} </button>
    </form>
  </div>
</template>

<style scoped>

</style>
