<template>
  <div>
    <AdminNavbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <div class="input-group mb-3">
        <input v-model="searchKeyword" type="text" class="form-control" />
        <div class="input-group-append">
          <button @click="loadAllPurchases" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>User purchases</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <p><strong>Filter by status</strong></p>
            <!-- status filtering -->
            <div class="m-1">
              <div>
                <input type="checkbox" :id="1" class="mycat" v-model="trackingFilter" :value="'Not yet available'"
                  checked /><label :for="1" class="btn btn-sm border btn-block">Display all purchases</label>
              </div>
            </div>
            <!-- purchases -->
          </div>
          <div class="col-md-9">
            <div class="row">
              <!-- Single purchase -->
              <div class="col-md-6" v-for="(purchase, index) in purchases" :key="index">
                <div id="product-1" class="single-product">
                  <div class="part-1">
                    <img :src="`/sale/${purchase.store.file_path}`" alt="{purchase.store,work_name}"
                      style="cursor: pointer; max-width: 450px" @click="openPurchaseModal(index)" />

                  </div>
                  <div class="part-2">
                    <h3 class="product-title">
                      <strong>{{ purchase.store.work_name }}</strong>
                    </h3>
                    <div class="category"> {{ purchase.store.price_in_eur }} EUR</div>


                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 text-center center-pagination">
          <Pagination :pagination="pagination" @perPage="loadAllPurchases()" @paginate="loadAllPurchases()" :offset="6">
          </Pagination>
        </div>
      </div>
    </section>
    <div class="modal" :class="{ show: showPurchaseModal }" id="purchaseModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" v-if="specific_purchase != null">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>{{ specific_purchase.store.work_name }}</strong></h5>
            <button type="button" class="close text-dark cursor: pointer" data-dismiss="modal" aria-label="Close"
              @click="hidePurchaseModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <img :src="`/sale/${specific_purchase.store.file_path}`" alt="{specific_purchase.store,work_name}"
              style=" max-width: 465px" />
            <br />
            <strong>Purchased by: </strong>{{ specific_purchase.user.name }} {{ specific_purchase.user.surname }} <br />
            <strong>Purchased on: </strong>{{ specific_purchase.created_at }} <br />
            <strong>Purchase ID: </strong> {{ specific_purchase.uuid }} <br />
            <strong>Price: </strong> {{ specific_purchase.store.price_in_eur }} EUR <br />
            <strong>Ship to: </strong> <br />
            <div v-if="specific_purchase.shipping">
              {{ specific_purchase.shipping.name }} {{ specific_purchase.shipping.surname }}, <br />
              {{ specific_purchase.shipping.country }}, {{ specific_purchase.shipping.city }}, <br />
              {{ specific_purchase.shipping.adress1 }}, {{ specific_purchase.shipping.adress2 }}, {{
                  specific_purchase.shipping.postal_code
              }} <br />
              <strong>E-mail: </strong>{{ specific_purchase.shipping.email }} <br />
              <strong>Phone number: </strong> {{ specific_purchase.shipping.phone_number }} <br />
              <strong>Tracking number: </strong> {{ specific_purchase.tracking_number }} <br />
              <div @click="openTrackingModal(specific_purchase.id)" class="btn btn-sm btn-primary">
                Add tracking
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" :class="{ show: showTrackingModal }" id="trackingModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>Add tracking for: {{ trackingForm.uuid }}</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideTrackingModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateTracking">


              <div class="form-group">
                <label for="">Tracking number</label>
                <input v-model="trackingForm.tracking_number" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block"
                  style="color:white; max-width:80px" />
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
import Pagination from "../components/Pagination.vue";
export default {
  data: function () {
    return {
      purchases: [],
      store: [],
      specific_purchase: null,
      searchKeyword: "",
      trackingFilter: [],
      showPurchaseModal: false,
      showTrackingModal: false,
      users: [],
      trackingForm: {
        id: null,
        uuid: '',
        tracking_number: '',
      },
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      currentUser: [],
      adminToken: localStorage.getItem("adminToken"),
      isLoggedIn: false,
    };
  },
  components: {
    AdminNavbar,
    Pagination,
  },

  methods: {
    updateTracking() {
      let formData = new FormData();
      formData.append("tracking_number", this.trackingForm.tracking_number);

      axios
        .post(`/api/purchases/${this.trackingForm.id}/update`, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            let purchaseIndex = this.purchases.findIndex(item => item.id == this.trackingForm.id);
            this.purchases[purchaseIndex] = res.data.purchase;

            // hide the modal
            this.hideTrackingModal();
            alert("The tracking info was updated!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    openTrackingModal(index) {
      this.trackingForm = this.specific_purchase;
      this.showTrackingModal = true;
    },
    hideTrackingModal() {
      this.showTrackingModal = false;
    },
    openPurchaseModal(index) {
      this.showPurchaseModal = true;
      this.loadSpecificPurchase(index);
    },
    hidePurchaseModal() {
      this.showPurchaseModal = false;
    },
    loadAllPurchases() {
      axios
        .get(
          `/api/purchases/all?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}&trackingFilter=${this.trackingFilter}`,
          {
            headers: {
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then((response) => {
          this.isLoggedIn = false;
          this.purchases = response.data.data;
          console.log(purchases);
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    loadSpecificPurchase(index) {
      axios
        .get("/api/purchases/" + this.purchases[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })

        .then((response) => {
          this.specific_purchase = response.data;
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
          this.isLoggedIn = true;
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
  created() { },
  mounted() {
    this.loadAllPurchases();
    this.checkLoginStatus();
  },
  watch: {
    trackingFilter(after, before) {
      this.pagination.current_page = 1;
      this.loadAllPurchases();

    },
  },
};
</script>

<style scoped>
input.mycat,
input.mypaint,
input.mysize,
input.mycanvas {
  display: none;
}

input.mycat:checked+label,
input.mypaint:checked+label,
input.mysize:checked+label,
input.mycanvas:checked+label {
  background: green;
  color: white;
  box-shadow: 0px 1px 3px inset;
}

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

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");

body {
  font-family: "Poppins", sans-serif;
  color: #444444;
}

a,
a:hover {
  text-decoration: none;
  color: inherit;
}

.section-products {
  padding: 80px 0 54px;
}

.section-products .header {
  margin-bottom: 50px;
}

.section-products .header h3 {
  font-size: 1rem;
  color: #fe302f;
  font-weight: 500;
}

.section-products .header h2 {
  font-size: 2.2rem;
  font-weight: 400;
  color: #444444;
}

.section-products .single-product {
  margin-bottom: 26px;
}

.section-products .single-product .part-1 {
  position: relative;
  height: 290px;
  max-height: 290px;
  margin-bottom: 20px;
  overflow: hidden;
}

.section-products .single-product .part-1::before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  transition: all 0.3s;
}

.section-products .single-product:hover .part-1::before {
  transform: scale(1.2, 1.2) rotate(5deg);
}

.section-products #product-1 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
  transition: all 0.3s;
}

.section-products #product-2 .part-1::before {
  background: url("https://i.ibb.co/cLnZjnS/2.jpg") no-repeat center;
  background-size: cover;
}

.section-products #product-3 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
}

.section-products #product-4 .part-1::before {
  background: url("https://i.ibb.co/cLnZjnS/2.jpg") no-repeat center;
  background-size: cover;
}

.section-products .single-product .part-1 .discount,
.section-products .single-product .part-1 .new {
  position: absolute;
  top: 15px;
  left: 20px;
  color: #ffffff;
  background-color: #fe302f;
  padding: 2px 8px;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.section-products .single-product .part-1 .new {
  left: 0;
  background-color: #444444;
}

.section-products .single-product .part-1 ul {
  position: absolute;
  bottom: -41px;
  left: 20px;
  margin: 0;
  padding: 0;
  list-style: none;
  opacity: 0;
  transition: bottom 0.5s, opacity 0.5s;
}

.section-products .single-product:hover .part-1 ul {
  bottom: 30px;
  opacity: 1;
}

.section-products .single-product .part-1 ul li {
  display: inline-block;
  margin-right: 4px;
}

.section-products .single-product .part-1 ul li a {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  background-color: #ffffff;
  color: #444444;
  text-align: center;
  box-shadow: 0 2px 20px rgb(50 50 50 / 10%);
  transition: color 0.2s;
}

.section-products .single-product .part-1 ul li a:hover {
  color: #fe302f;
}

.section-products .single-product .part-2 .product-title {
  font-size: 1rem;
}

.section-products .single-product .part-2 h4 {
  display: inline-block;
  font-size: 1rem;
  color: black;
}

.section-products .single-product .part-2 .product-old-price {
  position: relative;
  padding: 0 7px;
  margin-right: 2px;
  opacity: 0.6;
}

.section-products .single-product .part-2 .product-old-price::after {
  position: absolute;
  content: "";
  top: 50%;
  left: 0;
  width: 100%;
  height: 1px;
  background-color: #444444;
  transform: translateY(-50%);
}

.btn-block {
  width: 100%;
  text-align: left;
}

.mt-4 {
  margin-top: 10px;
}
</style>