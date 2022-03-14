<template>
  <v-app>
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
    <Footer />
  </v-app>
</template>



<script>
import Navbar from "./Navbar.vue";
import Footer from "./footer.vue";

export default {
  data() {
    return {};
  },
  components: {
    Navbar,
    Footer,
  },
};
</script>
<style scoped>
.main {
  height: 89vh;
  width: 100%;
}
</style>