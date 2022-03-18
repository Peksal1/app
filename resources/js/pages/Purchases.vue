<template>
  <div>
    <Navbar />

    <div class="d-flex justify-content-center flex-wrap my-5">
      <v-card
        v-for="purchase in purchases"
        v-bind:key="purchase.id"
        class="mx-auto my-3"
        max-width="15rem"
        min-width="15rem"
      >
        <v-img
          class="white--text align-end"
          height="10rem"
          src="https://rb.gy/rnnzki"
        >
          <v-card-title
            class="d-flex justify-center text-dark"
            >{{
          }}</v-card-title>
        </v-img>

        <v-card-subtitle class="pb-0">
          <div>
            size:
            {{ purchase.store.price_in_eur }}
          </div>
        </v-card-subtitle>

        <v-card-text class="text--primary">
          <div>paint: {{ purchase.store.product_id }}</div>
        </v-card-text>
        <v-card-text class="text--primary">
          <div>canvas: {{ purchase.store.Price }}</div>
        </v-card-text>
        <hr />
      </v-card>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      purchases: [],
      users: [],
      currentUser: [],
      token: localStorage.getItem("token"),
      isLoggedIn: false,
    };
  },
  components: {
    Navbar,
  },

  methods: {
    loadUserPurchases() {
      axios
        .get("/api/purchases", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;
          this.purchases = response.data.data;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },

    checkLoginStatus() {
      this.loading = true;
      // this.loading = true
      axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.currentUser = response.data;
          this.isLoggedIn = true;
        })
        .catch((errors) => {
          console.log(errors);
          this.isLoggedIn = false;
        })
        .finally(() => {
          this.loading = false;
        });
      // this.loading = false
    },
  },
  created() {},
  mounted() {
    this.loadUserPurchases();
    this.checkLoginStatus();
  },
};
</script>

<style scoped>
</style>