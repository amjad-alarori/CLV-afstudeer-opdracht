<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
        <h5 class="text-base text-2xl text-gray-400">New Customers</h5>
        <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Green to-RFM-Green">{{ newCustomer }} <span class="text-green-600"><i class="fas fa-caret-up"></i></span></h3>
</template>

<script>

import axios from 'axios'

export default {
    data() {
        return {
            newCustomer: '',
        };
    },

    async created() {
        try {
            const url = await axios.get('https://rfm.gmu.online/api/rfms');
            let array = url.data;
            let newCustomers = 0;
            for (let i = 0; i < array.length; i++) {
                if (array[i].segment == 'New Customers') newCustomers++;
            }
            this.newCustomer = newCustomers;
        } catch (e) {
            console.error(e);
        }
    }
};



</script>



