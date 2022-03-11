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
              </div>
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  name="price_in_eur"
                  placeholder="price_in_eur"
                  v-model="formData.price_in_eur"
                />
              </div>
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
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data() {
    return {
      sizes: {},
      canvases: {},
      paints: {},

      formData: {
        work_name: "",
        description: "",
        category: "",
        file_path: "",
        price_in_eur: "",
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
    AdminNavbar,
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
      itemForm.append("size_id", this.formData.size_id);
      itemForm.append("canvas_id", this.formData.canvas_id);
      itemForm.append("paint_id", this.formData.paint_id);
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
.card-body {
  color: white !important;
  background: white !important;
}
.card {
  color: black;
  background: black;
}
.form {
  color: black !important ;
  background: black !important;
}
</style>
