<template>
    <div class="flex flex-col items-center justify-center w-md py-10">
        <h2 class="mb-4 block text-gray-700 text-xl font-bold">Communication Usage</h2>
        <communication-usage-filters :server-params="serverParams"
                                     @filters-ready="getCommunicationUsage"></communication-usage-filters>
        <Loader v-if="isLoading"></Loader>

        <div class="flex gap-4 mt-12" v-if="!isLoading">
            <communication-usage-category v-if="Object.keys(callsInbound).length"  name="Call Inbound" v-bind="callsInbound"> </communication-usage-category>
            <communication-usage-category v-if="Object.keys(smsInbound).length" name="Sms Inbound" v-bind="smsInbound"> </communication-usage-category>
        </div>


    </div>
</template>

<script>
import {communicationUsage} from "../apis/communication";
import Loader from "../components/Loader";
import CommunicationUsageFilters from "../components/CommunicationUsageFilters";
import CommunicationUsageCategory from "../components/CommunicationUsageCategory";

export default {
    name: "CommunicationUsage",
    components: {CommunicationUsageCategory, CommunicationUsageFilters, Loader},
    data() {
        return {
            isLoading: false,
            callsInbound: {},
            smsInbound: {},
            serverParams: {}
        }
    },
    methods: {
        async getCommunicationUsage({params}) {
            this.isLoading = true
            const {request, calls_inbound, sms_inbound_longcode} = await communicationUsage(params)
            this.serverParams = request
            this.callsInbound = calls_inbound
            this.smsInbound = sms_inbound_longcode
            this.isLoading = false
        }
    },

}
</script>

