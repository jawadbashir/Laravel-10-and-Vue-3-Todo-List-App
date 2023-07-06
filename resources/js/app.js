import './bootstrap';
import '../sass/app.scss';
import {createApp} from 'vue/dist/vue.esm-bundler.js';
import * as VueRouter from 'vue-router';
import MainCom from './Components/MainComponent.vue';
import TaskComponent from './Components/TaskComponent.vue';


const routes = [
    { path: '/', component: MainCom },
    { path: '/tasks', component: TaskComponent },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes
})



const app = createApp({
    components: {
        'main-com': MainCom,
    }
})
app.use(router)
app.mount("#app")
