<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header @search="handleSearch"></Header>
                <div class="content">
                    <div>
                        <p class="title">ユーザー管理</p>
                        <router-link to="/users/register" class="register-button">
                            <p class="menu-item">
                                <i class="fas fa-sign-out-alt"></i> 新規登録
                            </p>
                        </router-link>
                    </div>
                    <user-table :users="users"></user-table>
                    <div class="pagination">
                        <button :disabled="meta.current_page <= 1" @click="fetchUser(meta.current_page - 1)">＜</button>
                        <ul>
                            <li v-for="page in meta.last_page" :key="page">
                                <button class="page-button" :class="{ active: page === meta.current_page }" @click="fetchUser(page)">
                                    {{ page }}
                                </button>
                            </li>
                        </ul>
                        <button :disabled="meta.current_page >= meta.last_page" @click="fetchUser(meta.current_page + 1)">＞</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "../components/Header.vue";
import Sidebar from "../components/Sidebar.vue";
import UserTable from "./UserTable.vue";
import axios from "axios";

export default {
    name: 'UserIndex',
    components: {Sidebar, Header, UserTable},
    data(){
        return {
            users: [],
            meta: {},
            links: {},
            currentPage: 1,
            currentKeyword: '',
        };
    },
    mounted() {
        this.fetchUser();
    },
    methods: {
        async fetchUser(page = 1) {
            try {
                const params = { page };
                if (this.currentKeyword) {
                    params.keyword = this.currentKeyword;
                }
                const res = await axios.get('/api/users', { params });
                this.users = res.data.data;
                this.meta = res.data.meta;
                this.links = res.data.links;
                this.currentPage = page;
            }catch (error) {
                console.error("APIからのデータ取得に失敗しました:", error);
            }
        },
        async handleSearch(keyword) {
            this.currentKeyword = keyword;
            await this.fetchUser(1);
        },
    }
}
</script>

<style src="./../css/Index.css" scoped></style>
<style src="./../css/UserIndex.css" scoped></style>

