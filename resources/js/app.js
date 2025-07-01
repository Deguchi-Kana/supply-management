import { createApp } from 'vue';
import App from '../views/App.vue';
import router from '../../router/index.js';

const app = createApp(App);

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title || ''} | 備品管理システム`;
    next();
});

app.use(router).mount('#app');
