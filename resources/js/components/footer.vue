<template>
  <div>
    <div class="row footer margin-right-0">
      <div class="col-md-4">
        <p>
          <router-link class="col" :to="{ name: 'deliveryshipping' }">Delivery & Shipping</router-link>
        </p>
        <p>
          <router-link class="col" :to="{ name: 'paymentoptions' }">Payment options</router-link>
        </p>
      </div>
      <div class="col-md-4">
        <h4>Contact us</h4>
        <p>info@peksal1.com</p>
        <p>+370 699 65921</p>
      </div>
      <div class="col-md-4">
        <h4>Social Links</h4>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="https://www.facebook.com/ALaursArt" target="_blank">
            <i class="fab fa-facebook fa-2x" alt="facebook"></i>
          </a>
        </span>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="https://www.youtube.com/" target="_blank">
            <i class="fab fa-youtube fa-2x" alt="youtube"></i>
          </a>
        </span>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="https://www.twitter.com/" target="_blank">
            <i class="fab fa-twitter fa-2x" alt="twitter"></i>
          </a>
        </span>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="https://www.linkedin.com/" target="_blank">
            <i class="fab fa-linkedin fa-2x" alt="linkedin"></i>
          </a>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
<style scoped>
.footer {
  background-color: #fca504;
  color: white;
  padding: 20px 0px 20px 30px;
  margin-top: 0px;
}
</style>
