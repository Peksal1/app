<template>
  <v-app>
    <AdminNavbar />
    <router-link class="col" :to="{ name: 'messages' }">messages</router-link>
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
  </v-app>
</template>



<script>
import AdminNavbar from "./AdminNavbar.vue";
export default {
  data() {
    return {};
  },
  components: {
    AdminNavbar,
  },
};
</script>
<style scoped>
.main {
  height: 89vh;
  width: 100%;
}
</style>