<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">New collection!</div>
          <div class="card-body">
            <form class="form" action="#" @submit.prevent="createCollection">
              <div class="form-group">
                <textarea
                  type="text"
                  class="form-control"
                  name="name"
                  placeholder="name"
                  v-model="formData.name"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
              <div class="form-group">
                <input
                  type="month"
                  class="form-control"
                  name="start_date"
                  placeholder="start_date"
                  v-model="formData.start_date"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
              <div class="form-group">
                <input
                  type="month"
                  class="form-control"
                  name="end_date"
                  placeholder="end_date"
                  v-model="formData.end_date"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="description"
                  placeholder="description"
                  v-model="formData.description"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label
                    for="attachment"
                    class="leading-7 text-sm text-gray-600"
                    >Attachments</label
                  ><br />
                  <input
                    type="file"
                    accept="image/*"
                    @change="uploadImage($event)"
                    id="file-input"
                  />
                </div>
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
        image: "",
        description: "",
        name: "",
        start_date: "",
        end_date: "",
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
    afterUploadComplete: async function (response) {
      if (response.status == "success") {
        console.log("upload successful");
        this.sendSuccess = true;
      } else {
        console.log("upload failed");
      }
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.formData.image = file;
    },

    createCollection() {
      const orderForm = new FormData();
      orderForm.append("image", this.formData.image);
      orderForm.append("description", this.formData.description);
      orderForm.append("name", this.formData.name);
      orderForm.append("start_date", this.formData.start_date);
      orderForm.append("end_date", this.formData.end_date);

      axios
        .post("/api/collection", orderForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: orderForm._boundary,
          },
        })
        .then((response) => {
          alert("Collection created!");
          this.$router.push({
            name: "adminportfolio",
          });
        })
        .catch((errors) => {
          console.log("error");
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
.vue-select {
  color: black;
}
.card-body {
  background: white;
  width: 400px;
}
.card {
  background: white;
  width: 400px;
  margin-bottom: 70px;
  margin-top: 70px;
}
.form {
  color: white;
}
</style>
