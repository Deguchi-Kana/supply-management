<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header @search="handleSearch"></Header>
                <div class="content">
                    <p class="title">備品一覧</p>
                    <p v-if="items.length === 0">一致する備品が見つかりませんでした</p>
                    <div class="item-list">
                        <div v-for="item in items" :key="item.id" class="item">
                            <router-link :to="{ name: 'ItemDetail', params: { id: item.id } }" class="item-link">
                                <img :src="`/storage/${item.image_path}`" alt="備品画像">
                                <p v-html="item.name"></p>
                            </router-link>
                        </div>
                    </div>
                    <div class="pagination">
                        <button :disabled="meta.current_page <= 1" @click="fetchItems(meta.current_page - 1)">＜</button>
                        <ul>
                            <li v-for="page in meta.last_page" :key="page">
                                <button class="page-button" :class="{ active: page === meta.current_page }" @click="fetchItems(page)">
                                    {{ page }}
                                </button>
                            </li>
                        </ul>
                        <button :disabled="meta.current_page >= meta.last_page" @click="fetchItems(meta.current_page + 1)">＞</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Header from "../components/Header.vue";
import Sidebar from "../components/Sidebar.vue";

export default {
    components: {Header, Sidebar},
    data() {
        return {
            items: [],
            meta: {},
            links: {},
            currentPage: 1,
            currentKeyword: '',
        };
    },
    mounted() {
        this.fetchItems();
    },
    methods: {
        async fetchItems(page = 1) {
            try {
                const params = { page };
                if (this.currentKeyword) {
                    params.keyword = this.currentKeyword;
                }
                const res = await axios.get('/api/supplies', { params });
                this.items = res.data.data;
                this.meta = res.data.meta;
                this.links = res.data.links;
                this.currentPage = page;
            }catch (error) {
                console.error("APIからのデータ取得に失敗しました:", error);
            }
        },
        async handleSearch(keyword) {
            this.currentKeyword = keyword;
            await this.fetchItems(1);
        },

    },

};
</script>

<style src="./../css/Index.css"></style>
