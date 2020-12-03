<template>
    <div class="form-group pt-3 row d.flex justify-content-center">
        <div class="form-group pt-3 col-form-label col-8 justify-content-center">
            <label for="sure">
              Deseja apagar o grupo de despesas {{ data.name }}. As despesas associadas ficarão sem grupo definido?
            </label>
        </div>
        <div class="form-group pt-3 col-form-label col-3 justify-content-center">
          <form method="POST"
              :action="data.endPoint"
              ref="form">
              <input type="hidden" name="_token" :value="csrf">
              <input type="hidden" name="_method" value="DELETE">
          </form>
          <b-button
              class="btn btn-danger btn-apagar ml-4 align-middle"
              v-b-modal="modalId()">
              Apagar
          </b-button>
        </div>

        <b-modal :id="modalId()" :ref="modalId()" :title="'Apagar ' + data.name" v-cloak>
          <span>Tem certeza de que deseja apagar o grupo de despesas <span class="green">{{ data.name }}</span>?</span>
            <template v-slot:modal-footer>
                <button
                  @click="destroy"
                  class="btn btn-danger btn-apagar">
                    Apagar
                </button>
                <b-button class="btn btn-apagar" @click="hideModal()">Cancelar</b-button>
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
      }
    },
    computed: {
      data: function () {
        return this.attributes
      }
    },
    data: function () {
      return {
        csrf: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
      }
    },
    methods: {
      modalId() {
        return 'del-modal-grupo-' + this.attributes.id
      },
      hideModal() {
        this.$refs[this.modalId()].hide()
      },
      destroy() {
        this.$refs["form"].submit()
      }
    }
  };
</script>
