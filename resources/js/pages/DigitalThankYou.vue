<template>
  <div>
    <AdminNavbar />

    <div class="container mt-4">
      <div class="col-10 m-auto text-black mt-4" v-if="!isLoading && hasError != true">
        <div class="text-center">
          <h2>Congrats! Your purchase #{{ digitalId }} was successfully paid.</h2>
          <p class="m-0">
            You can check your purchase details in your account dashboard.
          </p>
          <p class="m-0">Thank you for shopping with us!</p>
        </div>
      </div>
      <div v-if="hasError">
        <div class="alert alert-danger">
          <p>{{ errorMessgae }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data() {
    return {
      digitalId: null,
      digital: "",
      isLoading: false,
      hasError: false,
      errorMessgae: "",
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
    checkDigital() {
      this.isLoading = true;
      axios
        .get(`/api/check/digital/${this.digitalId}/status`)
        .then((res) => {
          if (res.data.success) {
            this.digital = res.data.digital;
          }
        })
        .catch((err) => {
          this.hasError = true;
          this.errorMessgae = "No digital purchase found";
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
  created() {
    this.digitalId = this.$route.query.digital;
    this.checkDigital();
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap");

* {
  color: black;
}
</style>