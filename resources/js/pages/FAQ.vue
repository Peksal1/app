<template>
  <div>
    <Navbar />
    <div class="container d-flex justify-content-center">
      <VueFaqAccordion :items="myItems" />
    </div>
  </div>
</template>

<script>
import VueFaqAccordion from "vue-faq-accordion";
import Navbar from "../components/Navbar.vue";

export default {
  components: {
    VueFaqAccordion,
    Navbar,
  },
  data() {
    return {
      myItems: [
        {
          title: "Where do you deliver?",
          value: "Any place on the planet",
          category: "Delivery",
        },
        {
          title: "What payments methods do you accept?",
          value: "Currently, we accept credit cards and bank transfers",
          category: "Payments",
        },
        {
          title: "Do you offer discounts?",
          value: "Currently we do not offer any discounts",
          category: "Payments",
        },
        {
          title: "Can I create a custom order?",
          value:
            "Yes, for that register a new account, and in your profile page you will see an option to create an order",
          category: "Other questions",
        },
      ],
    };
  },
};
</script>