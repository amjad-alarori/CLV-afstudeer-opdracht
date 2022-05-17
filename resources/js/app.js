import {createApp,h} from "vue";


import XslxDownload from "./components/XslxDownload";
import BubbleChart from "./components/BubbleChart";


const XslxComponent = createApp({
    render: ()=>h(XslxDownload),
    components: {
        XslxDownload,
    }
}).mount('#xslx');

const buubleComponent = createApp({
    render: ()=>h(BubbleChart),
    components: {
        BubbleChart,
    }
}).mount('#bubble');

require("./bootstrap");

