<template>
    <div class="sidebar">
        <div class="logo-section">
            <a href="http://localhost">
                <img src="../assets/fourmix_logo.png" alt="Logo" class="logo" />
            </a>
        </div>
        <div class="menu">
            <router-link to="/logout" class="menu-link">
                <p class="menu-item logout">
                    <i class="fas fa-sign-out-alt"></i> ログアウト
                </p>
            </router-link>
        </div>
        <ul class="menu">
            <router-link to="/users" class="menu-link">
                <li class="menu-item">
                    <i class="fas fa-users"></i> 利用者管理
                </li>
            </router-link>
            <router-link to="/register" class="menu-link">
                <li class="menu-item">
                    <i class="fas fa-plus"></i> 登録
                </li>
            </router-link>
            <router-link to="/search" class="menu-link">
                <li class="menu-item">
                    <i class="fas fa-search"></i> 詳細検索
                </li>
            </router-link>
            <router-link to="/return" class="menu-link">
                <li class="menu-item">
                    <i class="fas fa-exchange-alt"></i> 貸出・返却
                </li>
            </router-link>
        </ul>
    </div>
</template>

<script setup>
//後でアイコン導入
</script>

<style src="./../css/Sidebar.css"></style>
