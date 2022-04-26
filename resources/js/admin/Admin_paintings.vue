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
      <div
            class="col-md-6 col-lg-4 col-xl-3"
            v-for="(portfolio, index) in portfolios"
            :key="index"
          >
        <div class="card">
          <div class="card-body">
            <div class="product-image">
              <img :src="`/portfolio/${portfolio.file_path}`" alt="" @click="openAdminPortfolioModal(index)"/>
            </div>
            <div class="title">Art name: {{ portfolio.work_name }}</div>
            <div class="title">Description: {{ portfolio.description }}</div>
            <div class="title">Category: {{ portfolio.category }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination
          :pagination="pagination"
          @perPage="getAllItems()"
          @paginate="getAllItems()"
          :offset="6"
        >
        </Pagination>
      </div>
    </div>
         <div
        class="modal"
        :class="{ show: showAdminPortfolioModal }"
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
                {{ portfolio.work_name }}
              </h5>
              <button
                type="button"
                class="close text-dark cursor: pointer"
                data-dismiss="modal"
                aria-label="Close"
                @click="hideAdminPortfolioModal"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img
                :src="`/portfolio/${portfolio.file_path}`"
                style="max-width: 500px"
              />

              <br />
              {{ portfolio.orientation }}
              <br />
              {{ portfolio.id }}
              <br />
           
              <div @click="addDigital(this.portfolio.id)" class="btn btn-sm btn-danger">
                Add a digital version
              </div>
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
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
    Pagination,
  },
  methods: {

    addDigital({this.digital.id}) {


    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.collectionForm.image = file;
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
            Authorization: "Bearer " + this.token,
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
              Authorization: "Bearer " + this.token,
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