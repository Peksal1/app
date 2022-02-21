<template>
  <div class="container-fuiled">
    <AdminNavbar />
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">New shop item!</div>
          <div class="card-body">
            <form action="#" @submit.prevent="createItem">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="work_name"
                  placeholder="Work Name"
                  v-model="formData.work_name"
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="description"
                  placeholder="description"
                  v-model="formData.description"
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="category"
                  placeholder="category"
                  v-model="formData.category"
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="price_in_eur"
                  placeholder="price_in_eur"
                  v-model="formData.price_in_eur"
                />
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
import AdminNavbar from "../components/AdminNavbar.vue";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
export default {
  data() {
    return {
      formData: {
        work_name: "",
        description: "",
        category: "",
        file_path: "",
        price_in_eur: "",
      },
      dropzoneOptions: {
        url: "/api/store",
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
    AdminNavbar,
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
      this.formData.file_path = file;
    },

    // shootOrder() {
    //   console.log(this.formData);
    //   //   this.$refs.myVueDropzone.processQueue();
    // },
    // sendOrder: async function (files, xhr, formData) {
    //   formData.append("text", this.text);
    //   formData.append("file_path", this.file_path);
    // },

    createItem() {
      const itemForm = new FormData();
      itemForm.append("work_name", this.formData.work_name);
      itemForm.append("file_path", this.formData.file_path);
      itemForm.append("description", this.formData.description);
      itemForm.append("category", this.formData.category);
      itemForm.append("price_in_eur", this.formData.price_in_eur);
      axios
        .post("/api/store", itemForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: itemForm._boundary,
          },
        })
        .then((response) => {
          alert("Item Sent!");
          this.$router.push({
            name: "store",
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
</style>
