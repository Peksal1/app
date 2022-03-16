<template>
  <div class="container">
    <div
      class="
        new-stores-option
        d-flex
        justify-content-between
        align-items-center
      "
    >
      <div class="btn btn-sm btn-primary" @click="openStoreModal">
        Add New Store Item
      </div>
    </div>

    <!-- modal vindow -->
    <div
      class="modal"
      :class="{ show: showStoreModal }"
      id="storeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add a new item to the store
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hideStoreModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitStoreForm">
              <div class="form-group">
                <label for="">Title</label>
                <input
                  v-model="storeForm.work_name"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <input
                  v-model="storeForm.description"
                  type="text"
                  class="form-control"
                  required
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
                  v-model="storeForm.category"
                />
                <label for="Portrait">Portrait</label><br />
                <input
                  type="radio"
                  id="Landscape"
                  name="category"
                  value="Landscape"
                  v-model="storeForm.category"
                />
                <label for="Landscape">Landscape</label><br />
                <input
                  type="radio"
                  id="Random"
                  name="category"
                  value="Random"
                  v-model="storeForm.category"
                />
                <label for="Random">Random</label>
              </div>
              <div class="form-group">
                <label for="">Price (EUR)</label>
                <input
                  v-model="storeForm.price_in_eur"
                  type="number"
                  class="form-control"
                  required
                />
              </div>
              <label for="size">Size:</label>
              <select
                class="options"
                name="size"
                v-model="storeForm.size_id"
                style="width: 15rem"
                required
              >
                <option class="options" value="">Choose</option>
                <option
                  v-for="size in sizes"
                  v-bind:key="size.id"
                  :value="size.id"
                >
                  {{ size.type }}
                </option>
              </select>
              <br />
              <label for="canvas">Canvas:</label>
              <select
                class="options"
                name="canvas"
                v-model="storeForm.canvas_id"
                style="width: 15rem"
                required
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
              <br />
              <label for="paint">Paint:</label>
              <select
                name="paint"
                v-model="storeForm.paint_id"
                style="width: 15rem"
                class="options"
                required
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
                    required
                  />
                </div>
              </div>
              <div class="form-group">
                <input
                  type="submit"
                  value="Submit"
                  class="btn btn-primary btn-block"
                />
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
export default {
  name: "Uitility",
  data() {
    return {
      sizes: {},
      canvases: {},
      paints: {},
      showStoreModal: false,
      storeForm: {
        work_name: "",
        file_path: "",
        description: "",
        category: "",
        price_in_eur: "",
        size_id: "",
        canvas_id: "",
        paint_id: "",
      },
      stores: [],
      adminToken: localStorage.getItem("adminToken"),
    };
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
      this.storeForm.file_path = file;
    },
    openStoreModal() {
      this.showStoreModal = true;
    },
    hideStoreModal() {
      this.showStoreModal = false;
    },

    submitStoreForm() {
      let formData = new FormData();
      formData.append("work_name", this.storeForm.work_name);
      formData.append("file_path", this.storeForm.file_path);
      formData.append("description", this.storeForm.description);
      formData.append("category", this.storeForm.category);
      formData.append("price_in_eur", this.storeForm.price_in_eur);
      formData.append("size_id", this.storeForm.size_id);
      formData.append("canvas_id", this.storeForm.canvas_id);
      formData.append("paint_id", this.storeForm.paint_id);

      axios
        .post("/api/store", formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.stores.push(res.data.store);
            // reset the form
            this.storeForm = {
              work_name: "",
              file_path: "",
              description: "",
              category: "",
              price_in_eur: "",
              size_id: "",
              canvas_id: "",
              paint_id: "",
            };
            // hide the modal
            this.hideStoreModal();
            alert("The item was successfully added to the shop!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
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
    checkLoginStatus() {
      this.loading = true;
      // this.loading = true
      axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((response) => {
          this.currentUser = response.data;
          console.log("LOGGED IN");
          this.isLoggedIn = true;
          console.log(this.currentUser.name);
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
    this.checkLoginStatus();
    this.loadSizes();
    this.loadCanvases();
    this.loadPaints();
  },
};
</script>


<style scoped>
.options {
  border: solid 1px black;
}

.show {
  display: block !important;
}

form {
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  border: 0px;
}
label {
  color: #000;
}

.text-black {
  color: #000;
}

li {
  list-style: none;
  padding: 10px;
}
ul {
  padding: 0px;
  margin: 0px;
}
</style>