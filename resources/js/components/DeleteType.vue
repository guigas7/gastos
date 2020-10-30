<template>
    <div class="form-group row">
        <h5 class="col-lg-7 col-md-5 mb-2" :title="data.description">{{ data.name }}</h5>
        <button
          @click="destroy"
          class="btn btn-danger btn-apagar ml-4 mb-2 align-middle">
            Apagar
        </button>
    </div>
</template>

<script>
  export default {
    props: {
      attributes: {
        type: Object,
        required: true,
      },
      index: {
        type: Number,
        required: true,
      },
    },
    computed: {
      data: function () {
        return this.attributes
      }
    },
    methods: {
      destroy() {
        axios.delete(this.data.endPoint);

        if (this.data.fixed == null) { // is income
          alert(this.index)
          this.$eventBus.$emit('income_deleted', this.index);
        } else if (this.data.fixed == 1) {
          alert(this.index)
          this.$eventBus.$emit('fixed_deleted', this.index);
        } else {
          alert(this.index)
          this.$eventBus.$emit('variable_deleted', this.index);
        }
      }
    }
  };
</script>