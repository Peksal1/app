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
                <br />
                <input
                  type="radio"
                  id="Portrait"
                  name="category"
                  value="Portrait"
                  v-model="formData.category"
                />
                <label for="Portrait">Portrait</label><br />
                <input
                  type="radio"
                  id="Landscape"
                  name="category"
                  value="Landscape"
                  v-model="formData.category"
                />
                <label for="Landscape">Landscape</label><br />
                <input
                  type="radio"
                  id="Random"
                  name="category"
                  value="Random"
                  v-model="formData.category"
                />
                <label for="Random">Random</label>
                <select
                  name="collection"
                  v-model="formData.collection_id"
                  style="width: 15rem"
                >
                  <option value="">Choose</option>
                  <option
                    v-for="collection in collections"
                    v-bind:key="collection.id"
                    :value="collection.id"
                  >
                    {{ collection.name }}
                  </option>
                </select>
                <!-- SIZE -->
                <select
                  name="size"
                  v-model="formData.size_id"
                  style="width: 15rem"
                >
                  <option value="">Choose</option>
                  <option
                    v-for="size in sizes"
                    v-bind:key="size.id"
                    :value="size.id"
                  >
                    {{ size.type }}
                  </option>
                </select>
                <!-- PAINT -->
                <select
                  name="paint"
                  v-model="formData.paint_id"
                  style="width: 15rem"
                >
                  <option value="">Choose</option>
                  <option
                    v-for="paint in paints"
                    v-bind:key="paint.id"
                    :value="paint.id"
                  >
                    {{ paint.type }}
                  </option>
                </select>
                <!--  CANVAS -->
                <select
                  name="canvas"
                  v-model="formData.canvas_id"
                  style="width: 15rem"
                >
                  <option value="">Choose</option>
                  <option
                    v-for="canvas in canvases"
                    v-bind:key="canvas.id"
                    :value="canvas.id"
                  >
                    {{ canvas.type }}
                  </option>
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

export default {
  data() {
    return {
      collections: {},
      sizes: {},
      canvases: {},
      paints: {},

      formData: {
        file_path: "",
        work_name: "",
        description: "",
        category: "",
        image: "",
        collection_id: "",
        size_id: "",
        canvas_id: "",
        paint_id: "",
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
      axios
        .get("api/collections")
        .then(({ data }) => (this.collections = data.data));
      this.isLoggedIn = false;
      console.log(this.collections);
    },
    loadSizes() {
      axios.get("api/all_sizes").then(({ data }) => (this.sizes = data.data));
      this.isLoggedIn = false;
      console.log(this.sizes);
    },
    loadPaints() {
      axios.get("api/all_paints").then(({ data }) => (this.paints = data.data));
      this.isLoggedIn = false;
      console.log(this.paints);
    },
    loadCanvases() {
      axios
        .get("api/all_canvases")
        .then(({ data }) => (this.canvases = data.data));
      this.isLoggedIn = false;
      console.log(this.canvases);
    },
  },
  mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.loadCollections();
    this.checkLoginStatus();
    this.loadSizes();
    this.loadPaints();
    this.loadCanvases();
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
