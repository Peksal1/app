<template>
  <div>
    <Navbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <div class="input-group mb-3">
        <input v-model="searchKeyword" type="text" class="form-control" />
        <div class="input-group-append">
          <button @click="getAllItems" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="col-md-6 col-lg-4 col-xl-3" v-for="(portfolio, index) in portfolios" :key="index">
        <div class="card">
          <div class="card-body">
            <div class="product-image">
              <img :src="`/portfolio/${portfolio.file_path}`" alt="" @click="openAdminPortfolioModal(index)" />
            </div>
            <div class="title">Art name: {{ portfolio.work_name }}</div>
            <div class="title">Description: {{ portfolio.description }}</div>
            <div class="title">Category: {{ portfolio.portfolio_category.category }}</div>
            <div @click="callEditModal(index)" class="btn btn-sm btn-primary">
              Update
            </div>
            <div @click="deletePortfolio(index)" class="btn btn-sm btn-danger">
              Delete
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination :pagination="pagination" @perPage="getAllItems()" @paginate="getAllItems()" :offset="6">
        </Pagination>
      </div>
    </div>
    <div class="modal" :class="{ show: showAdminPortfolioModal }" id="portfolioModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>{{ portfolio.work_name }}</strong>
            </h5>
            <button type="button" class="close text-dark cursor: pointer" data-dismiss="modal" aria-label="Close"
              @click="hideAdminPortfolioModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img :src="`/portfolio/${portfolio.file_path}`" style="max-width: 465px" />

            <br />
            <strong>Description: </strong>{{ portfolio.description }}
            <br />


            <div @click="openDigitalModal(portfolio.id)" class="btn btn-sm btn-info">
              Add a digital version
            </div>

          </div>


        </div>
      </div>
    </div>
    <!-- new digital modal vindow -->
    <div class="modal" :class="{ show: showDigitalModal }" id="portfolioModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>Add a digital version</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideDigitalModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitDigitalForm(currentPortfolio)">
              <div class="form-group">
                <label for="">Resolution</label>
                <input v-model="digitalForm.resolution" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Price (in EUR)</label>
                <input v-model="digitalForm.price" type="text" class="form-control" required />
              </div>

              <div class="relative">
                <label for="attachment" class="leading-7 text-sm text-gray-600">Attachments</label><br />

                <input type="file" accept="image/*" @change="uploadDigitalImage($event)" id="file-input" required />
              </div>
              <br />
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block"
                  style="color:white;max-width:100px" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" :class="{ show: showUpdateModal }" id="storeModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>Update</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideUpdateModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updatePortfolio">



              <div class="form-group">
                <label for="">Work name</label>
                <input v-model="updateForm.work_name" type="text" class="form-control" required />
              </div>

              <div class="form-group">
                <label for="">Description</label>
                <input v-model="updateForm.description" type="text" class="form-control" required />
              </div>

              <div class="relative">
                <label for="attachment" class="leading-7 text-sm text-gray-600">Attachments</label><br />

                <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input" required />
              </div>
              <br />
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block"
                  style="color:white; max-width:100px" />
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
import Pagination from "../components/Pagination.vue";
export default {
  data() {
    return {
      portfolios: [],
      searchKeyword: "",
      showDigitalModal: false,
      showUpdateModal: false,
      updateForm: {
        id: null,
        file_path: '',
        description: '',
        orientation: '',
        price_in_eur: '',
        work_name: '',
      },
      digitalForm: {
        image: "",
        price: "",
        resolution: "",
        portfolio_id: "",
      },
      currentPortfolio: "",
      portfolio: [],
      showAdminPortfolioModal: false,
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      isLoggedIn: false,
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  components: {
    Navbar,
    Pagination,
  },
  methods: {
    deletePortfolio(index) {
      axios
        .delete("/api/portfolio/" + this.portfolios[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.getAllItems();
          if (res.data.status == "success") {
            this.portfolios.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    callEditModal(index) {
      this.updateForm = this.portfolios[index];
      this.showUpdateModal = true;
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.updateForm.file_path = file;
    },
    hideUpdateModal() {
      this.showUpdateModal = false;
    },
    updatePortfolio() {
      let formData = new FormData();
      formData.append("work_name", this.updateForm.work_name);
      formData.append("file_path", this.updateForm.file_path);
      formData.append("description", this.updateForm.description);
      //   formData.append("category_id", this.updateForm.category_id);
      formData.append("orientation", this.updateForm.orientation);
      //  formData.append("size_id", this.updateForm.size_id);
      //  formData.append("canvas_id", this.updateForm.canvas_id);
      //formData.append("paint_id", this.updateForm.paint_id);

      axios
        .post(`/api/portfolios/${this.updateForm.id}/update`, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            let portfolioIndex = this.portfolios.findIndex(item => item.id == this.updateForm.id);
            this.portfolios[portfolioIndex] = res.data.shop;
            // reset the form
            this.updateForm = {
              work_name: "",
              file_path: "",
              description: "",
              orientation: "",
            };
            // hide the modal
            this.hideUpdateModal();
            alert("The portfolio item was updated successfully !");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    submitDigitalForm(currentPortfolio) {
      this.checkLoginStatus();
      let formData = new FormData();
      formData.append("resolution", this.digitalForm.resolution);
      formData.append("price", this.digitalForm.price);
      formData.append("image", this.digitalForm.image);
      formData.append("portfolio_id", this.currentPortfolio);
      axios
        .post("/api/portfolio/digital/" + this.currentPortfolio, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,

          },
        })
        .then((res) => {
          if (res.data.success) {
            this.portfolios.push(res.data.portfolio);
            // reset the form
            this.digitalForm = {
              resolution: "",
              price: "",
            };
            // hide the modal
            this.hideAdminPortfolioModal();
            alert("The digital painting was added successfully!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    openDigitalModal(index) {
      this.showDigitalModal = true;
      this.currentPortfolio = index;
    },
    hideDigitalModal() {
      this.showDigitalModal = false;
    },
    uploadDigitalImage(event) {
      const file = event.target.files[0];
      this.digitalForm.image = file;
    },
    openAdminPortfolioModal(index) {
      this.showAdminPortfolioModal = true;
      this.loadSpecificPortfolio(index);
    },
    hideAdminPortfolioModal() {
      this.showAdminPortfolioModal = false;
    },
    loadSpecificPortfolio(index) {
      axios
        .get("/api/portfolio/" + this.portfolios[index].id, {})

        .then((response) => {
          this.portfolio = response.data;
          this.digitals = response.data.digital_paintings;
        })
        .catch((error) => {
          console.log(error);
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
    getAllItems() {
      axios
        .get(
          `/api/portfolio?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`,
          {
            headers: {
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then((res) => {
          this.portfolios = res.data.data;
          this.pagination = res.data;
        });
    },
  },
  created() {
    this.getAllItems();
  },
  mounted() {
    this.checkLoginStatus();
    this.getAllItems();
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap");

.form-control {
  border-radius: 7px;
  border: 1.5px solid #e3e6ed;
}

.product-image img {
  max-width: 100%;
  width: 100%;
}

input.form-control:focus {
  box-shadow: none;
  border: 1.5px solid #e3e6ed;
  background-color: #f7f8fd;
  letter-spacing: 1px;
}

.btn-primary {
  background-color: #5878ff !important;
  border-radius: 7px;
}

.btn-primary:focus {
  box-shadow: none;
}
</style>