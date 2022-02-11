<template>
  <div>
  <div class="row justify-content-center" >
  <div class="col-md-6">
<div class="card">
  <div class="card-header">
    Register
  </div>
  <div class="card-body">
    <form action="#" @submit.prevent="updateservice">
    <div class="form-group">
      <label for="">evaluation</label>
      <input type="text" class="form-control" name="evaluation"  v-model="evaluation">     
    </div>
    <div class="form-group">
      <label for="">pros</label>
      <input type="text" class="form-control" name="pros"  v-model="pros">     
    </div>
    <div class="form-group">
      <label for="">cons</label>
      <input type="text" class="form-control" name="cons"  v-model="cons">     
    </div>
    <div class="row">
      <div class="col-md-6">
        <button type="submit"  class="btn btn-primary">Update</button>
      </div>
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
export default {
  data() {
    return {   
        evaluation:'',
        pros:'',
        cons:'',
      token: localStorage.getItem("token"),
     
    };
  },
 
  methods:{
   updateservice(){
    axios.put('/api/feedback/'+ this.$route.params.id,{
      evaluation:this.evaluation,
      pros:this.pros,
      cons:this.cons,
 
    },{
      headers: {
      Authorization: "Bearer " + this.token,
      }
     
    }).then(response=>{
      console.log(response)
        Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'The feedback was changed successfully!',
  showConfirmButton: false,
  timer: 1500
})
       this.$router.push('/feedback')
    }).catch(error =>{
      console.log(error)
    })
   },
  
  }, 
  ///here we mounted when activity start 
  mounted(){
    axios.get('/api/feedback/'+ this.$route.params.id, {
      headers: {
      Authorization: "Bearer " + this.token,
      }
    }).then(response=>{
      const user=response.data
      this.evaluation=user.evaluation
      this.pros=user.pros
      this.cons=user.cons
    

    }).catch(error =>{
      console.log(error)
    })
  }
  
  
}
</script>

<style>
</style>