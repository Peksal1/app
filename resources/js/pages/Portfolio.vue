    <template>
  <div>
    <Navbar />
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Collection - {{ collection.name }}</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Single Product -->
          <div class="col-md-6 col-lg-4 col-xl-3" v-for="(portfolio, index) in portfolios" :key="index">
            <div id="product-1" class="single-product">
              <div class="part-1">
                <img :src="`/portfolio/${portfolio.file_path}`" alt="{portfolio.work_name}"
                  style="cursor: pointer; max-width: 450px" @click="openPortfolioModal(index)" />

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
                <div class="category">{{ portfolio.description }}</div>
                <h4 class="product-price">
                  {{ portfolio.category }}
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal" :class="{ show: showPortfolioModal }" id="portfolioModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-dark" id="exampleModalLabel">
                {{ portfolio.work_name }}
              </h5>
              <button type="button" class="close text-dark cursor: pointer" data-dismiss="modal" aria-label="Close"
                @click="hidePortfolioModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img :src="`/portfolio/${portfolio.file_path}`" style="max-width: 500px" />

              <br />
              {{ portfolio.orientation }}
              <br />
              {{ portfolio.id }}
              <br />

              <div v-for="(digital, portfolio) in digitals" :key="portfolio" @click="buyDigital(digital.id)"
                class="btn btn-sm btn-danger">
                {{ digital.resolution }} BUY IN DIGITAL
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      portfolios: [],
      digitals: [],
      portfolio: {},
      collection: [],
      showPortfolioModal: false,
      currentUser: {},
      isLoggedIn: false,
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
  },

  methods: {
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
    loadCollection() {
      axios
        .get("/api/collection/" + this.$route.params.id, {})

        .then((response) => {
          this.collection = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadPortfolios() {
      axios
        .get("/api/collection/portfolio/" + this.$route.params.id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;
          ///    this.appointments=response.data.data
          this.portfolios = response.data;
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    openPortfolioModal(index) {
      this.showPortfolioModal = true;
      this.loadSpecificPortfolio(index);
    },
    hidePortfolioModal() {
      this.showPortfolioModal = false;
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
  },
  created() { },

  mounted() {
    this.checkLoginStatus();
    this.loadPortfolios();
    this.loadCollection();
  },
};
</script>

 <style scoped>
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
  color: gray;
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
</style>