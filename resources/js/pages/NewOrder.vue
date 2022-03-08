<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            New Order! From user {{ currentUser.name }}
          </div>
          <div class="card-body">
            <form class="form" action="#" @submit.prevent="createOrder">
              <div class="form-group">
                <textarea
                  type="text"
                  class="form-control"
                  name="text"
                  placeholder="Description"
                  v-model="formData.text"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
                 <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="size"
                  placeholder="size"
                  v-model="formData.size"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
                 <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="paint"
                  placeholder="paint"
                  v-model="formData.paint"
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
                 <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="canvas"
                  placeholder="canvas"
                  v-model="formData.canvas"
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
              <v-select label="canvas" :options="['Canada', 'United States']" v-model="formData.canvas"></v-select>
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
        text: "",
        file_path: "",
        completion: "0",
        accepted: "0",
        image: "",
        canvas: "",
        size: "",
        paint: "",
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


    createOrder() {
      const orderForm = new FormData();
      orderForm.append("text", this.formData.text);
      orderForm.append("file_path", this.formData.file_path);
      orderForm.append("image", this.formData.image);
      orderForm.append("canvas", this.formData.canvas);
      orderForm.append("size", this.formData.size);
      orderForm.append("paint", this.formData.paint);
      orderForm.append("user_id", this.currentUser.id);

      axios
        .post("/api/neworder", orderForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: orderForm._boundary,
          },
        })
        .then((response) => {
          alert("Order Sent!");
          this.$router.push({
            name: "userprofile",
            params: { id: this.currentUser.id },
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

<style>
.login {
  margin-left: 25rem;
}
.card-header {
  color: black;
}
.vue-select {
  color:black;
}
.card-body {
  background:white;
  width:400px;
}
.card {
  background:white;
  width:400px;
  margin-bottom:70px;
  margin-top:70px;
}
.form {
  color:white;
}
</style>
