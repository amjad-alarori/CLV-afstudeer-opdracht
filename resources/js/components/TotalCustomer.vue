<!-- Below code is tested on SheetJS v0.14.0 -->
<template>

    <orbit-spinner style="margin-left: 100px; margin-right: 100px;" v-if="isLoading" :animation-duration="2000" :size="40" color="#F10051"/>
    <div v-else>
        <h5 class="float-left block text-2xl font-sans font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">Total Customers:</h5>
        <h3 class="block text-2xl font-sans font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Green to-RFM-Green">{{totalCustomers}} <span class="text-RFM-Pink"><i class="fas fa-exchange-alt"></i></span></h3>
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
            totalCustomers: ''
        };
    },

    async created() {
        this.loading = true
        try {
            const get = await axios.get('https://rfm.gmu.online/api/rfms');
            this.totalCustomers = get.data.length;
            this.isLoading = false
        } catch (e) {
            console.error(e);
            this.isLoading = false
        }
    }
};
</script>

<style lang="scss" scoped>
.loader {
    border: 16px solid #f3f3f3;
    border-top: 16px solid #3498db;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

