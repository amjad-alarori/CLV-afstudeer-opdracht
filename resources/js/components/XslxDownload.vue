<!-- Below code is tested on SheetJS v0.14.0 -->
<template>

    <div class="w-full" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
        <fingerprint-spinner v-if="isLoading" :animation-duration="2000" :size="60" color="#F10051"/>
        <div v-else>
        <button class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-head font-bold text-gray-200 hover:bg-RFM-Black" type="button" v-on:click="onexport">Download RFM Overview</button>
    </div>
    </div>
</template>
web-button font-title subtitle background-gradient-purple-orange color-white color-black-hover wysiwyg-button
<script>


// fix the empty new customer


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
                const datapoints = await response.json();

                return datapoints;
            };
            getData().then(datapoints => {
                let data = datapoints.map(item => {
                    return {
                        "customer_id": item.customer_id,
                        "frequency": item.frequency,
                        "frequency_score": item.frequency_score,
                        "monetary": "€" + item.monetary,
                        "monetary_score": item.monetary_score,
                        "recency": item.recency,
                        "recency_score": item.recency_score,
                        "rfm_score": item.rfm_score,
                        "segment": item.segment
                    }
                });
                let result = data.reduce(function (r, a) {
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
                   
                    'Potential Loyalists': 'Potential_Loyalists',
                    'Promising': 'Promising'
                }
               let newResult = replaceKeys(result, mapping)



            // export json to Worksheet of Excel
            // only array possible
            var About_to_Sleep = XLSX.utils.json_to_sheet(newResult.About_To_Sleep)
            var At_Risk = XLSX.utils.json_to_sheet(newResult.At_Risk)
            var Cant_Loose = XLSX.utils.json_to_sheet(newResult.Cant_Loose)
            var Champions = XLSX.utils.json_to_sheet(newResult.Champions)
            var Hibernating = XLSX.utils.json_to_sheet(newResult.Hibernating)
            var Loyal_Customers = XLSX.utils.json_to_sheet(newResult.Loyal_Customers)
            var Need_Attention = XLSX.utils.json_to_sheet(newResult.Need_Attention)
            var New_Customers = XLSX.utils.json_to_sheet(newResult.New_Customers)
            var Potential_Loyalists = XLSX.utils.json_to_sheet(newResult.Potential_Loyalists)
            var Promising = XLSX.utils.json_to_sheet(newResult.Promising)

            // A workbook is the name given to an Excel file
            var wb = XLSX.utils.book_new() // make Workbook of Excel

            // add Worksheet to Workbook
            // Workbook contains one or more worksheets

            XLSX.utils.book_append_sheet(wb, About_to_Sleep, 'About_To_Sleep') // sheetAName is name of Worksheet
            XLSX.utils.book_append_sheet(wb, At_Risk, 'At_Risk')
            XLSX.utils.book_append_sheet(wb, Cant_Loose, 'Cant_Loose')
            XLSX.utils.book_append_sheet(wb, Champions, 'Champions')
            XLSX.utils.book_append_sheet(wb, Hibernating, 'Hibernating')
            XLSX.utils.book_append_sheet(wb, Loyal_Customers, 'Loyal_Customers')
            XLSX.utils.book_append_sheet(wb, Need_Attention, 'Need_Attention')
            XLSX.utils.book_append_sheet(wb, New_Customers, 'New_Customers')
            XLSX.utils.book_append_sheet(wb, Potential_Loyalists, 'Potential_Loyalists')
            XLSX.utils.book_append_sheet(wb, Promising, 'Promising')
                this.isLoading = false
            // export Excel file
            XLSX.writeFile(wb, 'RFM_Results.xlsx') // name of the file is 'book.xlsx'
            })
        }
    }
}
</script>



