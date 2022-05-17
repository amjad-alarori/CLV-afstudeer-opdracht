import {createApp} from "vue";


import CsvDownload from "./components/CsvDownload";
import BubbleChart from "./components/BubbleChart";


const app = createApp({
    components: {
        CsvDownload,
        BubbleChart,
    }
}).mount('#app');



require("./bootstrap");

