<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header></Header>
                <div class="content">
                    <p class="title">備品登録</p>
                    <form @submit.prevent="registerItem" class="register">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" id="name" v-model="sendData.name" required />
                        </div>
                        <div class="form-group">
                            <label for="categories">カテゴリー</label>
                            <select id="categories" v-model="sendData.categories" required>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock">在庫数</label>
                            <input type="number" id="stock" v-model="sendData.stock" min="0" required />
                        </div>
                        <div class="form-group">
                            <label for="is_consumable">消耗品</label>
                            <select id="is_consumable" v-model="sendData.is_consumable" required>
                                <option value="1">消耗品</option>
                                <option value="0">非消耗品</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select id="status" v-model="sendData.status" required>
                                <option value="0">使用不可</option>
                                <option value="1">利用可能</option>
                                <option value="2">貸出中</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expiration_date">有効期限</label>
                            <input type="date" id="expiration_date" v-model="sendData.expiration_date" />
                        </div>
                        <div class="form-group">
                            <label for="images">画像</label>
                            <input type="file" id="images" @change="onFileChange" />
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
            categories: [],
            sendData: {
                name: "",
                stock: 0,
                is_consumable: 0,
                expiration_date: "",
                categories: null,
                status: ""
            },
            selectedFile: null,
        };
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        // カテゴリー取得
        async getCategories() {
            try {
                const response = await axios.get("/api/categories");
                this.categories = response.data;
            } catch (error) {
                console.error("カテゴリーの取得に失敗しました:", error);
            }
        },
        // 画像ファイルの選択
        onFileChange(event) {
            this.selectedFile = event.target.files[0];
        },
        // 備品登録
        async registerItem() {
            try {
                const payload = {
                    name: this.sendData.name,
                    stock: this.sendData.stock,
                    is_consumable: this.sendData.is_consumable,
                    expiration_date: this.sendData.expiration_date || "",
                    categories: this.sendData.categories,
                    status: this.sendData.status
                };

                if (this.selectedFile) {
                    payload.image = this.selectedFile;
                }

                await axios.post("/api/supplies", payload, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                alert("備品が登録されました！");
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
