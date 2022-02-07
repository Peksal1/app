<template>
  <div>
    <div class="row footer margin-right-0">
      <div class="col-md-4">
        <h4>You are currently on</h4>
        <p>The best website ever!!</p>
      </div>
      <div class="col-md-4">
       <h4>Contact us</h4>
       <p>Iljlau@ktu.edu</p>
       <p>+37063647007</p>
        </div> 
      <div class="col-md-4">
        <h4>Social Link</h4>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="" target="_blank">
            <i class="fa fa-facebook"></i>
          </a>
        </span>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="" target="_blank">TW</a>
        </span>
        <span class="list-inline-item">
          <a class="social-icon-text-xs-center text-white" href="" target="_blank">YT</a>
        </span>
        </div> 
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
<style scoped>
.footer {
    background-color:#fca504;
    color:white;
    padding: 20px 0px 20px 30px;
}
</style>
