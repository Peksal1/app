<template>
  <div class="container-fuiled">
    <AdminNavbar />
    <form action="#" @submit.prevent="newpost">
      <p>
        <strong>Topic Title:</strong><br />
        <input type="text" name="topic_title" v-model="formData.topic_title" size="40" maxlength="150" /><br />
        <strong>Post Text:</strong><br />
        <textarea name="topic_description" v-model="formData.topic_description" rows="8" cols="40"
          wrap="virtual"></textarea>
        <input type="submit" name="submit" value="Add Topic" />
      </p>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data() {
    return {
      formData: {
        user_id: "",
        topic_title: "",
        topic_description: "",
      },
      currentUser: {},
      token: localStorage.getItem("token"),
      errors: {},
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
    newpost() {
      this.formData.user_id = this.currentUser.id;
      axios
        .post("/api/topics", this.formData, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response.data);
          this.$router.push("/adminqna");
          this.errors = {};
          this.$toaster.success("Message sent successfully!");
        })
        .catch((errors) => {
          console.log("erro");
          this.errors = errors.response.data.errors;
          console.log(errors.response.data.errors);
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
          console.log("LOGGED IN");
          this.isLoggedIn = true;
          console.log(response.data.name);
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
  mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.checkLoginStatus();
  },
  updated() {
    console.log(this.isLoggedIn);
  },
  watch: {
    $route(to, from) {
      this.checkLoginStatus();
    },
  },
};
</script>

<style scoped>
.login {
  margin-left: 25rem;
}
</style>