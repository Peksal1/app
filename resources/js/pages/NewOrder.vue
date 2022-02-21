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
            <form action="#" @submit.prevent="createOrder">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="text"
                  placeholder="Description"
                  v-model="formData.text"
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
                  <!-- <vue-dropzone
                    ref="myVueDropzone"
                    id="dropzone"
                    :options="dropzoneOptions"
                    @vdropzone-complete="afterUploadComplete"
                    @vdropzone-sending-multiple="sendOrder"
                  ></vue-dropzone> -->
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
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
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
      },
      dropzoneOptions: {
        url: "/api/neworder",
        thumbnailWidth: 150,
        maxFilesize: 2.5,
        parallelUploads: 5,
        maxFiles: 5,
        uploadMultiple: true,
        autoProcessQueue: false,
      },
      currentUser: {},
      token: localStorage.getItem("token"),
      errors: {},
    };
  },
  components: {
    Navbar,
    "vue-dropzone": vue2Dropzone,
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

    // shootOrder() {
    //   console.log(this.formData);
    //   //   this.$refs.myVueDropzone.processQueue();
    // },
    // sendOrder: async function (files, xhr, formData) {
    //   formData.append("text", this.text);
    //   formData.append("file_path", this.file_path);
    // },

    createOrder() {
      const orderForm = new FormData();
      orderForm.append("text", this.formData.text);
      orderForm.append("file_path", this.formData.file_path);
      orderForm.append("image", this.formData.image);
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
          console.log("erro");
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
</style>
