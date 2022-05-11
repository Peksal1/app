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
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Full portfolio</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <p><strong>FILTER BY CATEGORY</strong></p>
            <!-- painting category filtering -->
            <div
              v-for="(painting_category, index) in painting_categories"
              :key="index"
              class="m-1"
            >
              <div>
                <input
                  type="checkbox"
                  :id="`category_${painting_category.id}`"
                  class="mycat"
                  v-model="cat"
                  :value="painting_category.id"
                /><label
                  :for="`category_${painting_category.id}`"
                  class="btn btn-sm border btn-block"
                  >{{ painting_category.category }}</label
                >
              </div>
            </div>
            <p class="mt-4"><strong>FILTER BY SIZE</strong></p>
            <!-- painting size filtering -->
            <div v-for="(size, index) in sizes" :key="index" class="m-2">
              <div>
                <input
                  type="checkbox"
                  :id="`size_${size.id}`"
                  class="mysize"
                  v-model="sizefilter"
                  :value="size.id"
                /><label :for="`size_${size.id}`" class="btn btn-sm border btn-block">{{
                  size.type
                }}</label>
              </div>
            </div>
            <p class="mt-4"><strong>FILTER BY PAINT</strong></p>
            <!-- paint filterting -->
            <div v-for="(paint, index) in paints" :key="index" class="m-1">
              <input
                type="checkbox"
                :id="`paint_${paint.id}`"
                class="mypaint"
                v-model="paintfilter"
                :value="paint.id"
              /><label :for="`paint_${paint.id}`" class="btn btn-sm border btn-block">{{
                paint.type
              }}</label>
            </div>

            <p class="mt-4"><strong>FILTER BY CANVAS</strong></p>

            <!-- canvas filtering -->
            <div v-for="(canvas, index) in canvases" :key="index" class="m-1">
              <div>
                <input
                  type="checkbox"
                  :id="`canvas_${canvas.id}`"
                  class="mycanvas"
                  v-model="canvasfilter"
                  :value="canvas.id"
                /><label
                  :for="`canvas_${canvas.id}`"
                  class="btn btn-sm border btn-block"
                  >{{ canvas.type }}</label
                >
              </div>
            </div>
            <!-- products -->
          </div>
          <div class="col-md-9">
            <div class="row">
              <!-- Single Product -->
              <div
                class="col-md-6"
                v-for="(portfolio, index) in portfolios"
                :key="index"
              >
                <div id="product-1" class="single-product">
                  <div class="part-1">
                    <img :src="`/portfolio/${portfolio.file_path}`" alt="" @click="openPortfolioModal(index)"/>
                    <ul>
                      <li>
                        <a href="#"><i class="fas fa-expand"></i></a>
                      </li>
                    </ul>
                  </div>
                  <div class="part-2">
                    <h3 class="product-title">
                      <strong>{{ portfolio.work_name }}</strong>
                    </h3>
                    <div class="category">{{ portfolio.category_id }}</div>
            
                    
                  </div>
                </div>
              </div>
              
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
    </section>
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
                {{ portfolio.work_name }}
              </h5>
              <button
                type="button"
                class="close text-dark cursor: pointer"
                data-dismiss="modal"
                aria-label="Close"
                @click="hidePortfolioModal"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img
                :src="`/portfolio/${portfolio.file_path}`"
                style="max-width: 470px"
              />

              <br />
              {{ portfolio.orientation }}
              <br />
              {{ portfolio.id }}
              <br />
           
              <div v-for="(digital, portfolio) in digitals"
            :key="portfolio" @click="buyDigital(digital.id)" class="btn btn-sm btn-danger" >
                {{digital.resolution}} BUY IN DIGITAL
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
      cat: [],
      sizefilter: [],
      canvasfilter: [],
      paintfilter: [],
      sizes: "",
      canvases: "",
      paints: "",
        digitals: [],
      portfolio: {},
      showPortfolioModal: false,
      searchKeyword: "",
      painting_categories: "",
      isPaymentLoading: false,
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
    Navbar,
    Pagination,
  },
  methods: {
     openPortfolioModal(index) {
      this.showPortfolioModal = true;
      this.loadSpecificPortfolio(index);
    },
    hidePortfolioModal() {
      this.showPortfolioModal = false;
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
    buyDigital(portfolio) {
      this.isPaymentLoading = true;
      axios
        .post(
          "/api/portfolio/create-payment-session",
          {
            portfolio: portfolio,
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
      let stripe = Stripe("pk_test_d6aChIuFov53M3i5n00Fn1j200m37XdpTE");
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
          `/api/portfolios?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}&cat=${this.cat}&sizefilter=${this.sizefilter}&paintfilter=${this.paintfilter}&canvasfilter=${this.canvasfilter}`
        )
        .then((res) => {
          this.portfolios = res.data.data;
          this.pagination = res.data;
        });
    },
    getAllPaintingCategories() {
      axios.get(`/api/painting_categories`).then((res) => {
        this.painting_categories = res.data.painting_categories;
      });
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
  },
  created() {
    this.getAllItems();
    this.getAllPaintingCategories();
    this.loadCanvases();
    this.loadPaints();
    this.loadSizes();
  },
  watch: {
    cat(after, before) {
           this.pagination.current_page = 1;
      this.getAllItems();
 
    },
    sizefilter(after, before) {
          this.pagination.current_page = 1;
      this.getAllItems();
  
    },
    canvasfilter(after, before) {
        this.pagination.current_page = 1;
      this.getAllItems();
    
    },
    paintfilter(after, before) {
      this.pagination.current_page = 1;
      this.getAllItems();
  
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

input.mycat:checked + label,
input.mypaint:checked + label,
input.mysize:checked + label,
input.mycanvas:checked + label {
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