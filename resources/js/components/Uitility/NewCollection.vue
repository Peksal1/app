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
      <div class="btn btn-sm btn-primary" @click="openCollectionModal">
        Add New Store Item
      </div>
    </div>

    <!-- modal vindow -->
    <div
      class="modal"
      :class="{ show: showCollectionModal }"
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
              @click="hideCollectionModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitCollectionForm">
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
      showCollectionModal: false,
      collectionForm: {
        name: "",
        description: "",
        image: "",
        start_date: "",
        end_date: "",
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
      this.collectionForm.image = file;
    },
    openCollectionModal() {
      this.showCollectionModal = true;
    },
    hideCollectionModal() {
      this.showCollectionModal = false;
    },

    submitCollectionForm() {
      const collectionForm = new FormData();
      collectionForm.append("image", this.formData.image);
      collectionForm.append("description", this.formData.description);
      collectionForm.append("name", this.formData.name);
      collectionForm.append("start_date", this.formData.start_date);
      collectionForm.append("end_date", this.formData.end_date);

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