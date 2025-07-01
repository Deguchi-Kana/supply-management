<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header></Header>
                <div class="content">
                    <p class="title">ユーザー登録</p>
                    <form @submit.prevent="registerUser" class="register">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" id="name" v-model="sendData.name" required />
                        </div>
                        <div class="form-group">
                            <label for="ruby">フリガナ</label>
                            <input type="text" id="ruby" v-model="sendData.ruby" required />
                        </div>
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="text" id="email" v-model="sendData.email" required />
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="password" id="password" v-model="sendData.password" required />
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">パスワード（確認）</label>
                            <input type="password" id="password_confirm" v-model="sendData.password_confirm" required />
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="register-button">登録</button>
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
            sendData: {
                name: "",
                ruby: "",
                email: "",
                password: "",
                password_confirm: "",
            },
        };
    },
    methods: {
        // ユーザー登録
        async registerUser() {
            if (this.sendData.password !== this.sendData.password_confirm) {
                alert('パスワードが一致しません');
                return;
            }
            try {
                const payload = {
                    name: this.sendData.name,
                    ruby: this.sendData.ruby,
                    email: this.sendData.email,
                    password: this.sendData.password,
                };
                await axios.post("/api/users", payload);
                alert("ユーザーが登録されました！");
                this.$router.push("/");
            } catch (error) {
                alert("登録中にエラーが発生しました");
                console.error("登録に失敗しました:", error);
            }
        },
    },
};
</script>

<style src="./../css/Register.css"></style>
<style src="./../css/UserRegister.css"></style>
