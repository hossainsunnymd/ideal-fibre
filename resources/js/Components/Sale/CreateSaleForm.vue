<template>
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
                        <input v-model="productQty" type="text" name="text" id="qty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  />
                    </div>

                    <button @click="addProduct()" type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>

                </div>
            </div>
        </div>
    </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
        <div class="min-h-[500px] border min-w border-gray-200 rounded-md px-4 py-2">
            <h1 class="text-lg font-bold text-gray-700 text-end">Invoice</h1>
            <h1 class="text-lg font-bold text-gray-700 text-end">{{ new Date().toISOString().slice(0, 10) }}</h1>

            <div>
                <h1 class="text-lg font-bold text-gray-700 "> Bill To </h1>
                <h1 class="text-sm font-bold text-gray-700 "> Name: {{ customer.name }} </h1>
                <h1 class="text-sm font-bold text-gray-700 "> User Id: {{ customer.id }}</h1>
            </div>
            <div>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Weight</th>
                            <th>Size</th>
                            <th>Rate</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr v-if="productList.length > 0" v-for="(product,index) in productList" :key="index" class="text-center">
                                <td> {{ index+1 }} </td>
                                <td> {{ product['description'] }} </td>
                                <td> {{ product['qty'] }} </td>
                                <td> {{ product['weight'] }} </td>
                                <td> {{ product['size'] }} </td>
                                <td> {{ product['rate'] }}</td>
                                <td> {{ product['order_price'] }}</td>

                                <td>
                                    <button @click="removeProduct(index)" class="text-red-600 ml-2">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                </table>
             <div class="mt-10">
                <h1> Total:  {{ calculate.total }} </h1>
                <h1> Payable:  {{ calculate.payable }}  </h1>
             </div>
             <div>
                <button @click="createInvoice()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-2 rounded">Confirm</button>
            </div>
            </div>
        </div>

        <div class="max-h-[500px] border border-gray-200 rounded-md">
            <input
                v-model="searchProduct"
                type="text"
                class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                placeholder="Search...."
            />
            <EasyDataTable
                buttons-paginations
                alternating
                :items="products"
                :headers="productsHeaders"
                :rows-per-page="10"
                :search-value="searchProduct"
                :seach-field="productSearchField"
            >

                <template #item-action="{ id,decription,rate,size,weight }">
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-2 rounded"
                        @click="addQty(id,decription,rate,size,weight)"
                    >
                        Add
                    </button>
                </template>
            </EasyDataTable>
        </div>

        <div class="max-h-[500px] border border-gray-200 rounded-md">
            <input
                v-model="searchCustomer"
                type="text"
                class="mb-2 px-2 py-1 w-[300px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                placeholder="Search...."
            />
            <EasyDataTable
                buttons-paginations
                alternating
                :items="customers"
                :headers="customersHeaders"
                :rows-per-page="10"
                :search-value="searchCustomer"
                :seach-field="customerSearchField"
            >
                <template #item-action="{name,id }">
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-2 rounded"
                        @click="addCustomer(name,id)"
                    >
                        Add
                    </button>
                </template>
            </EasyDataTable>
        </div>
    </div>
</template>

<script setup>
import { ref ,reactive} from "vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
const page = usePage();
import { createToaster } from "@meforma/vue-toaster";

const showModal=ref(false)
const toaster = createToaster({ });

const productsHeaders = [
    { text: "No", value: "id" },
    { text: "Description", value: "decription" },
    { text: "Size", value: "size" },
    { text: "Weight", value: "weight" },
    { text: "Rate", value: "rate", sortable: true },
    { text: "Action", value: "action" },
];
const searchCustomer = ref();
const customerSearchField = ref(["description"]);
const searchProduct = ref();
const productSearchField = ref(["name"]);

const customers = ref(page.props.customers);
const products = ref(page.props.products);

const customersHeaders = [
    { text: "No", value: "id" },
    { text: "Name", value: "name", sortable: true },
    { text: "Action", value: "action" },
];

const productList=ref([]);
const productQty=ref('');


const product=reactive({
    id:'',
    description:'',
    rate:'',
    size:'',
    weight:'',
    qty:''

});
function addQty(id,decription,rate,size,weight){

    showModal.value=!showModal.value;
    product.id=id;
    product.description=decription;
    product.rate=rate;
    product.size=size;
    product.weight=weight;
    product.qty=productQty.value;

}
const addProduct = () => {
    if(productQty.value==''){
        toaster.error('Product Quantity is Required');
        return ;
    }

   const selectedProduct={
       id:product.id,
       description:product.description,
       rate:product.rate,
       size:product.size,
       weight:product.weight,
       qty:productQty.value,
       order_price: parseFloat(productQty.value)*parseFloat(product.rate)

   };
   productList.value.push(selectedProduct);
   calculateTotal();
   showModal.value=!showModal.value;
};


const removeProduct = (index)=>{
    productList.value.splice(index,1);
    calculateTotal();
}


const customer=reactive({
    name:'',
    id:''
})

const addCustomer=(name,id)=>{
    customer.name=name;
    customer.id=id;
}

const calculate=reactive({
    total:0,
    payable:0,
})

const calculateTotal=()=>{
    calculate.total=0;
    productList.value.forEach((product)=>{
    calculate.total+=parseFloat(product.order_price);

    });
    calculate.payable=calculate.total;
}

const totalOrder=ref(0);
function totalWorkOrder(){
    productList.value.forEach((product)=>{
        totalOrder.value+=parseFloat(product.qty);
    })
}

const form=useForm({
    cus_id:'',
    products:'',
    total:'',
    payable:'',
    total_work_order:'',
    created_by:page.props.user.name
})


const createInvoice=()=>{
    if(customer.name==''){
        toaster.error('Customer is required');

    }else if(productList.value.length==0){
        toaster.error('Product is required');
    }else{
        totalWorkOrder();
    form.cus_id=customer.id;
    form.products=productList.value;
    form.total=calculate.total;
    form.payable=calculate.payable;
    form.total_work_order=totalOrder.value;

    form.post('create-invoice',{
        onSuccess: () => {

            if(page.props.flash.status===true){
                form.reset();
                productList.value=[];
                calculate.total=0;
                calculate.payable=0;
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/invoice-page");
                },500);
            }
            else {
                toaster.error(page.props.flash.message)

            }
        }
    })
}
}


</script>
