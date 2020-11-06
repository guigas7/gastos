<template>
  <li class="list-group-item">
      <div class="row d.flex row my-2 justify-content-center">
          <div class="col-md-8">
              <a  :title="type.description"
                  href="#"
                  class="type-title"
                  v-b-modal="modalId()">
                  {{ type.name }}
              </a>

              <b-modal hide-footer :id="'modal-' + type.id" :title="'Editar ' + type.name" v-cloak>
                  <div>
                      <form method="POST"
                          :action=" type.endPoint"
                          class="cent">
                          <input type="hidden" name="_method" value="PUT">
                          <input type="hidden" name="_token" :value="csrf">

                          <div class="form-group row py-3 justify-content-center">
                              <label for="expense-name" class="col-form-label col-lg-3 offset-lg-1">Nome: </label>
                              <div class="col-lg-7">
                                <input type="string" class="form-control" name="expense-name" required autofocus :value="type.name">
                              </div>
                          </div>
                          <hr>

                          <div class="form-group pt-3 row justify-content-center">
                              <label for="expense-type" class="col-form-label col-lg-3 offset-lg-1">Tipo: </label>

                              <div class="pl-4 col-lg-7">
                                  <p>
                                      <input type="radio" :id="'fixed-' + type.id" name="expense-type" required value="1" :checked="type.fixed">
                                      <label :for="'fixed-' + type.id">Fixa</label>
                                  </p>
                                  <P>
                                      <input type="radio" :id="'variable-' + type.id" name="expense-type" value="0" :checked="!type.fixed">
                                      <label :for="'variable-' + type.id">Variável</label>
                                  </P>
                              </div>
                          </div>
                          <hr>

                          <div class="form-group row py-3 justify-content-center">
                              <label for="expense-description" class="col-lg-3 offset-lg-1 col-form-label">Descrição: </label>

                              <div class="col-lg-7">
                                  <textarea
                                    name="expense-description"
                                    rows="4"
                                    cols="50"
                                    class="form-control">{{ type.description }}</textarea>
                              </div>
                          </div>

                          <button :id="'editar-' + type.slug" type="submit" class="btn btn-primary btn-sm btn-salvar">
                              Salvar
                          </button>
                      </form>
                  </div>
              </b-modal>
          </div>                                     
      </div>

    <div class="cent">
        <div class="d.flex row mb-2 justify-content-center">
            <div class="col-md-5 mb-3">
                <label for="value">Valor</label>
                <input type="number"
                name="value"
                step=".01"
                class="form-control"
                onClick="this.select();"
                @change="updateValue"
                v-model="record.value">
            </div>
            
            <div class="col-md-7 mb-3">
                <label for="description">Observações</label>
                <input type="text"
                name="description"
                class="form-control"
                @change="updateDescription"
                v-model="record.description"> 
            </div>                                 
        </div>
    </div>
  </li>
</template>

<script>
  export default {
    props: {
      typeAttrs: {
        type: Object,
        required: true,
      },
      recAttrs: {
        type: Object,
        required: true,
      }
    },
    computed: {
      type: function () {
        return this.typeAttrs
      },
      record: function () {
        return this.recAttrs
      }
    },
    data: function () {
      return {
        csrf: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
      }
    },
    methods: {
      modalId() {
        return 'modal-' + this.type.id
      },
      updateValue() {
        axios.put(this.record.endPoint, {
            value: this.record.value,
            description: this.record.description
        }).then(response => {
          this.$eventBus.$emit('flash', "O valor de " + this.type.name + " foi alterado para " + this.record.value + ".", "success");
        }).catch(error => {
          this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página", "danger");
        });
      },
      updateDescription() {
        axios.put(this.record.endPoint, {
            value: this.record.value,
            description: this.record.description
        }).then(response => {
          this.$eventBus.$emit('flash', "A descrição de " + this.type.name + " foi alterada.", "success", "success");
        }).catch(error => {
          this.$eventBus.$emit('flash', "Não foi possível concluir a operação, recarregue a página", "danger");
        });
      }
    }
  };
</script>