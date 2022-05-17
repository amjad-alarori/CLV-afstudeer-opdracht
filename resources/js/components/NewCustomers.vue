<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <div class="flex-1 text-right md:text-center">
        <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Customers</h5>
        <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">{{ total }} <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></h3>
    </div>
</template>

<script>

import axios from 'axios'

export default {
    data() {
        return {
            total: []
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
            this.total = newCustomers;
        } catch (e) {
            console.error(e);
        }
    }
};



</script>



