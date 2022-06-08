<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <orbit-spinner style="margin-left: 100px; margin-right: 100px;" v-if="isLoading" :animation-duration="2000" :size="40" color="#F10051"/>
    <div v-else>
        <h5 class="float-left block text-2xl font-head font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Green to-RFM-Green">Total Revenue:</h5>
        <h3 id="total" class="block text-2xl font-sans font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Green to-RFM-Green">&euro;{{ totalRevenue }} <span class="text-RFM-Green"><i class="fas fa-caret-up"></i></span></h3>
    </div>
</template>

<script>

import axios from 'axios'
import { OrbitSpinner  } from 'epic-spinners'
export default {
    components: {
        OrbitSpinner
    },
    data() {
        return {
            isLoading: true,
            totalRevenue: ''
        };
    },

    async created() {
        this.isLoading = true
        try {
            const get = await axios.get('https://rfm.gmu.online/api/rfms');
            let totalRevenue = get.data;
            for(var i = 0; i < totalRevenue.length; i++){
                var obj = totalRevenue[i];
                for(var prop in obj){
                    if(obj.hasOwnProperty(prop) && obj[prop] !== null && !isNaN(obj[prop])){
                        obj[prop] = +obj[prop];
                    }
                }
            }

            //code to sum the total value of the monetary
            var res = totalRevenue.reduce(function(_this, val) {
                return _this + val.monetary
            }, 0);
            this.totalRevenue =  Math.round(res)
            this.isLoading = false
        } catch (e) {
            console.error(e);
            this.isLoading = false
        }
    }
};



</script>



