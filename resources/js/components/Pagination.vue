<template>
  <div class="card card-custom">
    <div class="card-body py-7">
      <!--begin::Pagination-->
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex flex-wrap mr-3">
          <!--<a v-if="pagination.current_page > 1" href="javascript:void(0)" aria-label="Previous"
                       v-on:click.prevent="changePage(1)" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                     <i class="ki ki-bold-double-arrow-back icon-xs"></i> 
                    </a>
                    <a v-if="pagination.current_page > 1" href="javascript:void(0)" aria-label="Previous" 
                       v-on:click.prevent="changePage(pagination.current_page - 1)"
                       class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                    </a>-->
          <a v-for="page in pagesNumber" :class="{ active: page == pagination.current_page }" href="javascript:void(0)"
            class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1" v-on:click.prevent="changePage(page)">
            {{ page }}
          </a>

          <a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)"
            class="btn btn-icon btn-sm btn-light-primary mr-2 my-1"
            v-if="pagination.current_page < pagination.last_page">
            <i class="ki ki-bold-arrow-next icon-xs"></i>
          </a>
          <a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.last_page)"
            class="btn btn-icon btn-sm btn-light-primary mr-2 my-1"
            v-if="pagination.current_page < pagination.last_page">
            <i class="ki ki-bold-double-arrow-next icon-xs"></i>
          </a>
        </div>
        <div class="d-flex align-items-center">
          <select v-model="pagination.per_page" class="
              form-control form-control-sm
              text-primary
              font-weight-bold
              mr-4
              border-0
              bg-light-primary
            " style="width: 75px">
            <option value="8">8</option>
            <option value="12">12</option>
            <option value="16">16</option>
            <option value="32">32</option>
            <option value="64">64</option>
            <option value="128">128</option>
          </select>
          <span class="text-muted">Displaying {{ pagination.to }} of
            {{ pagination.total }} records</span>
        </div>
      </div>
      <!--end:: Pagination-->
    </div>
  </div>
</template>
<script>
export default {
  props: {
    pagination: {
      type: Object,
      required: true,
    },
    offset: {
      type: Number,
      default: 4,
    },
  },
  watch: {
    "pagination.per_page"(val) {
      this.pagination.current_page = 1;
      this.$emit("perPage");
    },
  },
  computed: {
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }
      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      return pagesArray;
    },
  },
  methods: {
    changePage(page) {
      this.pagination.current_page = page;
      this.$emit("paginate");
    },
  },
};
</script>

<style scoped>
.btn.btn-hover-primary:not(:disabled):not(.disabled):active:not(.btn-text),
.btn.btn-hover-primary:not(:disabled):not(.disabled).active,
.show>.btn.btn-hover-primary.dropdown-toggle,
.show .btn.btn-hover-primary.btn-dropdown {
  color: #ffffff !important;
  background-color: #6ec1e4 !important;
  border-color: #6ec1e4 !important;
}
</style>
