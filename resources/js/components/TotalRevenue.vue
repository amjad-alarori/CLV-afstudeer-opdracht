<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
        <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Revenue</h5>
        <h3 id="total" class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">&euro;{{ totalRevenue }} <span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
</template>

<script>

import axios from 'axios'

export default {
    props: ['results'],
    data() {
        return {
            totalRevenue: []
        };
    },

    async created() {
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
        } catch (e) {
            console.error(e);
        }
    }
};



</script>



