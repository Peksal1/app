    <template>
    <div>
        <Navbar />
        <div class="col-lg-4 col-md-12 right-box">
            <div class="card">
                <div class="body search">
                    <div class="input-group m-b-0">
                        <div class="input-group-prepend">
                            <button @click="loadCoins">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </button>
                        </div>
                        <input type="text" class="form-control" placeholder="Search..." v-model="searchKeyword" />
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row header" style="text-align:center;color:green">
                <h3>Table of cryptocurrencites</h3>
            </div>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Price (USD)</th>
                        <th>Total supply</th>
                        <th>Max supply</th>
                        <th>Added:</th>
                    </tr>
                </thead>
                <tbody v-for="coin in coins" :key="coin.id">
                    <tr>
                        <td>{{ coin.name }}</td>
                        <td>{{ coin.symbol }}</td>
                        <td>{{ coin.quote.USD.price }}</td>
                        <td>{{ coin.total_supply }}</td>
                        <td>{{ coin.max_supply }}</td>
                        <td>{{ coin.date_added }}</td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
import Pagination from "../components/Pagination.vue";
export default {
    data: function () {
        return {
            coins: [],
            searchKeyword: "",
            pagination: {
                data: [],
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1,
            },
            coinData: {
                name: [],
                symbol: [],
                usd_price: [],
                total_supply: [],
                max_supply: [],
            },
            token: localStorage.getItem("token"),
        };
    },
    components: {
        Navbar,
        Pagination,
    },

    methods: {
        loadCoins() {
            axios
                .get(`/api/coins/all?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                    },
                })
                .then((response) => {
                    this.coins = response.data.data;
                    this.coinData = response.data.data;
                    console.log(response.data.data);
                })
                .catch((error) => {
                    console.log(error.message);
                });
        },
        storeCoins() {
            const coinForm = new FormData();
            coinForm.append("name", this.coinData.name);
            coinForm.append("symbol", this.coinData.symbol);
            coinForm.append("usd_price", this.coinData.usd_price);
            coinForm.append("total_supply", this.coinData.total_supply);
            coinForm.append("max_supply", this.coinData.max_supply);
            coinForm.append("date_added", this.coinData.date_added);

            axios
                .post("/api/coins/store", this.coinData, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "multipart/form-data",
                        boundary: coinForm._boundary,
                    },
                })
                .then((response) => {
                    alert("Coins Stored!");
                })
                .catch((errors) => {
                    console.log("error");
                });
        },
    },
    created() { },

    mounted() {
        this.loadCoins();
        this.storeCoins();

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