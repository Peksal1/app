<template>
  <div>
    <b-form @submit.prevent="register">
      <b-form-group
        id="input-group-1"
        label="Email address:"
        label-for="input-1"
        description="We'll never share your email with anyone else."
      >
        <b-form-input
          id="input-1"
          v-model="formData.email"
          type="email"
          placeholder="Enter email"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Your Name:" label-for="input-2">
        <b-form-input
          id="input-2"
          v-model="formData.name"
          placeholder="Enter name"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="password" label-for="input-3">
        <b-form-input
          id="input-2"
          v-model="formData.password"
          placeholder="password"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        id="input-group-4"
        label="Repeat password:"
        label-for="input-4"
      >
        <b-form-input
          id="input-2"
          v-model="formData.password_confirmation"
          placeholder="Repeat password"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-5" label="Role::" label-for="input-5">
        <b-form-select
          id="input-3"
          v-model="formData.role"
          :options="options"
          required
        ></b-form-select>
      </b-form-group>
      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      formData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: "",
      },
      options: [{ text: "Select One", value: null }, "1", "2", "3"],
      show: true,
      errors: {},
    };
  },
  methods: {
    register() {
      axios
        .post("/api/register", this.formData)
        .then((response) => {
          console.log(response.data);

          this.errors = {};
          var $statues = this.formData.role;
          console.log($statues);

          this.$router.push("/users");

          this.$toaster.success("Account created");
        })
        .catch((errors) => {
          this.errors = errors.response.data.errors;
          console.log(errors.response.data.errors);
        });
    },
  },
};
</script>

<style scoped>
.login {
  margin-left: 25rem;
}
</style>