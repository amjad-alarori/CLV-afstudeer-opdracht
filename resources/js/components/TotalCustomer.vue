<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
        <h5 class="text-base text-2xl text-gray-400">Total Customers</h5>
        <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Green to-RFM-Green">{{totalCustomers}} <span class="text-green-500"><i class="fas fa-exchange-alt"></i></span></h3>
</template>

<script>

import axios from 'axios'

export default {

    data() {
        return {
            totalCustomers: ''
        };
    },

    async created() {
        try {
            const get = await axios.get('https://rfm.gmu.online/api/rfms');
            this.totalCustomers = get.data.length;
        } catch (e) {
            console.error(e);
        }
    }
};



</script>



