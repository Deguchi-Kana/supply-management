<template>
    <div class="index">
        <div class="container">
            <Sidebar></Sidebar>
            <div class="main-content">
                <Header></Header>
                <div class="item-details">
                    <div class="item-content-horizontal">
                        <div class="item-image"><img :src="`/storage/${supply.image_path}`" alt="備品画像"></div>
                        <div class="item-info">
                            <div v-if="supply.status" class="status-wrapper">
                                <span v-if="supply.status === '0'" class="unavailable">使用不可</span>
                                <span v-else-if="supply.status === '1'" class="available">利用可能</span>
                                <span v-else-if="supply.status === '2'" class="on-hold">貸出中</span>
                            </div>
                            <h2>{{ supply.name }}</h2>
                            <p>備品ID：{{ supply.id }}</p>
                            <p>カテゴリー：{{ this.formattedCategories }}</p>
                            <p>在庫：{{ this.supply.stock}}</p>
                            <p v-if="this.supply.is_consumable">消耗品</p>
                            <p v-else>非消耗品</p>
                            <p v-if="supply.status === '2'" class="alert">{{ supply.return_date}}まで貸出されています</p>
                            <div class="button-wrapper">
                                <button class="request-button" @click="deleteClick(supply.id)">削除</button>
                                <button class="request-button" @click="editClick(supply.id)">編集</button>
                                <button v-if="supply.status === '1'" class="request-button">貸出処理</button>
                                <button v-else-if="supply.status === '2'" class="request-button">返却処理</button>
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
            supply: {
                name: '',
                id: '',
                category_name: [],
                image_path: null,
                status: null,
                return_date: null,
            }
        };
    },
    created() {
        this.getSupplyData();
    },
    computed: {
        formattedCategories() {
            return this.supply.category_name.join(' / ');
        }
    },
    methods: {
        async getSupplyData() {
            try {
                const response = await axios.get(`/api/supplies/${this.$route.params.id}`);
                this.supply = response.data;
                console.log('データ', this.supply)
            } catch (error) {
                console.error("データ取得エラー:", error);
            }
        },
        deleteClick(id) {
            if (confirm("本当に削除しますか？")) {
                this.deleteSupply(id);
            } else {
                alert("削除をキャンセルしました。");
            }
        },
        editClick(id) {
            this.$router.push({ name: 'Edit', params: { id } });
        },
        async deleteSupply(id) {
            try {
                await axios.delete(`/api/supplies/${id}`);
                alert(`${this.supply.name}を削除しました！`);
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
