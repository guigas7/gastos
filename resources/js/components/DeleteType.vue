<template>
    <div class="form-group row">
        <h5 class="col-lg-7 col-md-5 mb-2" :title="data.description">{{ data.name }}</h5>
        <b-button
          class="btn btn-danger btn-apagar ml-4 mb-2 align-middle"
          v-b-modal="modalId()">Apagar
        </b-button>

        <b-modal :id="modalId()" :ref="modalId()" :title="'Apagar ' + data.name" v-cloak>
            <span>Tem certeza de que deseja apagar {{ data.name }}?</span>
            <template v-slot:modal-footer>
                <button
                  @click="destroy"
                  class="btn btn-danger btn-apagar">
                    Apagar
                </button>
                <b-button class="btn btn-apagar" @click="hideModal">Cancelar</b-button>
            </template>
      </b-modal>
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
      modalId() {
        return 'del-modal-' + this.data.id
      },
      hideModal() {
        this.$refs[this.modalId()].hide()
      },
      destroy() {
        axios.delete(this.data.endPoint);

        if (this.data.fixed == null) { // is income
          this.$eventBus.$emit('income_deleted', this.index);
          this.$eventBus.$emit('flash', "Receita " + this.data.name + " foi apagada.", "success");
        } else if (this.data.fixed == 1) {
          this.$eventBus.$emit('fixed_deleted', this.index);
          this.$eventBus.$emit('flash', "Despesa " + this.data.name + " foi apagada.", "success");
        } else {
          this.$eventBus.$emit('variable_deleted', this.index);
          this.$eventBus.$emit('flash', "Despesa " + this.data.name + " foi apagada.", "success");
        }
        this.hideModal()
      }
    }
  };
</script>
