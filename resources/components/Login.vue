<script setup>

</script>

<template>
    <div class="login">
        <p class="title">備品管理システム</p>
        <form @submit.prevent="">
            <p><input type="email" name="email" class="form" placeholder="メールアドレス" required></p>
            <p><input type="password" name="password" class="form" placeholder="パスワード" required></p>
            <button type="submit" class="button">ログイン</button>
        </form>
    </div>
</template>

<style src="./../css/login.css" scoped></style>
