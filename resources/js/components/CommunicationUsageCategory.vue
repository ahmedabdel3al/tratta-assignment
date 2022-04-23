<template>
    <div class="shadow-lg w-80 p-4 flex flex-col bg-white rounded-lg flex flex-col gap-2">
        <h2 class="font-bold text-xl text-gray-700 leading-6">{{ name }}</h2>
        <p>Count : <span class="ml-1">{{ count }}</span></p>
        <p>Usage : <span class="ml-1">{{ usage }}</span></p>
        <p>Usage Count : <span class="ml-1">{{ usage_unit }}</span></p>
        <p>Price : <span class="ml-1">{{ price }}</span></p>
        <p>Tratta Price : <span class="ml-1">{{ tratta_price }}</span></p>
    </div>

</template>

<script>
export default {
    name: "CommunicationUsageCategory",
    props: {
        count: {
            required: true,
            type: Number
        },
        name: {
            required: true,
            type: String
        },
        usage: {
            required: true,
            type: Number,
            default: () => 0
        },
        usage_unit: {
            required: true,
            type: String
        },
        price: {
            required: true,
            type: Number
        },
        tratta_price: {
            required: true,
            type: Number
        }

    }
}
</script>

<style scoped>

</style>
