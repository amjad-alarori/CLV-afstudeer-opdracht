import {createApp,h} from "vue";


import XslxDownload from "./components/XslxDownload";
import BubbleChart from "./components/BubbleChart";
import NewCustomers from "./components/NewCustomers";




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

const newCustomers = createApp({
    render: ()=>h(NewCustomers),
    components: {
        NewCustomers,
    }
}).mount('#new_customers');


require("./bootstrap");

