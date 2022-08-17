<!-- Below code is tested on SheetJS v0.14.0 -->
<template>

    <div class="w-full" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
        <fingerprint-spinner v-if="isLoading" :animation-duration="2000" :size="60" color="#F10051"/>
        <div v-else>
        <button class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-head font-bold text-gray-200 hover:bg-RFM-Black" type="button" v-on:click="onexport">Download RFM Overview</button>
    </div>
    </div>
</template>
<script>
import writeFileXLSX from 'xlsx';
import { FingerprintSpinner } from 'epic-spinners'
export default {
    components: {
        FingerprintSpinner
    },
    data: () => ({
        isLoading: false,
    }),
    methods: {
        onexport () { // On Click Excel download button
            this.isLoading = true
            getData();
            async function getData(){
                const url = 'https://rfm.gmu.online/api/rfms';
                const response = await fetch(url);
                let datapoints = await response.json();
                
                return datapoints;
                
            };
            getData().then(datapoints => {
           
               
                let result = datapoints.reduce(function (r, a) {
                    r[a.segment] = r[a.segment] || [];
                    r[a.segment].push(a);
                    return r;
                }, Object.create(null));
                const replaceKeys = (result, mapping) =>
                    Object.fromEntries(
                        Object.entries(result).map(([k, v]) => [mapping[k] || k, v])
                    )
                const mapping = {
                    'About to Sleep': 'About_To_Sleep',
                    'At Risk': 'At_Risk',
                    "Can't Loose": 'Cant_Loose',
                    'Champions': 'Champions',
                    'Hibernating': 'Hibernating',
                    'Loyal Customers': 'Loyal_Customers',
                    'Need Attention': 'Need_Attention',
                    'New Customers': 'New_Customers',
                    'Potential Loyalists': 'Potential_Loyalists',
                    'Promising': 'Promising'
                }
               let newResult = replaceKeys(result, mapping)

                var wb = XLSX.utils.book_new()
               for (var key in newResult) {
                if (newResult.hasOwnProperty(key)) {
                    console.log(key);
                    console.log(newResult[key]);
                    var sheetData = XLSX.utils.json_to_sheet(newResult[key])
                    
                    XLSX.utils.book_append_sheet(wb, sheetData, key)
                }
            }
                  this.isLoading = false
                    // export Excel file
                    XLSX.writeFile(wb, 'RFM_Results.xlsx') // name of the file is 'book.xlsx'
            
            })
        }
    }
}
</script>

