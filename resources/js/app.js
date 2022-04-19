import {createApp} from "vue";

import Spinner from "./components/spinner";

const app = createApp({
});

app.component('Spinner', Spinner);

// mount the app to the DOM
app.mount('#app');

require("./bootstrap");