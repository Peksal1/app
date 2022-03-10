<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">New Portfolio item!</div>
          <div class="card-body">
            <form action="#" @submit.prevent="createOrder">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="work_name"
                  placeholder="work_name"
                  v-model="formData.work_name"
                  required
                />
                <p class="text-danger" v-text="errors.text"></p>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="work_name"
                  placeholder="description"
                  v-model="formData.description" 
                  required
                />
                <span class="validity"></span>
                <p class="text-danger" v-text="errors.text"></p>
              </div>
              <div class="form-group">
Category:
<br>
  <input type="radio" id="Portrait" name="category" value="Portrait" v-model="formData.category">
  <label for="Portrait">Portrait</label><br>
  <input type="radio" id="Landscape" name="category" value="Landscape" v-model="formData.category">
  <label for="Landscape">Landscape</label><br>
  <input type="radio" id="Random" name="category" value="Random" v-model="formData.category">
  <label for="Random">Random</label>
     <select name="collection" v-model="formData.collection_id" style="width:15rem;" >
       <option value="">Choose</option>
       <option v-for="collection in collections" v-bind:key="collection.id" :value="collection.id" >{{collection.name}}</option>
  
     </select>
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
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
export default {
  data() {
    return {
        collections: {},
      formData: {
        file_path: "",
        work_name: "",
        description: "",
        category: "",
        image: "",
        collection_id: "",
        size_id: 1,
        canvas_id: 1,
        paint_id: 1,
      },
      dropzoneOptions: {
        url: "/api/portfolio",
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
      orderForm.append("work_name", this.formData.work_name);
      orderForm.append("description", this.formData.description);
      orderForm.append("image", this.formData.image);
      orderForm.append("category", this.formData.category);
      axios
        .post("/api/portfolio", orderForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: orderForm._boundary,
          },
        })
        .then((response) => {
          alert("Order Sent!");
          this.$router.push({
            name: "adminportfolio",
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
  
  loadCollections() {
      axios.get("api/collections").then(({ data }) => (this.collections = data.data));
       this.isLoggedIn= false
      console.log(this.collections)
    },
  },
  mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.loadCollections();
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
