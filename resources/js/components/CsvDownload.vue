<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <div class="w-full" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
        <button class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-gray-200 hover:bg-RFM-Black" type="button" v-on:click="onexport">Download RFM Overview</button>
    </div>
</template>

<script>

import writeFileXLSX from 'xlsx';

export default {
    data: () => ({
        newResult
    }),

    methods: {
        onexport () { // On Click Excel download button

            // export json to Worksheet of Excel
            // only array possible
            var About_to_Sleep = XLSX.utils.json_to_sheet(this.newResult.About_To_Sleep)
            var At_Risk = XLSX.utils.json_to_sheet(this.newResult.At_Risk)
            var Cant_Loose = XLSX.utils.json_to_sheet(this.newResult.Cant_Loose)
            var Champions = XLSX.utils.json_to_sheet(this.newResult.Champions)
            var Hibernating = XLSX.utils.json_to_sheet(this.newResult.Hibernating)
            var Loyal_Customers = XLSX.utils.json_to_sheet(this.newResult.Loyal_Customers)
            var Need_Attention = XLSX.utils.json_to_sheet(this.newResult.Need_Attention)
            var New_Customers = XLSX.utils.json_to_sheet(this.newResult.New_Customers)
            var Potential_Loyalists = XLSX.utils.json_to_sheet(this.newResult.Potential_Loyalists)
            var Promising = XLSX.utils.json_to_sheet(this.newResult.Promising)

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

            // export Excel file
            XLSX.writeFile(wb, 'RFM_Results.xlsx') // name of the file is 'book.xlsx'
        }
    }
}
</script>



