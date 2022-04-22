require('./bootstrap');

// Convert to csv
function csvDownload() {
    const csv = $.csv.fromObjects(list);

    // Download file as csv function
    const downloadBlobAsFile = function(csv, filename){
        var downloadLink = document.createElement("a");
        var blob = new Blob([csv], { type: 'text/csv' });
        var url = URL.createObjectURL(blob);
        downloadLink.href = url;
        downloadLink.download = filename;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    // Download csv file
    downloadBlobAsFile(csv, 'RFM_Export.csv');
}
