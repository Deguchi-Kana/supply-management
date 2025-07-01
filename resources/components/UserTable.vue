<template>
    <div class="user-table">
        <table>
            <thead>
            <tr>
                <th @click="sortBy('id')">ユーザーID
                    <span :class="changeArrowClass('id', 'asc')">↑</span>
                    <span :class="changeArrowClass('id', 'desc')">↓</span>
                </th>
                <th @click="sortBy('ruby')">名前
                    <span :class="changeArrowClass('ruby', 'asc')">↑</span>
                    <span :class="changeArrowClass('ruby', 'desc')">↓</span>
                </th>
                <th>フリガナ</th>
                <th >メールアドレス</th>
                <th>権限</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in sortUsers">
                <td>
                    {{ user.id }}
                </td>
                <td>
                    <router-link :to="{ name: 'UserDetail', params: { id: user.id } }">
                        {{ user.name }}
                    </router-link>
                </td>
                <td>
                    {{ user.ruby }}
                </td>
                <td>{{ user.email }}</td>
                <td>{{ user.role === 1 ? '管理者':'一般' }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    name: 'UserTable',
    props: ['users'],
    data() {
        return {
            sort_key: 'id',
            sort_order: 'asc',
        }
    },
    methods: {
        sortBy(key) {
            if (this.sort_key === key) {
                if (this.sort_order === 'asc') {
                    this.sort_order = 'desc';
                } else if (this.sort_order === 'desc') {
                    this.sort_key = 'id';
                    this.sort_order = 'asc';
                }
            } else {
                this.sort_key = key;
                this.sort_order = 'asc';
            }
        },
        changeArrowClass(key, direction) {
            if (this.sort_key !== key) return 'arrow gray';
            if (this.sort_order === direction) {
                return 'arrow orange';
            } else {
                return 'arrow gray';
            }
        },
    },
    computed: {
        sortUsers() {
            return this.users.sort((a, b) => {
                if (!this.sort_key || !this.sort_order) return 0;
                if (a[this.sort_key] < b[this.sort_key]) return this.sort_order === 'asc' ? -1 : 1;
                if (a[this.sort_key] > b[this.sort_key]) return this.sort_order === 'asc' ? 1 : -1;
                return 0;
            });
        },
    },
};
</script>

<style src="../css/UserTable.css" scoped></style>
