<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <div class="flex-1 text-right md:text-center">
        <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Customers</h5>
        <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">{{ newCustomers }} <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></h3>
    </div>
</template>

<script>



export default {
    data() {
        return {
            newCustomers: newCustomers
        }
    },
    methods: {
        getData() {
            async function getData() {
                const url = 'https://rfm.gmu.online/api/rfms';
                const response = await fetch(url);
                const datapoints = await response.json();

                return datapoints;
            };


            getData().then(datapoints => {
                let newCustomers = 0;
                for (let i = 0; i < datapoints.length; i++) {
                    if (array[i].clientStatus == 'New Customers') newCustomers++;
                }
                 console.log(newCustomers)

            })



        }
    }
}
</script>



