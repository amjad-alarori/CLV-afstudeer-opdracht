import {createApp} from "vue";

import CsvDownload from "./components/CsvDownload";


const app = createApp({
});


app.component('CsvDownload', CsvDownload);


// mount the app to the DOM
app.mount('#app');

require("./bootstrap");

