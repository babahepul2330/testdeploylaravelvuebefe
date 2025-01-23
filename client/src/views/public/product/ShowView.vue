<script setup>
import { useProductStore } from '@/stores/product';
import { storeToRefs } from 'pinia';
import { computed, onBeforeMount, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { parseCurrency } from "@/common/utils/currency";
import ROUTES from '@/common/constants/routes';
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/solid';
import { useOrderStore } from '@/stores/order';


const route = useRoute();
const router = useRouter();
const orderStore = useOrderStore()
const productStore = useProductStore();
const { data, isLoading, message, error, errors } = storeToRefs(productStore);

const form = reactive({
    product: computed(() => data?.value?.product),
    quantity: 1,
})

onBeforeMount(() => {
    productStore.getData(route.params?.id)
})

function decrement() {
    if (form.quantity === 1) return
    form.quantity--
}

function increment() {
    if (form.quantity === data?.value?.product?.stock) return
    form.quantity++
}

function handleCheckout() {
    orderStore.cart.product = form.product
    orderStore.cart.quantity = form.quantity
    router.push(ROUTES.order.create)
}
</script>

<template>


<section class="grid grid-cols-1 md:grid-cols-12 gap-8 mx-5 my-2 p-10  bg-base-100">
    <div class="col-span-1 md:col-span-5">
        <div class="w-full h-78 md:h-96">
            <img :src="data?.product?.image" 
            :alt="data?.product?.name" class="h-full w-full object-cover rounded md:w-full"/>
        </div>
    </div>

    <div class="col-span-1 md:col-span-7">
        <h1 class="text-5xl font-semibold"> 
            {{ data?.product?.name }}
        </h1> 
    
        <h2 class="text-2xl mt-3 font-bold">
            {{ parseCurrency(data?.product?.price) }}
        </h2>   

        <hr class="border  mt-7 mb-3">
        <h1 class="flex-1 text-2xl text-bold">Detail Product</h1>
        <hr class="border mt-3">

        <h2 class="text-2xl font-semibold mt-5"> 
            <span class="text-primary">{{ data?.product?.description }} </span>
        </h2> 
        <br>
        <h2 class="inline text-2xl font-semibold"> 
            <span class="text-primary">
                <span class="font-semibold" >Stock: </span>
                {{ data?.product?.stock }} </span>
        </h2>
        <div class="my-3">
            <div class="join join-horizontal">
                <button
                    type="button"
                    class="btn join-item btn-frame-outline btn-sm"
                    @click="decrement"
                >
                    <MinusIcon class="size-4" />
                </button>
                <button
                    type="button"
                    class="btn join-item btn-frame-outline btn-sm"
                >
                    {{ form.quantity }}
                </button>
                <button
                    type="button"
                    class="btn join-item btn-frame-outline btn-sm"
                    @click="increment"
                >
                    <PlusIcon class="size-4" />
                </button>
            </div>
        </div> 
    </div>
</section>

<section name="buy">
    <div class="grid grid-cols-6 gap-4">
        <div class="col-start-2 col-span-4">
            <div class="card  w-full border shadow">
                <div class="card-actions justify-end">
                    <button
                        type="button"
                        class="btn btn-block hover:scale-200 kbd kbd-md"
                        @click="handleCheckout"
                    >
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>


</template>

<style scoped>

</style>
