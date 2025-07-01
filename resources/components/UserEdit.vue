<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header></Header>
                <div class="content">
                    <p class="title">ユーザー編集</p>
                    <form @submit.prevent="updateUser" class="register">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" id="name" v-model="formData.name" required>
                        </div>
                        <div class="form-group">
                            <label for="ruby">フリガナ</label>
                            <input type="text" id="ruby" v-model="formData.ruby" required>
                        </div>
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="text" id="email" v-model="formData.email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="password" id="password" v-model="formData.password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">パスワード（確認用）</label>
                            <input type="password" id="password_confirm" v-model="formData.password_confirm" required>
                        </div>
                        <div v-if="errorMessage" class="error-message">
                            {{ errorMessage }}
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="register-button">更新</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Header from "./Header.vue";
import Sidebar from "./Sidebar.vue";

export default {
    components: {
        Header,
        Sidebar,
    },
    data() {
        return {
            formData: {
                name: "",
                ruby: "",
                email: "",
                password: "",
                password_confirm: "",
            },
            errorMessage: '',
        };
    },
    created() {
        this.getUserData();
    },
    methods: {
        // ユーザー情報取得
        async getUserData() {
            try {
                const response = await axios.get(`/api/users/${this.$route.params.id}`);
                this.formData = response.data;
            } catch (error) {
                console.error("データ取得エラー:", error);
            }
        },
        // 備品更新
        async updateUser() {
            if (this.formData.password !== this.formData.password_confirm) {
                this.errorMessage = 'パスワードとパスワード（確認用）は同じ値を入力してください';
                return;
            }
            try {
                const payload = {
                    name: this.formData.name,
                    ruby: this.formData.ruby,
                    email: this.formData.email,
                    password: this.formData.password,
                };
                await axios.patch(`/api/users/${this.$route.params.id}`, payload, {
                });
                alert("ユーザー情報の更新が完了しました！");
                this.$router.push("/");
            } catch (error) {
                alert("更新中にエラーが発生しました");
                console.error("更新に失敗しました:", error);
            }
        }
    }
}
</script>

<style src="./../css/UserEdit.css"></style>
