<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <orbit-spinner style="margin-left: 100px; margin-right: 100px;" v-if="isLoading" :animation-duration="2000" :size="40" color="#F10051"/>
    <div v-else>
        <h5  class="float-left text-base text-2xl text-gray-400">New Customers:</h5>
        <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Green to-RFM-Green">{{ newCustomer }} <span class="text-green-600"><i class="fas fa-caret-up"></i></span></h3>
    </div>
</template>

<script>

import axios from 'axios'
import { OrbitSpinner } from 'epic-spinners'
export default {
    components: {
        OrbitSpinner
    },
    data() {
        return {
            isLoading: true,
            newCustomer: '',
        };
    },

    async created() {
        this.isLoading = true
        try {
            const url = await axios.get('https://rfm.gmu.online/api/rfms');
            let array = url.data;
            let newCustomers = 0;
            for (let i = 0; i < array.length; i++) {
                if (array[i].segment == 'New Customers') newCustomers++;
            }
            this.newCustomer = newCustomers;
            this.isLoading = false
        } catch (e) {
            console.error(e);
            this.isLoading = false
        }
    }
};



</script>



