<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header></Header>
                <div class="content">
                    <p class="title">備品編集</p>
                    <form @submit.prevent="updateItem" class="register" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" id="name" v-model="formData.name" required>
                        </div>
                        <div class="form-group">
                            <label for="categories">カテゴリー</label>
                            <select id="categories" v-model="formData.categories" required>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label for="categories">カテゴリー</label>-->
<!--                            <select id="categories" v-model="formData.category_id" required multiple>-->
<!--                                <option v-for="category in categories" :key="category.id" :value="category.id">-->
<!--                                    {{ category.name }}-->
<!--                                </option>-->
<!--                            </select>-->
<!--                        </div>-->
                        <div class="form-group">
                            <label for="stock">在庫数</label>
                            <input type="number" id="stock" v-model="formData.stock" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="is_consumable">消耗品</label>
                            <select id="is_consumable" v-model="formData.is_consumable" required>
                                <option value="1">消耗品</option>
                                <option value="0">非消耗品</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expiration_date">有効期限</label>
                            <input type="date" id="expiration_date" v-model="formData.expiration_date">
                        </div>
                        <div class="form-group">
                            <label for="images">画像</label>
                            <input type="file" id="images" @change="onFileChange" />
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label for="images">画像</label>-->
<!--                            <input type="file" id="images" @change="onFileChange">-->
<!--                            <div v-if="formData.image_path">-->
<!--                                <img :src="`/storage/${formData.image_path}`" alt="現在の画像" width="100">-->
<!--                            </div>-->
<!--                        </div>-->
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
            categories: [],
            formData: {
                name: "",
                stock: 0,
                is_consumable: 0,
                expiration_date: "",
                // categories: null,
                categories: [],
                // category_id: [],
                // image_path: "",
            },
            selectedFile: null,
        };
    },
    created() {
        this.getCategories();
        this.getSupplyData();
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
        // // 画像ファイルの選択
        onFileChange(event) {
            this.selectedFile = event.target.files[0];
        },
        // 備品情報取得
        async getSupplyData() {
            try {
                const response = await axios.get(`/api/supplies/${this.$route.params.id}`);
                this.formData = response.data;
                this.formData.category_id = response.data.category_id || [];
            } catch (error) {
                console.error("データ取得エラー:", error);
            }
        },
        // 備品更新
        async updateItem() {
            try {
                const form = new FormData();
                form.append('name', this.formData.name);
                form.append('stock', this.formData.stock);
                form.append('is_consumable', this.formData.is_consumable);
                form.append('expiration_date', this.formData.expiration_date);
                form.append('categories', this.formData.categories);
                // if (Array.isArray(this.formData.categories)) {
                //     this.formData.categories.forEach(id => {
                //         form.append('categories[]', id);
                //     });
                // } else {
                //     form.append('categories', this.formData.categories);
                // }

                if (this.selectedFile) {
                    form.append('image', this.selectedFile);
                    console.log('FormDataにimage追加:', this.selectedFile.name);
                } else {
                    console.log('imageファイルなし');
                }

                for (let pair of form.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                await axios.patch(`/api/supplies/${this.$route.params.id}`, form);
                alert('更新されました');
            } catch (error) {
                console.error(error);
                alert('更新に失敗しました');
            }
            // try {
            //     const payload = {
            //         name: this.formData.name,
            //         stock: this.formData.stock,
            //         is_consumable: this.formData.is_consumable,
            //         expiration_date: this.formData.expiration_date || "",
            //         categories: this.formData.category_id,
            //     };
            //
            //     if (this.selectedFile) {
            //         payload.image = this.selectedFile;
            //     }
            //
            //     await axios.patch(`/api/supplies/${this.$route.params.id}`, payload, {
            //         // headers: {
            //         //     "Content-Type": "multipart/form-data",
            //         // },
            //     });
            //
            //     alert("備品情報の更新が完了しました！");
            //     this.$router.push("/");
            // } catch (error) {
            //     alert("更新中にエラーが発生しました");
            //     console.error("更新に失敗しました:", error);
            // }
        }
    }
}
</script>

<style src="./../css/Register.css"></style>
