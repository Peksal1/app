<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            New Feedback! From user {{ currentUser.name }}
          </div>
          <div class="card-body">
            <form action="#" @submit.prevent="createmessage">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="evaluation"
                  placeholder="Evaluation"
                  v-model="formData.evaluation"
                />
                <p class="text-danger" v-text="errors.evaluation"></p>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="pros"
                  placeholder="Pros"
                  v-model="formData.pros"
                />
                <p class="text-danger" v-text="errors.pros"></p>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="cons"
                  placeholder="Cons"
                  v-model="formData.cons"
                />
                <p class="text-danger" v-text="errors.cons"></p>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      formData: {
        user_id: "",
        evaluation: "",
        pros: "",
        cons: "",
      },
      currentUser: {},
      token: localStorage.getItem("token"),
      errors: {},
    };
  },
  components: {
    Navbar,
  },
  methods: {
    createmessage() {
      this.formData.user_id = this.currentUser.id;
      axios
        .post("/api/feedback", this.formData, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response.data);
          this.$router.push("/feedback");
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
.card-header {
  color: black;
}
</style>