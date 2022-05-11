    <template>
  <div>
    <Navbar />
    <section class="section-collections">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Painting collections</h2>
            </div>
          </div>
        </div>
         
          <!-- Single Product -->
          <div
            class="col-md-6 col-lg-4 col-xl-2"
           
          >
            <div id="product-1" class="single-product">
              <div class="part-1">
                <router-link
                  :to="{
                    name: 'portfolio/all',
                  }"
                >
                  <img :src="`/collection/all.png`" style="max-width:290px; max-height:300px" alt="" x
                /></router-link>

                <ul>
                  <li>
                    <a href="#"><i class="fas fa-expand"></i></a>
                  </li>
                </ul>
              </div>
              <div class="part-2">
                <h3 class="product-title">
                  <strong>Full portfolio</strong>
                </h3>
                <div class="category">All of my portfolio items</div>
                <h4 class="product-price">
                  1999 - to this day
                </h4>
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
                  <img :src="`/collection/${collection.image}`" alt="" style="max-width:300px"x
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
import Navbar from "../components/Navbar.vue";
import Pagination from "../components/Pagination.vue";
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
    Navbar,
    Pagination,
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

.section-collections {
  padding: 80px 0 54px;
}

.section-collections .header {
  margin-bottom: 50px;
}

.section-collections .header h3 {
  font-size: 1rem;
  color: #fe302f;
  font-weight: 500;
}

.section-collections .header h2 {
  font-size: 2.2rem;
  font-weight: 400;
  color: #444444;
}

.section-collections .single-product {
  margin-bottom: 26px;
}

.section-collections .single-product .part-1 {
  position: relative;
  height: 290px;
  max-height: 290px;
  margin-bottom: 20px;
  overflow: hidden;
}

.section-collections .single-product .part-1::before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  transition: all 0.3s;
}

.section-collections .single-product:hover .part-1::before {
  transform: scale(1.2, 1.2) rotate(5deg);
}

.section-collections #product-1 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
  transition: all 0.3s;
}

.section-collections .single-product .part-1 ul li a:hover {
  color: #fe302f;
}

.section-collections .single-product .part-2 .product-title {
  font-size: 1rem;
}

.section-collections .single-product .part-2 h4 {
  display: inline-block;
  font-size: 1rem;
  color: gray;
}
</style>