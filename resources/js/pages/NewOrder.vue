<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            New Order! From user {{ currentUser.name }}
            <br />
            <h2 style="color: #000">Price: {{ customPrice }} EURO</h2>
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
              <v-select
                label="canvas"
                :options="['Canada', 'United States']"
                v-model="formData.canvas"
              ></v-select>
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
      sizes: {},
      canvases: {},
      paints: {},
      formData: {
        user_id: "",
        text: "",
        file_path: "",
        completion: "0",
        accepted: "0",
        image: "",
        size_id: "",
        canvas_id: "",
        paint_id: "",
        price: 0,
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
      orderForm.append("size_id", this.formData.size_id);
      orderForm.append("canvas_id", this.formData.canvas_id);
      orderForm.append("paint_id", this.formData.paint_id);
      orderForm.append("user_id", this.currentUser.id);
      orderForm.append("price", this.customPrice);

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
  computed: {
    customPrice() {
      let totalPrice = 0;
      if (this.formData.size_id != "") {
        let sizeIndex = this.sizes.findIndex(
          (size) => size.id == this.formData.size_id
        );
        totalPrice += this.sizes[sizeIndex].price_in_eur;
      }

      if (this.formData.canvas_id != "") {
        let canvasIndex = this.canvases.findIndex(
          (canvas) => canvas.id == this.formData.canvas_id
        );
        totalPrice += this.canvases[canvasIndex].price_in_eur;
      }

      if (this.formData.paint_id != "") {
        let paintIndex = this.paints.findIndex(
          (paint) => paint.id == this.formData.paint_id
        );
        totalPrice += this.paints[paintIndex].price_in_eur;
      }

      return totalPrice;
    },
  },
  mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
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
  background: black;
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
