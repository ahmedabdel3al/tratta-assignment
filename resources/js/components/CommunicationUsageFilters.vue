<template>
    <div class="flex flex-col gap-4">
        <!--  input account with date -->
        <div class="flex gap-4">
            <div class="flex flex-col gap-1 w-full">
                <label class="block text-gray-700 text-sm font-bold" for="account_number">
                    Account Number
                </label>

                <input type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       v-model="params.account_number" placeholder="Account Number">

            </div>
            <div class="flex flex-col gap-1 w-full">
                <label class="block text-gray-700 text-sm font-bold" for="start_date">
                    Start Date
                </label>

                <input type="date"
                       id="start_date"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       v-model="params.start_date" placeholder="Start Date">
            </div>
            <div class="flex flex-col gap-1 w-full">
                <label class="block text-gray-700 text-sm font-bold" for="end_date">
                    End Date
                </label>

                <input type="date"
                       id="end_date"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       v-model="params.end_date" placeholder="Start Date">
            </div>
        </div>
        <!--  input fees  -->
        <div class="flex gap-4">
            <div class="flex flex-col gap-1 w-full">
                <label class="block text-gray-700 text-sm font-bold" for="account_number">
                    Call Inbound Fee
                </label>

                <input type="number"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       v-model="params.calls_inbound_fee" placeholder="Call Inbound Fee">

            </div>
            <div class="flex flex-col gap-1 w-full">
                <label class="block text-gray-700 text-sm font-bold" for="sms">
                    Sms Inbound Fee
                </label>
                <input type="number"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       v-model="params.sms_inbound_longcode_fee" id="sms" placeholder="Sms Inbound Fee">
            </div>
        </div>
        <!--   submit button  -->
        <button class="bg-gray-500 text-white rounded-md font-semibold px-4 py-3 w-full" @click="viewUsage">
            View Usage
        </button>
    </div>
</template>

<script>
export default {
    name: "CommunicationUsageFilters",
    props: {
        serverParams: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            params: {
                start_date: '',
                end_date: '',
                account_number: '',
                calls_inbound_fee: '',
                sms_inbound_longcode_fee: ''
            }
        }
    },
    watch: {
        serverParams(newValue, oldValue) {
            Object.assign(this.params, newValue)
        }
    },
    methods: {
        viewUsage() {
            this.$emit('filters-ready', {params: this.params})
        }
    }
}
</script>

<style scoped>

</style>
