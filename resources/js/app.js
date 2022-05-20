import {createApp,h} from "vue";

import XslxDownload from "./components/XslxDownload";
import BubbleChart from "./components/BubbleChart";
import NewCustomers from "./components/NewCustomers";
import TotalCustomer from "./components/TotalCustomer";
import TotalRevenue from "./components/TotalRevenue";
import BarChart from "./components/BarChart";
import store from "./src/store/index.js";


const XslxComponent = createApp({
    render: ()=>h(XslxDownload),
    components: {
        XslxDownload,
        store,
    }
}).use(store).mount('#xslx');

const buubleComponent = createApp({
    render: ()=>h(BubbleChart),
    components: {
        BubbleChart,
        store,
    }
}).use(store).mount('#bubble');

const newCustomers = createApp({
    render: ()=>h(NewCustomers),
    components: {
        NewCustomers,
        store,
    }
}).use(store).mount('#new_customers');


const totalCustomers = createApp({
    render: ()=>h(TotalCustomer),
    components: {
        TotalCustomer,
        store,
    }
}).use(store).mount('#total_customers');

const totalRevenue = createApp({
    render: ()=>h(TotalRevenue),
    components: {
        TotalRevenue,
        store,
    }
}).use(store).mount('#total_revenue');


const barChart = createApp({
    render: ()=>h(BarChart),
    components: {
        BarChart,
        store,
    }
}).use(store).mount('#bar_chart');
require("./bootstrap");


