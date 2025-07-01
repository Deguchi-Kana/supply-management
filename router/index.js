import { createRouter, createWebHistory } from 'vue-router';
import Index from "../resources/components/Index.vue";
import Login from '../resources/components/Login.vue';
import UserIndex from "../resources/components/UserIndex.vue";
import ItemDetail from '../resources/components/ItemDetail.vue';
import Register from "../resources/components/Register.vue";
import Edit from "../resources/components/Edit.vue";
import UserDetail from "../resources/components/UserDetail.vue";
import UserRegister from "../resources/components/UserRegister.vue";
import UserEdit from "../resources/components/UserEdit.vue";

const routes = [
    { path: '/', component: Index, name: 'Index', meta: { title: '備品一覧' } },
    { path: '/login', component: Login, name: 'Login', meta: { title: 'ログイン' } },
    { path: '/users', component: UserIndex, name: 'UserIndex', meta: { title: 'ユーザー一覧' } },
    { path: '/users/:id', component: UserDetail, name: 'UserDetail', meta: { title: 'ユーザー詳細' } },
    { path: '/users/edit/:id', component: UserEdit, name: 'UserEdit', meta: { title: 'ユーザー編集' } },
    { path: '/users/register', component: UserRegister, name: 'UserRegister', meta: { title: 'ユーザー登録' } },
    { path: '/items/:id', component: ItemDetail, name: 'ItemDetail', meta: { title: '備品詳細' } },
    { path: '/register', component: Register, name: 'Register', meta: { title: '備品登録' } },
    { path: '/edit/:id', component: Edit, name: 'Edit', meta: { title: '備品編集' } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
