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
      <div class="btn btn-sm btn-primary" @click="openPaintingCategoryModal">
        Add New Category
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Categories</div>
          <div class="card-body">
            <ul>
              <li
                v-for="(painting_category, index) in painting_categories"
                :key="index"
                class="
                  list-item
                  text-black
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <div>Category: {{ painting_category.category }}</div>
                <div
                  @click="deletePaintingCategory(index)"
                  class="btn btn-sm btn-danger"
                >
                  Delete
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal"
      :class="{ show: showPaintingCategoryModal }"
      id="paintingCategoryModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add Painting Category
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hidePaintingCategoryModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitPaintingCategoryForm">
              <div class="form-group">
                <label for="">Category</label>
                <input
                  v-model="paintingCategoryForm.category"
                  type="text"
                  class="form-control"
                />
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
      showPaintingCategoryModal: false,
      paintingCategoryForm: {
        category: "",
      },
      painting_categories: [],
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  methods: {
    openPaintingCategoryModal() {
      this.showPaintingCategoryModal = true;
    },
    hidePaintingCategoryModal() {
      this.showPaintingCategoryModal = false;
    },
    submitPaintingCategoryForm() {
      axios
        .post("/api/painting_categories", this.paintingCategoryForm, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.painting_categories.push(res.data.painting_category);
            // reset the form
            this.sizeForm = {
              type: "",
              price_in_eur: "",
            };
            // hide the modal
            this.hidePaintingCategoryModal();
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllPaintingCategories() {
      axios
        .get("/api/painting_categories", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.painting_categories = res.data.painting_categories;
          console.log(this.painting_categories);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deletePaintingCategory(index) {
      axios
        .delete(
          "/api/painting_categories/" + this.painting_categories[index].id,
          {
            headers: {
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then((res) => {
          if (res.data.status == "success") {
            this.painting_categories.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
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
    this.getAllPaintingCategories();
    this.checkLoginStatus();
  },
};
</script>


<style scoped>
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