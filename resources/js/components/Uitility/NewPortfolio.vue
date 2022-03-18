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
      <div class="btn btn-sm btn-primary" @click="openPortfolioModal">
        Add New portfolio Item
      </div>
    </div>

    <!-- modal vindow -->
    <div
      class="modal"
      :class="{ show: showPortfolioModal }"
      id="portfolioModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add a new item to the portfolio
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hidePortfolioModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitPortfolioForm">
              <div class="form-group">
                <label for="">Title</label>
                <input
                  v-model="portfolioForm.work_name"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <input
                  v-model="portfolioForm.description"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <label for="collection">Collection:</label>
              <select
                class="options"
                name="collection"
                v-model="portfolioForm.collection_id"
                style="width: 15rem"
                required
              >
                <option class="options" value="">Choose</option>
                <option
                  v-for="collection in collections"
                  v-bind:key="collection.id"
                  :value="collection.id"
                >
                  {{ collection.name }}
                </option>
              </select>
              <br />
              <label for="size">Size:</label>
              <select
                class="options"
                name="size"
                v-model="portfolioForm.size_id"
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
                v-model="portfolioForm.canvas_id"
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
                v-model="portfolioForm.paint_id"
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
              <br />
              <label for="orientation">Orientation:</label>
              <select
                name="orientation"
                v-model="portfolioForm.orientation"
                style="width: 15rem"
                class="options"
                required
              >
                <option value="vertical">Vertical</option>
                <option value="horizontal">Horizontal</option>
              </select>
              <br />
              <label for="category">Category:</label>
              <select
                name="category"
                v-model="portfolioForm.category_id"
                style="width: 15rem"
                class="options"
                required
              >
                <option value="">Choose</option>
                <option
                  v-for="painting_category in painting_categories"
                  v-bind:key="painting_category.id"
                  :value="painting_category.id"
                >
                  {{ painting_category.category }}
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
      collections: {},
      painting_categories: {},
      showPortfolioModal: false,
      portfolioForm: {
        file_path: "",
        work_name: "",
        description: "",
        collection_id: "",
        size_id: "",
        canvas_id: "",
        paint_id: "",
        orientation: "",
        category_id: "",
        available_in_digital: "0",
      },
      portfolios: [],
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
      this.portfolioForm.file_path = file;
    },
    openPortfolioModal() {
      this.showPortfolioModal = true;
    },
    hidePortfolioModal() {
      this.showPortfolioModal = false;
    },

    submitPortfolioForm() {
      let formData = new FormData();
      formData.append("work_name", this.portfolioForm.work_name);
      formData.append("description", this.portfolioForm.description);
      formData.append("file_path", this.portfolioForm.file_path);
      formData.append("collection_id", this.portfolioForm.collection_id);
      formData.append("size_id", this.portfolioForm.size_id);
      formData.append("canvas_id", this.portfolioForm.canvas_id);
      formData.append("paint_id", this.portfolioForm.paint_id);
      formData.append("orientation", this.portfolioForm.orientation);
      formData.append("category_id", this.portfolioForm.category_id);
      formData.append(
        "available_in_digital",
        this.portfolioForm.available_in_digital
      );

      axios
        .post("/api/portfolio", formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.portfolios.push(res.data.portfolio);
            // reset the form
            this.portfolioForm = {
              work_name: "",
              file_path: "",
              description: "",
              category_id: "",
              price_in_eur: "",
              size_id: "",
              canvas_id: "",
              paint_id: "",
            };
            // hide the modal
            this.hidePortfolioModal();
            alert("The item was successfully added to the portfolio!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    loadCollections() {
      axios
        .get("api/collections")
        .then(({ data }) => (this.collections = data.data));

      console.log(this.collections);
    },
    loadSizes() {
      axios.get(`/api/all_sizes`).then((res) => {
        this.sizes = res.data.sizes;
      });
    },
    loadPaints() {
      axios.get(`/api/all_paints`).then((res) => {
        this.paints = res.data.paints;
      });
    },
    loadCanvases() {
      axios.get(`/api/all_canvases`).then((res) => {
        this.canvases = res.data.canvases;
      });
    },
    getAllPaintingCategories() {
      axios
        .get("api/all_painting_categories")
        .then(({ data }) => (this.painting_categories = data.data));
      console.log(this.painting_categories);
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
    this.loadCollections();
    this.checkLoginStatus();
    this.loadSizes();
    this.loadPaints();
    this.getAllPaintingCategories();
    this.loadCanvases();
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