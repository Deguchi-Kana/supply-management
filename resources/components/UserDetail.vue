<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header></Header>
                <div class="content">
                    <p class="title">ユーザー編集</p>
                    <div class="item-details">
                        <div class="item-content-horizontal">
                            <div class="item-info">
                                <p>ID：{{ user.id }}</p>
                                <p>名前：{{ user.name }}</p>
                                <p>フリガナ：{{ user.ruby }}</p>
                                <p>メールアドレス：{{ user.email }}</p>
                                <p>パスワード：{{ user.password }}</p>
                                <div class="button-wrapper">
                                    <button class="request-button" @click="deleteClick(user.id)">削除</button>
                                    <button class="request-button" @click="editClick(user.id)">編集</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./Header.vue";
import Sidebar from "./Sidebar.vue";
import axios from "axios";

export default {
    components: { Sidebar, Header },
    data() {
        return {
            user: {
                name: '',
                ruby: '',
                id: '',
                email: '',
                password: '',
            }
        };
    },
    created() {
        this.getUserData();
    },
    computed: {
        formattedCategories() {
            return this.supply.category_name.join(' / ');
        }
    },
    methods: {
        async getUserData() {
            try {
                const response = await axios.get(`/api/users/${this.$route.params.id}`);
                this.user = response.data;
            } catch (error) {
                console.error("データ取得エラー:", error);
            }
        },
        deleteClick(id) {
            if (confirm("本当に削除しますか？")) {
                this.deleteUser(id);
            } else {
                alert("削除をキャンセルしました。");
            }
        },
        editClick(id) {
            this.$router.push({ name: 'UserEdit', params: { id } });
        },
        async deleteUser(id) {
            try {
                await axios.delete(`/api/users/${id}`);
                alert(`${this.user.name}を削除しました！`);
                this.$router.push("/");
            } catch (error) {
                console.error(error);
                alert("削除に失敗しました。");
            }
        }
    }
};
</script>

<style src="./../css/ItemDetail.css"></style>
