import {createApp,h} from "vue";

import XslxDownload from "./components/XslxDownload";
import BubbleChart from "./components/BubbleChart";
import NewCustomers from "./components/NewCustomers";
import TotalCustomer from "./components/TotalCustomer";
import TotalRevenue from "./components/TotalRevenue";
import BarChart from "./components/BarChart";


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


const totalCustomers = createApp({
    render: ()=>h(TotalCustomer),
    components: {
        TotalCustomer,
    }
}).mount('#total_customers');

const totalRevenue = createApp({
    render: ()=>h(TotalRevenue),
    components: {
        TotalRevenue,
    }
}).mount('#total_revenue');


const barChart = createApp({
    render: ()=>h(BarChart),
    components: {
        BarChart,
    }
}).mount('#bar_chart');
require("./bootstrap");


