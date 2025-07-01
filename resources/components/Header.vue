<template>
    <div class="header">
        <p class="header-title">備品管理システム</p>
        <div class="search-controls">
            <input class="search-form" v-model="keyword" @keydown.enter="onSearch" placeholder="検索したいワードを入力してください！">
            <button class="search-button" @click="onSearch">検索</button>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            keyword: '',
        };
    },
    methods: {
        onSearch() {
            this.$emit('search', this.keyword.trim());
        },
    },
};
</script>

<style src="./../css/Header.css" scoped></style>
