import { createApp } from 'vue';
import App from './App.vue';
import { router } from './router';
import vuetify from './plugins/vuetify';
import '@/scss/style.scss';
import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/style.css';
import VueApexCharts from 'vue3-apexcharts';
import VueTablerIcons from 'vue-tabler-icons';
import { createPinia } from 'pinia' // Importar Pinia
const app = createApp(App);
const pinia = createPinia() 
app.use(pinia)
app.use(router);
app.use(PerfectScrollbarPlugin);
app.use(VueTablerIcons);
app.use(VueApexCharts);
app.use(vuetify).mount('#app');
 