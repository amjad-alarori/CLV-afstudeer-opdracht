import {createApp} from "vue";

import csv_download from "./components/csv_download";


const app = createApp({
});

app.component('csv_download', csv_download);


// mount the app to the DOM
app.mount('#app');

require("./bootstrap");

