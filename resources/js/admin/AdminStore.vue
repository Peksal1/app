<template>
  <div>
    <AdminNavbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <NewStore />
      <div class="input-group mb-3">
        <input v-model="searchKeyword" type="text" class="form-control" />
        <div class="input-group-append">
          <button @click="getAllItems" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Paintings for sale</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Single Product -->
          <div class="col-md-6 col-lg-4 col-xl-3" v-if="!isPaymentLoading" v-for="(shop, index) in shops" :key="index">
            <div id="product-1" class="single-product">
              <div class="part-1">
                <img :src="`/sale/${shop.file_path}`" alt="" style="max-width:430px" />

              </div>
              <div class="part-2">
                <h3 class="product-title">
                  <strong>{{ shop.work_name }}</strong>
                </h3>
                <h4 class="product-price">{{ shop.description }}</h4><br />
                <h4 class="product-price">{{ shop.price_in_eur }} EUR</h4> <br />

                <div class="buy-btn mt-3">
                  <div @click="buyProduct(shop.id)" class="btn btn-block btn-primary">
                    Buy Now
                  </div>
                  <br />
                  <div @click="callEditModal(index)" class="btn btn-sm btn-primary">
                    Update
                  </div>
                  <div @click="deleteShop(index)" class="btn btn-sm btn-danger">
                    Delete
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="text-center">
              <h2>Payment Page Loading</h2>
            </div>
          </div>
        </div>
        <div class="col-md-12 text-center center-pagination">
          <Pagination :pagination="pagination" @perPage="getAllItems()" @paginate="getAllItems()" :offset="6">
          </Pagination>
        </div>
      </div>
    </section>
    <div class="modal" :class="{ show: shoUpadteModal }" id="storeModal" tabindex="-1" role="dialog"
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
            <form @submit.prevent="updateProduct">



              <div class="form-group">
                <label for="">Work name</label>
                <input v-model="updateForm.work_name" type="text" class="form-control" required />
              </div>

              <div class="form-group">
                <label for="">Description</label>
                <input v-model="updateForm.description" type="text" class="form-control" required />
              </div>

              <div class="form-group">
                <label for="">Price (EUR)</label>
                <input v-model="updateForm.price_in_eur" type="text" class="form-control" required />
              </div>
              <div class="relative">
                <label for="attachment" class="leading-7 text-sm text-gray-600">Attachments</label><br />

                <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input" required />
              </div>
              <br />
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block"
                  style="max-width:100px;color:white" />
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
import NewStore from "../components/Uitility/NewStore.vue";
export default {
  data() {
    return {
      shops: [],
      searchKeyword: "",
      adminToken: localStorage.getItem("adminToken"),
      isPaymentLoading: false,
      shoUpadteModal: false,
      updateForm: {
        id: null,
        file_path: '',
        description: '',
        orientation: '',
        price_in_eur: '',
        work_name: '',
      },
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
    };
  },
  components: {
    AdminNavbar,
    Pagination,
    NewStore,
  },
  methods: {
    updateProduct() {
      let formData = new FormData();
      formData.append("work_name", this.updateForm.work_name);
      formData.append("file_path", this.updateForm.file_path);
      formData.append("description", this.updateForm.description);
      //   formData.append("category_id", this.updateForm.category_id);
      formData.append("orientation", this.updateForm.orientation);
      formData.append("price_in_eur", this.updateForm.price_in_eur);
      //  formData.append("size_id", this.updateForm.size_id);
      //  formData.append("canvas_id", this.updateForm.canvas_id);
      //formData.append("paint_id", this.updateForm.paint_id);

      axios
        .post(`/api/shops/${this.updateForm.id}/update`, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            let shopIndex = this.shops.findIndex(item => item.id == this.updateForm.id);
            this.shops[shopIndex] = res.data.shop;
            // reset the form
            this.updateForm = {
              work_name: "",
              file_path: "",
              description: "",
              orientation: "",
              category_id: "",
              price_in_eur: "",
              size_id: "",
              canvas_id: "",
              paint_id: "",
            };
            // hide the modal
            this.hideUpdateModal();
            alert("The item was successfully added to the shop!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    callEditModal(index) {
      this.updateForm = this.shops[index];
      this.shoUpadteModal = true;
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.updateForm.file_path = file;
    },
    hideUpdateModal() {
      this.shoUpadteModal = false;
    },
    deleteShop(index) {
      axios
        .delete("/api/shops/" + this.shops[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.getAllItems();
          if (res.data.status == "success") {
            this.shops.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    buyProduct(id) {
      this.isPaymentLoading = true;
      axios
        .post(
          "/api/create-payment-session",
          {
            product: id,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((response) => {
          this.redirectToStripe(response.data.session_id);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.isPaymentLoading = false;
        });
    },
    redirectToStripe(sessionID) {
      let stripe = Stripe("pk_test_51HrQxvBs1Zza18elihlzjZJ6mZWcTnb6IVL8koLp8zgU4ohLCRAP50PL9KuAALZ9pPRAPTDebP3RrGJOreTQpVbb00K3Ngv7gO");
      stripe
        .redirectToCheckout({
          sessionId: sessionID,
        })
        .then((res) => {
          console.log(res);
        });
    },
    getAllItems() {
      axios
        .get(
          `/api/store?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`
        )
        .then((res) => {
          this.shops = res.data.data;
          this.pagination = res.data;
        });
    },
  },
  created() {
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

.part-1 {
  width: 250px;
  height: 250px;
  object-fit: contain;
  border: 1px solid #ccc;
  width: 100%;
}
</style>