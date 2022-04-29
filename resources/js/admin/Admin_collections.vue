    <template>
  <div>
    <AdminNavbar />
    <router-link class="btn btn-sm btn-danger" :to="{ name: 'portfolio/admin' }"
              >Manage the portfolio</router-link
            >
    <Utility />
    <NewCollection />
    <NewPortfolio />
    <NewPaintingCategory />
    
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Painting collections</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Single Product -->
          <div
            class="col-md-6 col-lg-4 col-xl-3"
            v-for="collection in collections"
            :key="collection.id"
          >
            <div id="product-1" class="single-product">
              <div class="part-1">
                <router-link
                  :to="{
                    name: 'portfolio',
                    params: { id: collection.id },
                  }"
                >
                  <img :src="`/collection/${collection.image}`" alt="" x
                /></router-link>

                <ul>
                  <li>
                    <a href="#"><i class="fas fa-expand"></i></a>
                  </li>
                </ul>
              </div>
              <div class="part-2">
                <h3 class="product-title">
                  <strong>{{ collection.name }}</strong>
                </h3>
                <div class="category">{{ collection.description }}</div>
                <h4 class="product-price">
                  {{ collection.start_date }} - {{ collection.end_date }}
                </h4>
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
  </div>
</template>
<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
import Pagination from "../components/Pagination.vue";
import Utility from "../components/Uitility/Uitility.vue";
import NewCollection from "../components/Uitility/NewCollection.vue";
import NewPortfolio from "../components/Uitility/NewPortfolio.vue";
import NewPaintingCategory from "../components/Uitility/NewPaintingCategory.vue";
export default {
  data() {
    return {
      collections: [],
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      token: localStorage.getItem("token"),
    };
  },
  components: {
    AdminNavbar,
    Pagination,
    Utility,
    NewCollection,
    NewPortfolio,
    NewPaintingCategory,
  },
  methods: {
    getAllCollections() {
      axios.get("/api/collections").then((res) => {
        this.collections = res.data.data;
        this.pagination = res.data;
      });
    },
  },
  checkLoginStatus() {
    this.loading = true;
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
  created() {
    this.getAllCollections();
  },
};
</script>


<style  scoped>
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